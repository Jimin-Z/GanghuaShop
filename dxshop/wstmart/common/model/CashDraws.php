<?php
namespace wstmart\common\model;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 提现流水业务处理器
 */
class CashDraws extends Base{
	 protected $pk = 'cashId';
     /**
      * 获取列表
      */
      public function pageQuery($targetType,$targetId){
      	  $type = (int)input('post.type',-1);
          $where = [];
          $where['targetType'] = (int)$targetType;
          $where['targetId'] = (int)$targetId;
          if(in_array($type,[0,1]))$where['moneyType'] = $type;
          $page = $this->where($where)->order('cashId desc')->paginate(input('pagesize/d'))->toArray();
          if(count($page['data'])>0){
              foreach ($page['data'] as $key => $v) {
                  $page['data'][$key]['accNo'] =  '**** '.substr($v['accNo'],-4);
              }
          }
          return $page;
      }

      /**
       * 申请提现
       */
      public function drawMoney($uId=0){
          $userId = ($uId==0)?(int)session('WST_USER.userId'):$uId;
          $money = (float)input('money');
          if($money==0)return WSTReturn('请输入提现金额');
          $accId = (int)input('accId');
          $isWeapp = (int)input('isWeapp');
          $payPwd = input('payPwd');
          $decrypt_data = WSTRSA($payPwd);
          if($uId<=0 || $isWeapp==1){
            if($decrypt_data['status']==1){
            	$payPwd = $decrypt_data['data'];
            }else{
            	return WSTReturn('提现申请失败');
            }
          }
          $limitMoney = (float)WSTConf('CONF.drawCashUserLimit');
          if($money<$limitMoney)return WSTReturn('提取金额必须大于或等于￥'.$limitMoney.'方可提现');
          if($payPwd=='')return WSTReturn('支付密码不能为空');
          //加载用户
          $user = model('users')->get($userId);
          $acc = [];
          $areas = null;
          if($accId>0){
               //加载提现账号信息
               $acc = Db::name('cash_configs')->alias('cc')
                     ->join('__BANKS__ b','cc.accTargetId=b.bankId')->where(['cc.dataFlag'=>1,'id'=>$accId])
                     ->field('b.bankName,b.bankId,cc.*')->find();
               if(empty($acc))return WSTReturn('提现账号不存在');
               $areas = model('areas')->getParentNames($acc['accAreaId']);
          }else{
               if(!isset($user['wxOpenId']) || $user['wxOpenId']=='')return WSTReturn('申请微信提现失败，微信提现账户需先在微信商城中登录并且绑定账号');
               $acc['accUser'] = input('accUser');
               if($acc['accUser']=='')return WSTReturn('真实姓名不能为空');
               $acc['accNo'] = $user->wxOpenId;
          }

          $userMoney = $user->userMoney;
          $rechargeMoney = $user->rechargeMoney;
          $payPwd = md5($payPwd.$user->loginSecret);

          if($payPwd!=$user->payPwd)return WSTReturn('支付密码错误');
          if($money>($userMoney-$rechargeMoney))return WSTReturn('提取金额不能大于用户可提现金额');
          //减去要提取的金额
          $user->userMoney = $user->userMoney-$money;
          $user->lockMoney = $user->lockMoney+$money;
          $actualMoney = 0;
          $commission = 0;
          $commissionRate = (float)WSTConf('CONF.drawCashCommission');
          if($commissionRate>0){
              $commission = $money*$commissionRate*0.01;
              $actualMoney = $money-$commission;
          }
          Db::startTrans();
          try{
             $result = $user->save();
             if(false !==$result){
                //创建提现记录
                $data = [];
                $data['accId'] = $accId;
                $data['targetType'] = 0;
                $data['targetId'] = $userId;
                $data['money'] = $money;
                $data['accType'] = ($accId==-1000)?1:(($accId==-2000)?2:3);
                if($accId>0){
                   $data['accTargetId'] = $acc['bankId'];
                   $data['accTargetName'] = $acc['bankName'];
                   $data['accAreaName'] = implode('',$areas);
                }
                $data['accNo'] = $acc['accNo'];
                $data['accUser'] = $acc['accUser'];
                $data['cashSatus'] = 0;
                $data['cashConfigId'] = $accId;
                $data['createTime'] = date('Y-m-d H:i:s');
                $data['cashNo'] = '';
                $data['commission'] = $commission;
                $data['actualMoney'] = $actualMoney;
                $data['commissionRate'] = $commissionRate;
                $this->save($data);
                $this->cashNo = $this->cashId.(fmod($this->cashId,7));
                $this->save();
                //判断是否需要发送管理员短信
                $tpl = WSTMsgTemplates('PHONE_ADMIN_CASH_DRAWS');
                if((int)WSTConf('CONF.smsOpen')==1 && (int)WSTConf('CONF.smsCashDrawsTip')==1 &&  $tpl['tplContent']!='' && $tpl['status']=='1'){
                   $params = ['tpl'=>$tpl,'params'=>['CASH_NO'=>$this->cashNo]];
                    $staffs = Db::name('staffs')->where([['staffId','in',explode(',',WSTConf('CONF.cashDrawsTipUsers'))],['staffStatus','=',1],['dataFlag','=',1]])->field('staffPhone')->select();
                    for($i=0;$i<count($staffs);$i++){
                       if($staffs[$i]['staffPhone']=='')continue;
                       $m = new LogSms();
                       $rv = $m->sendAdminSMS(0,$staffs[$i]['staffPhone'],$params,'drawMoney','');
                    }
                }
                //微信消息
                if((int)WSTConf('CONF.wxenabled')==1){
                    //判断是否需要发送给管理员消息
                    if((int)WSTConf('CONF.wxCashDrawsTip')==1){
                        $params = [];
                        $params['CASH_NO'] = $this->cashNo;
                        $params['LOGIN_NAME'] = session('WST_USER.loginName');
                        $params['MONEY'] = $money;
                        $params['CASH_TIME'] = date('Y-m-d H:i:s');
                        WSTWxBatchMessage(['CODE'=>'WX_ADMIN_CASH_DRAW','userType'=>3,'userId'=>explode(',',WSTConf('CONF.cashDrawsTipUsers')),'params'=>$params]);
                    }
                }
                Db::commit();
                return WSTReturn('提现申请成功，请留意系统信息',1);
             }
          }catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('提现申请失败',-1);
          }
      }

      public function drawMoneyByShop($sId=0,$uId=0){
          $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
          $userId = ($uId==0)?(int)session('WST_USER.userId'):$uId;
          $accType = (int)input('accType');
          if(!in_array($accType,[1,2,3]))return WSTReturn('无效的提现类型');
          $money = (float)input('money');
          $payPwd = input('payPwd');

          if($sId<=0){// 大于0表示来自app端
            $decrypt_data = WSTRSA($payPwd);
            if($decrypt_data['status']==1){
              $payPwd = $decrypt_data['data'];
            }else{
              return WSTReturn('提现申请失败');
            }
          }

          $limitMoney = (float)WSTConf('CONF.drawCashShopLimit');
          if($money<$limitMoney)return WSTReturn('提取金额必须大于或等于￥'.$limitMoney.'方可提现');
          if($payPwd=='')return WSTReturn('支付密码不能为空');
          $shops = model('shops')->get($shopId);
          $wxOpenId = '';
          if($accType==1){
            $wxOpenId = model('users')->where('userId',$shops->userId)->value('wxOpenId');
            if($wxOpenId=='')return WSTReturn('申请微信提现失败，店铺主账号需先在微信商城中登录并且绑定账号');
          }
          $shopMoney = $shops->shopMoney;
          $rechargeMoney = $shops->rechargeMoney;
          $areas = null;
          $bank = null;
          if($accType==3){
               $areas = model('areas')->getParentNames($shops->bankAreaId);
               $bank = model('banks')->get($shops->bankId);
          }else if($accType==1){
               if(input('accUser')=='')return WSTReturn('真实姓名不能为空');
          }
          $payPwd = md5($payPwd.$shops->paySecret);
          if($payPwd!=$shops->payPwd)return WSTReturn('店铺支付密码错误');
          if($money>($shopMoney-$rechargeMoney))return WSTReturn('提取金额不能大于商家的可提现金额');
          //减去要提取的金额
          $shops->shopMoney = $shops->shopMoney-$money;
          $shops->lockMoney = $shops->lockMoney+$money;
          $actualMoney = 0;
          $commission = 0;
          $commissionRate = (float)WSTConf('CONF.drawCashCommission');
          if($commissionRate>0){
              $commission = $money*$commissionRate*0.01;
              $actualMoney = $money-$commission;
          }
          Db::startTrans();
          try{
             $result = $shops->save();
             if(false !==$result){
                //创建提现记录
                $data = [];
                $data['targetType'] = 1;
                $data['targetId'] = $shopId;
                $data['money'] = $money;
                $data['accType'] = $accType;
                if($accType==3){
                   $data['accTargetName'] = $bank['bankName'];
                   $data['accAreaName'] = implode('',$areas);
                   $data['accTargetId'] = $bank['bankId'];
                   $data['accNo'] = $shops['bankNo'];
                   $data['accUser'] = $shops['bankUserName'];
                }else if($accType==1){
                   $data['accNo'] = $wxOpenId;
                   $data['accUser'] = input('accUser');
                }
                $data['cashSatus'] = 0;
                $data['cashConfigId'] = 0;
                $data['createTime'] = date('Y-m-d H:i:s');
                $data['cashNo'] = '';
                $data['commission'] = $commission;
                $data['actualMoney'] = $actualMoney;
                $data['commissionRate'] = $commissionRate;
                $this->save($data);
                $this->cashNo = $this->cashId.(fmod($this->cashId,7));
                $this->save();
                //判断是否需要发送管理员短信
                $tpl = WSTMsgTemplates('PHONE_ADMIN_CASH_DRAWS');
                if((int)WSTConf('CONF.smsOpen')==1 && (int)WSTConf('CONF.smsCashDrawsTip')==1 &&  $tpl['tplContent']!='' && $tpl['status']=='1'){
                   $params = ['tpl'=>$tpl,'params'=>['CASH_NO'=>$this->cashNo]];
                    $staffs = Db::name('staffs')->where([['staffId','in',explode(',',WSTConf('CONF.cashDrawsTipUsers'))],['staffStatus','=',1],['dataFlag','=',1]])->field('staffPhone')->select();
                    for($i=0;$i<count($staffs);$i++){
                       if($staffs[$i]['staffPhone']=='')continue;
                       $m = new LogSms();
                       $rv = $m->sendAdminSMS(0,$staffs[$i]['staffPhone'],$params,'drawMoney','');
                    }
                }
                //微信消息
                // if((int)WSTConf('CONF.wxenabled')==1){
                //     //判断是否需要发送给管理员消息
                //     if((int)WSTConf('CONF.wxCashDrawsTip')==1){
                //         $params = [];
                //         $params['CASH_NO'] = $this->cashNo;
                //         $params['LOGIN_NAME'] = session('WST_USER.loginName');
                //         $params['MONEY'] = $money;
                //         $params['CASH_TIME'] = date('Y-m-d H:i:s');
                //         WSTWxBatchMessage(['CODE'=>'WX_ADMIN_CASH_DRAW','userType'=>3,'userId'=>explode(',',WSTConf('CONF.cashDrawsTipUsers')),'params'=>$params]);
                //     }
                // }
                Db::commit();
                return WSTReturn('提现申请成功，请留意系统信息',1);
             }
          }catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('提现申请失败',-1);
          }
      }


}
