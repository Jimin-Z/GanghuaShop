<?php /*a:2:{s:68:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\goods\list_audit.html";i:1669538924;s:56:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\base.html";i:1669564546;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>后台管理中心 - <?php echo WSTConf('CONF.mallName'); ?></title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<script src="/hkshopNC/dxshop/static/js/jquery.min.js"></script>
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__ADMIN__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />


<style>
    td .layui-table-cell{height:60px !important;line-height: 60px !important;overflow: inherit!important;}
    td .laytable-cell-1-0-4,td .laytable-cell-1-0-6{overflow:hidden!important;}
    .layui-table img{max-width:200px!important;}
</style>

<?php 
$msgGrant = [];
if(WSTGrant('TSDD_00'))$msgGrant[] = 'shopapply';
if(WSTGrant('DSHSP_00'))$msgGrant[] = 'goodsaudit';
if(WSTGrant('TSDD_00'))$msgGrant[] = 'ordercomplains';
if(WSTGrant('JBSP_00'))$msgGrant[] = 'informs';
 ?>
<script>
window.conf = {"DOMAIN":"<?php echo str_replace('index.php','',app('request')->root(true)); ?>","ROOT":"/hkshopNC/dxshop","APP":"/hkshopNC/dxshop/index.php","STATIC":"/hkshopNC/dxshop/static","SUFFIX":"<?php echo config('url_html_suffix'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>",'GRANT':'<?php echo implode(",",session("WST_STAFF.privileges")); ?>',"IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>","ROUTES":'<?php echo WSTRoute(); ?>',"MAP_KEY":"<?php echo WSTConf('CONF.mapKey'); ?>","__HTTP__":"<?php echo WSTProtocol(); ?>",'RESOURCE_PATH':'<?php echo WSTConf('CONF.resourcePath'); ?>','RESOURCE_DOMAIN':'<?php echo WSTConf('CONF.resourceDomain'); ?>',MSG_GRANT:'<?php echo implode(',',$msgGrant); ?>'}
</script>
<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/js/common.js"></script>
</head>
<body>
<input type='hidden' id='WSTP' value="<?php echo input('p'); ?>"/>
<input type='hidden' id='WSTTYPE'  value="<?php echo isset($tabType)?$tabType:''; ?>"/>
<input type='hidden' id='WSTReferer' value="<?php if(isset($_SERVER['HTTP_REFERER'])): ?><?php echo $_SERVER['HTTP_REFERER']; ?><?php endif; ?>"/>
<div id="j-loader"><img src="__ADMIN__/img/ajax-loader.gif"/></div>

<div class="wst-toolbar">
<select id="areaId1" class='j-ipt j-areas hide' level="0" onchange="WST.ITAreas({id:'areaId1',val:this.value,className:'j-areas'});">
  <option value="">-商家所在地-</option>
  <?php if(is_array($areaList) || $areaList instanceof \think\Collection || $areaList instanceof \think\Paginator): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
  <option value="<?php echo $vo['areaId']; ?>"><?php echo $vo['areaName']; ?></option>
  <?php endforeach; endif; else: echo "" ;endif; ?>
</select>
<select id="cat_0" class='ipt pgoodsCats' level="0" onchange="WST.ITGoodsCats({id:'cat_0',val:this.value,isRequire:false,className:'pgoodsCats'});">
   <option value="">-所属分类-</option>
   <?php $_result=WSTGoodsCats(0);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	<option value="<?php echo $vo['catId']; ?>"><?php echo $vo['catName']; ?></option>
	<?php endforeach; endif; else: echo "" ;endif; ?>
</select>
<input type="text" name="goodsName"  placeholder='商品名称/商品编号' id="goodsName" class='j-ipt'/>
<input type="text" name="shopName"  placeholder='店铺名称/店铺编号' id="shopName" class='j-ipt'/>
<button class="btn btn-primary" onclick='javascript:loadGrid(0)'><i class='fa fa-search'></i>查询</button>

<?php if(WSTGrant('DSHSP_04')): ?>
<button class="btn btn-danger f-right" onclick='javascript:toBatchIllegal()' style='margin-left:10px;'><i class='fa fa-ban'></i>批量不通过</button>
<button class="btn btn-success f-right" onclick='javascript:toBatchAllow()' style='margin-left:10px;'><i class='fa fa-check'></i>批量通过</button>
<?php endif; ?>

<div style='clear:both'></div>
</div>
<div class='wst-grid'>
 <div id="mmg" class="mmg"></div>
</div>
<script>
$(function(){initAuditGrid(<?php echo $p; ?>);})
</script>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/goods/goods.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>