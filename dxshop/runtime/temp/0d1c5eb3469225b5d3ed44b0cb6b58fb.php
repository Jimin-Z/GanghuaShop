<?php /*a:5:{s:74:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\shop_goods_list.html";i:1672383620;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\base.html";i:1669564406;s:62:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\top.html";i:1738420029;s:69:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\right_cart.html";i:1650787502;s:65:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\footer.html";i:1738136898;}*/ ?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $data['shop']['shopName']; ?> - <?php echo WSTConf('CONF.mallName'); ?></title>

<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__STYLE__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet">

<link href="/hkshopNC/dxshop/static/plugins/lazyload/skin/laypage.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="/hkshopNC/dxshop/static/plugins/slide/css/slide.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/shophome.css?v=<?php echo $v; ?>" rel="stylesheet">
<style type="text/css">
</style>

<script type="text/javascript" src="/hkshopNC/dxshop/static/js/jquery.min.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js?v=<?php echo $v; ?>"></script>	
<script type='text/javascript' src='/hkshopNC/dxshop/static/js/common.js?v=<?php echo $v; ?>'></script>

<script type='text/javascript' src='__STYLE__/js/common.js?v=<?php echo $v; ?>'></script>


<?php if(((int)session('WST_USER.userId')<=0)): ?>
<link href="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/login.css?v=<?php echo $v; ?>" rel="stylesheet">
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.min.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/js/rsa.js"></script>
<script type='text/javascript' src='__STYLE__/js/login.js?v=<?php echo $v; ?>'></script>
<?php endif; ?>
<script>
window.conf = {"ROOT":"/hkshopNC/dxshop","APP":"/hkshopNC/dxshop","STATIC":"/hkshopNC/dxshop/static","SUFFIX":"<?php echo config('url_html_suffix'); ?>","SMS_VERFY":"<?php echo WSTConf('CONF.smsVerfy'); ?>","SMS_OPEN":"<?php echo WSTConf('CONF.smsOpen'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>","IS_LOGIN":"<?php if((int)session('WST_USER.userId')>0): ?>1<?php else: ?>0<?php endif; ?>","TIME_TASK":"1","ROUTES":'<?php echo WSTRoute(); ?>',"IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>","HTTP":"<?php echo WSTProtocol(); ?>","MAP_KEY":"<?php echo WSTConf('CONF.mapKey'); ?>",'RESOURCE_DOMAIN':'<?php echo WSTConf('CONF.resourceDomain'); ?>','RESOURCE_PATH':'<?php echo WSTConf('CONF.resourcePath'); ?>'}
$(function() {
	WST.initVisitor();
});
</script>
</head>

