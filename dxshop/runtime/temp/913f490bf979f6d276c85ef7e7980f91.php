<?php /*a:2:{s:64:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\resources\list.html";i:1738761705;s:54:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\base.html";i:1738761698;}*/ ?>
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

<form>
<div class="wst-toolbar">
<select id='key' class='ipt'>
    <?php if(is_array($datas) || $datas instanceof \think\Collection || $datas instanceof \think\Paginator): $i = 0; $__LIST__ = $datas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <option value="<?php echo $vo['dataVal']; ?>" <?php if($keyword==$vo['dataVal']): ?>selected<?php endif; ?>><?php echo $vo['dataName']; ?></option>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</select>
<select id='resType' class='ipt'>
    <option value='-1'>资源类型</option>
    <option value='0'>图片</option>
    <option value='1'>视频</option>
</select>
<select id='isUse' class='ipt'>
    <option value='-1'>全部</option>
    <option value='1'>有效</option>
    <option value='0'>失效</option>
</select>
</form>
<button class="btn btn-primary" type='button' onclick='javascript:loadGrid(0)'><i class='fa fa-search'></i>查询</button>
<button class="btn f-right btn-fixtop" type='button' onclick="javascript:history.go(-1)" style='margin-left:10px;'><i class="fa fa-angle-double-left"></i>返回</button>
<?php if(WSTGrant('TPKJ_04')): ?>
<a class="btn btn-danger f-right btn-fixtop" onclick='javascript:toBatchDel()'><i class='fa fa-trash'></i>批量删除</a>
<?php endif; ?>
<div style='clear:both;'></div>
</div>
<div class='wst-grid'>
<div id="mmg" class="mmg">
</div>
</div>
<script>
$(function(){initGrid(<?php echo $p; ?>);})
</script>

<script language="javascript" type="text/javascript" src="/qmdd/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/resources/resources.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<style>
    .btn-danger{height: 20px;line-height: 20px;color:#fff;}
    .btn-danger:hover{color:#fff;}
</style>

<?php echo hook('initCronHook'); ?>
</body>
</html>