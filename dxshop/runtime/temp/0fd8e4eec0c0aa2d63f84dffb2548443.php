<?php /*a:1:{s:65:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\\login.html";i:1737762835;}*/ ?>
<!DOCTYpE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-Ua-Compatible" content="IE=edge">
<meta name="Keywords" content=""/>
<meta name="Description" content=""/>
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link href="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__SHOP__/css/login.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />
<title>商家中心登录 - <?php echo WSTConf('CONF.mallName'); ?></title>
</head>
<body id="loginFrame">
	<div class="contrainer">
		<div class="wst-lo-top">
		  <div class='login_logo'>
			  <img src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.mallLogo'); ?>">
		  </div>
		</div>
		<?php  $adsRs = WSTAds('ads-login-shop',1,31536000);?>
		<div class="wst-lo-center" <?php if(isset($adsRs['adFile'])): ?>style='background: url(__RESOURCE_PATH__/<?php echo $adsRs["adFile"]; ?>) no-repeat top center;min-width: 1200px;'<?php endif; ?>>
		  <div class="wst-lo">
			<div class="login-wrapper">
			  <div class="boxbg2"></div>
			  <div class="box">

					  <div class="login-title">商家中心登录</div>
					  <form class="wst-lo-form">
						  <table>
							  <tr>
								  <td>
									  <div class="frame wst-flex-row">
										  <div class="icon wst-flex-row wst-center">
											  <img src="__SHOP__/img/icon_user.png" />
										  </div>
										  <input type='text' id='loginName' class='ipt text' placeholder='请输入帐号'>
									  </div>
								  </td>
							  </tr>
							  <tr>
								  <td>
									  <div class="frame wst-flex-row">
										  <div class="icon wst-flex-row wst-center">
											  <img src="__SHOP__/img/icon_pwd.png" />
										  </div>
										  <input type='password' id='loginPwd' class='ipt text' placeholder='请输入密码'>
									  </div>
								  </td>
							  </tr>
							  <tr>
								  <td>
									  <div class="frame" style="position: relative;">
										  <div class="wst-flex-row">
											  <div class="icon wst-flex-row wst-center">
												  <img src="__SHOP__/img/icon_yanzhengma.png" />
											  </div>
											  <input type='text' id='verifyCode' class='ipt text2' placeholder='请输入验证码'>
										  </div>
										  <img id='verifyImg' src="<?php echo url('shop/index/getVerify'); ?>" onclick='javascript:getVerify(this)'>
									  </div>
								  </td>
							  </tr>
							  <tr>
								  <td colspan='2' align='center'>
									  <botton id='loginbtn' type='button' class='layui-btn layui-btn-big layui-btn-normal' onclick='javascript:login()'>登录</botton>
								  </td>
							  </tr>
						  </table>
					  </form>
				</div>
			</div>
		</div>
	</div>
	<div class="login-footer">
	      <div class="wst-footer-flink">
	 
	    </div>
	     <?php 
	          if(WSTConf('CONF.mallFooter')!=''){
	              echo htmlspecialchars_decode(WSTConf('CONF.mallFooter'));
	            }
	      
	        if(WSTConf('CONF.visitStatistics')!=''){
	          echo htmlspecialchars_decode(WSTConf('CONF.visitStatistics'))."<br/>";
	          }
	      if(WSTConf('CONF.mallLicense') == ''): ?>
	     <div>
	        Copyright©2019 Powered By <a target="_blank" href="http://hk-city.com">WSTMart</a>
	     </div>
	     <?php else: ?>
	        <div id="wst-mallLicense" data='1' style="display:none;">Copyright©2016 Powered By <a target="_blank" href="http://hk-city.com">WSTMart</a></div>
	     <?php endif; ?>
	</div>
	<input type='hidden' id='token' value='<?php echo WSTConf("CONF.pwdModulusKey"); ?>'/>
	<script type='text/javascript' src='/hkshopNC/dxshop/static/js/jquery.min.js'></script>
	<script>
		window.conf = {"DOMAIN":"<?php echo str_replace('index.php','',app('request')->root(true)); ?>","ROOT":"/hkshopNC/dxshop","APP":"/hkshopNC/dxshop","STATIC":"/hkshopNC/dxshop/static","SUFFIX":"<?php echo config('url_html_suffix'); ?>","IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>"}
		</script>
		<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
		<script type='text/javascript' src='/hkshopNC/dxshop/static/js/common.js'></script>
		<script type="text/javascript" src="/hkshopNC/dxshop/static/js/rsa.js"></script>
		<script type='text/javascript' src='__SHOP__/js/common.js'></script>
		<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>
		<script src="__SHOP__/js/login.js?v=<?php echo $v; ?>" type="text/javascript"></script>
		<script type="text/javascript">
		if (window.frames.length != parent.frames.length) {
		　　parent.location.reload();
		}
	</script>
</body>
</html>
