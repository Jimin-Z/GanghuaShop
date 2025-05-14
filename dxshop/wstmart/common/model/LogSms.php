<?php
namespace wstmart\common\model;
//use wstmart\admin\model\Base;
use wstmart\admin\model\Base as bBase;

/**
* 短信日志类
 */
class LogSms extends bBase{
	protected $pk = 'smsId';

	/**
	 * 
	 * 写入并发送短讯记录
	 */
	public function sendSMS($smsSrc,$phoneNumber,$params,$smsFunc,$verfyCode,$userId=0,$isLimit=1){
		//判断有没有开启短信功能
		if(iyiiConf('smsOpen')==0) return WSTReturn('未开启短信接口');
		$userId = $userId>0? getUserid(0,1):$userId;
		$ip = request()->ip();
		if($isLimit==1){
			//检测短信验证码验证是否正确
			if(iyiiConf("smsVerfy")==1){
				$smsverfy = input("post.smsVerfy");
				$rs = DataVerifyCheck($smsverfy);
				if(!$rs){ return WSTReturn("验证码不正确!",-2); }
			}
			//检测是否超过每日短信发送数
			$sn=$this->checkSendCount(["smsPhoneNumber"=>$phoneNumber]);
		    $sn=($sn==0) ? 0 :  $this->checkSendCount(["smsIP"=>$ip]);
			//if ($sn==0) return WSTReturn("请勿频繁发送短信验证!");
		}
		$this->sendSms_Admin($smsSrc,$phoneNumber,$params,$smsFunc,$verfyCode,$userId);
	//	$rdata = ['msg'=>'短信发送失败!','status'=>-1];
		//hook('sendSMS',['phoneNumber'=>$phoneNumber,"params"=>$params,'smsId'=>$this->smsId,'status'=>&$rdata]);
		$rs=$this->sendSms_qmdd($phoneNumber,'');
		$rs=substr($rs,-5);$b=1;
		if(!ctype_digit($rs)){	$rs='';$b=0;}
		setGetValue('checkcode',$rs);
		return ['msg'=>'短信发送成功!','status'=>$b,'checkcode'=>$rs];
	}
    /*
     $w1=
     ["smsPhoneNumber"=>$phoneNumber]*/
    function checkSendCount($w1){
		//检测是否超过每日短信发送数
		$date = date('Y-m-d');
		$wd=[$date.' 00:00:00', $date.' 23:59:59'];
		$tmp = $this->field("count(smsId) counts,max(createTime) createTime")
			->where($w1)->whereTime('createTime', 'between', $wd)->find();
		$rs=($tmp['counts']>iyiiConf("smsLimit")) ? 0 : 1;
		$rt=$tmp['createTime'];
		return ($rt !='' && ((time()-strtotime($rt))<15) ) ? 0 : $rs;
    }
	/**
	 * 写入并发送管理员短讯记录
	 */
	public function sendAdminSMS($smsSrc,$phoneNumber,$params,$smsFunc,$verfyCode,$userId=0){
		//判断有没有开启短信功能
		if(iyiiConf('smsOpen')==0)return WSTReturn('未开启短信接口');
	    if($phoneNumber=="") return ['msg'=>'电话号码错!','status'=>-1];	
		$this->sendSms_Admin($smsSrc,$phoneNumber,$params,$smsFunc,$verfyCode,$userId);
	    $this->sendSms_qmdd($phoneNumber,$msg);
		return ['msg'=>'短信发送失败!','status'=>-1];
	}


	/**
	 * 写入并发送管理员短讯记录
	 */
	public function sendSms_Admin($smsSrc,$phoneNumber,$params,$smsFunc,$verfyCode,$userId=0){
		$userId = $userId>0? getUserid(0,1):$userId;
		$ip = request()->ip();
		$data = array();
		$data['smsSrc'] = $smsSrc;
		$data['smsUserId'] = $userId;
		$data['smsPhoneNumber'] = $phoneNumber;
		$data['smsContent'] = 'N/A';
		$data['smsReturnCode'] = '';
		$data['smsCode'] = $verfyCode;
		$data['smsIP'] = $ip;
		$data['smsFunc'] = $smsFunc;
		$data['createTime'] = date('Y-m-d H:i:s');
		$this->save($data);
	}

	
function sendSms_qmdd($mobile,$content){
	    //accesskey：HhZRzRIKicP3DsLj
        //secret：jVHDRri4HEOLdkotDguzvXquWAlbS2uu
        //http://127.0.0.1/qmdd_admin/admin/qmdd2018/index.php?r=Gameupdate/SendSms&mobile=13450489369&content=abcdef
        $target='https://qmdd.net/hkshop/shop/index.php?r=attractinvestment/httpVerification&phone='.$mobile;
        $content=rawurlencode($content);   
        $post_data="mobile=".$mobile."&content=".$content;
        //$target=$target."&".$post_data;
        $post_data='';
      //  $send_result=$this->sms_post_url($target,$post_data,false,true);
         $send_result=$this->https_request($target);
        return $send_result;
    }


function https_request($url) {
    if (function_exists('curl_init')) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return null;
        }
        curl_close($curl);
    } else {
    	$data=null;
        if (file_exists($url)) {
            $data = file_get_contents($url);
         }
    }
     return $data;
}
  //   * Http post请求
  
    function sms_post_url($url,$post_data,$header=false,$nobody=false,$isHttps=false){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, $nobody);
        curl_setopt($ch, CURLOPT_POST, true);//POST数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);//post变量
        if ($isHttps === true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
        }
        $output = curl_exec($ch);
        $post_code=curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $output = ($post_code == '404' ||$post_code=='0')?"":$output;   
        curl_close($ch);
        return $output;
    }
  
}
