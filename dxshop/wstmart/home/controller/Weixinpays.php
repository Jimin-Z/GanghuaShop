<?php
namespace wstmart\home\controller;
use think\Loader;
use Env;
use wstmart\common\model\Payments as M;
use wstmart\common\model\Orders as OM;
use wstmart\common\model\LogMoneys as LM;
use wstmart\common\model\Shops as SM;
use wstmart\common\model\Suppliers as SUM;
use wstmart\common\model\LogPays as PM;
use wstmart\common\model\ChargeItems as CM;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 微信支付控制器
 */
class Weixinpays extends Base{
	
	/**
	 * 初始化
	 */
	private $wxpayConfig;
	private $wxpay;
	public function initialize() {
		header ("Content-type: text/html; charset=utf-8");
		require Env::get('root_path') . 'extend/wxpay/WxPayConf.php';
		require Env::get('root_path') . 'extend/wxpay/WxQrcodePay.php';
		$this->wxpayConfig = array();
		$m = new M();
		$this->wxpay = $m->getPayment("weixinpays");
		$this->wxpayConfig['appid'] = $this->wxpay['appId']; // 微信公众号身份的唯一标识
		$this->wxpayConfig['appsecret'] = $this->wxpay['appsecret']; // JSAPI接口中获取openid
		$this->wxpayConfig['mchid'] = $this->wxpay['mchId']; // 受理商ID
		$this->wxpayConfig['key'] = $this->wxpay['apiKey']; // 商户支付密钥Key
		$this->wxpayConfig['notifyurl'] = url("home/weixinpays/wxNotify","",true,true);
		$this->wxpayConfig['curl_timeout'] = 30;
		$this->wxpayConfig['returnurl'] = "";
		// 初始化WxPayConf_pub
		//put_msg('$this->wxpayConfig 40');put_msg($this->wxpayConfig);
		$wxpaypubconfig = new \WxPayConf($this->wxpayConfig);

	}
	
	/**
	 * 获取微信URL
	 */
	public function getWeixinPaysURL(){
		$m = new OM();
		$payObj = input("payObj/s");
		$pkey = "";
		$data = array();
		put_msg('$payObj weixinpays 51');put_msg($payObj);
		if($payObj=="recharge"){
			$cm = new CM();
			$itmeId = (int)input("itmeId/d");
			$targetType = (int)input("targetType/d");
			$targetId = (int)session('WST_USER.userId');
			if($targetType==1){//商家
				$targetId = (int)session('WST_USER.shopId');
			}
			$needPay = 0;
			if($itmeId>0){
				$item = $cm->getItemMoney($itmeId);
				$needPay = isSet($item["chargeMoney"])?$item["chargeMoney"]:0;
			}else{
				$needPay = (int)input("needPay/d");
			}
			$data["status"] = $needPay>0?1:-1;
			$pkey = $payObj."@".$targetId."@".$targetType."@".$needPay."@".$itmeId;
		}elseif($payObj=="enter"){
		    $flowId = (int)input("flowId");
            $pkey = input("pkey");
            $pkey = WSTBase64urlDecode($pkey);
            $pkey = explode('@',$pkey);
            
            $userId = (int)session('WST_USER.userId');
            $trade = model("shops")->getTradeFee($userId);
            $needPay = $trade['tradeFee'];
            $targetType = 0;
            $targetId = (int)session('WST_USER.userId');
            $data["status"] = $needPay>0?1:-1;
            $pkey = $payObj."@".$targetId."@".$targetType."@".$needPay."@".$flowId;
        }elseif($payObj=="supplier_enter"){
            $flowId = (int)input("flowId");
            $pkey = input("pkey");
            $pkey = WSTBase64urlDecode($pkey);
            $pkey = explode('@',$pkey);

            $userId = (int)session('WST_USER.userId');
            $trade = model("suppliers")->getTradeFee($userId);
            $needPay = $trade['tradeFee'];
            $targetType = 0;
            $targetId = (int)session('WST_USER.userId');
            $data["status"] = $needPay>0?1:-1;
            $pkey = $payObj."@".$targetId."@".$targetType."@".$needPay."@".$flowId;
        }else{
        	put_msg('生成二维码');
			$userId = (int)session('WST_USER.userId');
			$pkey = input("pkey");
			$pkey = WSTBase64urlDecode($pkey);
			put_msg('pkey 102');put_msg($pkey);
	        $pkey = explode('@',$pkey);
	        $orderNo = $pkey[0];
	        $isBatch = (int)$pkey[1]; 
	        $obj= ["userId"=>$userId,"orderNo"=>$orderNo,"isBatch"=>$isBatch];
			$data = $m->checkOrderPay2($obj);
			put_msg('108 data ');put_msg($data);
			if($data["status"]==1){
				$pkey = $payObj."@".$userId."@".$orderNo;
				if($isBatch==1){
					$pkey = $pkey."@1";
				}else{
					$pkey = $pkey."@2";
				}
			}
		}
		if($data["status"]!=1){
			if(!(isSet($data["msg"])) || $data["msg"]=="") $data["msg"]= "支付失败";
		}
		$data["url"] = url('home/weixinpays/createQrcode',array("pkey"=>WSTBase64urlEncode($pkey)));
		put_msg('data weixinpays 122');put_msg($data);
		return $data;
	}
	
