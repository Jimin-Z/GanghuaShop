<?php
/**
 * 新闻通
 * ============================================================================
 * 版权所有 2016-2028 智讯通 同一科技有限公司。。
 * 
 * ----------------------------------------------------------------------------
，
 * ============================================================================
 * Author: 新闻通  4035172988@qq.com
 * Date: 2024-06-18
 */

namespace app\common\model;

use think\Db;
use think\Config;

/**
 * 抖音公共模型
 */
load_trait('controller/Jump');
class TikTok
{
    use \traits\controller\Jump;

    // 构造函数
    public function __construct()
    {
        // 统一接收参数处理
        $this->times = getTime();
        // 抖音信息
        $this->tikTokConfig = tpSetting("OpenMinicode.conf_toutiao");
        $this->tikTokConfig = !empty($this->tikTokConfig) ? json_decode($this->tikTokConfig, true) : [];
        // dump($this->tikTokConfig);
        // 接口请求头
        $this->headers  = [
            'Content-Type: application/json',
        ];
    }

    // 获取抖音支付订单号(order_id)、订单token(order_token)
    public function getTikTokAppletsPay($orderID = '', $orderCode = '', $orderAmount = 0, $orderUnpayCloseTime = 2880, $table = 'shop_order')
    {
        // 接口参数
        $postData = [
            'app_id'       => $this->tikTokConfig['appid'],
            'out_order_no' => strval($orderCode),
            'total_amount' => floatval($orderAmount * 100),
            'subject'      => '抖音支付',
            'body'         => '商品购买',
            'valid_time'   => intval(intval($orderUnpayCloseTime) * 60),
            'cp_extra'     => "tikTok|,|" . session('users_id') . "|,|" . $orderID . "|,|" . $orderCode . "|,|" . $table,
            'notify_url'   => request()->domain() . ROOT_DIR . '/index.php',
        ];
        // MD5加密签名
        $postData['sign'] = $this->getSignParam($postData);
        // 接口API
        $url = 'https://developer.toutiao.com/api/apps/ecpay/v1/create_order';
        $jsonData = json_decode(httpRequest($url, 'POST', json_encode($postData), $this->headers, 300000), true);
        // 返回订单创建信息
        if (isset($jsonData['err_no']) && 0 === intval($jsonData['err_no']) && isset($jsonData['err_tips']) && 'success' == strval($jsonData['err_tips'])) {
            return [
                'success' => true,
                'order_id' => $jsonData['data']['order_id'],
                'order_token' => $jsonData['data']['order_token'],
            ];
        } else {
            return [
                'success' => false,
                'err_tips' => $jsonData['err_tips'],
            ];
        }
    }

    // 抖音小程序商品购买支付后续处理
    public function tikTokAppletsPayDealWith($post = [], $notify = false, $table = 'shop_order')
    {
        // 异步回调时执行
        $cpExtra = !empty($post['msg']['cp_extra']) ? explode('|,|', $post['msg']['cp_extra']) : [];
        if (true === $notify && !empty($cpExtra[0]) && 'tikTok' == $cpExtra[0]) {
            $post['users_id'] = !empty($cpExtra[1]) ? $cpExtra[1] : 0;
            $post['order_id'] = !empty($cpExtra[2]) ? $cpExtra[2] : 0;
            $post['order_code'] = !empty($cpExtra[3]) ? $cpExtra[3] : '';
            $table = !empty($cpExtra[4]) ? $cpExtra[4] : $table;
        }

        if (!empty($post['users_id'])) {
            // 获取系统订单
            $order = $this->getSystemOrder($post, $notify, $table);
            // 系统订单号
            if ('shop_order' == $table) {
                $orderCode = strval($order['order_code']);
            } else if ('users_recharge_pack_order' == $table) {
                $orderCode = true === $notify ? strval($post['order_code']) : strval($order['order_pay_code']);
            } else if ('users_money' == $table) {
                $orderCode = true === $notify ? strval($post['order_code']) : strval($order['order_number']);
            }
            // 查询抖音支付订单是否真实完成支付
            $jsonData = $this->queryOrderPayResult($orderCode);
            if (isset($jsonData['err_no']) && 0 === intval($jsonData['err_no']) && !empty($jsonData['payment_info']['order_status'])) {
                // 支付成功
                if ('SUCCESS' == $jsonData['payment_info']['order_status']) {
                    // 处理系统订单
                    $this->handleSystemOrder($post, $notify, $table, $order, $jsonData);
                }
                // 正在支付中
                else if ('PROCESSING' == $jsonData['payment_info']['order_status']) {
                    if (true !== $notify) $this->success('正在支付中');
                }
                // 超时未支付
                else if ('TIMEOUT' == $jsonData['payment_info']['order_status']) {
                    if (true !== $notify) $this->error($jsonData['err_tips']);
                }
                // 支付失败
                else if ('FAIL' == $jsonData['payment_info']['order_status']) {
                    if (true !== $notify) $this->error($jsonData['err_tips']);
                }
            } else {
                if (true !== $notify) $this->error($jsonData['err_tips']);
            }
        }
    }

