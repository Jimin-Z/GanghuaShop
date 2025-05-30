<?php
/**
 * 新闻通
 * ============================================================================
 * 版权所有 2016-2028 智讯通 同一科技有限公司。。
 * 
 * ----------------------------------------------------------------------------
，
 * ============================================================================
 * Author:
	unset
 * Date: 2020-05-22
 */

namespace app\admin\controller;

use think\Page;
use think\Db;
use think\Config;

class PayApi extends Base {

    private $UsersConfigData = [];

    /**
     * 构造方法
     */
    public function __construct(){
        parent::__construct();
        $this->language_access(); // 多语言功能操作权限
        $this->pay_api_config_db = Db::name('pay_api_config');

        // 会员中心配置信息
        $this->UsersConfigData = getUsersConfigData('all');
        $this->assign('userConfig', $this->UsersConfigData);
    }

    /**
     * 支付接口首页
     */
    public function pay_api_index()
    {
        $list = $this->pay_api_config_db->where('status', 1)->order('pay_id asc')->select();
        foreach ($list as $key => $val) {
            if (1 == $val['system_built']) {
                $val['litpic'] = $this->root_dir . "/public/static/admin/images/{$val['pay_mark']}.png";
            } else {
                $val['litpic'] = $this->root_dir . "/weapp/{$val['pay_mark']}/logo.png";
            }
            $list[$key] = $val;
        }
        $this->assign('list', $list);
        return $this->fetch('pay_api_index');
    }

    /**
     * 打开支付接口配置
     */
    public function open_pay_api_config()
    {
        $pay_id = input('get.pay_id') ? input('get.pay_id') : 0;
        $Config = $this->pay_api_config_db->where('pay_id', $pay_id)->find();

        if (!empty($Config) && 1 == $Config['pay_id'] && 'wechat' == $Config['pay_mark']) {
            // 系统内置的微信支付
            $TemplateHtml = $this->WeChatPayTemplate($Config);
        } else if (!empty($Config) && 2 == $Config['pay_id'] && 'alipay' == $Config['pay_mark']) {
            // 系统内置的支付宝支付
            $TemplateHtml = $this->AliPayPayTemplate($Config);
        } else if (!empty($Config) && !empty($Config['pay_mark']) && 0 == $Config['system_built']) {
            // 第三方插件
            $ControllerName  = "\weapp\\" . $Config['pay_mark']."\controller\\" . $Config['pay_mark'];
            $UnifyController = new $ControllerName;
            $TemplateHtml = $UnifyController->UnifyAction($Config);
        }

        return $this->display($TemplateHtml);
    }

    /**
     * 保存支付接口配置
     */
    public function save_pay_api_config()
    {
        if (IS_AJAX_POST) {
            $post = input('post.');

            $pay_id = !empty($post['pay_id']) ? $post['pay_id'] : 0;
            $Config = $this->pay_api_config_db->where('pay_id', $pay_id)->find();
            if (empty($Config)) $this->error('数据有误，请刷新重试');

            if (1 == $Config['pay_id'] && 'wechat' == $Config['pay_mark']) {
                // 系统内置的微信支付
                $this->WeChatPayConfig($post);
            } else if (2 == $Config['pay_id'] && 'alipay' == $Config['pay_mark']) {
                // 系统内置的支付宝支付
                $this->AliPayPayConfig($post);
            } else if (!empty($Config) && !empty($Config['pay_mark']) && 0 == $Config['system_built']) {
                // 第三方插件
                $ControllerName  = "\weapp\\" . $Config['pay_mark']."\controller\\" . $Config['pay_mark'];
                $UnifyController = new $ControllerName;
                $UnifyController->UnifySaveConfigAction($post);
            }
        }
    }

    /* 微信逻辑 */
    public function WeChatPayTemplate($Config = [])
    {
        $pay_info = !empty($Config['pay_info']) ? unserialize($Config['pay_info']) : [];
        $Config['pay_terminal'] = !empty($Config['pay_terminal']) ? unserialize($Config['pay_terminal']) : [];
        $this->assign('Config', $Config);
        $this->assign('pay_info', $pay_info);
        return $this->fetch('wechat_template');
    }

