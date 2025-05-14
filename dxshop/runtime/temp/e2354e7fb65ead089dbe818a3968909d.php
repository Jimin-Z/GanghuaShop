<?php /*a:2:{s:75:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\settlements\list.html";i:1669346210;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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
<div id='tab' class="wst-tab-box">
	<ul class="wst-tab-nav ">
		<li id="wst-msg-li-0">结算信息<span style="display:none;"></span></li>
		<li id="wst-msg-li-1">未结算订单<span style="display:none;"></span></li>
		<li id="wst-msg-li-2">已结算订单<span style="display:none;"></span></li>
	</ul>
	<div class="wst-tab-content" style='width:100%;'>
	    <div class='wst-tab-item'>
	       <div class="wst-toolbar wst-toolbar1">
	       <input type="text" id="settlementNo_0" style='width:120px;' autocomplete="off" placeholder="请输入结算单号"/>
						<select id='isFinish_0' autocomplete="off">
								<option value='-1'>结算状态</option>
								<option value='0'>未结算</option>
								<option value='1'>已结算</option>
								</select>
						<a class='s-btn btn btn-primary' onclick="loadGrid(0)"><i class="fa fa-search"></i>查询</a>
		   </div>
			<div class='wst-grid'>
				<div id="mmg1" class="mmg1"></div>
			</div>
        </div>
        
        <div class='wst-tab-item'>
            <div class="wst-toolbar wst-toolbar2">
                <input type="text" id="orderNo_1" style='width:120px;' autocomplete="off" placeholder="请输入订单号"/>
				<a class='s-btn btn btn-primary' onclick="loadUnSettleGrid(0)"><i class="fa fa-search"></i>查询</a>
            </div>
			<div class='wst-grid'>
				<div id="mmg2" class="mmg2"></div>
			</div>
        </div>
        <div class='wst-tab-item'>
            <div class="wst-toolbar wst-toolbar3">
            	<input type="text" id="settlementNo_2" style='width:120px;' autocomplete="off" placeholder="请输入结算单号"/>
				<input type="text" id="orderNo_2" style='width:120px;' autocomplete="off" placeholder="请输入订单号"/>
				<select id='isFinish_2' autocomplete="off">
							    <option value='-1'>结算状态</option>
								<option value='0'>未结算</option>
								<option value='1'>已结算</option>
						  </select>
				<a class='s-btn btn btn-primary' onclick="loadSettleGrid(0)"><i class="fa fa-search"></i>查询</a>
            </div>
			<div class='wst-grid'>
				<div id="mmg3" class="mmg3"></div>
			</div>
        </div>
	</div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='__SHOP__/settlements/settlements.js?v=<?php echo $v; ?>'></script>
	<script>
        $(function(){
            $('#tab').TabPanel({tab:0,callback:function(tab){
                    switch(tab){
                        case 0:getQueryPage(<?php echo $p; ?>);break;
                        case 1:getUnSettledOrderPage(<?php echo $p; ?>);break;
                        case 2:getSettleOrderPage(<?php echo $p; ?>);break;
                    }
                }});
        });
	</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
