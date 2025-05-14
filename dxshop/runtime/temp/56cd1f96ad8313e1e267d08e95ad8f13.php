<?php /*a:2:{s:64:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\\main.html";i:1738154879;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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

<link href="__SHOP__/css/main.css?v=<?php echo $v; ?>" rel="stylesheet">

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

<div>
<div class="wst-shop-info">
	<div class="wst-shop-na" >
		<div class='wst-shop-name'><a target='_blank' href='<?php echo Url("home/shops/index","shopId=".$data["shop"]["shopId"]); ?>'><?php echo $data['shop']['shopName']; ?></a></div>
		<span class="wst-shop-img">
	        <a target='_blank' href="<?php echo url('home/shops/index',array('shopId'=>$data['shop']['shopId'])); ?>">
	            <img src="__RESOURCE_PATH__/<?php echo WSTImg($data['shop']['shopImg']); ?>" title="<?php echo WSTStripTags($data['shop']['shopName']); ?>" alt="<?php echo WSTStripTags($data['shop']['shopName']); ?>">
	        </a>
	    </span>
		<div class="wst-shop-na2">
		<span class="accred">认证等级：
		<?php if(is_array($data['shop']['accreds']) || $data['shop']['accreds'] instanceof \think\Collection || $data['shop']['accreds'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['shop']['accreds'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sv): $mod = ($i % 2 );++$i;?>
		<img src="__RESOURCE_PATH__/<?php echo $sv['accredImg']; ?>">
		<?php endforeach; endif; else: echo "" ;endif; ?>
	    </span>
		<?php $isExpire = ((strtotime($data['shop']['expireDate'])-strtotime(date('Y-m-d')))<2592000)?true:false; ?>
		<span class="wst-shop-na3">用户名：<?php echo app('session')->get('WST_USER.loginName'); ?></span>
		<div style="clear: both;"></div>
		<span class="wst-shop-na3">上次登录：<?php echo session('WST_USER.lastTime'); ?></span>
		<div style="clear: both;"></div>
		<span class="wst-shop-na3">店铺地址：<?php echo WSTMSubstr($data['shop']['shopAddress'],0,10); ?></span>
		<div style="clear: both;"></div>
		<span class="wst-shop-na3">店铺到期日期：<span style="float:none;<?php if($isExpire): ?>color:red;<?php endif; ?>"><?php echo $data['shop']['expireDate']; ?></span> <a href="<?php echo url('shop/logmoneys/torenew'); ?>">续费</a></span>
		<div style="clear: both;"></div>
		<?php if((WSTDatas('ADS_TYPE',2)!='' || WSTDatas('ADS_TYPE',3)!='' || WSTDatas('ADS_TYPE',5)!='')): ?>

		<div id="shopQrbox" style="position: relative;">
		<div id="qrTitle" class="qrtitle"><i class="fa fa-qrcode"></i>&nbsp;店铺二维码</div></div>
        <div id="shopQrcode" style="width: <?php echo ((WSTDatas('ADS_TYPE',2)!='' || WSTDatas('ADS_TYPE',3)!='') && (WSTDatas('ADS_TYPE',5)!='')?460:223) ?>px;">
           <div class='wst-form wst-box-top'>
    			<div >
			   		<?php if((WSTDatas('ADS_TYPE',2)!='' || WSTDatas('ADS_TYPE',3)!='')): ?>
			   		<div class="qritem j-qritem1">
			   			<div>手机/微信二维码</div>
						<div id="moQrcode" class="qcode"></div>
			   		</div>
			   		<?php endif; if((WSTDatas('ADS_TYPE',5)!='')): ?>
			   		<div class="qritem j-qritem2">
			   			<div >小程序二维码</div>
						<div id="weQrcode" class="qcode"></div>
			   		</div>
			   		<?php endif; ?>
			   		<div style="clear: both;"></div>
			  	</div>
           </div>
        </div>
        <?php endif; ?>

		</div>
	</div>
	<div class="wst-shop-score">
    <div class='wst-shop-name'><a>店铺评分</a></div>
	<div class="wst-shop-eva" style="margin-left: 8%">
		<p>商品评分</p>
		<div class="wst-shop-evai">
		<?php $__FOR_START_12551__=0;$__FOR_END_12551__=$data['shop']['scores']['goodsScore'];for($i=$__FOR_START_12551__;$i < $__FOR_END_12551__;$i+=1){ ?>
			<img src="/hkshopNC/dxshop/static/plugins/raty/img/star-on.png">
		<?php } $__FOR_START_27462__=1;$__FOR_END_27462__=6-$data['shop']['scores']['goodsScore'];for($i=$__FOR_START_27462__;$i < $__FOR_END_27462__;$i+=1){ ?>
			<img src="/hkshopNC/dxshop/static/plugins/raty/img/star-off.png">
		<?php } ?>
		</div>
	</div>
	<div class="wst-shop-eva">
		<p>时效评分</p>
		<div class="wst-shop-evai">
		<?php $__FOR_START_15137__=0;$__FOR_END_15137__=$data['shop']['scores']['timeScore'];for($i=$__FOR_START_15137__;$i < $__FOR_END_15137__;$i+=1){ ?>
			<img src="/hkshopNC/dxshop/static/plugins/raty/img/star-on.png">
		<?php } $__FOR_START_17800__=1;$__FOR_END_17800__=6-$data['shop']['scores']['timeScore'];for($i=$__FOR_START_17800__;$i < $__FOR_END_17800__;$i+=1){ ?>
			<img src="/hkshopNC/dxshop/static/plugins/raty/img/star-off.png">
		<?php } ?>
		</div>
	</div>
	<div class="wst-shop-eva">
		<p>服务评分</p>
		<div class="wst-shop-evai">
		<?php $__FOR_START_27947__=0;$__FOR_END_27947__=$data['shop']['scores']['serviceScore'];for($i=$__FOR_START_27947__;$i < $__FOR_END_27947__;$i+=1){ ?>
			<img src="/hkshopNC/dxshop/static/plugins/raty/img/star-on.png">
		<?php } $__FOR_START_12666__=1;$__FOR_END_12666__=6-$data['shop']['scores']['serviceScore'];for($i=$__FOR_START_12666__;$i < $__FOR_END_12666__;$i+=1){ ?>
			<img src="/hkshopNC/dxshop/static/plugins/raty/img/star-off.png">
		<?php } ?>
		</div>
	</div>
    </div>
	<div class="wst-shop-con">
		<div class='wst-shop-name' ><a>平台联系方式</a></div>
		<p style="margin-left: 8%;"><span>电话：<?php echo $data['shop']['shopTel']; ?></span><span>QQ：<?php echo $data['shop']['shopQQ']; ?></span></p>
		<p style="margin-left: 8%;"><span>邮箱：<?php echo WSTConf('CONF.serviceEmail'); ?></span><span>服务时间：<?php echo date("H:i",strtotime($data['shop']['serviceStartTime'])); ?>-<?php echo date("H:i",strtotime($data['shop']['serviceEndTime'])); ?></span></p>
		<p></p>
	</div>
	<div class="f-clear"></div>
</div>
<?php if(app('session')->get('WST_USER.SHOP_MASTER')==1 && app('session')->get('WST_USER.isGuide')==0): ?>
<div class='guide'>
    <div class='top-title'><span class='c16_555'>新店经营指导</span></div>
    <div style='padding: 0 20px;'>
         <div class='top-head' id='topHead'>
            <ul>
                <li class='active' dataval='0'>
                   <span class='no'>1</span>
                   <span class='title'>开店筹备</span>
                </li>
                 <li dataval='1'>
                   <span class='no'>2</span>
                   <span class='title'>基础设置</span>
                </li>
                <li dataval='2'>
                  <span class='no'>3</span>
                  <span class='title'>测款试销</span>
                </li>
                <li dataval='3'>
                  <span class='no'>4</span>
                  <span class='title'>推广发布</span>
                </li>
            </ul>
         </div>
         <div class='sec-head' id='secHead'>
             <ul id='sendHead0'>
                <li class='active'>
	                <span class='title'>店铺设置</span>
	                <span class='guide-line'>
	                   <span class='fa fa-chevron-circle-right pos'></span>
	                </span>
                </li>
                <li>
	                <span class='title'>店铺风格</span>
	                <span class='guide-line'>
	                   <span class='fa fa-chevron-circle-right pos'></span>
	                </span>
                </li>
                <li>
                	<span class='title'>客服设置</span>
                </li>
             </ul>

             <ul id='sendHead1'>
                <li class='active'>
	                <span class='title'>设置商品分类</span>
	                <span class='guide-line'>
	                   <span class='fa fa-chevron-circle-right pos'></span>
	                </span>
                </li>
                <li>
	                <span class='title'>设置商品运费</span>
	                <span class='guide-line'>
	                   <span class='fa fa-chevron-circle-right pos'></span>
	                </span>
                </li>
                <li>
	                <span class='title'>设置商品规格属性</span>
	                <span class='guide-line'>
	                   <span class='fa fa-chevron-circle-right pos'></span>
	                </span>
                </li>
                <li>
                	<span class='title'>上架商品</span>
                </li>
             </ul>

             <ul id='sendHead2'>
                <li class='active'>
	                <span class='title'>选择营销手段</span>
	                <span class='guide-line'>
	                   <span class='fa fa-chevron-circle-right pos'></span>
	                </span>
                </li>
                <li>
	                <span class='title'>基础评价搭建</span>
	                <span class='guide-line'>
	                   <span class='fa fa-chevron-circle-right pos'></span>
	                </span>
                </li>
                <li>
                	<span class='title'>售后服务</span>
                </li>
             </ul>

             <ul id='sendHead3'>
                <li class='active'>
	                <span class='title'>推广渠道</span>
	                <span class='guide-line'>
	                   <span class='fa fa-chevron-circle-right pos'></span>
	                </span>
                </li>
                 <li>
	                <span class='title'>客户维护</span>
	                <span class='guide-line'>
	                   <span class='fa fa-chevron-circle-right pos'></span>
	                </span>
                </li>
                <li>
	                <span class='title'>数据分析优化</span>
                </li>
             </ul>
         </div>
         <div id='panel-box'>
         	<!-- 开店筹备 -->
            <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                <div>在<a href='<?php echo url("shop/shops/info"); ?>'>店铺资料</a>设置具有识别度的店名以及店铺Logo，设置好相应的客服QQ以及旺旺信息。</div>
                        <div>在<a href='<?php echo url("shop/shopconfigs/toshopcfg"); ?>'>店铺设置</a>设置好店铺相关热搜，店铺街背景，店铺相应的广告图等等。</div>
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                <div>在<a href='<?php echo url("shop/shopstyles/index"); ?>'>风格设置</a>选择合适店铺的风格。</div>
		                <?php if((WSTConf('WST_ADDONS.shopcustompage')!='')): ?>
                        <div>在<a href='<?php echo addon_url("shopcustompage://shop/index"); ?>'>自定义页面</a>装修店铺电脑和移动端风格。</div>
                        <?php endif; ?>
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                <div>在<a href='<?php echo url("shop/shops/info"); ?>'>店铺资料</a>中设置相应的客服QQ以及旺旺信息。</div>
		                <?php if((WSTConf('WST_ADDONS.wstim')!='')): ?>
                        <div>在<a href='<?php echo addon_url("wstim://shopservices/index"); ?>'>客服管理</a>里设置店铺的客服人员，有客户联系时将由此处的客服人员进行接收对话信息。</div>
                        <?php endif; ?>
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>

            <!-- 基础设置 -->
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                 按照店铺经营的品类，在<a href='<?php echo url("shop/shopcats/index"); ?>'>商品分类</a>中合理规划店铺的商品分类，让消费者快捷找到商品。
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='#' class='fbtn'>关闭指引</a>
                </div>
	        </div>
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                在<a href='<?php echo url("shop/express/index"); ?>'>运费模板</a>中设置店铺商品的运费，新增商品的时候选择该商品适用的运费模板，或者商家包邮。
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                系统会有默认的商品规格属性，如果商家对商品有自己的规格或者属性则可以在<a href='<?php echo url("shop/speccats/index"); ?>'>商品规格</a>以及<a href='<?php echo url("shop/attributes/index"); ?>'>商品属性</a>中进行设置。
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                <div>在<a href='<?php echo url("shop/goods/add"); ?>'>新增商品</a>中上架商品，对商品进行管理。可以手工新增商品或者通过Excel导入商品。</div>
		                <?php if((WSTConf('WST_ADDONS.collection')!='')): ?>
                        <div>如果是天猫、淘宝、京东的商品还可以通过<a href='<?php echo addon_url("collection://collection/index"); ?>'>商品采集</a>功能进行导入外部商品。</div>
                        <?php endif; ?>
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>

             <!-- 营销试款 -->
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                关注<a href='javascript:void(0)'>促销管理</a>菜单下的促销方式，选择合适自己商品的促销方式进行销量破零，打造爆款商品。也可以联系平台购买平台的广告位、商品排名、商品搜索关键字等方式对商品进行曝光。
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                请已购消费者评价商品展示买家秀，在<a href='<?php echo url("shop/goodsappraises/index"); ?>'>商品评价</a>和<a href='<?php echo url("shop/goodsconsult/shopreplyconsult"); ?>'>商品咨询</a>中和消费者达成良好互动关系。若在<a href='<?php echo url("shop/ordercomplains/shopcomplain"); ?>'>投诉订单</a>中接到订单投诉，建议商家与消费者达成良好沟通，尽可能和平解决订单纠纷，否则将交由平台进行仲裁。
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                消费者提交的售后信息将展示在<a href='<?php echo url("shop/orderservices/index"); ?>'>售后申请</a>中，商家应了解退换货流程及应对技巧，根据店铺情况完成退换货操作。
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>

            <!-- 推广发布 -->
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                研究<a href='javascript:void(0)'>促销管理</a>规则，选择若干商品搭建促销活动，通过平台广告位，或者自有渠道如微博，微信，直播等传播方式引流。
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                对新老客户进行<a href='<?php echo url("shop/shopmembergroups/index"); ?>'>会员分组</a>，通过在商品中设置各分组的优惠额度，促进新老客户的成交。也可以对关注和下单客户进行优惠券赠送等方式进行促进成交。
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>
	        <div class='panel'>
	            <div class='leftp'>
		             <div class='tit'></div>
		             <div class='cont'>
		                通过对<a href='javascript:void(0)'>报表统计</a>的变化监控，不断优化营销方式以及提升新老客户的下单率。
		             </div>
		        </div>
                <div class='rightp'>
                 	<a href='javascript:closeGuide()' class='fbtn'>关闭指引</a>
                </div>
	        </div>
	    </div>
    </div>
</div>
<script>
$('#topHead li').click(function(){
	var topLi = $(this);
	topLi.addClass('active').siblings().removeClass('active');
	var index = topLi.attr('dataval');
	$('#sendHead'+index).css('display','inline-flex').siblings().css('display','none');
	$('#sendHead'+index+' li').eq(0).click();
});
$('#secHead li').click(function(){
    var secLi = $(this);
    secLi.siblings().removeClass('active');
    var uls = secLi.parent().siblings();
    uls.each(function(){
    	$(this).find('li').removeClass('active');
    })
    secLi.addClass('active');
    // var title = secLi.find('.title').html();
    var index = secLi.attr('dataval');
    var panel = $('#panel-box .panel').eq(index);
    // panel.find('.tit').html(title);
    panel.show().siblings().hide();
})
function closeGuide(){
	$('.guide').slideUp(600);
	$.post(WST.U('shop/index/closeGuide'),WST.getParams('.ipt'),function(data,textStatus){});
}
$(function(){
	var index = 0;
	$('#secHead li').each(function(){
		$(this).attr('dataval',index);
		index++;
	});
	$('#topHead li').eq(0).click();
})
</script>
<?php endif; ?>
<div class="main">
	<div class="main_middle">
		<ul class="main_mid_box">
			<li class="mid_l">
				<div class="mid_l_item">
					<div class="main_title">
						<div class="wst-lfloat">

							<span class="c16_555">订单提示</span>
						</div>
						<div class="f-clear"></div>
					</div>
					<div class="mid_main">
						<ul class="order_info">
							<?php if(WSTShopGrant('shop/ordercomplains/shopcomplain')): ?>
							<li><a id="menuItem25" href="<?php echo url('shop/ordercomplains/shopcomplain'); ?>" dataid="25">
								<div class="complain_num"><?php echo $data['stat']['complainNum']; ?></div>
								<div>待回应投诉</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/orders/delivered')): ?>
							<li><a id="menuItem53" href="<?php echo url('shop/orders/delivered'); ?>" dataid="53">
								<div class="complain_num"><?php echo $data['stat']['waitReceiveCnt']; ?></div>
								<div>待收货</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/orders/waitdelivery')): ?>
							<li><a id="menuItem24" href="<?php echo url('shop/orders/waitdelivery'); ?>" dataid="24">
								<div class="complain_num"><?php echo $data['stat']['waitDeliveryCnt']; ?></div>
								<div>待发货</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/orders/waituserpay')): ?>
							<li><a id="menuItem55" href="<?php echo url('shop/orders/waituserpay'); ?>" dataid="55">
								<div class="complain_num"><?php echo $data['stat']['orderNeedpayCnt']; ?></div>
								<div>待付款</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/orders/failure')): ?>
							<li><a id="menuItem45" href="<?php echo url('shop/orders/failure'); ?>" dataid="45">
								<div class="complain_num"><?php echo $data['stat']['cancel']; ?></div>
								<div>取消/拒收</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/orders/failure')): ?>
							<li><a id="menuItem45" href="<?php echo url('shop/orders/refund'); ?>" dataid="45">
								<div class="complain_num"><?php echo $data['stat']['orderRefundCnt']; ?></div>
								<div>待退款</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/orderservices/index')): ?>
							<li><a id="menuItem45" href="<?php echo url('shop/orderservices/index'); ?>" dataid="45">
								<div class="complain_num"><?php echo $data['stat']['orderServicesCnt']; ?></div>
								<div>售后</div>
							</a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>

				<div class="mid_l_item" style="margin-top:10px;">
					<div class="main_title">
						<div class="wst-lfloat">
							<span class="c16_555">商品信息</span>
						</div>
					</div>
					<div class="f-clear"></div>
					<div class="mid_main">
						<ul class="order_info">
							<?php if(WSTShopGrant('shop/goods/store')): ?>
							<li><a id="menuItem34" href="<?php echo Url('shop/goods/store'); ?>" dataid="34">
								<div class="complain_num"><?php echo $data['stat']['unSaleCnt']; ?></div>
								<div>仓库中</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/goods/stockwarnbypage')): ?>
							<li><a id="menuItem54" href="<?php echo Url('shop/goods/stockwarnbypage'); ?>" dataid="54">
								<div class="complain_num"><?php echo $data['stat']['stockWarnCnt']; ?></div>
							    <div >预警库存</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/goods/sale')): ?>
							<li><a id="menuItem32" href="<?php echo Url('shop/goods/sale'); ?>" dataid="32">
								<div class="complain_num"><?php echo $data['stat']['onSaleCnt']; ?></div>
								<div>出售中</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/goods/audit')): ?>
							<li><a id="menuItem33" href="<?php echo Url('shop/goods/audit'); ?>" dataid="33">
								<div class="complain_num"><?php echo $data['stat']['waitAuditCnt']; ?></div>
								<div>待审核</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/goods/illegal')): ?>
							<li><a id="menuItem56" href="<?php echo Url('shop/goods/illegal'); ?>" dataid="56">
								<div class="complain_num"><?php echo $data['stat']['illegalCnt']; ?></div>
							    <div>违规商品</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/goodsconsult/shopReplyConsult')): ?>
							<li><a id="menuItem102" href="<?php echo Url('shop/goodsconsult/shopReplyConsult'); ?>" dataid="102">
								<div class="complain_num"><?php echo $data['stat']['consult']; ?></div>
							    <div>待回复咨询</div>
							</a></li>
							<?php endif; if(WSTShopGrant('shop/reports/statfavorites')): ?>
							<li><a href="<?php echo Url('shop/reports/statfavorites'); ?>">
								<div class="complain_num"><?php echo $data['stat']['collectionCnt']; ?></div>
								收藏数
							</a></li>
							<?php endif; if(WSTShopGrant('shop/reports/statcarts')): ?>
							<li><a href="<?php echo Url('shop/reports/statcarts'); ?>">
								<div class="complain_num"><?php echo $data['stat']['cartCnt']; ?></div>
								添加购物车数
							</a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</li>

			<li class="mid_r">

				<div class='mid_r_rbottom' style="margin-bottom: 10px;">
					<div class="main_title">
						<div class="wst-lfloat">

							<span class="c16_555">商家帮助</span>
						</div>
						<div class="f-clear"></div>
					</div>
					<div class="rbottom_main">
						<ul class="shop_tips">
							<?php $wstTagArticle =  model("common/Tags")->listArticle("300",8,0); foreach($wstTagArticle as $key=>$vo){?>
							<li class="wst-textover"><a href="<?php echo url('home/news/view',['id'=>$vo['articleId']]); ?>" target="_blank" title="<?php echo $vo['articleTitle']; ?>"><i></i><?php echo $key+1; ?>、<?php echo $vo['articleTitle']; ?></a><span><?php echo date('Y-m-d',strtotime($vo['createTime'])); ?></span></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class='mid_r_rbottom'>
					<div class="main_title">
						<div class="wst-lfloat">

							<span class="c16_555">商家公告</span>
						</div>
						<div class="f-clear"></div>
					</div>
					<div class="rbottom_main">
						<ul class="shop_tips2">
							<?php $wstTagArticle =  model("common/Tags")->listArticle("51",5,0); foreach($wstTagArticle as $key=>$vo){?>
							<li class="wst-textover"><a href="<?php echo url('home/news/view',['id'=>$vo['articleId']]); ?>" target="_blank" title="<?php echo $vo['articleTitle']; ?>"><?php echo $key+1; ?>、<?php echo $vo['articleTitle']; ?></a><i>NEWS</i>&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo date('Y-m-d',strtotime($vo['createTime'])); ?></span></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</li>
			<div style='clear:both'></div>
			<?php if(WSTShopGrant('shop/reports/topSaleGoods')): ?>
			<li class="mid_c">
				<div class="index-right">
					<div class="index-right-item">
						<div class="main_title" style="padding-left:10px;">
							<div class="wst-lfloat">

								<span class="c16_555">最近30天销售排行</span>
							</div>
							<div class="f-clear"></div>
						</div>
						<ul class="right-list-tit">
							<li class="c12_555">序号</li>
							<li class="c12_555">商品</li>
							<li class="c12_555">数量</li>
						</ul>
						<?php if(is_array($data['stat']['goodsTop']) || $data['stat']['goodsTop'] instanceof \think\Collection || $data['stat']['goodsTop'] instanceof \think\Paginator): $gkey = 0;$__LIST__ = is_array($data['stat']['goodsTop']) ? array_slice($data['stat']['goodsTop'],0,10, true) : $data['stat']['goodsTop']->slice(0,10, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$glist): $mod = ($gkey % 2 );++$gkey;?>
						<ul class="right-list-tit right-list">
							<li class="c14_ff66">
								<div class="gTop<?php echo $gkey; ?> top-num"><?php echo $gkey; ?></div>
							</li>
							<li class="wst-textover"><a class="c14_ff90 atop<?php echo $gkey; ?>" target="_blank" href="<?php echo url('home/goods/detail',['goodsId'=>$glist['goodsId']]); ?>"><?php echo $glist['goodsName']; ?></a></li>
							<li class="c14_ff66 gTop<?php echo $gkey; ?>"><?php echo !empty($glist['goodsNum']) ? $glist['goodsNum'] : 0; ?></li>
						</ul>
						<?php endforeach; endif; else: echo "" ;endif; ?>

					</div>
				</div>
			</li>
			<?php endif; if(WSTShopGrant('shop/reports/statSales')): ?>
			<li class="mid_r">
				<div class="sale_info">
					<div class="main_title">
						<div class="wst-lfloat">

							<span class="c16_555">近30天销售情况</span>
						</div>
						<div class="f-clear"></div>
					</div>
					<div id="saleMain" style="width:100%;height:335px;"></div>
				</div>
			</li>
			<script>$(function(){saleCount()});</script>
			<?php endif; ?>
		</ul>
	</div>
<div class="f-clear"></div>

</div>
</div>

<input type="hidden"  id="startDate"  class="ipt" value='<?php echo date("Y-m-d",strtotime("-30 day")); ?>'/>
<input type="hidden" id="endDate" class="ipt" value='<?php echo date("Y-m-d"); ?>'/>

<script type="text/javascript">
<?php if((WSTDatas('ADS_TYPE',2)!='' || WSTDatas('ADS_TYPE',3)!='' || WSTDatas('ADS_TYPE',5)!='')): ?>
$(function(){
	var qtop = $("#qrTitle").offset().top;
	var qleft = $("#qrTitle").offset().left;
	$("#shopQrbox").on({
		click : function(){
			$("#shopQrcode").css({'top':(qtop+30)+"px",'left':qleft+"px"}).toggle();
		}
	}) ;
	<?php if((WSTDatas('ADS_TYPE',2)!='' || WSTDatas('ADS_TYPE',3)!='')): ?>
	WST.createShopQrcode(1);
	<?php endif; if((WSTDatas('ADS_TYPE',5)!='')): ?>
	WST.createShopQrcode(2);
	<?php endif; ?>
});
<?php endif; ?>
</script>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script src="/hkshopNC/dxshop/static/plugins/echarts/echarts.min.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script>
// 销售统计
function saleCount(){
	$.post(WST.U('shop/reports/getStatSales'),WST.getParams('.ipt'),function(data,textStatus){
	    var json = WST.toJson(data);
	    var myChart = echarts.init(document.getElementById('saleMain'));
	    myChart.clear();
	    $('#mainTable').hide();
	    if(json.status=='1' && json.data){
			var option = {
			    tooltip : {
			        trigger: 'axis'
			    },
			    calculable : true,
			    xAxis : [
			        {
			            type : 'category',
			            data : json.data.days
			        }
			    ],
			    yAxis : [			        {      type : 'value'     }	    ],
			    series : [
			        {
			            name:'销售额',
			            type:'line',
			            data:json.data.dayVals
			        }
			    ]
			};
			myChart.setOption(option);
	    }
	});
}
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
