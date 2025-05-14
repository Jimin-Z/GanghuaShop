<?php /*a:2:{s:62:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\switchs\list.html";i:1738761707;s:54:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\base.html";i:1738761698;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>后台管理中心 - <?php echo WSTConf('CONF.mallName'); ?></title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<script src="/qmdd/dxshop/static/js/jquery.min.js"></script>
<link rel="stylesheet" href="/qmdd/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/qmdd/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__ADMIN__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />



<?php 
$msgGrant = [];
if(WSTGrant('TSDD_00'))$msgGrant[] = 'shopapply';
if(WSTGrant('DSHSP_00'))$msgGrant[] = 'goodsaudit';
if(WSTGrant('TSDD_00'))$msgGrant[] = 'ordercomplains';
if(WSTGrant('JBSP_00'))$msgGrant[] = 'informs';
 ?>
<script>
window.conf = {"DOMAIN":"<?php echo str_replace('index.php','',app('request')->root(true)); ?>","ROOT":"/qmdd/dxshop","APP":"/qmdd/dxshop/index.php","STATIC":"/qmdd/dxshop/static","SUFFIX":"<?php echo config('url_html_suffix'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>",'GRANT':'<?php echo implode(",",session("WST_STAFF.privileges")); ?>',"IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>","ROUTES":'<?php echo WSTRoute(); ?>',"MAP_KEY":"<?php echo WSTConf('CONF.mapKey'); ?>","__HTTP__":"<?php echo WSTProtocol(); ?>",'RESOURCE_PATH':'<?php echo WSTConf('CONF.resourcePath'); ?>','RESOURCE_DOMAIN':'<?php echo WSTConf('CONF.resourceDomain'); ?>',MSG_GRANT:'<?php echo implode(',',$msgGrant); ?>'}
</script>
<script language="javascript" type="text/javascript" src="/qmdd/dxshop/static/js/common.js"></script>
</head>
<body>
<input type='hidden' id='WSTP' value="<?php echo input('p'); ?>"/>
<input type='hidden' id='WSTTYPE'  value="<?php echo isset($tabType)?$tabType:''; ?>"/>
<input type='hidden' id='WSTReferer' value="<?php if(isset($_SERVER['HTTP_REFERER'])): ?><?php echo $_SERVER['HTTP_REFERER']; ?><?php endif; ?>"/>
<div id="j-loader"><img src="__ADMIN__/img/ajax-loader.gif"/></div>

<?php if(WSTGrant('YMQH_01')): ?>
<div class="wst-toolbar">
   <button class="btn btn-success f-right" onclick='javascript:toEdit(0)'><i class='fa fa-plus'></i>新增</button>
   <div style="clear:both"></div>
<?php endif; ?>
</div>
<div class='wst-grid'>
<div id="mmg" class="mmg"></div>
</div>
<div id='switchBox' style='display:none'>
    <form id='switchForm' autocomplete="off">
    <input type='hidden' id='id' name="id" class='ipt'/>
    <table class='wst-form wst-box-top'>
       <tr>
          <th width='100'>PC端网址：</th>
          <td><input type='text' id='homeURL' name="homeURL" style='width:90%' class='ipt' maxLength='50'/></td>
       </tr>
       <tr>
          <th width='100'>手机端网址：</th>
          <td><input type='text' id='mobileURL' name="mobileURL"  style='width:90%' class='ipt' maxLength='50'/></td>
       </tr>
       <tr>
          <th width='100'>微信端网址：</th>
          <td><input type='text' id='wechatURL' name="wechatURL"  style='width:90%' class='ipt' maxLength='50'/></td>
       </tr>
    </table>
    </form>
 </div>
<script>
  $(function(){initGrid(<?php echo $p; ?>)});
</script>

<script language="javascript" type="text/javascript" src="/qmdd/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/switchs/switchs.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>