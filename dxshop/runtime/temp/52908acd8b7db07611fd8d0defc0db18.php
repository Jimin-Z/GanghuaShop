<?php /*a:2:{s:71:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\goodsappraises\list.html";i:1670308354;s:56:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\base.html";i:1669564546;}*/ ?>
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
	td .layui-table-cell{height:auto !important;line-height: auto !important;overflow: inherit!important;padding:5px 15px;}
	td .laytable-cell-1-0-3,td .laytable-cell-1-0-5,td .laytable-cell-2-0-3,td .laytable-cell-2-0-5{overflow:hidden!important;}
	.layui-table img{max-width:150px!important;}
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

<div class="wst-grid">
<div class="layui-tab layui-tab-brief" lay-filter="msgTab">
	<ul class="layui-tab-title">
		<li <?php if($tabType==1): ?>class="layui-this"<?php endif; ?>>评论</li>
		<li <?php if($tabType==2): ?>class="layui-this"<?php endif; ?>>评论举报</li>
	</ul>
	<div class="layui-tab-content" style="padding: 10px 0;">
		<div class="layui-tab-item <?php if($tabType==1): ?>layui-show<?php endif; ?>">
			<div class="wst-toolbar">
				<div id="query" style="float:left;">
					<select id="areaId1" class='query' level="0" onchange="WST.ITAreas({id:'areaId1',val:this.value,className:'query'});" >
						<option value="-1">-请选择地区-</option>
						<?php foreach($area1 as $v): ?>
						<option value="<?=$v['areaId']?>"><?=$v['areaName']?></option>
						<?php endforeach; ?>
					</select>
					<input type="text" name="shopName" placeholder='店铺名称' id="shopName" class="query" />
					<input type="text" name="goodsName" placeholder='商品名称' id="goodsName" class="query" />
					<button type="button"  class='btn btn-primary btn-mright' onclick="javascript:loadGrid(0)"><i class="fa fa-search"></i>查询</button>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class='wst-grid'>
				<div id="mmg" class="mmg layui-form"></div>
			</div>
		</div>
		<div class="layui-tab-item <?php if($tabType==2): ?>layui-show<?php endif; ?>">
			<div class="wst-toolbar wst-toolbar2">
				<div id="query2" style="float:left;">
					<select id="areaId2" class='query2' level="0" onchange="WST.ITAreas({id:'areaId2',val:this.value,className:'query2'});" >
						<option value="-1">-请选择地区-</option>
						<?php foreach($area1 as $v): ?>
						<option value="<?=$v['areaId']?>"><?=$v['areaName']?></option>
						<?php endforeach; ?>
					</select>
					<input type="text" name="shopName" placeholder='店铺名称' id="shopName2" class="query2" />
					<input type="text" name="goodsName" placeholder='商品名称' id="goodsName2" class="query2" />
					<button type="button"  class='btn btn-primary btn-mright' onclick="javascript:loadGrid2(0)"><i class="fa fa-search"></i>查询</button>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class='wst-grid'>
				<div id="mmg2" class="mmg2 layui-form"></div>
			</div>
		</div>
	</div>

</div>
</div>
<script>
$(function(){
	var isInit = isInit2 = false;
	<?php if($tabType==1): ?>
	isInit = true;
	initGrid(<?php echo $p; ?>);
	<?php else: ?>
	isInit2 = true;
	initGrid2(<?php echo $p; ?>);
	<?php endif; ?>
		var element = layui.element;
		element.on('tab(msgTab)', function(data){
			if(data.index==1){
				if(!isInit2){
					isInit2 = true;
					initGrid2(<?php echo $p; ?>);
				}else{
					loadGrid2(<?php echo $p; ?>);
				}
			}else{
				if(!isInit){
					isInit = true;
					initGrid(<?php echo $p; ?>);
				}else{
					loadGrid(<?php echo $p; ?>);
				}
			}
		});
	});
</script>


<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/goodsappraises/goodsappraises.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>