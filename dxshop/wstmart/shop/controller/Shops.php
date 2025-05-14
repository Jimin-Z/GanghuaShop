<?php
namespace wstmart\shop\controller;
use wstmart\common\model\GoodsCats;
use wstmart\shop\validate\Shops as Validate;
use wstmart\common\model\Shops as M;
use wstmart\common\model\LogSms;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 门店控制器
 */

class Shops extends Base{
    protected $beforeActionList = ['checkAuth'];
    /**
    * 店铺公告页
    */
    public function notice(){
        $notice = model('shops')->getNotice();
        $this->assign('notice',$notice);
        return $this->fetch('shop/notice');
    }
    /**
    * 修改店铺公告
    */
    public function editNotice(){
        $s = model('shops');
        return $s->editNotice();
    }


    /**
     * 查看店铺设置
     */
    public function info(){
    	$s = model('shops');
    	$object = $s->getByView((int)session('WST_USER.shopId'));
    	$this->assign('object',$object);
        $this->assign('banks',model('banks')->listQuery(0));
        $this->assign('areas',model('areas')->listQuery(0));
    	return $this->fetch('shop/view');
    }

    /**
     * 编辑店铺资料
     */
    public function editShopInfoByShop(){
        $rs = model('shops')->editShopInfoByShop();
        return $rs;
    }
    public function editShopBankInfoByShop(){
        $rs = model('shops')->editShopBankInfoByShop();
        return $rs;
    }

    /**
     * 获取店铺金额
     */
    public function getShopMoney(){
        $rs = model('shops')->getFieldsById((int)session('WST_USER.shopId'),'shopMoney,lockMoney,rechargeMoney,payPwd');
        $rs['isSetPayPwd'] = ($rs['payPwd']=='')?0:1;
        $rs['isDraw'] = ((float)WSTConf('CONF.drawCashShopLimit')<=$rs['shopMoney'])?1:0;
        unset($rs['payPwd']);
        return WSTReturn('',1,$rs);
    }

    /*
     * 商家续费
     */
    public function renew(){
        $rs = model('shops')->renew();
        return $rs;
    }

    /**
     * 生成商品二維碼
     */
    public function createShopQrcode(){
        $m = model("shops");
        $vtype = (int)input("vtype",0);
        $shopId = (int)session('WST_USER.shopId');
        if($shopId>0){
            $subDir =  'upload/shares/shop/'.date("Y-m");
            WSTCreateDir(WSTRootPath().'/'.$subDir);
            $today = date("Ymd");
            $fname = 'shop_qr_'.($vtype==1?'mo':'we').'_'.$shopId.'.png';
            $outImg = $subDir.'/'.$fname;
            $shareImg = WSTRootPath().'/'.$outImg;

            if($vtype==2){
                $shopHomeTheme = $m->getShopHomeTheme($shopId,"weapp");
                try{
                    $weapp = new \weapp\WSTWeapp(WSTConf('CONF.weAppId'),WSTConf('CONF.weAppKey'));
                    $tokenId = $weapp->getToken();

                    $parm['scene'] = $shopId;
                    $page = "pages/shop-home/shop-home";
                    if($shopHomeTheme == 'shop_floor'){
                        $page = "pages/shop-self/shop-self";
                    }
                    $parm['page'] = $page;
                    $parm['width'] = 400;
                    $url='https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$tokenId;
                    $qrdata = $weapp->http($url,json_encode($parm));
                    $qr_code = WSTRootPath().'/'.$subDir.'/'.$fname;// 小程序碼
                    file_put_contents( $qr_code,$qrdata );
                }catch (\Exception $e) {
                     return WSTReturn("生成小程序二维码失败，请检查小程序配置是否正确");
                }
            }else{
                $qr_url = url('mobile/shops/index',array('shopId'=>$shopId),true,true);//二維碼內容
                //生成二維碼圖片
                $qr_code = WSTCreateQrcode($qr_url,'','shop',3600,2);
                $qr_code = WSTRootPath().'/'.$qr_code;
            }

            $rs = $m->createPoster(0,$qr_code,$outImg);
            return WSTReturn("生成成功",1,$outImg);
        }else{
            return WSTReturn("生成失败，无效的商品ID");
        }
    }