<body>

	
<?php $wstTagAds =  model("common/Tags")->listAds("index-top-ads",99,86400); foreach($wstTagAds as $key=>$tads){if(($tads['adFile']!='')): ?>
<div class="index-top-ads">
  <a href="<?php echo $tads['adURL']; ?>" <?php if(($tads['isOpen'])): ?>target='_blank'<?php endif; if(($tads['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $tads['adId']; ?>)"<?php endif; ?> onfocus="this.blur();">
    <img src="__RESOURCE_PATH__/<?php echo $tads['adFile']; ?>"></a>
  <a href="javascript:;" class="close-ads" onclick="WST.closeAds(this)"></a>
</div>
<?php endif; } ?>

<div class="wst-header">
    <div class="wst-nav">
		<ul class="headlf">
		<?php if(session('WST_USER.userId') >0): ?>
		   <li class="drop-info">
			  <div class="drop-infos">
			  <a href="<?php echo Url('home/users/index'); ?>">欢迎您，<?php echo session('WST_USER.userName')?session('WST_USER.userName'):session('WST_USER.loginName'); ?></a>
			  </div>
			  <div class="wst-tag dorpdown-user">
			  	<div class="wst-tagt">
			  	   <div class="userImg" >
				  	<img class='usersImg' data-original="<?php echo WSTUserPhoto(session('WST_USER.userPhoto')); ?>"/>
				   </div>	
				  <div class="wst-tagt-n">
				    <div style="height: 30px;overflow: hidden;">
					  	<span class="wst-tagt-na"><?php echo session('WST_USER.userName')?session('WST_USER.userName'):session('WST_USER.loginName'); ?></span>
					  	<?php if((int)session('WST_USER.rankId') > 0): $rankName = session('WST_USER.rankName');?>
					  		<img src="__RESOURCE_PATH__/<?php echo session('WST_USER.userrankImg'); ?>" title="<?php echo WSTStripTags($rankName); ?>"/>
					  	<?php endif; ?>
				  	</div>
				  	<div class='wst-tags'>
			  	     <span class="w-lfloat"><a onclick="WST.toUserMenus(15,'home/users/edit',0)" href='javascript:;'>用户资料</a></span>
			  	     <span class="w-lfloat" style="margin-left:10px;"><a onclick="WST.toUserMenus(16,'home/users/security',1)" href='javascript:;'>安全设置</a></span>
			  	    </div>
				  </div>
			  	  <div class="wst-tagb" >
			  		<a onclick="WST.toUserMenus(5,'home/orders/waitReceive',1)" href='javascript:;'>待收货订单</a>
			  		<a onclick="WST.toUserMenus(60,'home/logmoneys/usermoneys',43)" href='javascript:;'>我的余额</a>
			  		<a onclick="WST.toUserMenus(49,'home/messages/index',1)" href='javascript:;'>我的消息</a>
			  		<a onclick="WST.toUserMenus(13,'home/userscores/index',43)" href='javascript:;'>我的积分</a>
			  		<a onclick="WST.toUserMenus(41,'home/favorites/goods',1)" href='javascript:;'>我的关注</a>
			  		<a style='display:none'>咨询回复</a>
			  	  </div>
			  	<div class="wst-clear"></div>
			  	</div>
			  </div>
			</li>
			<li class="spacer">|</li>
			<li class="drop-info">
			<a href='javascript:;' onclick="WST.toUserMenus(49,'home/messages/index',0)">消息（<span id='wst-user-messages'>0</span>）</a>
			</li>
			<li class="spacer">|</li>
			<li class="drop-info">
			  <div><a href="javascript:WST.logout();">退出</a></div>
			</li>
			<?php else: ?>
			<li class="drop-info">
			  <div>欢迎来到<?php echo WSTMSubstr(WSTConf('CONF.mallName'),0,13); ?><a href="<?php echo Url('home/users/login'); ?>" onclick="WST.currentUrl();">&nbsp;&nbsp;请&nbsp;登录</a></div>
			</li>
			<li class="spacer">|</li>
			<li class="drop-info">
			  <div><a href="<?php echo Url('home/users/regist'); ?>" onclick="WST.currentUrl();">免费注册</a></div>
			</li>
			<?php endif; ?>
		</ul>
		<ul class="headrf" style='float:right;'>
		    <li class="j-dorpdown" style="width: 86px;">
				<div class="drop-down pdr5">
					<a href='javascript:;' onclick="WST.toUserMenus(3,'home/orders/waitPay',1)"><i class='fa fa-shopping-bag'></i> 我的订单<i class="di-right"><s>◇</s></i></a>
				</div>
				<div class='j-dorpdown-layer order-list'>
				   <div><a href='javascript:;' onclick="WST.toUserMenus(3,'home/orders/waitPay',1)">待付款订单</a></div>
				   <div><a href='javascript:;' onclick="WST.toUserMenus(5,'home/orders/waitReceive',1)">待发货订单</a></div>
				   <div><a href='javascript:;' onclick="WST.toUserMenus(6,'home/orders/waitAppraise',1)">待评价订单</a></div>
				</div>
			</li>	
			<?php if((WSTDatas('ADS_TYPE',4))): ?>
			<li class="spacer">|</li>
			<li class="j-dorpdown">
				<div class="drop-down pdr5"><i class="di-left"></i><a href="#" target="_blank"><i class='fa fa-mobile fa-lg'></i> 手机商城</a></div>
				<div class='j-dorpdown-layer sweep-list'>
				   <div class="qrcodea">
					   <div id='qrcodea' class="qrcodeal"></div>
					   <div class="qrcodear">
					   	<p>扫描二维码</p><span>下载手机客户端</span>
					   	<br/>
					   	<a href="<?php echo url('home/index/download'); ?>" target="_blank">Android</a>
					   	<br/>
					   	<a href="<?php echo url('home/index/download'); ?>" target="_blank">iPhone</a>
					   </div>
				   </div>
				</div>
			</li>
			<?php endif; if((WSTConf('CONF.wxenabled')==1)): ?>
			<li class="spacer">|</li>
			<li class="j-dorpdown">
				<div class="drop-down pdr5"><a href="#" target="_blank"><i class='fa fa-wechat'></i> 关注我们</a></div>
				<div class='j-dorpdown-layer des-list' style="width:120px;">
					<div style="height:114px;"><?php if((WSTConf('CONF.wxAppLogo'))): ?><img src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.wxAppLogo'); ?>" style="height:114px;"><?php endif; ?></div>
					<div>关注我们</div>
				</div>
			</li>
			<?php endif; ?>
			<li class="spacer">|</li>
			<li class="j-dorpdown">
				<div class="drop-down pdr5"><a href="#" target="_blank"><i class='fa fa-star'></i> 我的收藏</a></div>
				<div class='j-dorpdown-layer foucs-list'>
				   <div><a href="javascript:;" onclick="WST.toUserMenus(41,'home/favorites/goods',1)">商品收藏</a></div>
				   <div><a href="javascript:;" onclick="WST.toUserMenus(46,'home/favorites/shops',1)">店铺收藏</a></div>
				</div>
			</li>
			<li class="spacer">|</li>
			<li class="j-dorpdown">
				<div class="drop-down pdr5" ><a href="#" target="_blank"><i class='fa fa-headphones'></i> 客户服务</a></div>
				<div class='j-dorpdown-layer des-list'>
				   <div><a href='<?php echo Url("home/helpcenter/view","id=1"); ?>' target='_blank'>帮助中心</a></div>
				   <div><a href='<?php echo Url("home/helpcenter/view","id=8"); ?>' target='_blank'>售后服务</a></div>
				   <div><a href='<?php echo Url("home/helpcenter/view","id=3"); ?>' target='_blank'>常见问题</a></div>
				   <div><a href='<?php echo Url("home/feedbacks/index"); ?>' target='_blank'>功能反馈</a></div>
				   <div><a href='<?php echo getWeliveUrl("客户服务"); ?>' target='_blank'>连线客服</a></div>
				</div>
			</li>
			<?php if((WSTConf('CONF.isOpenShopApply')==1 || WSTConf('CONF.isOpenSupplierApply')==1)): ?>
			<li class="spacer">|</li>
			<li class="j-dorpdown">
				<div class="drop-down pdr5" ><a href="#" target="_blank"><i class='fa fa-handshake-o'></i> 招商合作</a></div>
				<div class='j-dorpdown-layer des-list'>
					<?php if(WSTConf('CONF.isOpenShopApply')==1): ?>
				   	<div><a href="<?php echo url('home/shops/join'); ?>" rel="nofollow" onclick="WST.currentUrl('<?php echo url("home/shops/join"); ?>');">商家入驻</a></div>
				   	<?php endif; if(WSTConf('CONF.isOpenSupplier')==1 && WSTConf('CONF.isOpenSupplierApply')==1): ?>
				   	<div><a href="<?php echo url('home/suppliers/join'); ?>" rel="nofollow" onclick="WST.currentUrl('<?php echo url("home/suppliers/join"); ?>');">供货商入驻</a></div>
				   	<?php endif; ?>
				</div>
			</li>
			<?php endif; ?>
			<li class="spacer">|</li>
			<?php if((session('WST_USER.userId') > 0) && (session('WST_USER.userType') == 1 || session('WST_SUPPLIER.userType') == 3)): if((session('WST_USER.userType') == 1 && session('WST_SUPPLIER.userType') == 3)): ?>
					<li class="j-dorpdown">
						<div class="drop-down pdr5" ><a href="#" target="_blank"><i class='fa fa-desktop'></i> 管理中心<i class="di-right"><s>◇</s></i></a></div>
						<div class='j-dorpdown-layer foucs-list'>
						   <div><a href="<?php echo Url('supplier/index/index'); ?>" target="_blank">供货商中心</a></div>
						   <div><a href="<?php echo Url('shop/index/index'); ?>" target="_blank">商家中心</a></div>
						</div>
					</li>
				<?php else: if(session('WST_SUPPLIER.supplierId') > 0): ?>
					<li style='width:78px;text-align: center'><a target="_blank" href="<?php echo Url('supplier/index/index'); ?>" rel="nofollow"><i class='fa fa-desktop'></i> 供货商中心</a></li>
					<?php else: ?>
					<li style='width:78px;text-align: center'><a target="_blank" href="<?php echo Url('shop/index/index'); ?>" rel="nofollow"><i class='fa fa-desktop'></i> 商家中心</a></li>
					<?php endif; ?>
				<?php endif; else: ?>
				<li class="j-dorpdown">
					<div class="drop-down pdr5" ><a href="#" target="_blank"><i class='fa fa-desktop'></i> 管理中心<i class="di-right"><s>◇</s></i></a></div>
					<div class='j-dorpdown-layer foucs-list'>
					   <div><a href="<?php echo url('shop/index/login'); ?>" target="_blank">商家登录</a></div>
					   <?php if(WSTConf('CONF.isOpenSupplier')==1): ?>
					   <div><a href="<?php echo url('supplier/index/login'); ?>" target="_blank">供货商登录</a></div>
					   <?php endif; ?>
					</div>
				</li>
            <?php endif; ?>
		</ul>
		<div class="wst-clear"></div>
  </div>
</div>
<script>
<?php if((WSTDatas('ADS_TYPE',4))): ?>
$(function(){
	//二维码
	var url = '<?php echo url('home/index/download'); ?>';
	var qrcode = new QRCode(document.getElementById("qrcodea"), {
        width : 260,
        height : 260
    });
    qrcode.makeCode(url);
});
<?php endif; ?>
function goShop(id){
  location.href=WST.U('home/shops/index','shopId='+id);
}
</script>
<script type='text/javascript' src='/hkshopNC/dxshop/static/js/qrcode.js'></script>


    <input type="hidden" id="longitude" value="<?php echo $data['shop']['longitude']; ?>" >
    <input type="hidden" id="latitude" value="<?php echo $data['shop']['latitude']; ?>" >
	<div class="wst-container">
		<div class="wst-shop-h">
		<div class="wst-shop-img"><a href="<?php echo url('home/shops/index',array('shopId'=>$data['shop']['shopId'])); ?>"><img class="shopsImg" data-original="__RESOURCE_PATH__/<?php echo $data['shop']['shopImg']; ?>" title="<?php echo WSTStripTags($data['shop']['shopName']); ?>"></a></div>
		<div class="wst-shop-info">
			<p><?php echo $data['shop']['shopName']; ?>
				
        		<?php echo hook('homeDocumentContact',['type'=>'shopHome','shopId'=>$data['shop']['shopId']]); ?>
			</p>
			<div class="wst-shop-info2">
			<?php if(is_array($data['shop']['accreds']) || $data['shop']['accreds'] instanceof \think\Collection || $data['shop']['accreds'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['shop']['accreds'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ac): $mod = ($i % 2 );++$i;?>
			<img src="__RESOURCE_PATH__/<?php echo $ac['accredImg']; ?>"><span><?php echo $ac['accredName']; ?></span>
			<?php endforeach; endif; else: echo "" ;endif; if(($data['shop']['shopQQ'])): ?>
			<a href="tencent://message/?uin=<?php echo $data['shop']['shopQQ']; ?>&Site=QQ交谈&Menu=yes">
		        <img border="0" style="width:65px;height:24px;" src="<?php echo WSTProtocol(); ?>wpa.qq.com/pa?p=1:<?php echo $data['shop']['shopQQ']; ?>:7">
		    </a>
			<?php endif; if(($data['shop']['shopWangWang'])): ?>
			<a href="<?php echo WSTProtocol(); ?>www.taobao.com/webww/ww.php?ver=3&touid=<?php echo $data['shop']['shopWangWang']; ?>&siteid=cntaobao&status=1&charset=utf-8" target="_blank">
			<img border="0" src="<?php echo WSTProtocol(); ?>amos.alicdn.com/realonline.aw?v=2&uid=<?php echo $data['shop']['shopWangWang']; ?>&site=cntaobao&s=1&charset=utf-8" alt="和我联系" class='wangwang'/>
			</a>
			<?php endif; ?>
			</div>
			<div class="wst-shop-info3">
				<span class="wst-shop-eva">商品评价：<span class="wst-shop-red"><?php echo $data['shop']['scores']['goodsScore']; ?></span></span>
				<span class="wst-shop-eva">时效评价：<span class="wst-shop-red"><?php echo $data['shop']['scores']['timeScore']; ?></span></span>
				<span class="wst-shop-eva">服务评价：<span class="wst-shop-red"><?php echo $data['shop']['scores']['serviceScore']; ?></span></span>
				<?php if(($data['shop']['isfollow']>0)): ?>
				<a href='javascript:void(0);' onclick='cancelFavorite(this,1,<?php echo $data['shop']['shopId']; ?>,<?php echo $data['shop']['isfollow']; ?>)' class="wst-shop-evaa j-fav">已关注</a>
				<?php else: ?>
				<a href='javascript:void(0);' onclick='addFavorite(this,1,<?php echo $data['shop']['shopId']; ?>,<?php echo $data['shop']['isfollow']; ?>)' class="wst-shop-evaa j-fav2">关注店铺</a>
				<?php endif; if(($data['shop']['longitude'] && $data['shop']['latitude'])): ?>
				<a href='javascript:void(0);' onclick='javascript:init();' class="wst-shop-evaa  wst-shop-location j-fav3">店铺位置</a>
                <?php endif; ?>
				<span class="wst-shop-eva">用手机逛本店  &nbsp;&nbsp;|</span>
				<a class="wst-shop-code"><span class="wst-shop-codes hide"><div id='qrcode' style='width:142px;height:142px;'></div></span></a>
			</div>
		</div>
		<div class="wst-shop-sea">
			<input type="text" id="goodsName" value="<?php echo $goodsName; ?>" placeholder="输入商品名称">
			<a class="search" href="javascript:void(0);" onclick="javascript:WST.goodsSearch($('#goodsName').val());">搜全站</a>
			<a class="search" href="javascript:void(0);" onclick="javascript:searchShopsGoods(0);">搜本店</a>
			<div class="wst-shop-word">
			<?php if(is_array($data['shop']['shopHotWords']) || $data['shop']['shopHotWords'] instanceof \think\Collection || $data['shop']['shopHotWords'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['shop']['shopHotWords'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shw): $mod = ($i % 2 );++$i;?>
			<a href='<?php echo Url("home/shops/goods",array('shopId'=>$data['shop']['shopId'],'goodsName'=>$shw)); ?>'><?php echo $shw; ?></a><?php if($i< count($data['shop']['shopHotWords'])): ?>&nbsp;|&nbsp;<?php endif; ?>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			<?php if(!(Request()->isSsl())){?>
			<div class="bdsharebuttonbox">
                <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                <a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>
                <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
          	</div>
         	<script>
                with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='/hkshopNC/dxshop/static/plugins/baiduShare/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
         	</script>
			<?php } ?>
			<?php echo hook('homeDocumentShopHomeHeader',['shop'=>$data['shop'],'getParams'=>input()]); ?>
			<div style="clear: both;"></div>
		</div>
		<div class="wst-clear"></div>
		</div>
	</div>
	 <div class='wst-header'>
		<div class="wst-shop-nav">
			<div class="wst-nav-box">
				<a href="<?php echo url('home/shops/index',array('shopId'=>$data['shop']['shopId'])); ?>"><li class="liselect wst-lfloat <?php if($ct1 == 0): ?>wst-nav-boxa<?php endif; ?>">店铺主页</li></a>
				<?php $wstTagShopscats =  model("common/Tags")->listShopCats(0,8,$data['shop']['shopId'],0); foreach($wstTagShopscats as $key=>$sc){?>
					<a href="<?php echo url('home/shops/goods',array('shopId'=>$sc['shopId'],'ct1'=>$sc['catId'])); ?>"><li class="liselect wst-lfloat <?php if($ct1 == $sc['catId']): ?>wst-nav-boxa<?php endif; ?>"><?php echo $sc['catName']; ?></li></a>
				<?php } ?>
				<a class="homepage" href='<?php echo app('request')->root(true); ?>'>返回商城首页</a>
				<div class="wst-clear"></div>
			</div>
		</div>
		<div class="wst-clear"></div>
	</div>



<input type="hidden" id="msort" value="<?php echo $msort; ?>" autocomplete="off"/>
<input type="hidden" id="mdesc" value="<?php echo $mdesc; ?>" autocomplete="off"/>
<input type="hidden" id="shopId" value="<?php echo $data['shop']['shopId']; ?>" autocomplete="off"/>
<input type="hidden" id="ct1" value="<?php echo $ct1; ?>" autocomplete="off"/>
<input type="hidden" id="ct2" value="<?php echo $ct2; ?>" autocomplete="off"/>
<div class="wst-container">
	<div class="wst-shop-contl">
		<div class="wst-shop-cat">
			<p class="wst-shop-conlp">店铺分类</p>
			<div class="wst-shop-catt">
			<?php $wstTagShopscats =  model("common/Tags")->listShopCats(0,99,$data['shop']['shopId'],0); foreach($wstTagShopscats as $key=>$sc1){?>
				<li onclick="javascript:dropDown(this,<?php echo $sc1['catId']; ?>);" class="js-shop-plus">
					<a href="<?php echo url('home/shops/goods',array('shopId'=>$sc1['shopId'],'ct1'=>$sc1['catId'])); ?>">
						<?php echo WSTMSubstr($sc1['catName'],0,15); ?>
					</a>
				</li>
				<div class="wst-shop-catts tree_<?php echo $sc1['catId']; ?>">
				<?php $wstTagShopscats =  model("common/Tags")->listShopCats($sc1['catId'],99,$data['shop']['shopId'],0); foreach($wstTagShopscats as $key=>$sc2){?>
					<a href="<?php echo url('home/shops/goods',array('shopId'=>$sc1['shopId'],'ct1'=>$sc1['catId'],'ct2'=>$sc2['catId'])); ?>"><li><?php echo WSTMSubstr($sc2['catName'],0,15); ?></li></a>
				<?php } ?>
				</div>
			<?php } ?>
			</div>
		</div>
		<div class="wst-shop-best">
			<p class="wst-shop-conlp">热卖商品</p>
			<?php $wstTagShopGoods =  model("common/Tags")->listShopGoods("hot",$data['shop']['shopId'],0,5,0); foreach($wstTagShopGoods as $key=>$ho){?>
			<a href="<?php echo url('home/goods/detail',array('goodsId'=>$ho['goodsId'])); ?>" target="_blank">
			<div class="wst-shop-bestg">
				<div class="wst-shop-besti"><img class="goodsImg" data-original="__RESOURCE_PATH__/<?php echo $ho['goodsImg']; ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>" title="<?php echo WSTStripTags($ho['goodsName']); ?>" alt="<?php echo WSTStripTags($ho['goodsName']); ?>"></div>
				<a href="<?php echo url('home/goods/detail',array('goodsId'=>$ho['goodsId'])); ?>"><p class="wst-shop-bestgp1"><?php echo WSTStripTags($ho['goodsName']); ?></p></a>
				<p class="wst-shop-bestgp2">已售出<span class="wst-shop-bestpi"><?php echo $ho['saleNum']; ?></span>件</p>
				<p class="wst-shop-bestgp2"><span class="wst-shop-bestpr">￥<?php echo $ho['shopPrice']; ?></span><span class="wst-shop-bestpr2">￥<?php echo $ho['marketPrice']; ?></span></p>
			</div>
			</a>
			<?php } ?>
			<div class="wst-clear"></div>
		</div>
		<?php if(cookie("history_goods")!=''): ?>
		<div class="wst-shop-lat">
			<p class="wst-shop-conlp">最近浏览</p>
			<?php $wstTagGoods =  model("common/Tags")->listGoods("history",0,4,0); foreach($wstTagGoods as $key=>$vo){?>
			<div class="wst-shop-bestg">
				<div class="wst-shop-besti"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$vo['goodsId']); ?>"><img class="goodsImg" data-original="__RESOURCE_PATH__/<?php echo WSTImg($vo['goodsImg']); ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>" title="<?php echo WSTStripTags($vo['goodsName']); ?>" alt="<?php echo WSTStripTags($vo['goodsName']); ?>" ></div>
				<a href="<?php echo url('home/goods/detail','goodsId='.$vo['goodsId']); ?>" target='_blank'><p class="wst-shop-bestgp1"><?php echo WSTStripTags($vo['goodsName']); ?></p></a>
				<p class="wst-shop-bestgp2">已售出<span class="wst-shop-bestpi"><?php echo $vo['saleNum']; ?></span>件</p>
				<p class="wst-shop-bestgp2"><span class="wst-shop-bestpr">￥<?php echo $vo['shopPrice']; ?></span><span class="wst-shop-bestpr2">￥<?php echo $vo['marketPrice']; ?></span></p>
			</div>
			<?php } ?>
			<div class="wst-clear"></div>
		</div>
		<?php endif; ?>
	</div>
	<div class="wst-shop-contr">
		<div class="wst-shop-list">
			<div class="wst-shop-listh">
				<a href="javascript:void(0);" class="<?php if($msort == 0): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(0);">综合排序</a>
				<a href="javascript:void(0);" class="<?php if($msort == 1): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(1);">人气<span class="<?php if($msort != 1): ?>wst-shop-store<?php endif; if($msort == 1 and $mdesc == 1): ?>wst-shop-store2<?php endif; if($msort == 1 and $mdesc == 0): ?>wst-shop-store3<?php endif; ?>"></span></a>
				<a href="javascript:void(0);" class="<?php if($msort == 2): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(2);">销量<span class="<?php if($msort != 2): ?>wst-shop-store<?php endif; if($msort == 2 and $mdesc == 1): ?>wst-shop-store2<?php endif; if($msort == 2 and $mdesc == 0): ?>wst-shop-store3<?php endif; ?>"></span></a>
				<a href="javascript:void(0);" class="<?php if($msort == 3): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(3);">价格<span class="<?php if($msort != 3): ?>wst-shop-store<?php endif; if($msort == 3 and $mdesc == 1): ?>wst-shop-store2<?php endif; if($msort == 3 and $mdesc == 0): ?>wst-shop-store3<?php endif; ?>"></span></a>
				<a href="javascript:void(0);" class="<?php if($msort == 5): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(5);">好评度<span class="<?php if($msort != 5): ?>wst-shop-store<?php endif; if($msort == 5 and $mdesc == 1): ?>wst-shop-store2<?php endif; if($msort == 5 and $mdesc == 0): ?>wst-shop-store3<?php endif; ?>"></span></a>
				<a href="javascript:void(0);" class="<?php if($msort == 6): ?>wst-shop-a<?php endif; ?>" onclick="searchShopsGoods(6);">上架时间<span class="<?php if($msort != 6): ?>wst-shop-store<?php endif; if($msort == 6 and $mdesc == 1): ?>wst-shop-store2<?php endif; if($msort == 6 and $mdesc == 0): ?>wst-shop-store3<?php endif; ?>"></span></a>
				<div class="wst-price-ipts">
				<span class="wst-price-ipt1">￥</span><span class="wst-price-ipt2">￥</span>
				<input type="text" class="wst-price-ipt" id="sprice" value="<?php echo $sprice; ?>" style="margin-left:8px;" onkeypress='return WST.isNumberdoteKey(event);' onkeyup="javascript:WST.isChinese(this,1)">
				- <input type="text" class="wst-price-ipt" id="eprice" value="<?php echo $eprice; ?>" onkeypress='return WST.isNumberKey(event);' onkeyup="javascript:WST.isChinese(this,1)">
				</div>
				<button class="wst-shop-but" type="submit" style="width:60px;height: 33px;" onclick="searchShopsGoods(0);">确定</button>
			</div>
			<div class="wst-clear"></div>
			<div class="wst-shop-listg">
				<?php if(is_array($data['list']['data']) || $data['list']['data'] instanceof \think\Collection || $data['list']['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['list']['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?>
				<div class="wst-shop-goods">
					<div class="wst-shop-goimg"><a href="<?php echo url('home/goods/detail',array('goodsId'=>$li['goodsId'])); ?>" target="_blank"><img class="goodsImg" data-original="__RESOURCE_PATH__/<?php echo $li['goodsImg']; ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>" title="<?php echo WSTStripTags($li['goodsName']); ?>"></a><a href="javascript:addCart(<?php echo $li['goodsId']; ?>);"><span class="js-cart">加入购物车</span></a></div>
					<p class="wst-shop-gonam"><a href="<?php echo url('home/goods/detail',array('goodsId'=>$li['goodsId'])); ?>" target="_blank"><?php echo WSTStripTags($li['goodsName']); ?></a></p>
					<p class="wst-shop-goodp1"><span class="wst-shop-goodpr">￥<?php echo $li['shopPrice']; ?></span><span class="wst-rfloat">成交数：<span class="wst-shop-goodpr2"><?php echo $li['saleNum']; ?></span></span></p>
					<p class="wst-shop-goodp2"><span class="wst-shop-goodpr3">市场价:￥<?php echo $li['marketPrice']; ?></span><span class="wst-rfloat">已有<span class="wst-shop-goodpr4"><?php echo $li['appraiseNum']; ?></span>人评价</span></p>
				</div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="wst-clear"></div>
			</div>
			<div class="wst-shop-pa">
				<div id="shopPage"></div>
			</div>
		</div>
	</div>
	<div class="wst-clear"></div>

    <div id="container" class="container" style='display:none'></div>
</div>
<link href="__STYLE__/css/right_cart.css?v=<?php echo $v; ?>" rel="stylesheet">
<div class="j-global-toolbar">
	<div class="toolbar-wrap j-wrap" >
		<div class="toolbar">
			<div class="toolbar-panels j-panel">
				<div style="visibility: hidden;" class="j-content toolbar-panel tbar-panel-cart toolbar-animate-out">
					<h3 class="tbar-panel-header j-panel-header">
						<a href="" class="title"><i></i><em class="title">购物车</em></a>
						<span class="close-panel j-close" title='关闭'></span>
					</h3>
					<div class="tbar-panel-main" >
						<div class="tbar-panel-content j-panel-content">
						    <?php if(session('WST_USER.userId') == 0): ?>
							<div id="j-cart-tips" class="tbar-tipbox hide">
								<div class="tip-inner">
									<span class="tip-text">还没有登录，登录后商品将被保存</span>
									<a href="#none" onclick='WST.loginWindow()' class="tip-btn j-login">登录</a>
								</div>
							</div>
							<?php endif; ?>
							<div id="j-cart-render">
								<div id='cart-panel' class="tbar-cart-list"></div>
								  <script id="list-rightcart" type="text/html">
								  {{#
                                    var shop,goods,specs;
                                    for(var key in d){
                                        shop = d[key];
					                   
                                   }}
								   <div class="tbar-cart-item" id="shop-cart-{{shop.shopId}}">
							          <div class="jtc-item-promo">
							            <div class="promo-text">{{shop.shopName}}</div>
							          </div>
							          {{#
					                    for(var i=0;i<shop.list.length;i++){
                                           goods = shop.list[i];
						                   goods.goodsImg = WST.conf.RESOURCE_PATH+"/"+goods.goodsImg.replace('.','_thumb.');
						                   specs = '';
						                   if(goods.specNames && goods.specNames.length>0){
							                  for(var j=0;j<goods.specNames.length;j++){
								                 specs += goods.specNames[j].itemName+ " ";
							                  }
						                   }
                                   		}}
								      <div class="jtc-item-goods j-goods-item-{{goods.cartId}}" dataval="{{goods.cartId}}">
								          <div class='wst-lfloat'>
			                                 <input type='checkbox' id='rcart_{{goods.cartId}}' class='rchk' onclick='javascript:checkRightChks({{goods.cartId}},this);' {{# if(goods.isCheck==1){}}checked{{# } }}/></div>
									      <span class="p-img"><a target="_blank" href="{{WST.U('home/goods/detail','goodsId='+goods.goodsId)}}" target="_blank"><img src="{{goods.goodsImg}}" title="{{goods.goodsName}}" height="50" width="50"></a></span>
									      <div class="p-name">
									          <a target="_blank" title="{{(goods.goodsName+((specs!='')?"【"+specs+"】":""))}}" href="{{WST.U('home/goods/detail','goodsId='+goods.goodsId)}}">{{WST.cutStr(goods.goodsName,22)}}<br/>{{specs}}</a>
									      </div>
									      <div class="p-price">
									          <strong>¥<span id='gprice_{{goods.cartId}}'>{{goods.shopPrice}}</span></strong> 
									          <div class="wst-rfloat">
									             <a href="#none" class="buy-btn" id="buy-reduce_{{goods.cartId}}" onclick="javascript:WST.changeIptNum(-1,'#buyNum','#buy-reduce,#buy-add','{{goods.cartId}}','statRightCartMoney')">-</a>
									             <input type="text" id="buyNum_{{goods.cartId}}" class="right-cart-buy-num" value="{{goods.cartNum}}" data-max="{{goods.goodsStock}}" data-min="1" onkeyup="WST.changeIptNum(0,'#buyNum','#buy-reduce,#buy-add',{{goods.cartId}},'statRightCartMoney')" autocomplete="off"  onkeypress="return WST.isNumberKey(event);" maxlength="6"/>
									             <a href="#none" class="buy-btn" id="buy-add_{{goods.cartId}}" onclick="javascript:WST.changeIptNum(1,'#buyNum','#buy-reduce,#buy-add','{{goods.cartId}}','statRightCartMoney')">+</a>
									          </div>
									     </div>

									      <span onclick="javascript:delRightCart(this,{{goods.cartId}});" dataid="{{shop.shopId}}|{{goods.cartId}}" class="goods-remove" title="删除"></span>
									 </div>
									 {{# } }} 
								 </div>    
								 {{#  } }} 
                                 </script>   	
							</div>
						</div>
					</div>
					<div class="tbar-panel-footer j-panel-footer">
						<div class="tbar-checkout">
							<div class="jtc-number">已选<strong id="j-goods-count">0</strong>件商品 </div>
							<div class="jtc-sum"> 共计：¥<strong id="j-goods-total-money">0</strong> </div>
							<a class="jtc-btn j-btn" href="#none" onclick='javascript:jumpSettlement()'>去结算</a>
						</div>
					</div>
				</div>

				<div style="visibility: hidden;" data-name="follow" class="j-content toolbar-panel tbar-panel-follow">
					<h3 class="tbar-panel-header j-panel-header">
						<a href="#" target="_blank" class="title"> <i></i> <em class="title">我的关注</em> </a>
						<span class="close-panel j-close" title='关闭'></span>
					</h3>
					<div class="tbar-panel-main">
						<div class="tbar-panel-content j-panel-content">
							<div class="tbar-tipbox2">
								<div class="tip-inner"> <i class="i-loading"></i> </div>
							</div>
						</div>
					</div>
					<div class="tbar-panel-footer j-panel-footer"></div>
				</div>
				<div style="visibility: hidden;" class="j-content toolbar-panel tbar-panel-history toolbar-animate-in">
					<h3 class="tbar-panel-header j-panel-header">
						<a href="#none" class="title"> <i></i> <em class="title">我的足迹</em> </a>
						<span class="close-panel j-close" title='关闭'></span>
					</h3>
					<div class="tbar-panel-main">
						<div class="tbar-panel-content j-panel-content">
							<div class="jt-history-wrap">
								<ul id='history-goods-panel'></ul>
								<script id="list-history-goods" type="text/html">
								{{# 
                                 for(var i = 0; i < d.length; i++){ 
                                  d[i].goodsImg = WST.conf.RESOURCE_PATH+"/"+d[i].goodsImg.replace('.','_thumb.');
                                 }}
								   <li class="jth-item">
										<a target='_blank' href="{{WST.U('home/goods/detail','goodsId='+d[i].goodsId)}}" class="img-wrap"><img src="{{d[i].goodsImg}}" height="100" width="100"> </a>
										<a class="add-cart-button" href="javascript:WST.addCart({{d[i].goodsId}});">加入购物车</a>
										<a href="#none" class="price">￥{{d[i].shopPrice}}</a>
									</li>
								{{# } }}
                                </script>
							</div>
						</div>
					</div>
					<div class="tbar-panel-footer j-panel-footer"></div>
				</div>
			</div>
			
			<div class="toolbar-header"></div>
			
			<div class="toolbar-tabs j-tab">
				
				<div class="toolbar-tab tbar-tab-cart">
					<i class="tab-ico"></i>
					<em class="tab-text">购物车</em>
					<span class="tab-sub j-cart-count hide"></span>
				</div>
				<div class="toolbar-tab tbar-tab-follow" style='display:none'>
					<i class="tab-ico"></i>
					<em class="tab-text">我的关注</em>
					<span class="tab-sub j-count hide">0</span> 
				</div>
				<div class=" toolbar-tab tbar-tab-history ">
					<i class="tab-ico"></i>
					<em class="tab-text">我的足迹</em>
					<span class="tab-sub j-count hide"></span>
				</div>
				<div class="toolbar-tab tbar-tab-message">
				  <a href="javascript:;" onclick='WST.toUserMenus(49,"home/messages/index",1)'>
					<i class="tab-ico"></i>
					<em class="tab-text">我的消息</em>
					<span class="tab-sub j-message-count hide"></span> 
				  </a>
				</div>
				<div class=" toolbar-tab tbar-tab-feedback"> <a href="<?php echo url('home/feedbacks/index'); ?>" target="_blank"> <i class="tab-ico"></i> <em class="footer-tab-text ">反馈</em> </a> </div>
			</div>
			
			<div class="toolbar-footer">
				<div class="toolbar-tab tbar-tab-top"> <a href="#"> <i class="tab-ico  "></i> <em class="footer-tab-text">顶部</em> </a> </div>
			</div>
			<div class="toolbar-mini"></div>
		</div>
		<div id="j-toolbar-load-hook"></div>		
	</div>
</div>
<script type='text/javascript' src='__STYLE__/js/right_cart.js?v=<?php echo $v; ?>'></script>


	<div class="footer-line"></div>
<ul class="wst-footer-info">
	<li><div class="wst-footer-info-img wst-fimg1"></div>
		<div class="wst-footer-info-text">
			<h1>支付宝支付</h1>
			<p>支付宝签约商家</p>
		</div>
	</li>
	<li><div class="wst-footer-info-img wst-fimg2"></div>
		<div class="wst-footer-info-text">
			<h1>正品保证</h1>
			<p>100%原产地</p>
		</div>
	</li>
	<li><div class="wst-footer-info-img wst-fimg3"></div>
		<div class="wst-footer-info-text">
			<h1>退货无忧</h1>
			<p>七天退货保障</p>
		</div>
	</li>
	<li><div class="wst-footer-info-img wst-fimg4"></div>
		<div class="wst-footer-info-text">
			<h1>免费配送</h1>
			<p>满98元包邮</p>
		</div>
	</li>
	<li><div class="wst-footer-info-img wst-fimg5"></div>
		<div class="wst-footer-info-text">
			<h1>货到付款</h1>
			<p>400城市送货上门</p>
		</div>
	</li>
</ul>
<div class="wst-footer-help">
	<div class="wst-footer">
		<div class="wst-footer-hp-ck1">
			<?php $_result=WSTHelps(5,6);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
			<div class="wst-footer-wz-ca">
				<div class="wst-footer-wz-pt">
					<span class="wst-footer-wz-pn"><?php echo $vo1["catName"]; ?></span>
					<ul style='margin-left:25px;'>
						<?php if(is_array($vo1['articlecats']) || $vo1['articlecats'] instanceof \think\Collection || $vo1['articlecats'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo1['articlecats'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
						<li style='list-style:disc;color:#999;font-size:13px;'>
						<a href="<?php echo Url('Home/Helpcenter/view',array('id'=>$vo2['articleId'])); ?>"><?php echo WSTMSubstr($vo2['articleTitle'],0,8); ?></a>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>

			<div class="wst-contact">
				<ul>
					<?php if((WSTConf('CONF.serviceTel')!='')): ?>
					<li style="height:30px;">
						<div class="icon-phone"></div><p class="call-wst">服务热线：</p>
					</li>
					<li style="height:38px;">
						<p class="email-wst"><?php echo WSTConf('CONF.serviceTel'); ?></p>
					</li>
					<?php endif; ?>
					<li style="height:85px;">
						<div class="qr-code" style="position:relative;">
						    <?php if((WSTConf('CONF.wxenabled')==1) && WSTConf('CONF.wxAppLogo')): ?>
							<img src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.wxAppLogo'); ?>" style="height:110px;">
							<?php endif; ?>
							<div class="focus-wst">
							    <?php if((WSTConf('CONF.serviceQQ')!='')): ?>
								<p class="focus-wst-qr">在线客服：</p>
								<p class="focus-wst-qra">
						          <a href="tencent://message/?uin=<?php echo WSTConf('CONF.serviceQQ'); ?>&Site=QQ交谈&Menu=yes">
									  <img border="0" src="<?php echo WSTProtocol(); ?>wpa.qq.com/pa?p=1:<?php echo WSTConf('CONF.serviceQQ'); ?>:7" alt="QQ交谈" width="71" height="24" />
								  </a>
								</p>
          						<?php endif; if((WSTConf('CONF.serviceEmail')!='')): ?>
								<p class="focus-wst-qr">商城邮箱：</p>
								<p class="focus-wst-qre"><?php echo WSTConf('CONF.serviceEmail'); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</li>
				</ul>
			</div>


			<div class="wst-clear"></div>
		</div>
		<?php 
			$links = model('common/Tags')->listFriendlink(99,86400);
		 if(count($links)>0): ?>
		<div class="wst-footer-flink">
			<div class="wst-footer" >
		
				<div class="wst-footer-cld-box">
					<div style="text-align:center;">
						<span class="wst-footer-fl" style="margin-right: 30px;">友情链接</span>
						<?php if(is_array($links) || $links instanceof \think\Collection || $links instanceof \think\Paginator): $i = 0; $__LIST__ = $links;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<a class="flink-hover" href="<?php echo $vo['friendlinkUrl']; ?>"  target="_blank"><?php echo $vo["friendlinkName"]; ?></a>
						<?php endforeach; endif; else: echo "" ;endif; ?>
						<div class="wst-clear"></div>
					</div>
				</div>
		
			</div>
		</div>
		<?php endif; ?>
	    <div class="wst-footer-hp-ck3">
	        <div class="links">
	           <?php $navs = WSTNavigations(1); if(is_array($navs) || $navs instanceof \think\Collection || $navs instanceof \think\Paginator): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
               <a href="<?php echo $vo['navUrl']; ?>" <?php if($vo['isOpen']==1): ?>target="_blank"<?php endif; ?>><?php echo $vo['navTitle']; ?></a>
               <?php if($i< count($navs)): ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php endif; ?>
               <?php endforeach; endif; else: echo "" ;endif; ?>
	        </div>
	        <div class="copyright">
	        <?php 
	        	if(WSTConf('CONF.mallFooter')!=''){
	         		echo htmlspecialchars_decode(WSTConf('CONF.mallFooter'));
	        	}
	         
				if(WSTConf('CONF.visitStatistics')!=''){
					echo htmlspecialchars_decode(WSTConf('CONF.visitStatistics'))."<br/>";
			    }
			 if(WSTConf('CONF.mallLicense') == ''): ?>
	        <div>
				Copyright©2016 Powered By <a target="_blank" href="https://hk-city.com">hk-city.com</a>
			</div>
			<?php else: ?>
				<div id="wst-mallLicense" data='1' style="display:none;">Copyright©2025 Powered By <a target="_blank" href="https://hk-city.com">hk-city.com</a></div>
	        <?php endif; ?>
	        </div>
	    </div>
	</div>
</div>
<?php echo hook('homeDocumentListener'); ?>
<?php echo hook('initCronHook'); ?>



<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/slide/js/slide.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='__STYLE__/js/shophome.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='__STYLE__/js/qrcode.js?v=<?php echo $v; ?>'></script>
<script type="text/javascript" src="<?php echo WSTProtocol(); ?>map.qq.com/api/js?v=2.exp&key=<?php echo WSTConf('CONF.mapKey'); ?>"></script>
<script>
$(function(){
	$(document).keypress(function(e) {
          if(e.which == 13) {
            searchShopsGoods();
          }
    });
	if(<?php echo $data['list']['last_page']; ?>>1){
	layui.laypage.render({
		elem: 'shopPage',
		count:<?php echo $data['list']['total']; ?>,
		limit:<?php echo $data['list']['per_page']; ?>,
		curr: <?php echo $data['list']['current_page']; ?>,
		layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
	    skip: true, //是否开启跳页
	    skin: '#fd6148',
	    groups: 3, //连续显示分页数
	    jump: function(e, first){ //触发分页后的回调
	        if(!first){ //一定要加此判断，否则初始时会无限刷新
	        	var nuewurl = WST.splitURL("page");
	        	var ulist = nuewurl.split("?");
	        	if(ulist.length>1){
	        		location.href = nuewurl+'&page='+e.curr;
	        	}else{
	        		location.href = '?page='+e.curr;
	        	}

	        }
	    }
	});
	}
	var qr = qrcode(10, 'H');
	var url = '<?php echo url("mobile/shops/index",array("shopId"=>$data["shop"]["shopId"]),true,true); ?>';
	qr.addData(url);
	qr.make();
	$('#qrcode').html(qr.createImgTag());
	var width = $(window).width();
	$('.wst-shop-tu').css('width',width);
});
</script>

</body>
</html>