    // 查询系统订单
    private function getSystemOrder($post = [], $notify = false, $table = 'shop_order')
    {
        // 商城商品订单
        if ('shop_order' == $table) {
            // 查询系统订单信息
            $where = [
                'users_id'   => intval($post['users_id']),
                'order_id'   => intval($post['order_id']),
                'order_code' => strval($post['order_code']),
            ];
            $order = Db::name('shop_order')->where($where)->find();
            if (empty($order)) {
                // 同步
                if (true !== $notify) $this->error('无效订单');
            } else if (0 < $order['order_status']) {
                // 异步
                if (true === $notify) {
                    exit(json_encode(['err_no' => 0, 'err_tips' => 'success']));
                }
                // 同步
                else {
                    $usersData = Db::name('users')->where('users_id', $post['users_id'])->find();
                    // 邮箱发送
                    $resultData['email'] = GetEamilSendData(tpCache('smtp'), $usersData, $order, 1, 'wechat');
                    // 短信发送
                    $resultData['mobile'] = GetMobileSendData(tpCache('sms'), $usersData, $order, 1, 'wechat');
                    // 跳转链接
                    $url = 1 == input('param.fenbao/d') ? '' : '/pages/order/index';
                    $resultData['url'] = $url;
                    $this->success('支付完成', $url, $resultData);
                }
            }
        }
        // 会员充值套餐订单
        else if ('users_recharge_pack_order' == $table) {
            $where = [
                'users_id' => intval($post['users_id']),
                'order_id' => intval($post['order_id']),
                'order_code' => strval($post['order_code']),
                'order_pay_code' => strval($post['order_pay_code']),
            ];
            $order = Db::name('users_recharge_pack_order')->where($where)->find();
            if (empty($order)) {
                // 同步
                if (true !== $notify) $this->error('无效订单');
            } else if (1 < $order['order_status']) {
                // 异步
                if (true === $notify) {
                    exit(json_encode(['err_no' => 0, 'err_tips' => 'success']));
                }
                // 同步
                else {
                    $this->success('支付完成');
                }
            }
        }
        // 会员充值余额订单
        else if ('users_money' == $table) {
            $post['moneyid'] = !empty($post['order_id']) ? $post['order_id'] : $post['moneyid'];
            $post['order_number'] = !empty($post['order_code']) ? $post['order_code'] : $post['order_number'];
            $where = [
                'moneyid' => intval($post['moneyid']),
                'users_id' => intval($post['users_id']),
                'order_number' => strval($post['order_number']),
            ];
            $order = Db::name('users_money')->where($where)->find();
            if (empty($order)) {
                // 同步
                if (true !== $notify) $this->error('无效订单');
            } else if (1 < $order['status']) {
                // 异步
                if (true === $notify) {
                    exit(json_encode(['err_no' => 0, 'err_tips' => 'success']));
                }
                // 同步
                else {
                    $this->success('支付完成');
                }
            }
        }

        return $order;
    }

