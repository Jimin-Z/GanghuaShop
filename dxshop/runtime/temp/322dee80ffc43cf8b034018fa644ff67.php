<?php /*a:2:{s:77:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\recharge\pay_step1.html";i:1669480652;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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

<link href="__SHOP__/css/recharge.css?v=<?php echo $v; ?>" rel="stylesheet">

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
    <div class='pay-sbox'>
    	<div>
    		<div>
				<div class='wst-tips-box'>
				<div class='icon'></div>
					<div class='tips'>
						1.充值金额和赠送金额不能提现；<br/>
					</div>
				<div style="clear:both"></div>
	           	</div>
    		</div>
	   		<div class="wst-form">
			    <div class="pay-type" style="overflow: hidden; float: left;">充值金额：</div>
			    <div>
			       <div class="wst-list-box">
			          <?php if(is_array($chargeItems) || $chargeItems instanceof \think\Collection || $chargeItems instanceof \think\Paginator): $i = 0; $__LIST__ = $chargeItems;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
			          	<div class="wst-frame2 <?php echo $key; ?> " onclick="javascript:changeSelected(<?php echo $item['id']; ?>,'itmeId',this)">
				          	<?php if($item['giveMoney'] > 0): ?>
				          	<div class='charge-doub'>充值 <span class="charge-money"><?php echo $item['chargeMoney']; ?></span> 元</div>
				        	<div>送 <?php echo $item['giveMoney']; ?> 元</div>
				        	<?php else: ?>
				        	<div class='charge-alone'>充值 <span class="charge-money"><?php echo $item['chargeMoney']; ?></span> 元</div>
				          	<?php endif; ?>
				          	<i></i>
			     		</div>
			          <?php endforeach; endif; else: echo "" ;endif; ?>
			          	<div class="wst-frame2 " onclick="javascript:changeSelected(0,'itmeId',this)">
				        	<div class='charge-alone'>
				        		<span class="j-charge-other">其他金额</span>
				        		<span class="j-charge-money"><input class="charge-othermoney j-ipt" id="needPay" value="1" maxlength="10" data-rule="充值金额:required;" onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxlength="8"></span>
				        	</div>
			   			</div>
			          	<input type="hidden" value="" id='itmeId' class='j-ipt' />
			          <div class='f-clear'></div>
			       </div>

			    </div>
			    <div style="overflow: hidden;border-top: 1px dashed #eee;border-bottom: 1px dashed #eee;">

			    <div class="pay-type">选择支付方式：</div>
			    <div class="pay-list" style="overflow: hidden;">
			    	<input type="hidden" id="payCode" name="payCode" />
			    	<?php if(is_array($payments) || $payments instanceof \think\Collection || $payments instanceof \think\Paginator): $i = 0; $__LIST__ = $payments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$payment): $mod = ($i % 2 );++$i;if($payment['isOnline'] == 1): ?>
	                    	<div class="wst-payCode-<?php echo $payment['payCode']; ?>" data="<?php echo $payment['payCode']; ?>"></div>
	                 	<?php endif; ?>
	                 <?php endforeach; endif; else: echo "" ;endif; ?>
			         <div class="wst-clear"></div>
			    </div>

	    	    </div>
	    	    <div class="bnt-box">
			    	<button type='button' class='btn btn-success wst-pay-bnt' onclick='javascript:getPayUrl();'><i class='fa fa-shield'></i>确认提交支付</button>
			    </div>
			</div>


        </div>
</div>
<div id="alipayform" style="display:none;"></div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='__SHOP__/recharge/recharge.js?v=<?php echo $v; ?>'></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