    // 保存微信配置
    public function WeChatPayConfig($post = [])
    {
        if (empty($post['pay_info']['is_open_wechat'])) {
            // 配置信息不允许为空
            if (empty($post['pay_info']['appid'])) $this->error('请填写微信AppId');
            if (empty($post['pay_info']['mchid'])) $this->error('请填写微信商户号');
            if (empty($post['pay_info']['key']))   $this->error('请填写微信KEY值');
            
            // 验证微信配置是否正确，不正确则返回提示
            $Result = model('PayApi')->VerifyWeChatConfig($post['pay_info']);
            if (!empty($Result['return_code']) && $Result['return_code'] == 'FAIL') $this->error($Result['return_msg']);
        }

        // 保存配置
        $SynData['pay_info'] = serialize($post['pay_info']);
        // $SynData['pay_terminal'] = serialize($post['pay_terminal']);
        $SynData['update_time'] = getTime();

        // 保存条件
        $where = [
            'pay_id' => $post['pay_id'],
            'pay_mark' => 'wechat',
            'system_built' => 1
        ];
        $ResultID = $this->pay_api_config_db->where($where)->update($SynData);

        // 返回结果
        if (!empty($ResultID)) {
            $this->success('保存成功');
        } else {
            $this->error('数据错误');
        }
    }
    /* END */

    /* 支付宝逻辑 */
    public function AliPayPayTemplate($Config = [])
    {
        $pay_info = !empty($Config['pay_info']) ? unserialize($Config['pay_info']) : [];
        $Config['pay_terminal'] = !empty($Config['pay_terminal']) ? unserialize($Config['pay_terminal']) : [];
        $this->assign('Config', $Config);
        $this->assign('pay_info', $pay_info);
        // PHP5.5.0或更高版本，可使用新版支付方式，兼容旧版支付方式
        $php_version = 0;
        if (version_compare(PHP_VERSION, '5.5.0', '<')) {
            // PHP5.4.0或更低版本，可使用旧版支付方式
            $php_version = 1;
        }
        $this->assign('php_version', $php_version);
        return $this->fetch('alipay_template');
    }

    // 保存支付宝支付配置
    public function AliPayPayConfig($post = [])
    {
        $php_version = $post['pay_info']['version'];
        if (0 == $php_version) {
            if (empty($post['pay_info']['is_open_alipay'])) {
                // 配置信息不允许为空
                if (empty($post['pay_terminal']['computer']) && empty($post['pay_terminal']['computer'])) $this->error('请勾选支付终端');
                if (empty($post['pay_info']['app_id'])) $this->error('请填写支付宝APPID');
                if (empty($post['pay_info']['merchant_private_key'])) $this->error('请填写商户私钥');
                if (empty($post['pay_info']['alipay_public_key'])) $this->error('请填写支付宝公钥');

                // 验证支付宝配置是否正确，不正确则返回提示
                $Result = model('PayApi')->VerifyAliPayConfig($post['pay_info']);
                if ('ok' != $Result) {
                    empty($Result) && $Result = '配置信息不正确，请重新获取';
                    $this->error($Result);
                }
            }

            // 处理数据中的空格和换行
            $post['pay_info']['app_id'] = preg_replace('/\r|\n/', '', $post['pay_info']['app_id']);
            $post['pay_info']['alipay_public_key'] = preg_replace('/\r|\n/', '', $post['pay_info']['alipay_public_key']);
            $post['pay_info']['merchant_private_key'] = preg_replace('/\r|\n/', '', $post['pay_info']['merchant_private_key']);

        } else if (1 == $php_version) {
            if (empty($post['pay_info']['is_open_alipay'])) {
                // 配置信息不允许为空
                if (empty($post['pay_info']['account'])) $this->error('请填写支付宝账号');
                if (empty($post['pay_info']['code'])) $this->error('请填写安全校验码');
                if (empty($post['pay_info']['id'])) $this->error('请填写合作者身份ID');
            }
        }

        // 保存配置
        $SynData['pay_info'] = serialize($post['pay_info']);
        $SynData['pay_terminal'] = serialize($post['pay_terminal']);
        $SynData['update_time'] = getTime();
        $where = [
            'pay_id' => $post['pay_id'],
            'pay_mark' => 'alipay',
            'system_built' => 1
        ];
        $ResultID = $this->pay_api_config_db->where($where)->update($SynData);

        // 返回结果
        if (!empty($ResultID)) {
            $this->success('保存成功');
        } else {
            $this->error('数据错误');
        }
    }
    /* END */
}