	public function createQrcode() {
		$pkey = WSTBase64urlDecode(input("pkey"));
		$pkeys = explode("@", $pkey );
		$flag = true;
		$needPay = 0;
		$out_trade_no = 0;
		$trade_no = 0;
		if($pkeys[0]=="recharge"){
			$needPay = (int)$pkeys[3];
			$out_trade_no = WSTOrderNo();
			$body = "钱包充值";
			$trade_no = $out_trade_no;
		}elseif($pkeys[0]=="enter"){
			$userId = (int)session('WST_USER.userId');
            $trade = model("shops")->getTradeFee($userId);
            $needPay = $trade['tradeFee'];
            $out_trade_no = WSTOrderNo();
            $body = "店铺入驻缴纳年费";
            $trade_no = $out_trade_no;
        }elseif($pkeys[0]=="supplier_enter"){
            $userId = (int)session('WST_USER.userId');
            $trade = model("suppliers")->getTradeFee($userId);
            $needPay = $trade['tradeFee'];
            $out_trade_no = WSTOrderNo();
            $body = "供货商入驻缴纳年费";
            $trade_no = $out_trade_no;
        }else{
			if(count($pkeys)!= 4){
				$this->assign('out_trade_no', "");
			}else{
				$userId = (int)session('WST_USER.userId');
				$obj = array();
				$obj["userId"] = $userId;
				$obj["orderNo"] = $pkeys[2];
				$obj["isBatch"] = $pkeys[3];
				$m = new OM();
				$order = $m->getPayOrders($obj);
				$needPay = $order["needPay"];
				$payRand = $order["payRand"];
				$body = "支付订单费用";
				$out_trade_no = $obj["orderNo"]."a".$payRand;
				$trade_no = $obj["orderNo"];
			}
		}
		
		if($needPay>0){
			// 使用统一支付接口
			$wxQrcodePay = new \WxQrcodePay ();
			$wxQrcodePay->setParameter ( "body", $body ); // 商品描述
			$wxQrcodePay->setParameter ( "out_trade_no", $out_trade_no ); // 商户订单号
			$wxQrcodePay->setParameter ( "total_fee", $needPay * 100 ); // 总金额
			$wxQrcodePay->setParameter ( "notify_url", $this->wxpayConfig['notifyurl'] ); // 通知地址
			$wxQrcodePay->setParameter ( "trade_type", "NATIVE" ); // 交易类型
			$wxQrcodePay->setParameter ( "attach", "$pkey" ); // 附加数据
			$wxQrcodePay->SetParameter ( "input_charset", "UTF-8" );
			// 获取统一支付接口结果
			$wxQrcodePayResult = $wxQrcodePay->getResult ();
			put_msg('182 weixinpays');put_msg($wxQrcodePayResult);
			$code_url = '';
			// 商户根据实际情况设置相应的处理流程
			if ($wxQrcodePayResult ["return_code"] == "FAIL") {
				// 商户自行增加处理流程
				echo "通信出错：" . $wxQrcodePayResult ['return_msg'] . "<br>";
			} elseif ($wxQrcodePayResult ["result_code"] == "FAIL") {
				// 商户自行增加处理流程
				echo "错误代码：" . $wxQrcodePayResult ['err_code'] . "<br>";
				echo "错误代码描述：" . $wxQrcodePayResult ['err_code_des'] . "<br>";
			} elseif ($wxQrcodePayResult ["code_url"] != NULL) {
				// 从统一支付接口获取到code_url
				$code_url = $wxQrcodePayResult ["code_url"];
				// 商户自行增加处理流程
			}
			$this->assign ( 'out_trade_no', $trade_no );
			$this->assign ( 'code_url', $code_url );
			$this->assign ( 'wxQrcodePayResult', $wxQrcodePayResult );
			$this->assign ( 'needPay', $needPay );
		}else{
			$flag = false;
		}
		put_msg('weixinpays 204');put_msg($pkeys);
		if($pkeys[0]=="recharge"){
			if($pkeys[2]==1){
				return $this->fetch('shops/recharge/pay_step2');
			}else{
				return $this->fetch('users/recharge/pay_step2');
			}
		}elseif($pkeys[0]=="enter"){
            $flowId = $pkeys[4];
            $pkey = WSTBase64urlEncode($needPay."@2");
            $this->assign('pkey',$pkey);
            $this->assign('flowId',$flowId);
            $this->assign('payStep',2);
            $this->checkStep($flowId);
            $shopFlows = model('shops')->getShopFlowDatas($flowId);
            $stepFields = model('shops')->getFlowFieldsById($flowId);
            $this->assign('shopFlows',$shopFlows['flows']);
            $this->assign('prevStep',$shopFlows['prevStep']);
            $this->assign('currStep',$shopFlows['currStep']);
            $this->assign('nextStep',$shopFlows['nextStep']);
            $this->assign('stepFields',$stepFields);
            $apply = model('shops')->getShopApply();
            $this->assign('apply',$apply);
            $this->assign('payType','weixinpays');
            return $this->fetch('shop_join_step');
        }elseif($pkeys[0]=="supplier_enter") {
            $flowId = $pkeys[4];
            $pkey = WSTBase64urlEncode($needPay."@2");
            $this->assign('pkey',$pkey);
            $this->assign('flowId',$flowId);
            $this->assign('payStep',2);
            $this->supplierCheckStep($flowId);
            $supplierFlows = model('suppliers')->getSupplierFlowDatas($flowId);
            $stepFields = model('suppliers')->getFlowFieldsById($flowId);
            $this->assign('supplierFlows',$supplierFlows['flows']);
            $this->assign('prevStep',$supplierFlows['prevStep']);
            $this->assign('currStep',$supplierFlows['currStep']);
            $this->assign('nextStep',$supplierFlows['nextStep']);
            $this->assign('stepFields',$stepFields);
            $apply = model('suppliers')->getSupplierApply();
            $this->assign('apply',$apply);
            $this->assign('payType','weixinpays');
            return $this->fetch('suppliers/supplier_join_step');
        }else{
			if($flag){
				return $this->fetch('order_pay_step2');
			}else{
				return $this->fetch('order_pay_step3');
			}
		}
	}
	
	
	/**
	 * 检查支付结果
	 */
	public function getPayStatus() {
		$trade_no = input('trade_no');
		$obj = array();
		$obj["userId"] = (int)session('WST_USER.userId');
		$obj["transId"] = $trade_no;
		$m = new PM();
		$log = $m->getPayLog($obj);
		$data = array("status"=>-1);
		// 检查是否存在，存在说明支付成功
		if(isset($log["logId"]) && $log["logId"]>0){
			$m->delPayLog($obj);
			$data["status"] = 1;
		}else{
			$data["status"] = -1;
		}
		return $data;
	}
	
