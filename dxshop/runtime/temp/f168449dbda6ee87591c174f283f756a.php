<?php /*a:2:{s:73:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\cashdraws\list.html";i:1669536788;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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

<link href="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">

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

<div class='wst-page'>
<div class='money-head'>
  <div class='shop-logo'><img height='100' width='100'src='__RESOURCE_PATH__/<?php echo session("WST_USER.shopImg"); ?>'></div>
  <div class='shop-info'>
    <div class='shopName'><?php echo session('WST_USER.shopName'); ?></div>
    <div class='shopMoney' style="margin-top: 10px;width:100%;">
      <div class="usermoney">
        可用资金：<font color='red' id='shopMoney'>¥0</font>
      </div>
      <div class="cashbox" style="width:auto;">
        <span style='margin-left:20px;'><a class="btn btn-primary" id='drawBtn' href="javascript:toDrawMoney();" style='line-height:18px;height: 18px'>申请提现</a></span>
        <span class='draw-tips' style="margin-left:0;"><?php if((int)WSTConf('CONF.drawCashShopLimit')>0): ?>（至少￥<?php echo WSTConf('CONF.drawCashShopLimit'); ?>方可提现）<?php endif; if((int)WSTConf('CONF.drawCashCommission')> 0): ?>提现有<?php echo WSTConf('CONF.drawCashCommission'); ?>%支付通道交易手续费<?php endif; ?></span>
      </div>
      <div class="f-clear"></div>
    </div>
    <div class="f-clear"></div>
    <div class="money-rows">
      <div class="lockbox">
        冻结资金：<font color='red' id='lockMoney'>¥0</font>
      </div>
      <div class="cashbox">
        <span class="cashmoney-box">可提现金额：<font color='red' id='userCashMoney'>¥0</font></span>
      </div>
      <div class="f-clear"></div>
    </div>
  </div>
</div>
<div class='wst-user-content'>
   <div id='tab' class="wst-tab-box">
    <ul class="wst-tab-nav">
       <li>提现记录</li>
    </ul>
    <div class='wst-grid'>
       <div id="mmg" class="mmg"></div>
   </div>
    </div>
</div>
<style type="text/css">
  .wst-tab-nav{border-bottom: 0px;}
</style>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='__SHOP__/cashdraws/cashdraws.js?v=<?php echo $v; ?>'></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.min.js?v=<?php echo $v; ?>"></script>
<script>
$(function(){
   getShopMoney();
})
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
