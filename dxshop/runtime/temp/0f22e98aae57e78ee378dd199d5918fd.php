<?php /*a:1:{s:55:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\login.html";i:1738761698;}*/ ?>
<!DOCTYpE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-Ua-Compatible" content="IE=edge">
<meta name="Keywords" content=""/>
<meta name="Description" content=""/> 
<link rel="stylesheet" href="/qmdd/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link href="__ADMIN__/css/login.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />
<title>后台管理中心登录 - <?php echo WSTConf('CONF.mallName'); ?></title>
</head>
<body id="loginFrame">

<div class="wst-lo-center ">
  <div class="wst-lo">
    <div class="login-header">
        <?php if(WSTConf('CONF.mallLicense')==''): ?>
        <div class='login_logo'>
        	<img src="__ADMIN__/img/login_logo.png">
        </div>
        <div class="login_title">
          <div class='title_cn'>商淘云后台管理中心</div>
          <div class='title_en'>ShangTao Soft Background Management Center</div>
        </div>
        <?php else: ?>
        <div class="login_title">
          <div class='title_cn'>平台管理中心登录</div>
        </div>
        <?php endif; ?>
        <div class="wst-clear"></div>
    </div>
    <div class="login-wrapper">
      <div class="boxbg2"></div>
      <div class="box">
          <div class="content-wrap">
            <div class="login-box">
              <div class="login-icon1"></div>
              <div class="login-icon2"></div>
              <div class="login-icon3"></div>
              <input id='loginName' type="text" class="layui-input ipt ">
              <input id='loginPwd' type="password" class="layui-input ipt">
              <div class="frame">
                <input type='text' id='verifyCode' class='layui-input  ipt text2'>
                <img id='verifyImg' src="<?php echo url('admin/index/getVerify'); ?>" onclick='javascript:getVerify(this)'>
              </div>
            </div>
            <button id="loginbtn" type="button" onclick='javascript:login()' class="layui-btn layui-btn-big layui-btn-normal" style="width: 100%;">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
          </div>
        </div>
    </div>
    <div class="login-footer">
      <div class="line1"></div>
      <div class="line2"></div><?php echo WSTConf('CONF.mallName'); ?></div>
  </div>
</div>

<input type='hidden' id='token' value='<?php echo WSTConf("CONF.pwdModulusKey"); ?>'/>
<script type='text/javascript' src='/qmdd/dxshop/static/js/jquery.min.js'></script>
<script>
window.conf = {"DOMAIN":"<?php echo str_replace('index.php','',app('request')->root(true)); ?>","ROOT":"/qmdd/dxshop","APP":"/qmdd/dxshop/index.php","STATIC":"/qmdd/dxshop/static","SUFFIX":"<?php echo config('url_html_suffix'); ?>","IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>"}
</script>
<script type='text/javascript' src='/qmdd/dxshop/static/js/common.js'></script>
<script language="javascript" type="text/javascript" src="/qmdd/dxshop/static/plugins/layui/layui.js"></script>
<script type="text/javascript" src="/qmdd/dxshop/static/js/rsa.js"></script>
<script type='text/javascript' src='__ADMIN__/js/common.js'></script>
<script src="__ADMIN__/js/login.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script type="text/javascript">
if (window.frames.length != parent.frames.length) {
　　parent.location.reload();
}
</script>
</body>
</html>