	/**
	 * 微信异步通知
	 */
	public function wxNotify() {
		// 使用通用通知接口
		$wxQrcodePay = new \WxQrcodePay ();
		// 存储微信的回调
		$xml = file_get_contents("php://input");
		put_msg('weiixnpays 280');put_msg($xml);
		$wxQrcodePay->saveData ( $xml );
		// 验证签名，并回应微信。
		if ($wxQrcodePay->checkSign () == FALSE) {
			$wxQrcodePay->setReturnParameter ( "return_code", "FAIL" ); // 返回状态码
			$wxQrcodePay->setReturnParameter ( "return_msg", "签名失败" ); // 返回信息
		} else {
			$wxQrcodePay->setReturnParameter ( "return_code", "SUCCESS" ); //设置返回码
		}
		
		$returnXml = $wxQrcodePay->returnXml ();
		if ($wxQrcodePay->checkSign () == TRUE) {
			if ($wxQrcodePay->data ["return_code"] == "FAIL") {
				echo "FAIL";
			} elseif ($wxQrcodePay->data ["result_code"] == "FAIL") {
				echo "FAIL";
			} else {
				// 此处应该更新一下订单状态，商户自行增删操作
				$order = $wxQrcodePay->getData ();
				$trade_no = $order["transaction_id"];
				$total_fee = $order ["total_fee"];
				$pkey = $order ["attach"] ;
				$pkeys = explode ( "@", $pkey );
				$out_trade_no = 0;
				$userId = 0;
				if($pkeys[0]=="recharge"){//充值
					$out_trade_no = $order["out_trade_no"];
					$targetId = (int)$pkeys [1];
					$userId = $targetId;
					$targetType = (int)$pkeys [2];
					$itemId = (int)$pkeys [4];
					$obj = array ();
					$obj["trade_no"] = $trade_no;
					$obj["out_trade_no"] = $out_trade_no;
					$obj["targetId"] = $targetId;
					$obj["targetType"] = $targetType;
					$obj["itemId"] = $itemId;
					$obj["total_fee"] = (float)$total_fee/100;
					$obj["payFrom"] = 'weixinpays';
					// 支付成功业务逻辑
					$m = new LM();
					$rs = $m->complateRecharge ( $obj );
				}elseif($pkeys[0]=="enter"){ // 缴纳年费
                    $out_trade_no = $order["out_trade_no"];
                    $targetId = (int)$pkeys [1];
                    $userId = $targetId;
                    $targetType = (int)$pkeys [2];
                    $obj = array ();
                    $obj["trade_no"] = $trade_no;
                    $obj["out_trade_no"] = $out_trade_no;
                    $obj["targetId"] = $targetId;
                    $obj["targetType"] = $targetType;
                    $obj["total_fee"] = (float)$total_fee/100;
                    $obj["payFrom"] = 'weixinpays';
                    $obj["scene"] = 'enter';
                    // 支付成功业务逻辑
                    $m = new SM();
                    $rs = $m->completeEnter($obj);
                }elseif($pkeys[0]=="supplier_enter"){ // 供货商缴纳年费
                    $out_trade_no = $order["out_trade_no"];
                    $targetId = (int)$pkeys [1];
                    $userId = $targetId;
                    $targetType = (int)$pkeys [2];
                    $obj = array ();
                    $obj["trade_no"] = $trade_no;
                    $obj["out_trade_no"] = $out_trade_no;
                    $obj["targetId"] = $targetId;
                    $obj["targetType"] = $targetType;
                    $obj["total_fee"] = (float)$total_fee/100;
                    $obj["payFrom"] = 'weixinpays';
                    $obj["scene"] = 'enter';
                    // 支付成功业务逻辑
                    $m = new SUM();
                    $rs = $m->completeEnter($obj);
                }else{//订单支付
					$userId = (int)$pkeys [1];
					$out_trade_no = $pkeys[2];
					$isBatch = (int)$pkeys[3];
					// 商户订单
					$obj = array ();
					$obj["trade_no"] = $trade_no;
					$obj["out_trade_no"] = $out_trade_no;
					$obj["isBatch"] = $isBatch;
					$obj["total_fee"] = (float)$total_fee/100;
					$obj["userId"] = $userId;
					$obj["payFrom"] = 'weixinpays';
					// 支付成功业务逻辑
					$m = new OM();
					$rs = $m->complatePay ( $obj );
					put_msg('weixinpays 368');put_msg($rs);

				}
				if($rs["status"]==1){
					$data = array();
					$data["userId"] = $userId;
					$data["transId"] = $out_trade_no;
					$m = new PM();
					$m->addPayLog($data);
					echo "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
				}else{
					echo "<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[FAIL]]></return_msg></xml>";
				}
			}
		}else{
			echo "FAIL";
		}
	}