    // 处理系统订单
    private function handleSystemOrder($post = [], $notify = false, $table = 'shop_order', $order = [], $jsonData = [])
    {
        $moneyID = !empty($order['moneyid']) ? intval($order['moneyid']) : 0;
        $usersID = !empty($order['users_id']) ? intval($order['users_id']) : 0;
        $orderID = !empty($order['order_id']) ? intval($order['order_id']) : 0;
        $orderCode = !empty($order['order_code']) ? strval($order['order_code']) : '';
        $orderNumber = !empty($order['order_number']) ? strval($order['order_number']) : '';
        $orderPayCode = !empty($order['order_pay_code']) ? strval($order['order_pay_code']) : '';
        $cpExtra = !empty($jsonData['payment_info']['cp_extra']) ? explode('|,|', $jsonData['payment_info']['cp_extra']) : [];
        $cpExtra[0] = !empty($cpExtra[0]) ? $cpExtra[0] : '';
        $cpExtra[1] = !empty($cpExtra[1]) ? $cpExtra[1] : 0;
        $cpExtra[2] = !empty($cpExtra[2]) ? $cpExtra[2] : 0;
        $cpExtra[3] = !empty($cpExtra[3]) ? $cpExtra[3] : 0;
        if ('tikTok' == $cpExtra[0] && $usersID == $cpExtra[1]) {
            // 商城商品订单
            if ('shop_order' == $table && $orderID == $cpExtra[2]) {
                // 订单已支付，处理订单流程
                $where = [
                    'order_id' => $orderID,
                    'users_id' => $usersID
                ];
                $update  = [
                    'order_status' => 1,
                    'pay_details'  => serialize($jsonData),
                    'pay_time'     => getTime(),
                    'update_time'  => getTime()
                ];
                $resultID = Db::name('shop_order')->where($where)->update($update);
                if (!empty($resultID)) {
                    // 添加订单操作记录
                    AddOrderAction($orderID, $usersID, 0, 1, 0, 1, '支付成功', '会员使用抖音小程序完成支付');

                    // 虚拟自动发货
                    $shopModel = new \app\user\model\Pay();
                    $where = [
                        'lang'     => get_home_lang(),
                        'users_id' => $usersID,
                        'order_id' => $orderID
                    ];
                    $shopModel->afterVirtualProductPay($where);

                    // 订单支付通知
                    $params = [
                        'users_id' => $usersID,
                        'result_id' => $orderID,
                    ];
                    eyou_send_notice(9, $params);

                    // 站内信通知
                    $order['pay_method'] = '微信支付';
                    SendNotifyMessage($order, 5, 1, 0);

                    // 添加会员积分记录
                    $where = [
                        'users_id' => $usersID,
                        'order_id' => $orderID
                    ];
                    $data = Db::name('shop_order_details')->where($where)->getField('data');
                    $data = !empty($data) ? unserialize($data) : [];
                    $pointsGoodsBuyField = !empty($data['pointsGoodsBuyField']) ? json_decode($data['pointsGoodsBuyField'], true) : [];
                    if (!empty($pointsGoodsBuyField['goodsTotalPoints'])) {
                        $insert = [
                            'type' => 11, // 积分商城订单支付
                            'users_id' => $usersID,
                            'score' => $pointsGoodsBuyField['goodsTotalPoints'],
                            'info' => '积分商城订单支付',
                            'remark' => '积分商城订单支付',
                        ];
                        addConsumObtainScores($insert, 1, false);
                    }

                    // 异步
                    if (true === $notify) {
                        exit(json_encode(['err_no' => 0, 'err_tips' => 'success']));
                    }
                    // 同步
                    else {
                        // 统计销售额
                        eyou_statistics_data(2);
                        eyou_statistics_data(3, $order['order_amount']);

                        $usersData = Db::name('users')->where('users_id', $usersID)->find();
                        // 邮箱发送
                        $resultData['email'] = GetEamilSendData(tpCache('smtp'), $usersData, $order, 1, 'wechat');
                        // 短信发送
                        $resultData['mobile'] = GetMobileSendData(tpCache('sms'), $usersData, $order, 1, 'wechat');
                        // 跳转链接
                        $url = 1 == input('param.fenbao/d') ? '' : '/pages/order/index';
                        $resultData['url'] = $url;
                        $this->success('支付完成', $url, $resultData);
                    }
                }
            }
            // 会员充值套餐订单
            else if ('users_recharge_pack_order' == $table && $orderID == $cpExtra[2]) {
                // 更新订单为已支付
                $where = [
                    'users_id' => $usersID,
                    'order_id' => $orderID,
                    'order_code' => $orderCode,
                    'order_pay_code' => $orderPayCode,
                ];
                $update = [
                    'order_status' => 2,
                    'order_pay_time' => $this->times,
                    'order_pay_name' => 'tikTokPay',
                    'order_pay_terminal' => 4,
                    'order_pay_details' => serialize($jsonData),
                    'update_time' => $this->times,
                ];
                $result_1 = Db::name('users_recharge_pack_order')->where($where)->update($update);
                if (!empty($result_1)) {
                    // 根据会员充值套餐给会员充储值余额
                    $result_2 = Db::name('users')->where(['users_id' => $usersID])->setInc('users_money', $order['order_face_value']);
                    if (!empty($result_2)) {
                        // 更新订单为已充值
                        $update = [
                            'order_status' => 3,
                            'update_time' => $this->times,
                        ];
                        Db::name('users_recharge_pack_order')->where($where)->update($update);
                        // 增加充值套餐的销售量
                        $where = [
                            'pack_id' => $order['pack_id'],
                        ];
                        Db::name('users_recharge_pack')->where($where)->setInc('pack_sales_num');
                        // 会员当前余额
                        $usersMoney = Db::name('users')->where('users_id', $usersID)->getField('users_money');
                        $moneyData = [
                            'users_id' => $usersID,
                            'money' => unifyPriceHandle($order['order_face_value']),
                            'users_money' => unifyPriceHandle($usersMoney),
                            'cause' => $order['order_pack_names'] . '(充值套餐)',
                            'cause_type' => 1,
                            'status' => 3,
                            'pay_method' => 'tikTokPay',
                            'pay_details' => serialize($jsonData),
                            'order_number' => $orderPayCode,
                            'lang' => get_home_lang(),
                            'add_time' => $this->times,
                            'update_time' => $this->times,
                        ];
                        Db::name('users_money')->insertGetId($moneyData);
                        // 异步
                        if (true === $notify) {
                            exit(json_encode(['err_no' => 0, 'err_tips' => 'success']));
                        }
                        // 同步
                        else {
                            $this->success('充值成功');
                        }
                    }
                }
            }
            // 会员充值余额订单
            else if ('users_money' == $table && $moneyID == $cpExtra[2]) {
                // 更新订单为已支付
                $where = [
                    'moneyid' => intval($moneyID),
                    'users_id' => intval($usersID),
                    'order_number' => strval($orderNumber),
                ];
                $update = [
                    'status' => 2,
                    'pay_method' => 'tikTokPay',
                    'wechat_pay_type' => '',
                    'pay_details' => serialize($jsonData),
                    'update_time' => getTime()
                ];
                $result_1 = Db::name('users_money')->where($where)->update($update);
                if (!empty($result_1)) {
                    // 更新增加会员余额
                    $result_2 = Db::name('users')->where(['users_id' => intval($usersID)])->setInc('users_money', $order['money']);
                    if (!empty($result_2)) {
                        // 更新订单为已充值
                        $update = [
                            'status' => 3,
                            'update_time' => getTime()
                        ];
                        Db::name('users_money')->where($where)->update($update);

                        $this->success('充值成功');
                    }
                }
                $this->error('付款成功，充值失败，请联系管理员');
            }
        }
    }

