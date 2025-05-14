<?php /*a:2:{s:69:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\user_login.html";i:1737762835;s:66:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\base_js.html";i:1669885590;}*/ ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>用户登录 - <?php echo WSTConf('CONF.mallName'); ?></title>

<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__STYLE__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">

<link href="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/login.css?v=<?php echo $v; ?>" rel="stylesheet">

<script type="text/javascript" src="/hkshopNC/dxshop/static/js/jquery.min.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='/hkshopNC/dxshop/static/js/common.js?v=<?php echo $v; ?>'></script>

<script type='text/javascript' src='__STYLE__/js/common.js?v=<?php echo $v; ?>'></script>
<script>
window.conf = {"ROOT":"/hkshopNC/dxshop","APP":"/hkshopNC/dxshop/index.php","STATIC":"/hkshopNC/dxshop/static","SUFFIX":"<?php echo config('url_html_suffix'); ?>","SMS_VERFY":"<?php echo WSTConf('CONF.smsVerfy'); ?>","SMS_OPEN":"<?php echo WSTConf('CONF.smsOpen'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>","IS_LOGIN":"<?php if((int)session('WST_USER.userId')>0): ?>1<?php else: ?>0<?php endif; ?>","TIME_TASK":"1","ROUTES":'<?php echo WSTRoute(); ?>',"IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>","HTTP":"<?php echo WSTProtocol(); ?>","MAP_KEY":"<?php echo WSTConf('CONF.mapKey'); ?>",'RESOURCE_DOMAIN':'<?php echo WSTConf('CONF.resourceDomain'); ?>','RESOURCE_PATH':'<?php echo WSTConf('CONF.resourcePath'); ?>'}
</script>
</head>
<body>

	<input type="hidden" id="token" value='<?php echo WSTConf("CONF.pwdModulusKey"); ?>'/>

    <div class="wst-login-banner">
      <div class="wst-icon-banner">
      	<?php $mallName = WSTConf('CONF.mallName'); ?>

    	<div class="img-banner" >
    		<a href='<?php echo app('request')->root(true); ?>' title="<?php echo WSTStripTags($mallName); ?>" >
    		<img src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.mallLogo'); ?>">
    		</a>
    	</div>
        <div class="wst-right-action">
    		  没有账号? <a class="wst-login-but wst-location" href="<?php echo Url('home/users/regist'); ?>" onclick="WST.currentUrl();">立即注册</a>
    	</div>
       </div>
    </div>
    <?php  $adsRs = WSTAds('ads-login-user',1,31536000);?>
	<div class="wst-login-middle" <?php if(isset($adsRs['adFile'])): ?>style='background: url(__RESOURCE_PATH__/<?php echo $adsRs['adFile']; ?>) center center no-repeat;'<?php endif; ?>>
	<div class="wst-container">
	<div class="wst-login_l">
	 <div class="wst-login_r">
			<?php $loginTypeArr = explode(',',WSTConf('CONF.loginType')); ?>
			<div id='tab1' class="wst-tab-box">
				<ul id='goodsTabs1' class="wst-tab-nav">
					<?php if(in_array(3,$loginTypeArr)): ?><li>扫码登录</li><?php endif; if(in_array(2,$loginTypeArr)): ?><li>手机登录</li><?php endif; if(in_array(1,$loginTypeArr)): ?><li>账号登录</li><?php endif; ?>
				</ul>
				<div class="wst-tab-content">
					<?php if(in_array(3,$loginTypeArr)): ?>
					<div class="wst-tab-item">
						<div class="qrcode-main">
							<div class="qrcode-img">
								<div style="display: none;" class="qrcode-error-mask">
									<div class="qrcode-msg">
										二维码已失效
									</div>
									<a class="qrcode-btn">
										刷新
									</a>
								</div>

								<div style="display: none;" class="qrcode-scanner">
									<div class="qr-scanner-img"></div>
									<div class="qr-scanner-title">扫描成功</div>
									<div class="qr-scanner-desc">请勿刷新本页面，按手机提示操作！</div>
								</div>

								<!-- <img src="__STYLE__/img/wst_qr_code.jpg"> -->
							</div>
							<p>打开 <span>WSTMart App</span>  扫描二维码</p>
							<ul class="qr-coagent">
								<li>
									<i></i>
									<em>免输入</em>
								</li>
								<li>
									<i class="faster"></i>
									<em>更快</em>
								</li>
								<li>
									<i class="more-safe"></i>
									<em>更安全</em>
								</li>
							</ul>
						</div>
					</div>
					<?php endif; if(in_array(2,$loginTypeArr)): ?>
					<div class="wst-tab-item">
						<form method="post" autocomplete="off" id="login_form" >
						<input type='hidden' id='typ' value='0' class='ipt'/>
						<div class="wst-item wst-item-box" style="margin-top: 20px;">
							<div for="loginnamea" class="login-img"></div>
							<input id="loginNamea" name="loginNamea" class="ipt wst-login-input-1" maxlength="11"  tabindex="1" autocomplete="off" type="text" data-rule="手机号: required;" data-msg-required="请填写手机号" data-tip="请输入手机号" placeholder="手机号"/>
						</div>
						<div class="wst-item wst-item-box">
							<div for="loginnamea" class="yanzheng-img"></div>
							<div id="mobileCodeDiv" class="wst-login-tr">
								<input maxlength="6" autocomplete="off" tabindex="6" class="ipt wst-regist-codemo" name="mobileCode" style="ime-mode:disabled" id="mobileCode" type="text" data-target="#mobileCodeTips" placeholder="短信验证码"/>
								<?php if((int)WSTConf('CONF.isAddonCaptcha')!=1): ?>
								<button type="button" id="timeTips" onclick="getVerifyCode(2);" class="wst-regist-obtain">获取短信验证码</button>
                                <?php else: ?>
							    <?php echo hook('homeDocumentLoginSmsCaptcha'); ?>
							    <?php endif; ?>
								<span id="mobileCodeTips"></span>
							</div>
						</div>
						<div class="wst-item wst-item-box" style="border: 0;" >
							<div style="width:100%;height:32px;line-height:32px;float:left;"><a id="reg_butt" onclick='javascript:login2(1)' class="wst-login-but">登录</a></div>
						</div>
					    </form>
					</div>
					<?php endif; if(in_array(1,$loginTypeArr)): ?>
					<div class="wst-tab-item">
						<form method="post" autocomplete="off">
						<input type='hidden' id='typ' value='0' class='ipt'/>
						<div class="wst-item wst-item-box" style="margin-top: 20px;">
							<div for="loginname" class="login-img"></div>
							<input id="loginName" name="loginName" class="ipt wst-login-input-1"  tabindex="1" value="<?php echo $loginName; ?>" autocomplete="off" type="text" data-rule="用户名: required;" data-msg-required="请填写用户名" data-tip="请输入用户名" placeholder="邮箱/用户名"/>
						</div>
						<div class="wst-item wst-item-box">
							<div for="loginname" class="password-img"></div>
							<input id="loginPwd" name="loginPwd" class="ipt wst-login-input-1" tabindex="2" autocomplete="off" type="password" maxlength="20" data-rule="密码: required;" data-msg-required="请填写密码" data-tip="请输入密码" placeholder="密码"/>
						</div>
						<div class="wst-item wst-item-box">
							<div for="loginname" class="yanzheng-img"></div>
							<div class="wst-login-code-1">
								<input id="verifyCode" style="ime-mode:disabled" name="verifyCode"  class="ipt wst-login-codein-1" tabindex="6" autocomplete="off" maxlength="6" type="text" data-rule="验证码: required;" data-msg-required="请输入验证码" data-tip="请输入验证码" data-target="#verify" placeholder="验证码"/>
								<img id='verifyImg' class="wst-login-codeim-1" src="<?php echo url('home/index/getVerify'); ?>" onclick='javascript:WST.getVerify("#verifyImg","#verifyCode")' style="width:125px;height:36px;border-top-right-radius:6px;border-bottom-right-radius:6px;float: right;margin-top: 1px;"><span id="verify"></span>
							</div>
						</div>
						<table class="wst-table">
							<tr class="wst-login-tr">
								<td colspan="2" style="padding-left:0px;">
									<input id="rememberPwd" name="rememberPwd" class="ipt wst-login-ch" checked="checked" type="checkbox"/>
									<label>记住密码</label>
									<label><a style="color:#b2b1b1;float:right;" href="<?php echo Url('home/users/regist'); ?>">&nbsp;免费注册</a></label>
									<label><a style="color:#b2b1b1;float:right;" href="javascript:;" onclick="javascript:location.href=WST.U('home/users/forgetpass','loginName='+$('#loginName').val())" >忘记密码? | </a></label>
								</td>
							</tr>
						</table>
						<div class="wst-item wst-item-box" style="border: 0;" >
							<div style="width:100%;height:32px;line-height:32px;float:left;"><a class="wst-login-but" href="javascript:void(0);" onclick='javascript:login(1)'>登录</a></div>
						</div>
					    </form>
					</div>
					<?php endif; ?>
				</div>
		    </div>
		<?php echo hook('homeDocumentLogin'); ?>
	 </div>
	</div>
	</div>
	<div class="wst-clear"></div>
	</div>
	<div class="wst-footer">
		<div class="wst-container">
		<div class="wst-footer-hp-ck3">
	        <div class="links">
	           <?php $navs = WSTNavigations(1); if(is_array($navs) || $navs instanceof \think\Collection || $navs instanceof \think\Paginator): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	           <a href="<?php echo $vo['navUrl']; ?>" <?php if($vo['isOpen']==1): ?>target="_blank"<?php endif; ?>><?php echo $vo['navTitle']; ?></a>
	           <?php if($i< count($navs)): ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php endif; ?>
	           <?php endforeach; endif; else: echo "" ;endif; ?>
	        </div>
	        <div class="copyright">
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
				<div id="wst-mallLicense" data='1' style="display:none;">Copyright©2019 Powered By <a target="_blank" href="http://hk-city.com">WSTMart</a></div>
	        <?php endif; ?>
	        </div>
	    </div>
	    </div>
	  </div>


    <script type="text/javascript" src="/hkshopNC/dxshop/static/js/rsa.js"></script>
	<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.min.js?v=<?php echo $v; ?>"></script>
	<script type='text/javascript' src='__STYLE__/js/login.js?v=<?php echo $v; ?>'></script>
	<script type='text/javascript' src='/hkshopNC/dxshop/static/js/qrcode.js?v=<?php echo $v; ?>'></script>
	<script>
		var interval;
		$(function(){
			$('#tab1').TabPanel({tab:0,callback:function(no){
				if(no==1);
				if(no==2);
			}});
			
			<?php if(in_array(3,$loginTypeArr)): ?>
				getQrCode();
				$('.qrcode-btn').click(function(){
					$('.qrcode-img').find('img').remove();
					getQrCode();
				})
			<?php endif; ?>
		})
    $(document).keypress(function(e) {
		if(e.which == 13) {
			login();
		}
	});
	
	<?php if(in_array(3,$loginTypeArr)): ?>
		function getQrCode(){
			var url = '<?php echo url("home/qrcode/getToken"); ?>';
			$.get(url, function(res){
				var json = WST.toJson(res);
				if(json.status==1){
					var token = json.data.token;
					var url = 't='+token;
					var qrcode = new QRCode($(".qrcode-img")[0], {
						width : 200,
						height : 200,
					});
					qrcode.makeCode(url);

					qrCheck(token);
				}else{
					WST.msg("二维码获取异常", {icon: 2});
				}
			});
		}

		function qrCheck(token){
			$('.qrcode-error-mask').hide();
			$('.qrcode-scanner').hide();
			var url = '<?php echo url("home/qrcode/qrScannerCheck"); ?>?token='+token;
			clearInterval(interval);
			interval = setInterval(function(){
				var ja = document.createElement('script');
				ja.type = 'text/javascript';
				ja.async = true;
				ja.src = url;
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ja, s);
				ja.remove();
			}, 2000)

		}
		function wstjsonp(str){
			var json = WST.toJson(str);
			var succMask = $('.qrcode-scanner');
			var errMask = $('.qrcode-error-mask');
			var errMsg = errMask.find('.qrcode-msg');
			switch(json.status){
				case -3:
					
					errMsg.html(json.msg);
					errMask.show();
					succMask.hide();
					break;
				case -2:
					
					errMsg.html(json.msg);
					errMask.show();
					succMask.hide();
					break;
				case 0:
					
					succMask.show();
					break;
				case 1:
					
					console.log("执行登录");
					window.location.reload();
					break;
				default:
					
			}
		}
	<?php endif; ?>


	</script>

</body>