	/**
	 * 检查支付结果
	 */
	public function paySuccess() {
		return $this->fetch('order_pay_step3');
	}

    /*
     * 入驻缴纳年费同步回调方法
     */
    function payAnnualFeeSuccess(){
        return $this->redirect(url("home/shops/joinstepnext",array('id'=>(int)input("flowId")),true,true));
    }

    /**
     * 检测入驻商城时有步骤有没有遗漏，不允许跳过步骤
     */
    public function checkStep($flowId){
        $this->checkUserType('shop');
        if((int)WSTConf('CONF.isOpenShopApply')!=1)return;
        $tmpShopApplyFlow = session('tmpShopApplyFlow');
        $tmpApplyStep = (int)session('tmpApplyStep');
        //如果没有建立数组则强制重新开始
        if(!$tmpShopApplyFlow){
            return $this->redirect(Url('home/shops/join'));
        }
        $flowSteps = [];
        $isFind = false;
        foreach ($tmpShopApplyFlow as $key => $v) {
            $flowSteps[] = $v['flowId'];
            if($v['flowId']==$tmpApplyStep){
                $isFind = true;
                break;
            }
        }
        //没找到这个环节强制重新开始
        if(!$isFind){
            $this->redirect(Url('home/shops/joinStepNext',array('id'=>$tmpShopApplyFlow[0]['flowId'])));
            exit();
        }
        //如果找到则判断是否当前环节是否有效
        if(!in_array($flowId,$flowSteps)){
            $flowId = end($flowSteps);
            $this->redirect(Url('home/shops/joinStepNext',array('id'=>$flowId)));
            exit();
        }
    }

