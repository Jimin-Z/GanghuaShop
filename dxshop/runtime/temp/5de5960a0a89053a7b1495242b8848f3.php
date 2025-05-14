<?php /*a:2:{s:79:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\orders\list_invoices.html";i:1669390454;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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
    .wst-toolbar{padding:0px;}
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

<div class='wst-page'>
<div id='tab' class="wst-tab-box">
    <ul class="wst-tab-nav">
        <li>未开票</li>
        <li>已开票</li>
    </ul>
    <div class="wst-tab-content" style='width:100%;'>
        <input type="hidden" id="shopId" class="j-ipt" value='<?php echo $shopId; ?>' autocomplete="off"/>
        <div class='wst-tab-item'>
            <div class='wst-toolbar'>
                <input type='text'  id='orderNo' class='j-ipt' placeholder='订单号'/>
                <input type="text" id="startDate" name="startDate" class="laydate-icon j-ipt" maxLength="20" value='' placeholder='开始日期' autocomplete="off"/>
                <!--至-->
                <input type="text" id="endDate" name="endDate" class="laydate-icon j-ipt" maxLength="20" value='' placeholder='结束日期' autocomplete="off"/>
                <a class="btn btn-primary" onclick="loadGrid(0)"><i class="fa fa-search"></i>查询</a>
                <button class="btn btn-primary f-right"  onclick='javascript:toExport(0)'><i class="fa fa-sign-in"></i>导出</button>
                <button class="btn btn-primary f-right " onclick='javascript:toBatchSet(1)' style='margin-right: 10px;'>设置为已开票</button>
                <div style='clear:both'></div>
            </div>
            <div class='wst-grid'>
                <div id="mmg" class="mmg"></div>
            </div>
        </div>
        <div class='wst-tab-item' style="display: none">
            <div class='wst-toolbar wst-toolbar2'>
                <input type='text'  id='orderNo2' class='j-ipt2' placeholder='订单号'/>
                <input type="text" id="startDate2" name="startDate" class="laydate-icon j-ipt2" maxLength="20" value='' placeholder='开始日期' autocomplete="off"/>
                <!--至-->
                <input type="text" id="endDate2" name="endDate" class="laydate-icon j-ipt2" maxLength="20" value='' placeholder='结束日期' autocomplete="off"/>
                <a class="btn btn-primary" onclick="loadGrid2(0)"><i class="fa fa-search"></i>查询</a>
                <button class="btn btn-primary f-right" onclick='javascript:toExport(1)'><i class="fa fa-sign-in"></i>导出</button>
                <button class="btn btn-primary f-right " onclick='javascript:toBatchSet(0)' style='margin-right: 10px;'>设置为未开票</button>
                <div style='clear:both'></div>
            </div>
            <div class='wst-grid'>
                <div id="mmg2" class="mmg2"></div>
            </div>
        </div>
    </div>
</div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='__SHOP__/orders/invoices.js?v=<?php echo $v; ?>'></script>
<script>
     $(function(){
          $('#tab').TabPanel({tab:0,callback:function(tab){
              switch(tab){
                  case 0:initGrid();break;
                  case 1:initGrid2();break;
              }
          }});
     });
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
