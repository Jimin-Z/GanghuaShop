<?php /*a:1:{s:66:"D:\wamp64\www\qmdd\dxshop\wstmart\home\view\default\box_login.html";i:1738761714;}*/ ?>
<style type="text/css">
	.wst-login_r{width: 99%;margin: 5px auto;float: none;height: 390px;}
	.wst-login_r .wst-tab-box li{margin-top:20px; padding: 0px;border: 0px;height: 20px;}
	.wst-login_r .wst-tab-nav{background: #fff; border: 0px; height: auto}
	.wst-login_r .wst-tab-nav .on{background: #fff;}
	.wst-tab-content{border: 0px;}
	input.wst-login-input-1{width: 260px;height: 32px;}
	.wst-regist-obtain{width: 127px;}
	.wst-table{margin-top: 20px;margin-left: -30px;}
	#verify{ margin-left: 90px;}
	#verify .n-right{margin-top: -1px;}
	.wst-login-code{width: 246px;}
</style>
<div class="wst-login_r">
			<?php $loginTypeArr = explode(',',WSTConf('CONF.loginType')); ?>
			<div id='tab' class="wst-tab-box" style="border-right:0;">
				<ul id='goodsTabs' class="wst-tab-nav">
					<?php if(in_array(3,$loginTypeArr)): ?><li>扫码登录</li><?php endif; if(in_array(2,$loginTypeArr)): ?><li>手机登录</li><?php endif; if(in_array(1,$loginTypeArr)): ?><li>账号登录</li><?php endif; ?>
				</ul>
				<div class="wst-tab-content">
					<?php if(in_array(3,$loginTypeArr)): ?>
					<div class="wst-tab-item">
						<div class="qrcode-main">
							<div class="qrcode-img"><img src="__STYLE__/img/wst_qr_code.jpg"></div>
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
						<input type="hidden" id="token" value='<?php echo WSTConf("CONF.pwdModulusKey"); ?>'/>
						<form method="post" autocomplete="off" id="login_form" >

						<div class="wst-item wst-item-box" style="margin-top: 20px;">
							<div for="loginnamea" class="login-img"></div>
							<input id="loginNamea" name="loginNamea" class="ipt wst-login-input-1" maxlength="11"  tabindex="1" autocomplete="off" type="text" data-rule="手机号: required;" data-msg-required="请填写手机号" data-tip="请输入手机号" placeholder="手机号"/>
						</div>
						<div class="wst-item wst-item-box">
							<div for="loginname" class="yanzheng-img"></div>
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
							<div style="width:100%;height:32px;line-height:32px;float:left;"><a id="reg_butt" class="wst-login-but" onclick='javascript:login2(3)'>登录</a></div>
						</div>
					    </form>
					</div>
					<?php endif; if(in_array(1,$loginTypeArr)): ?>
					<div class="wst-tab-item">
						<input type="hidden" id="token" value='<?php echo WSTConf("CONF.pwdModulusKey"); ?>'/>
						<form method="post" autocomplete="off">
							<table class="wst-table">
								<tr class="wst-login-tr">
									<td width='60' align='right'>账号：</td>
									<td><input id="loginName" name="loginName" class="ipt wst-login-input"  tabindex="1" value="" autocomplete="off" type="text" data-rule="用户名: required;" data-msg-required="请填写用户名" data-tip="请输入用户名" placeholder="邮箱/用户名" style="width: 240px" /></td>
								</tr>
								<tr class="wst-login-tr">
									<td align='right'>密码：</td>
									<td><input id="loginPwd" name="loginPwd" class="ipt wst-login-input" tabindex="2" autocomplete="off" type="password" data-rule="密码: required;" data-msg-required="请填写密码" data-tip="请输入密码" placeholder="密码" style="width: 240px"/> </td>
								</tr>
								<tr class="wst-login-tr">
									<td align='right'>验证码：</td>
									<td>
										<div class="wst-login-code">
											<input id="verifyCode" style="ime-mode:disabled;width: 120px" name="verifyCode"  class="ipt wst-login-codein" tabindex="6" autocomplete="off" maxlength="6" type="text" data-rule="验证码: required;" data-msg-required="请输入验证码" data-tip="请输入验证码" data-target="#verify"placeholder="验证码" />
											<img id='verifyImg' class="wst-login-codeim" src="<?php echo url('home/users/getVerify'); ?>" onclick='javascript:WST.getVerify("#verifyImg","#verifyCode")' style="width:116px;border-top-right-radius:6px;border-bottom-right-radius:6px;"><span id="verify"></span>
										</div>
									</td>
								</tr>
								<tr class="wst-login-tr">
									<td colspan="2" style="padding-left:43px;">
										<input id="rememberPwd" name="rememberPwd" class="ipt wst-login-ch" checked="checked" type="checkbox"/>
										<label>记住密码</label>
										<label><a style="color:#666;line-height:32px;margin-left:10px;" target='_blank' href="<?php echo Url('home/users/regist'); ?>">免费注册</a>&nbsp;| </label>
										<label><a style="color:#666;line-height:32px;" href="javascript:;" onclick="javascript:window.open(WST.U('home/users/forgetpass','loginName='+$('#loginName').val()))" >忘记密码? </a></label>
									</td>
								</tr>
								<tr>
									<td><div style="width: 80px;">&nbsp;</div></td>
									<td>
										<div class="wst-item" style="height:32px;line-height:32px;float:left;"><a class="wst-login-but" href="javascript:void(0);" onclick='javascript:login(3)' style="width:246px;">登录</a></div>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<?php endif; ?>
				</div>
		    </div>
			<?php echo hook('homeDocumentLogin'); ?>
</div>

	<script>
		$(function(){
			$('.wst-login_r #tab').TabPanel({tab:0,callback:function(no){
				if(no==1);
				if(no==2);
			}});
		})

	</script>