    // 查询抖音支付订单是否真实完成支付
    public function queryOrderPayResult($orderCode = '')
    {
        // 接口参数
        $postData = [
            'app_id'       => $this->tikTokConfig['appid'],
            'out_order_no' => strval($orderCode),
        ];
        // MD5加密签名
        $postData['sign'] = $this->getSignParam($postData);
        // 接口API
        $url = 'https://developer.toutiao.com/api/apps/ecpay/v1/query_order';
        // 返回结果
        return json_decode(httpRequest($url, 'POST', json_encode($postData), $this->headers, 300000), true);
    }

    private function getSignParam($map = [])
    {
        $param = [];
        foreach($map as $key => $value) {
            // 排除不参与加密的字段
            if ($key == "other_settle_params" || $key == "app_id" || $key == "sign" || $key == "thirdparty_id") continue;

            // 参数处理
            $valueNew = trim(strval($value));
            if (is_array($value)) $valueNew = arrayToStr($value);

            $len = strlen($valueNew);
            if ($len > 1 && substr($valueNew, 0,1)=="\"" && substr($valueNew, $len-1)=="\"") $valueNew = substr($valueNew,1, $len-1);

            $valueNew = trim($valueNew);
            if ($valueNew == "" || $valueNew == "null") continue;

            $param[] = $valueNew;
        }
        $param[] = $this->tikTokConfig['salt'];
        sort($param, SORT_STRING);
        return md5(trim(implode('&', $param)));
    }

    private function arrayToStr($map = [])
    {
        $isMap = isArrMap($map);

        $result = "";
        if (!empty($isMap)) $result = "map[";

        $keyArr = array_keys($map);
        if (!empty($isMap)) sort($keyArr);

        $paramsArr = array();
        foreach($keyArr as $key) {
            $v = $map[$key];
            if (!empty($isMap)) {
                if (is_array($v)) {
                    $paramsArr[] = sprintf("%s:%s", $key, arrayToStr($v));
                } else  {
                    $paramsArr[] = sprintf("%s:%s", $key, trim(strval($v)));
                }
            } else {
                if (is_array($v)) {
                    $paramsArr[] = arrayToStr($v);
                } else  {
                    $paramsArr[] = trim(strval($v));
                }
            }
        }

        $result = sprintf("%s%s", $result, join(" ", $paramsArr));
        if (empty($isMap)) {
            $result = sprintf("[%s]", $result);
        } else {
            $result = sprintf("%s]", $result);
        }

        return $result;
    }

    private function isArrMap($map = [])
    {
        foreach($map as $k =>$v) {
            if (is_string($k)) return true;
        }
        return false;
    }

}