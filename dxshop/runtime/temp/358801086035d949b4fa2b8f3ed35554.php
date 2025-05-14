<?php /*a:2:{s:75:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\goods\list_audit.html";i:1669479426;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>商家中心 - <?php echo WSTConf('CONF.mallName'); ?></title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<script src="/hkshopNC/dxshop/static/js/jquery.min.js?v=<?php echo $v; ?>"></script>
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__SHOP__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />

<style>
body{overflow-y:hidden;}
td .layui-table-cell{height:60px !important;line-height: 60px;overflow: inherit!important;}
td .laytable-cell-1-0-2{overflow:hidden!important;}
.layui-table img{max-width:180px!important;}
</style>

<?php 
$msgGrant = [];
if(WSTShopGrant('shop/messages/shopMessage'))$msgGrant[] = 'message';
if(WSTShopGrant('shop/orders/waitdelivery'))$msgGrant[] = 'shoporder24';
if(WSTShopGrant('shop/orders/waituserPay'))$msgGrant[] = 'shoporder55';
if(WSTShopGrant('shop/orders/failure'))$msgGrant[] = 'shoporder45';
if(WSTShopGrant('shop/ordercomplains/shopComplain'))$msgGrant[] = 'shoporder25';
if(WSTShopGrant('shop/orderservices/index'))$msgGrant[] = 'shoporder306';
if(WSTShopGrant('shop/goods/stockWarnByPage'))$msgGrant[] = 'shoporder54';
 ?>
<script>
window.conf = {"DOMAIN":"<?php echo str_replace('index.php','',app('request')->root(true)); ?>","ROOT":"/hkshopNC/dxshop","APP":"/hkshopNC/dxshop","STATIC":"/hkshopNC/dxshop/static","SUFFIX":"<?php echo config('url_html_suffix'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>",'GRANT':'',"IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>","ROUTES":'<?php echo WSTRoute(); ?>',"MAP_KEY":"<?php echo WSTConf('CONF.mapKey'); ?>","__HTTP__":"<?php echo WSTProtocol(); ?>",'RESOURCE_PATH':'<?php echo WSTConf('CONF.resourcePath'); ?>','RESOURCE_DOMAIN':'<?php echo WSTConf('CONF.resourceDomain'); ?>',"SMS_VERFY":"<?php echo WSTConf('CONF.smsVerfy'); ?>",'TIME_TASK':1,"MESSAGE_BOX":"",MSG_SHOP_GRANT:'<?php echo implode(',',$msgGrant); ?>'}
</script>
<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/js/common.js?v=<?php echo $v; ?>"></script>
</head>
<body>
<input type='hidden' id='WSTP' value="<?php echo input('p'); ?>"/>
<input type='hidden' id='WSTTYPE'  value="<?php echo isset($tabType)?$tabType:''; ?>"/>
<input type='hidden' id='WSTReferer' value="<?php if(isset($_SERVER['HTTP_REFERER'])): ?><?php echo $_SERVER['HTTP_REFERER']; ?><?php endif; ?>"/>
<div id="j-loader"><img src="__SHOP__/img/ajax-loader.gif"/></div>

<div class="wst-page">
<div class="wst-toolbar">
    <select name="cat1" id="cat1" onchange="getCat(this.value)" class="s-query">
        <option value="">-请选择商品分类-</option>
      <?php $_result=WSTShopCats(0);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['catId']; ?>" ><?php echo $vo['catName']; ?></option>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </select>
      <select name="cat2" id="cat2" class="s-query"><option value="">-请选择商品分类-</option></select>
  <span style="float: left;line-height: 40px;">商品类型：</span>
  <select id='goodsType' class="s-query">
     <option value=''>全部</option>
     <option value='0'>实物商品</option>
     <option value='1'>虚拟商品</option>
  </select>
    <input type="text" name="goodsName" id="goodsName" class="s-query" placeholder='商品名称/商品编号'/>
    <select id='goodsAttr' class="s-query" style='width:80px'>
        <option value='-1'>全部</option>
        <option value='0'>推荐</option>
        <option value='3'>新品</option>
        <option value='2'>精品</option>
        <option value='1'>热销</option>
  </select>
    <a class="s-btn btn btn-primary" onclick="loadGrid(0)"><i class="fa fa-search"></i>查询</a>
</div>
<div class="wst-toolbar wst-toolbar2">
   <div class="s-menu">
      <button type="button" class="btn btn-primary" onclick="changeSale(0,'audit')" >下架</button>
      <button type="button" class="btn btn-primary" onclick="changeGoodsStatus('isRecom','audit')" >推荐</button>
      <button type="button" class="btn btn-primary" onclick="changeGoodsStatus('isNew','audit')" >新品</button>
      <button type="button" class="btn btn-primary" onclick="changeGoodsStatus('isBest','audit')" >精品</button>
      <button type="button" class="btn btn-primary mra" onclick="changeGoodsStatus('isHot','audit')" >热销</button>
      <div class="flex1"></div>
      <button type="button" class="btn btn-primary" onclick="toAdd('audit')">
        <span><i class="fa fa-plus"></i>新增</span>
      </button>
      <button type="button" class="btn btn-danger" onclick="benchDel('audit')">
        <span><i class="fa fa-trash-o"></i>删除</span>
      </button>
   </div>
</div>
<div class='wst-grid'>
    <div id="mmg" class="mmg"></div>
</div>
<input type='hidden' id='goodsId' class='j-ipt' value=''/>
<div id='goodsBox' style='display:none'>
  <div id='specsAttrBox' style="padding:10px;"></div>
</div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='__SHOP__/goods/goods.js?v=<?php echo $v; ?>'></script>
<script>
$(function(){auditByPage(<?php echo $p; ?>)})
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