    /**
     * 跳去修改店铺支付密码页
     */
    public function editPayPass(){
        $m = new M();
        //获取店铺信息
        $shopId = (int)session('WST_USER.shopId');
        $data = $m->getByView($shopId);
        $this->assign('data',$data);
        return $this->fetch('security/shop_pay_pass');
    }
    /**
     * 修改店铺支付密码
     */
    public function payPassEdit(){
        $m = new M();
        $rs = $m->editPayPass();
        return $rs;
    }

    /**
     * 忘记店铺支付密码
     */
    public function backPayPass(){
        $m = new M();
        $shopId = (int)session('WST_USER.shopId');
        $data = $m->getByView($shopId);
        $userPhone = $data['userPhone'];
        $data['userPhone'] = WSTStrReplace($data['userPhone'],'*',3);
        $data['phoneType'] = empty($userPhone)?0:1;

        $process = 'One';
        $this->assign('data', $data);
        $this->assign('process', $process);
        return $this->fetch('security/shop_edit_pay');
    }

    /**
     * 忘记店铺支付密码：发送短信
     */
    public function  getphoneverifypay(){
        $m = new M();
        $shopId = (int)session('WST_USER.shopId');
        $data = $m->getByView($shopId);
        $userPhone = $data['userPhone'];
        $phoneVerify = rand(100000,999999);
        $rv = ['status'=>-1,'msg'=>'短信发送失败'];
        $tpl = WSTMsgTemplates('PHONE_FOTGET_PAY');
        if( $tpl['tplContent']!='' && $tpl['status']=='1'){
            $params = ['tpl'=>$tpl,'params'=>['LOGIN_NAME'=>$data['loginName'],'VERFIY_CODE'=>$phoneVerify,'VERFIY_TIME'=>10]];
            $m = new LogSms();
            $rv = $m->sendSMS(0,$userPhone,$params,'getPhoneVerifyt',$phoneVerify);
        }
        if($rv['status']==1){
            $USER = [];
            $USER['userPhone'] = $userPhone;
            $USER['phoneVerify'] = $phoneVerify;
            session('Shop_Verify_backPaypwd_info',$USER);
            session('Shop_Verify_backPaypwd_Time',time());
            return WSTReturn('短信发送成功!',1);
        }
        return $rv;
    }

    /**
     * 忘记店铺支付密码：验证
     */
    public function payEditt(){
        $payVerify = input("post.Checkcode");
        $timeVerify = session('Shop_Verify_backPaypwd_Time');
        if(!session('Shop_Verify_backPaypwd_info.phoneVerify') || time()>floatval($timeVerify)+10*60){
            return WSTReturn("校验码已失效，请重新发送！");
        }
        if($payVerify==session('Shop_Verify_backPaypwd_info.phoneVerify')){
            return WSTReturn("验证成功",1);
        }
        return WSTReturn("校验码不一致，请重新输入！",-1);
    }
    public function editPaySut(){
        $process = 'Two';
        $this->assign('process',$process);
        if(session('Shop_Verify_backPaypwd_info.phoneVerify')){
            return $this->fetch('security/shop_edit_pay');
        }
        $this->error('地址已失效，请重新验证身份');
    }
    /**
     * 忘记店铺支付密码：设置
     */
    public function payEdito(){
        $process = input("post.process");
        $timeVerify = session('Shop_Verify_backPaypwd_Time');
        if(!session('Shop_Verify_backPaypwd_info.phoneVerify') || time()>floatval($timeVerify)+10*60){
            return WSTReturn("地址已失效，请重新验证身份！");
        }
        $m = new M();
        $rs = $m->resetbackPay();
        if($process=='Two'){
            $rs['process'] = $process;
        }else{
            $rs['process'] = '0';
        }
        return $rs;
    }
    /**
     * 忘记店铺支付密码：完成
     */
    public function editPaySu(){
        $pr = input("get.pr");
        $process = 'Three';
        $this->assign('process',$process);
        if($pr == 'Two'){
            return $this->fetch('security/shop_edit_pay');
        }else{
            return $this->fetch('security/shop_pay_pass');
        }
    }
}