    /*
     * 供货商入驻缴纳年费同步回调方法
     */
    function supplierPayAnnualFeeSuccess(){
        return $this->redirect(url("home/suppliers/joinstepnext",array('id'=>(int)input("flowId")),true,true));
    }

    /**
     * 检测供货商入驻商城时有步骤有没有遗漏，不允许跳过步骤
     */
    public function supplierCheckStep($flowId){
        $this->checkUserType('supplier');
        if((int)WSTConf('CONF.isOpenSupplierApply')!=1)return;
        $tmpSupplierApplyFlow = session('tmpSupplierApplyFlow');
        $tmpApplyStep = (int)session('tmpApplyStep');
        //如果没有建立数组则强制重新开始
        if(!$tmpSupplierApplyFlow){
            return $this->redirect(Url('home/suppliers/join'));
        }
        $flowSteps = [];
        $isFind = false;
        foreach ($tmpSupplierApplyFlow as $key => $v) {
            $flowSteps[] = $v['flowId'];
            if($v['flowId']==$tmpApplyStep){
                $isFind = true;
                break;
            }
        }
        //没找到这个环节强制重新开始
        if(!$isFind){
            $this->redirect(Url('home/suppliers/joinStepNext',array('id'=>$tmpSupplierApplyFlow[0]['flowId'])));
            exit();
        }
        //如果找到则判断是否当前环节是否有效
        if(!in_array($flowId,$flowSteps)){
            $flowId = end($flowSteps);
            $this->redirect(Url('home/suppliers/joinStepNext',array('id'=>$flowId)));
            exit();
        }
    }

    // 检测用户账号
    public function checkUserType($type=''){
        $USER = session('WST_USER');
        if($type=='shop'){
            if(!($USER['userType']==0 || $USER['userType']==1)){
                if(request()->isAjax()){
                    die('{"status":-999,"msg":"当前账号已关联供货商/门店信息，不能申请商家"}');
                }else{
                    $this->redirect('home/shops/disableApply');
                    exit;
                }
            }
        }else{
            if(!($USER['userType']==0 || $USER['userType']==3)){
                if(request()->isAjax()){
                    die('{"status":-999,"msg":"当前账号已关联店铺/门店信息，不能申请供货商"}');
                }else{
                    $this->redirect('home/suppliers/disableApply');
                    exit;
                }
            }
        }
    }
}
