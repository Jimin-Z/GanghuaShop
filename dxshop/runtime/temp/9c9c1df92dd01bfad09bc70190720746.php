<?php /*a:2:{s:63:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\articles\list.html";i:1738761699;s:54:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\base.html";i:1738761698;}*/ ?>
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


<link href="/qmdd/dxshop/static/plugins/ztree/css/zTreeStyle/zTreeStyle.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />

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

<div class="wst-toolbar">
   <input id="catSel" placeholder='文章分类' type="text" readonly onclick="showMenu();" style='width:250px;' />
   <div id="ztreeMenuContent" class="ztreeMenuContent">
      <ul id="dropDownTree" class="ztree" style="margin-top:0; width:250px; height: 300px;"></ul>
   </div>
   <input id="catId" class="text ipt" autocomplete="off" type="hidden" value=""/>
   <input type='text' id='key' placeholder='文章标题'/>
   <button class="btn btn-primary" onclick='javascript:loadGrid(0)'><i class='fa fa-search'></i>查询</button>
   <?php if(WSTGrant('WZGL_03')): ?>
   <button class="btn btn-danger f-right btn-fixtop" onclick='javascript:toBatchDel()' style='margin-left:10px;'><i class='fa fa-trash'></i>批量删除</button>
   <?php endif; if(WSTGrant('WZGL_01')): ?>
   <button class="btn btn-success f-right btn-fixtop" onclick='javascript:toEdit(0)'><i class='fa fa-plus'></i>新增</button>
   <?php endif; ?>
   <div style='clear:both'></div>
</div>
<div class='wst-grid'>
<div id="mmg" class="mmg"></div>
</div>

<script language="javascript" type="text/javascript" src="/qmdd/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="/qmdd/dxshop/static/plugins/ztree/jquery.ztree.all-3.5.js?v=<?php echo $v; ?>"></script>
<script src="__ADMIN__/articles/articles.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script>
$(function(){initCombo(1);initGrid(<?php echo $p; ?>);})
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>