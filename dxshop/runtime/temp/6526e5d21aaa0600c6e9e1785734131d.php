<?php /*a:2:{s:69:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\orderrefunds\list.html";i:1669102998;s:56:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\base.html";i:1669564546;}*/ ?>
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

<div id='alertTips' class='alert alert-success alert-tips fade in'>
  <div id='headTip' class='head'><i class='fa fa-lightbulb-o'></i>操作说明</div>
  <ul class='body'>
    <li>操作退款提示“退款成功”后，可能退款状态没有立即改变，这是由于退款需调用支付回调接口，可能存在5-10秒延时，请稍后再刷新查看退款状态；</li>
  </ul>
</div>
<div class="wst-toolbar">
<select id="areaId1" class='ipt j-ipt hide' level="0" onchange="WST.ITAreas({id:'areaId1',val:this.value,className:'j-ipt'});">
  <option value="-1">-商家所在地-</option>
  <?php if(is_array($areaList) || $areaList instanceof \think\Collection || $areaList instanceof \think\Paginator): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
  <option value="<?php echo $vo['areaId']; ?>"><?php echo $vo['areaName']; ?></option>
  <?php endforeach; endif; else: echo "" ;endif; ?>
</select>
<input type="text" name="orderNo"  placeholder='订单编号' id="orderNo" class='j-ipt'/>
<input type="text" name="shopName"  placeholder='店铺名称/店铺编号' id="shopName" class='j-ipt'/>
<select id='deliverType' class='j-ipt'>
         <option value='-1'>配送方式</option>
         <option value='1'>自提</option>
         <option value='0'>送货上门</option>
       </select>
<select id='isRefund' class='j-ipt'>
 <option value='-1'>退款状态</option>
 <option value='1'>已退款</option>
 <option value='0'>未退款</option>
</select>
<input type="text" id="startDate" name="startDate" class="laydate-icon j-ipt" maxLength="20" value='' placeholder='开始日期'/>
至
<input type="text" id="endDate" name="endDate" class="laydate-icon j-ipt" maxLength="20" value='' placeholder='结束日期'/>
   <button class="btn btn-primary" onclick='javascript:loadRefundGrid(0)'><i class="fa fa-search"></i>查询</button>
   <?php if(WSTGrant('TKDD_05')): ?>
   <button class="btn btn-primary f-right" style='margin-top:0px' onclick='javascript:toExport(0)'><i class="fa fa-sign-in"></i>导出</button>
   <?php endif; ?>
   <div style='clear:both'></div>
</div>
<div class='wst-grid'>
 <div id="mmg" class="mmg"></div>
</div>
<script>
$(function(){initRefundGrid(<?php echo $p; ?>);})
</script>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/orderrefunds/orderrefunds.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>