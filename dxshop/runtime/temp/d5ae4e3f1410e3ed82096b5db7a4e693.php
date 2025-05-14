<?php /*a:6:{s:76:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\goods_detail.html";i:1738761715;s:68:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\base.html";i:1738761714;s:67:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\top.html";i:1738761716;s:70:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\header.html";i:1738761715;s:74:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\right_cart.html";i:1738761715;s:70:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\footer.html";i:1738761714;}*/ ?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $goods['goodsName']; ?> - <?php echo WSTConf('CONF.mallName'); ?></title>

<meta name="description" content="<?php echo $goods['goodsSeoDesc']; ?>">
<meta name="keywords" content="<?php echo $goods['goodsSeoKeywords']; ?>">
<?php 
$shareParams = [];
$shareParams['goodsId'] = $goods['goodsId'];
if(session('WST_USER.userId')>0){
$shareParams['shareUserId'] = base64_encode((int)session('WST_USER.userId'));
}
 ?>
<meta property="og:url"           content="<?php echo url('home/goods/detail',$shareParams,true,true); ?>" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="<?php echo $goods['goodsName']; ?>" />
<meta property="og:description"   content="<?php echo $goods['goodsTips']; ?>" />
<meta property="og:image"         content='<?php echo WSTConf("CONF.resourceDomain"); ?>/<?php echo WSTImg($goods["goodsImg"],3); ?>' />
<meta property="og:site_name" content="<?php echo WSTConf('CONF.mallName'); ?>">

<meta name="twitter:url" content="<?php echo url('home/goods/detail',$shareParams,true,true); ?>" />
<meta name="twitter:title" content="<?php echo $goods['goodsName']; ?>" />
<meta name="twitter:description" content="<?php echo $goods['goodsTips']; ?>" />
<meta name="twitter:image" content='<?php echo WSTConf("CONF.resourceDomain"); ?>/<?php echo WSTImg($goods["goodsImg"],3); ?>' />
<?php if(WSTConf("CONF.shareThisPropertyId")!=''): ?>
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=<?php echo WSTConf("CONF.shareThisPropertyId"); ?>&product=undefined' async='async'></script>
<?php endif; ?>

<link rel="stylesheet" href="/hkshop/qmdd/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/hkshop/qmdd/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__STYLE__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet">

<link href="__STYLE__/css/goods.css?v=<?php echo $v; ?>" rel="stylesheet">


<script type="text/javascript" src="/hkshop/qmdd/dxshop/static/js/jquery.min.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshop/qmdd/dxshop/static/plugins/layui/layui.js?v=<?php echo $v; ?>"></script>	
<script type='text/javascript' src='/hkshop/qmdd/dxshop/static/js/common.js?v=<?php echo $v; ?>'></script>

<script type='text/javascript' src='__STYLE__/js/common.js?v=<?php echo $v; ?>'></script>


<?php if(((int)session('WST_USER.userId')<=0)): ?>
<link href="/hkshop/qmdd/dxshop/static/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/login.css?v=<?php echo $v; ?>" rel="stylesheet">
<script type="text/javascript" src="/hkshop/qmdd/dxshop/static/plugins/validator/jquery.validator.min.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshop/qmdd/dxshop/static/js/rsa.js"></script>
<script type='text/javascript' src='__STYLE__/js/login.js?v=<?php echo $v; ?>'></script>
<?php endif; ?>
<script>
window.conf = {"ROOT":"/hkshop/qmdd/dxshop","APP":"/hkshop/qmdd/dxshop/index.php","STATIC":"/hkshop/qmdd/dxshop/static","SUFFIX":"<?php echo config('url_html_suffix'); ?>","SMS_VERFY":"<?php echo WSTConf('CONF.smsVerfy'); ?>","SMS_OPEN":"<?php echo WSTConf('CONF.smsOpen'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>","IS_LOGIN":"<?php if((int)session('WST_USER.userId')>0): ?>1<?php else: ?>0<?php endif; ?>","TIME_TASK":"1","ROUTES":'<?php echo WSTRoute(); ?>',"IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>","HTTP":"<?php echo WSTProtocol(); ?>","MAP_KEY":"<?php echo WSTConf('CONF.mapKey'); ?>",'RESOURCE_DOMAIN':'<?php echo WSTConf('CONF.resourceDomain'); ?>','RESOURCE_PATH':'<?php echo WSTConf('CONF.resourcePath'); ?>'}
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
<script type='text/javascript' src='/hkshop/qmdd/dxshop/static/js/qrcode.js'></script>


	<div class='wst-search-container'>
   <div class='wst-logo'>
    <?php $mallName = WSTConf('CONF.mallName'); ?>
   <a href='<?php echo app('request')->root(true); ?>' title="<?php echo WSTStripTags($mallName); ?>" >
      <img src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.mallLogo'); ?>" height="120" width='240' title="<?php echo WSTStripTags($mallName); ?>" alt="<?php echo WSTStripTags($mallName); ?>">
   </a>
   </div>
   <div class="wst-search-box">
      <div class='wst-search'>
          <input type="hidden" id="search-type" value="<?php echo isset($keytype)?1:0; ?>"/>
          <ul class="j-search-box">
            <li class="j-search-type">
              搜<span><?php if(isset($keytype)): ?>店铺<?php else: ?>商品<?php endif; ?></span>&nbsp;<i class="arrow"> </i>
            </li>
            <li class="j-type-list">
            <?php if(isset($keytype)): ?>
              <div data="0">商品</div>
              <?php else: ?>
            <div data="1">店铺</div>
              <?php endif; ?>
            </li>
          </ul>
        <input type="text" id='search-ipt' class='search-ipt' placeholder='<?php echo WSTConf("CONF.adsGoodsWordsSearch"); ?>' value='<?php echo isset($keyword)?$keyword:""; ?>'/>
        <input type='hidden' id='adsGoodsWordsSearch' value='<?php echo WSTConf("CONF.adsGoodsWordsSearch"); ?>'>
        <input type='hidden' id='adsShopWordsSearch' value='<?php echo WSTConf("CONF.adsShopWordsSearch"); ?>'>
        <div id='search-btn' class="search-btn" onclick='javascript:WST.search(this.value)'>搜索</div>
      </div>
      <div class="wst-search-keys">
      <?php $searchKeys = WSTSearchKeys(); if(is_array($searchKeys) || $searchKeys instanceof \think\Collection || $searchKeys instanceof \think\Paginator): $i = 0; $__LIST__ = $searchKeys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
       <a href='<?php echo Url("home/goods/search","keyword=".$vo); ?>'><?php echo $vo; ?></a>
       <?php if($i< count($searchKeys)): ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php endif; ?>
      <?php endforeach; endif; else: echo "" ;endif; ?>
      </div>
   </div>
   <div class="wst-cart-box">
   <a href="<?php echo url('home/carts/index'); ?>" target="_blank" onclick="WST.currentUrl('<?php echo url("home/carts/index"); ?>');"><span class="word j-word">我的购物车<span class="num" id="goodsTotalNum" style='display:none'>0</span></span></a>
    <div class="wst-cart-boxs hide">
      <div id="list-carts"></div>
      <div id="list-carts2"></div>
      <div id="list-carts3"></div>
      <div class="wst-clear"></div>
    </div>
   </div>

<script id="list-cart" type="text/html">
{{# for(var i = 0; i < d.list.length; i++){ }}
  <div class="goods" id="j-goods{{ d.list[i].cartId }}">
      <div class="imgs"><a href="{{ WST.U('home/goods/detail','goodsId='+d.list[i].goodsId) }}"><img class="goodsImgc" data-original="__RESOURCE_PATH__/{{ d.list[i].goodsImg }}" title="{{ d.list[i].goodsName }}"></a></div>
      <div class="number"><p><a  href="{{ WST.U('home/goods/detail','goodsId='+d.list[i].goodsId) }}">{{WST.cutStr(d.list[i].goodsName,26)}}</a></p><p>数量：{{ d.list[i].cartNum }}</p></div>
      <div class="price"><p>￥{{ d.list[i].shopPrice }}</p><span><a href="javascript:WST.delCheckCart({{ d.list[i].cartId }})">删除</a></span></div>
  </div>
{{# } }}
</script>
</div>
<div class="wst-clear"></div>

<div class="wst-nav-menus">
   <div class="nav-w" style="position: relative;">
      <div class="w-spacer"></div>
      <div class="dorpdown <?php if(isset($hideCategory)): ?>j-index<?php endif; ?>" id="wst-categorys">

      
      <div id="wst-nav-items">
           <ul>
               <?php $_result=WSTNavigations(0);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
               <li class="fore1">
                    <a href="<?php echo $vo['navUrl']; ?>" <?php if($vo['isOpen']==1): ?>target="_blank"<?php endif; ?>><?php echo $vo['navTitle']; ?></a>
               </li>
               <?php endforeach; endif; else: echo "" ;endif; ?>
           </ul>
      </div>
      <script>
          $(document).keypress(function(e) { 
          if(layerMapIndex == 0 && e.which == 13) {  
            $('#search-btn').click();  
          }
        }); 
      </script>
</div>
<div class="wst-clear"></div>
</div>



<style type="text/css">
    #preview ul li:nth-child(n+2) {display: none;}
</style>

<div class='wst-w' style='margin-bottom:0px'>
<div class='wst-filters'>
   <div class='item' style="border:1px solid transparent;border-left:2px solid #df2003;padding-left: 8px">
      <a class='link' href="<?php echo url('home/index/index'); ?>">首页</a>
      <i class="arrow"></i>
   </div>
   <?php $_result=WSTPathGoodsCat($goods['goodsCatId']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
   <div class='wst-lfloat'>
    <div class='item dorpdown'>
     <div class='drop-down'>
        <a class='link' href='<?php echo Url("home/goods/lists",["cat"=>$vo["catId"]]); ?>'><?php echo $vo['catName']; ?></a>
     </div>
     <div class="dorp-down-layer">
         <?php $_result=WSTGoodsCats($vo['parentId']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
         <div class="<?php echo $vo['parentId']>0 ? 'cat2' : 'cat1'; ?>"><a href='<?php echo Url("home/goods/lists","cat=".$vo2["catId"]); ?>'><?php echo $vo2['catName']; ?></a></div>
         <?php endforeach; endif; else: echo "" ;endif; ?>
     </div>
  </div>
  <i class="arrow"></i>
   </div>
   <?php endforeach; endif; else: echo "" ;endif; ?>
   <div class='wst-lfloat'><div class='gitem'><?php echo $goods['goodsName']; ?></div></div>
   <div class='wst-clear'></div>
</div>
</div>
<div class='wst-w'>
   <div class='wst-container' style='width: 1198px;border:1px solid #e6e6e6;'>
      <div class='goods-img-box'>
          <?php if($goods['goodsVideo']!=""): ?>
            <div class="wst-video-box">
              <video muted src="__RESOURCE_PATH__/<?php echo $goods["goodsVideo"]; ?>" id='previewVideo' controls="controls" autoplay="autoplay" width='350' height='350'></video>
            </div>
          <?php endif; ?>
          <div class="goods-img spec-preview" id="preview">
            <!--<img title="<?php echo WSTStripTags($goods['goodsName']); ?>" alt="<?php echo WSTStripTags($goods['goodsName']); ?>" src="__RESOURCE_PATH__/<?php echo WSTImg($goods['goodsImg']); ?>"  class="cloudzoom" data-cloudzoom="zoomImage:'__RESOURCE_PATH__/<?php echo $goods['goodsImg']; ?>'" height="350" width="350">-->
              <ul >
              <?php if(is_array($goods['gallery']) || $goods['gallery'] instanceof \think\Collection || $goods['gallery'] instanceof \think\Paginator): $gi = 0; $__LIST__ = $goods['gallery'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($gi % 2 );++$gi;?>
              <li>
                  <img title="<?php echo WSTStripTags($goods['goodsName']); ?>"
                       alt="<?php echo WSTStripTags($goods['goodsName']); ?>"
                       class='cloudzoom'
                       src="__RESOURCE_PATH__/<?php echo WSTImg($vo); ?>"
                       layer-src="__RESOURCE_PATH__/<?php echo WSTImg($vo, 0); ?>"
                       width="350" height="350">
              </li>
              <?php endforeach; endif; else: echo "" ;endif; ?>
              </ul>
          </div>
          <div class="goods-pics">
            <a class="prev">&lt;</a>
            <a class="next">&gt;</a>
            <div class="items">
               <ul>
                <?php if($goods['goodsVideo']!=""): ?>
                 <li class="gallery-li hover">
                  <div class="wst-video-btn"><i class="fa fa-play-circle"></i></div>
                   <img class="gvideo gallery-img" src="__RESOURCE_PATH__/<?php echo $goods['goodsImg']; ?>"  width="60" height="60">
                 </li>
                <?php endif; ?>
                <div id="gallery-img-0">
                  <?php if(is_array($goods['gallery']) || $goods['gallery'] instanceof \think\Collection || $goods['gallery'] instanceof \think\Paginator): $gi = 0; $__LIST__ = $goods['gallery'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($gi % 2 );++$gi;?>
                      <li class="gallery-li <?php echo $goods['goodsVideo']=='' && $key==1 ? 'hover' :  ''; ?>">
                        <img title="<?php echo WSTStripTags($goods['goodsName']); ?>"
                              alt="<?php echo WSTStripTags($goods['goodsName']); ?>"
                              class='cloudzoom-gallery gallery-img'
                              src="__RESOURCE_PATH__/<?php echo WSTImg($vo); ?>"
                              layer-src="__RESOURCE_PATH__/<?php echo WSTImg($vo, 0); ?>"
                              data-cloudzoom="useZoom: '.cloudzoom', image:'__RESOURCE_PATH__/<?php echo WSTImg($vo); ?>', zoomImage:'__RESOURCE_PATH__/<?php echo $vo; ?>' " width="60" height="60">
                      </li>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>

         </ul>
      </div>
      <div class="wst-clear"></div>
         </div>
         <div class="goods-term-box">
            <div class="wst-favorite">
               <?php if(($goods['favGood']>0)): ?>
                 <a href='javascript:void(0);' onclick='WST.cancelFavorite(this,0,<?php echo $goods["goodsId"]; ?>,<?php echo $goods['favGood']; ?>)' class='favorite j-fav'><i class='fa fa-heart'></i> 已关注</a>
               <?php else: ?>
                 <a href='javascript:void(0);' onclick='WST.addFavorite(this,0,<?php echo $goods["goodsId"]; ?>,<?php echo $goods["goodsId"]; ?>)' class='favorite j-fav2 j-fav3'><i class='fa fa-heart'></i> 关注商品</a>
               <?php endif; ?>
               </div>
           <div class="wst-contrast" onclick="javascript:contrastGoods(1,<?php echo $goods['goodsId']; ?>,1)"><i></i>对比</div>
           <a  href='javascript:informs(<?php echo $goods["goodsId"]; ?>)' class="j-inform">举报</a>
           <div class="wst-clear"></div>
         </div>
      </div>
      <div class='intro'>
          <div class='intro-name'>
          <h2><?php echo $goods['goodsName']; ?></h2>
          <span class='tips'><?php echo $goods['goodsTips']; ?></span>
          </div>
          <div class='summary'>
            <div class="infol">
             <div class='item'>
               <div class='dt'>市 场 价&nbsp;</div>
               <div class='dd market-price' id='j-market-price'>￥<?php echo $goods['marketPrice']; ?></div>
             </div>
             <div class='item'>
               <div class='dt'>价&nbsp;&nbsp;格&nbsp;</div>
               <div class='dd price'>￥<span id='j-shop-price'><?php echo $goods['shopPrice']; ?></span></div>
             </div>
             <?php if((int)session('WST_USER.userId')==0 && $goods['shopMemberGroups']): ?>
                <div class='item'>
                    <div class='dt'>店铺会员价&nbsp;</div>
                    <div class='dd wst-flex-row wst-ac'><div><a class='login' href="<?php echo url('home/users/login'); ?>">登录</a> 后确认是否享受优惠 </div><div class="shop-member" title='关注店铺成为店铺会员，消费越高优惠越大'>店铺会员</div></div>
                </div>
             <?php endif; ?>
             <?php echo hook('homeDocumentGoodsPriceDetail',['goods'=>$goods,'getParams'=>input()]); ?>
             <div class='goods-intro-bg'>
               <div class='item'>
                 <ul class="ginfo_b">
                   <li>
                     <div class='dt'>销&nbsp;&nbsp;量&nbsp;</div>
                     <span class='appraise-num'><?php echo $goods['saleNum']; ?></span>
                   </li>
                   <li>
                     <div class='dt'>累计评价&nbsp;</div>
                     <span class='appraise-num'><?php echo $goods['appraiseNum']; ?></span>
                   </li>
                   <li>
                     <div class='dt'>商品评分&nbsp;</div>
                     <div class='dd'>
                        <?php $__FOR_START_16679__=0;$__FOR_END_16679__=$goods['scores']['totalScores'];for($i=$__FOR_START_16679__;$i < $__FOR_END_16679__;$i+=1){ ?>
                          <img src="/hkshop/qmdd/dxshop/static/plugins/raty/img/star-on.png">
                        <?php } $__FOR_START_10214__=1;$__FOR_END_10214__=6-$goods['scores']['totalScores'];for($i=$__FOR_START_10214__;$i < $__FOR_END_10214__;$i+=1){ ?>
                          <img src="/hkshop/qmdd/dxshop/static/plugins/raty/img/star-off.png">
                        <?php } ?>
                     </div>
                   </li>
                   <div class="wst-clear"></div>
                 </ul>
               </div>
             </div>
             </div>
             <div class='wst-clear'></div>
          </div>

          <div class="sale_box">
            
             <div class='item' id='j-promotion' style='display:none'>
               <div class='dt'>促&nbsp;&nbsp;销&nbsp;</div>
               <div class='dd'>
                 <?php echo hook('homeDocumentGoodsPromotionDetail',['goods'=>$goods]); ?>
               </div>
             </div>
             <?php echo hook('homeDocumentGoodsPropDetail',['goods'=>$goods,'getParams'=>input()]); ?>
          </div>

          <div class='spec'>
             <?php if(!empty($goods['spec'])): if(is_array($goods['spec']) || $goods['spec'] instanceof \think\Collection || $goods['spec'] instanceof \think\Paginator): $i = 0; $__LIST__ = $goods['spec'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
             <div class='item'>
               <div class='dt'><?php echo $vo['name']; ?>&nbsp;</div>
               <div class='dd'>
               <?php if(is_array($vo['list']) || $vo['list'] instanceof \think\Collection || $vo['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;if($vo2['itemImg']!=''): ?>
                  <div class='j-option img' data-val="<?php echo $vo2['itemId']; ?>" style='min-width:80px;height:28px;padding:0px;position: relative;'><img class="cloudzoom-gallery" width="28" height="28" src="__RESOURCE_PATH__/<?php echo WSTImg($vo2['itemImg']); ?>" data-cloudzoom="useZoom: '.cloudzoom', image:'__RESOURCE_PATH__/<?php echo WSTImg($vo2['itemImg']); ?>', zoomImage:'__RESOURCE_PATH__/<?php echo $vo2['itemImg']; ?>' "  title="<?php echo WSTStripTags($vo2['itemName']); ?>" alt="<?php echo WSTStripTags($vo2['itemName']); ?>"/><span><?php echo $vo2['itemName']; ?></span><i></i></div>
                  <?php else: ?>
                  <div class='j-option' data-val="<?php echo $vo2['itemId']; ?>"><?php echo $vo2['itemName']; ?><i></i></div>
                  <?php endif; ?>
               <?php endforeach; endif; else: echo "" ;endif; ?>
               </div>
               <div class='wst-clear'></div>
             </div>
             <?php endforeach; endif; else: echo "" ;endif; ?>
             <?php endif; ?>
          </div>
          <div class='buy'>
             <div class='item'>
                <div class='dt'>数&nbsp;&nbsp;量&nbsp;</div>
                <div class='dd'>
                  <a href='#none' class='buy-btn' id='buy-reduce' style='color:#f1f1f1;' onclick='javascript:WST.changeIptNum(-1,"#buyNum","#buy-reduce,#buy-add")'>-</a>
                  <input type='text' id='buyNum' class='buy-num' value='1' data-min='1' autocomplete="off" onkeyup='WST.changeIptNum(0,"#buyNum","#buy-reduce,#buy-add")' onkeypress="return WST.isNumberKey(event);" maxlength="6"/>
                  <a href='#none' class='buy-btn' id='buy-add' onclick='javascript:WST.changeIptNum(1,"#buyNum","#buy-reduce,#buy-add")'>+</a>
                    &nbsp; &nbsp;（库存：<span id='goods-stock'>0</span>&nbsp;<?php echo $goods['goodsUnit']; ?>）
                </div>
                 <div class='wst-clear'></div>

             </div>
             <div class='item'>
                <div class='dt'>服&nbsp;&nbsp;务&nbsp;</div>
                <div class='dd'>服务由  <a class="c14_005" href='<?php echo Url("home/shops/index","shopId=".$shop["shopId"]); ?>' target='_blank'><?php echo $shop['shopName']; ?></a> 发货并提供 售后服务。</div>
             </div>
             <div class='item' style='padding-left:95px;margin-top:20px;'>
               <?php if($goods['read']): if($goods['goodsType']==0): ?>
                 <a id='addBtn' href='javascript:void(0);' class='addBtn un-buy' style='background:#eee'>加入购物车</a>
                 <?php endif; ?>
                 <a id='buyBtn' href='javascript:void(0);' class='buyBtn un-buy' style='background:#eee'>立即购买</a>
               <?php else: if($goods['goodsType']==0): ?>
                 <a id='addBtn' href='javascript:addCart(0,"#buyNum")' class='addBtn' >加入购物车</a>
                 <?php endif; ?>
                 <a id='buyBtn' href='javascript:addCart(1,"#buyNum")' class='buyBtn'>立即购买</a>
               <?php endif; ?>
              <div class='wst-clear'></div>
            </div>

            <div class="wst-relative" style="margin-top: 20px;margin-left: 10px;">
                <!-- ShareThis BEGIN -->
                <div style="padding: 20px 10px 20px 0;">
                    <div class="sharethis-inline-share-buttons"
                         data-url="<?php echo url('home/goods/detail',$shareParams,true,true); ?>"
                         data-title="<?php echo $goods['goodsName']; ?>"
                         data-description="<?php echo $goods['goodsTips']; ?>"
                         data-image="<?php echo WSTConf('CONF.resourceDomain'); ?>/<?php echo WSTImg($goods['goodsImg'],3); ?>"
                         style="float: left;"></div>
                    <div class='wst-clear'></div>
                </div>
                <!-- ShareThis END -->
              <?php echo hook('homeDocumentGoodsDetail',['goods'=>$goods,'getParams'=>input()]); ?>
              </div>
            </div>
      </div>

      <div class='seeing'>
         <div class='head'>看了又看</div>
         <div class='body'>
          <?php $wstTagGoods =  model("common/Tags")->listGoods("visit",$goods['goodsCatId'],6,0); foreach($wstTagGoods as $key=>$visit){?>
          <a href="<?php echo Url('home/goods/detail','goodsId='.$visit['goodsId']); ?>">
          <div class="see-item">
            <div class="see-img">
              <img title="<?php echo WSTStripTags($visit['goodsName']); ?>" class="goodsImg" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>" alt="<?php echo WSTStripTags($visit['goodsName']); ?>" data-original="__RESOURCE_PATH__/<?php echo $visit['goodsImg']; ?>">
              <span class="see-price">￥<?php echo $visit['shopPrice']; ?></span>
            </div>
          </div>
          </a>
          <?php } ?>
         </div>
      </div>
      <div class='wst-clear'></div>
   </div>
</div>
<div class='wst-w'>
   <div class='wst-container'>
       <?php echo hook('homeDocumentGoodsDetailSalePromotion',['goodsId'=>$goods['goodsId']]); ?>
       <div class='wst-side'>
           <div class='shop-intro'>
                <div class="shop_imgbox">
                  <img class="shopsImg" data-original="__RESOURCE_PATH__/<?php echo $shop['shopImg']; ?>" title="<?php echo WSTStripTags($shop['shopName']); ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>" style="vertical-align: middle;width:120px;height:120px;">
                </div>
                <div class='title shop-name'><?php echo $shop['shopName']; ?></div>
                <div class='title'>店主：<?php echo $shop['shopKeeper']; ?></div>
                <div class='title'>联系：
                  <?php echo hook('homeDocumentContact',['type'=>'goodsDetail','shopId'=>$shop['shopId'],'goodsId'=>$goods['goodsId']]); if(($shop['shopQQ']!='')): ?>
                  <a href="tencent://message/?uin=<?php echo $shop['shopQQ']; ?>&Site=QQ交谈&Menu=yes">
                    <img
                        style="vertical-align: bottom;"
                        border="0"
                        src="<?php echo WSTProtocol(); ?>wpa.qq.com/pa?p=1:<?php echo $shop['shopQQ']; ?>:7" alt="QQ交谈" width="60" height="20" />
                  </a>
                  <?php endif; ?>

                </div>
                <div class='title'>地址：<?php echo $shop['shopAddress']; ?></div>
                <div class='body'>
                    <div class='itemScore'>
                    描述
                    <br />
                    <span class="c12_e40">
                    <?php if(($shop['scores']['goodsScore']!=0)): ?><?php echo $shop['scores']['goodsScore']; else: ?>5<?php endif; ?></span></div>
                    <div class='itemScore'>
                    服务
                    <br />
                    <span class="c12_e40">
                    <?php if(($shop['scores']['serviceScore']!=0)): ?><?php echo $shop['scores']['goodsScore']; else: ?>5<?php endif; ?></span></div>
                    <div class='itemScore'>
                    物流
                    <br />
                    <span class="c12_e40">
                    <?php if(($shop['scores']['timeScore']!=0)): ?><?php echo $shop['scores']['goodsScore']; else: ?>5<?php endif; ?></span></div>
                    <div class="wst-clear"></div>
                </div>
                <div class='footer'>
                   <a class="home" href='<?php echo Url("home/shops/index","shopId=".$shop["shopId"]); ?>' target='_blank'><i class='fa fa-home'></i> 进店逛逛</a>
                   <?php if(($goods['favShop']>0)): ?>
                   <a class="j-fav" href='javascript:void(0);' onclick='WST.cancelFavorite(this,1,<?php echo $shop["shopId"]; ?>,<?php echo $goods['favShop']; ?>)'><i class='fa fa-heart'></i> 已关注</a>
                   <?php else: ?>
                   <a class="j-fav2" href='javascript:void(0);' onclick='WST.addFavorite(this,1,<?php echo $shop["shopId"]; ?>,<?php echo $goods['favShop']; ?>)'><i class='fa fa-heart'></i> 关注店铺</a>
                   <?php endif; ?>
                   <div class='wst-clear'></div>
                </div>
           </div>
       <div class="goods-side">
        <div class="guess-like">
          <div class="title">猜你喜欢</div>
          <?php $wstTagGoods =  model("common/Tags")->listGoods("guess",$goods['goodsCatId'],3,0); foreach($wstTagGoods as $key=>$vo){?>
          <div class="item">
            <div class="img"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$vo['goodsId']); ?>"><img title="<?php echo WSTStripTags($vo['goodsName']); ?>" alt="<?php echo WSTStripTags($vo['goodsName']); ?>" data-original="__RESOURCE_PATH__/<?php echo WSTImg($vo['goodsImg']); ?>" class="goodsImg" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/></a></div>
            <div class="p-name"><a class="wst-hide wst-redlink"><?php echo $vo['goodsName']; ?></a></div>
            <div class="p-price">￥<?php echo $vo['shopPrice']; ?><span class="v-price">￥<?php echo $vo['marketPrice']; ?></span></div>
          </div>
          <?php } ?>
        </div>
        <div class="hot-goods">
          <div class="title">热销商品</div>
          <?php $wstTagGoods =  model("common/Tags")->listGoods("hot",0,3,0); foreach($wstTagGoods as $key=>$vo){?>
          <div class="item">
            <div class="img"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$vo['goodsId']); ?>"><img title="<?php echo WSTStripTags($vo['goodsName']); ?>" alt="<?php echo WSTStripTags($vo['goodsName']); ?>" data-original="__RESOURCE_PATH__/<?php echo WSTImg($vo['goodsImg']); ?>" class="goodsImg" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/></a></div>
            <div class="p-name"><a class="wst-hide wst-redlink"><?php echo $vo['goodsName']; ?></a></div>
            <div class="p-price">￥<?php echo $vo['shopPrice']; ?><span class="v-price">￥<?php echo $vo['marketPrice']; ?></span></div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class='goods-desc'>
        <div id='tab' class="wst-tab-box">
        <ul id='goodsTabs' class="wst-tab-nav">
           <li>商品介绍</li>
           <li>商品评价<span class='appraise-num'>（<?php echo $goods['appraiseNum']; ?>）</span></li>
           <li>商品咨询</li>
           <li id="wx_qrcode">
             手机购买
            <i class='fa fa-qrcode' style='font-size: 15px;line-height: 16px;vertical-align: middle;'></i>
            <div class="wx_qrcode_box">
              <div class="qrcode"></div>
              <p style="margin-top:-5px;">扫码访问商品</p>
            </div>
           </li>
           <?php if(!$goods['read']): ?>
           <a id='addCart2' href='javascript:addCart(1,"#buyNum")'>立即购买</a>
           <?php endif; ?>
        </ul>
        <div class="wst-tab-content" style='width:99%;margin-bottom: 10px;min-height:1312px;'>
             <div class="wst-tab-item goods-desc-box" style="position: relative;">
               <?php if(($goods['attrs'])): ?>
               <ul class='wst-attrs-list'>
                  <?php if((isset($goods['brandName']) && $goods['brandName']!='')): ?>
                    <div class="brand_name">品牌：<span><?php echo $goods['brandName']; ?></span></div>
                  <?php endif; if(is_array($goods['attrs']) || $goods['attrs'] instanceof \think\Collection || $goods['attrs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $goods['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <li title='<?php echo WSTStripTags($vo['attrVal']); ?>'><?php echo $vo['attrName']; ?>：<?php echo $vo['attrVal']; ?></li>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                  <div class="wst-clear"></div>
               </ul>
               <?php endif; ?>
               <?php echo $goods['goodsDesc']; ?>
             </div>
             <input type="hidden" id="filtertype" value="all" />
             <script id="tblist" type="text/html">
              <div class="appr-filter">
                <ul class="appr-filterbox">
                  <li><a href="javascript:void(0)" onclick="apprfilter('all')" id='all'>全部评价(<span id="totalNum">0</span>)</a></li>
                  <li><a href="javascript:void(0)" onclick="apprfilter('pic')" id='pic'>晒图(<span id="picNum">0</span>)</a></li>
                  <li><a href="javascript:void(0)" onclick="apprfilter('best')" id='best'>好评(<span id="bestNum">0</span>)</a></li>
                  <li><a href="javascript:void(0)" onclick="apprfilter('good')" id='good'>中评(<span id="goodNum">0</span>)</a></li>
                  <li><a href="javascript:void(0)" onclick="apprfilter('bad')" id='bad'>差评(<span id="badNum">0</span>)</a></li>
                </ul>
              </div>
               {{# for(var i = 0; i < d.length; i++){ }}
               <div class="appraises-box">
               <div class="wst-appraises-right">
                  <div class="userinfo">
                    <img data-original="{{#  if(d[i]['userPhoto'] != null){  }}{{WST.userPhoto(d[i]['userPhoto'])}}{{# } }}" class="apprimg" />
                    <div class="appraiser">
                        {{d[i]['loginName']}}
                    </div>
                  </div>
                  <p>{{d[i].rankName}}</p>
               </div>
                <div class="wst-appraises-left">
                  <div class="appr-starbox">
                    {{#  for(var j=0;j<d[i].avgScore;++j){ }}
                      <div class="appr-star"></div>
                    {{# }  }}
                    {{#for(var g=0;g<5-d[i].avgScore;++g){ }}
                        <div class="appr-star-off"></div>
                    {{# }  }}
                  </div>
                  <div class='wst-clear'></div>
                  <p class="app-content">
                    {{d[i]['content']}}
                    <div class="goods-spec-box">
                        {{d[i]['goodsSpecNames']}}
                    </div>
                  </p>
                  {{#  if(WST.blank(d[i]['images'])!=''){ var img = d[i]['images'].split(','); var length = img.length;  }}
                  <div id="img-file-{{i}}">
                  {{#  for(var g=0;g<length;g++){  }}
                         <img src="__RESOURCE_PATH__/{{img[g].replace('.','_thumb.')}}" layer-src="__RESOURCE_PATH__/{{img[g]}}"  style="width:80px;height:80px;" />
                  {{#  } }}
                  </div>
                  {{# }  }}
                  <span class="apprtime">{{d[i]['createTime']}}</span>
                  {{# if(d[i]['shopReply']!='' && d[i]['shopReply']!=null){ }}
                  <div class="reply-box">
                     <p class="reply-content"><a href="javascript:void(0)" onclick="goShop({{d[i]['shopId']}})">{{d[i]['shopName']}}</a>：{{d[i]['shopReply']}}</p>
                     <p class="reply-time">{{d[i]['replyTime']}}</p>
                 </div>
                 {{# } }}

               </div>
             <div class="wst-clear"></div>
              </div>
               {{# } }}
               </script>
             <div class="wst-tab-item" style="position: relative;display:none;">
                <div class="appraise-head">
                  <div class="app-head-l">
                    <div class="app-head-lbox">
                      <strong class="text">好评度</strong>
                      <div class='percent'>
                        <i class="best_percent">0</i><span>%</span>
                      </div>
                    </div>

                  </div>
                  <div class="app-head-r">
                    <div class="app-head-rbox">
                      <div class="app-hr-item">
                        <div class="app-hr-text">好评(<i class="best_percent">0</i>%)</div>
                        <div class="percentbox">
                            <div class="percentbg" id="best_percentbg" style="width:0%"></div>
                        </div>
                      </div>
                      <div class="app-hr-item">
                        <div class="app-hr-text">中评(<i class="good_percent">0</i>%)</div>
                        <div class="percentbox">
                            <div class="percentbg" id="good_percentbg" style="width:0%"></div>
                        </div>
                      </div>
                      <div class="app-hr-item">
                        <div class="app-hr-text">差评(<i class="bad_percent">0</i>%)</div>
                        <div class="percentbox">
                            <div class="percentbg" id="bad_percentbg" style="width:0%"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div id='ga-box'>

                </div>
                <div id='pager' style='text-align:center;'></div>
             </div>
             
             <div class="wst-tab-item" style="position: relative;display:none;">
                <div class="appr-filter">
                  <input type='hidden' id="consultType" value="0" />
                  <ul class="appr-filterbox">
                    <li><a class="gc-filter curr" href="javascript:void(0)" onclick="filterConsult(this,'0')">全部</a></li>
                    <?php $_result=WSTDatas('COUSULT_TYPE');if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <li><a class="gc-filter" href="javascript:void(0)" onclick="filterConsult(this,'<?php echo $vo['dataVal']; ?>')"><?php echo $vo['dataName']; ?></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                  </ul>
                </div>
                <div class="consult-searchbox">
                    <p class="search-tips">温馨提示：因每位咨询者购买情况、咨询时间等不同，以下回复对咨询者3天内有效，其他网友仅供参考。</p>
                    <div class="searchout">
                      <input type="text" class="search-text" id="consultKey" placeholder="请输入关键词" />
                      <button class="csbtn" onClick="queryConsult(0)">搜索</button>
                    </div>
                </div>
                <div class="wst-clear"></div>
                <div class="consult-listbox" id="consultBox">

                </div>
                <script id="gclist" type="text/html">
                  <ul class='consult-list'>
                    {{# for(var i=0;i<d.length;++i){  }}
                      <li>
                          <ul class="consult-item">
                            
                            <li class='ask'>
                              <p class="wst-lfloat">咨询内容：</p>
                              <div class="wst-lfloat cs-content">{{d[i]['consultContent']}}&nbsp;<span class="c999">({{(WST.blank(d[i]['loginName'])=='')?'游客':d[i]['loginName']}})</span></div>
                              <div class="wst-rfloat">{{d[i]['createTime']}}</div>
                              <div class="wst-clear"></div>
                            </li>
                            
                            {{# if(d[i]['reply']!=''){  }}
                              <li class='answer'>
                                <p class="wst-lfloat">商家回复：</p>
                                <div class="wst-lfloat cs-content">
                                 {{d[i]['reply']}}
                                </div>
                                <div class="wst-rfloat">{{d[i]['replyTime']}}</div>
                                <div class="wst-clear"></div>
                              </li>
                            {{# }  }}

                          </ul>
                      </li>
                    {{# }  }}
                  </ul>
                </script>
                <div id="consult-pager" style="text-align:center;margin-top:10px;">
                    
                </div>
                
                <div class="consult-publish">
                  <h5>发表咨询</h5>
                  <div class="explain">
                    声明：您可在购买前对产品包装、颜色、运输、库存等方面进行咨询，我们有专人进行回复！因厂家随时会更改一些产品的包装、颜色、产地等参数，所以该回复仅在当时对提问者有效，其他网友仅供参考！咨询回复的工作时间为：周一至周五，9:00至18:00，请耐心等待工作人员回复。
                  </div>
                  <ul>
                    <li>
                      <span class='fbold'>咨询类型：</span>
                      <?php $_result=WSTDatas('COUSULT_TYPE');if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                      <label>
                      <input type="radio" name="pointType" value="<?php echo $vo['dataVal']; ?>" /><?php echo $vo['dataName']; ?>
                      </label>
                      <?php endforeach; endif; else: echo "" ;endif; ?>

                    </li>
                    <li>
                      <span class='fbold'>咨询内容：</span>
                      <textarea id="consultContent" placeholder='3~200个字符长度' maxlength='200'></textarea>
                    </li>
                    <li>
                      <button id="consultCommit" onclick="consultCommit()">提交</button>
                    </li>
                  </ul>
                </div>
              </div>
        </div>
    </div>
    <div class='wst-clear'></div>
  </div>
  <div class='wst-clear'></div>
</div>

<div class="wst-cont-frame" id="j-cont-frame">
  <div class="head"><span>对比栏</span><a href="javascript:void(0);" class="close" onclick="javascript:contrastGoods(0,0,0)">关闭</a></div>
  <div class="list">
    <div class="goods" id="contrastList"></div>
    <div class="term-contrast">
      <p><a class="contrast" href="<?php echo Url('home/goods/contrast'); ?>" target="_blank">对比</a></p>
      <p><a href="javascript:void(0);" onclick="javascript:contrastDel(0)" class="empty">清空</a></p>
    </div>
  </div>
  <script id="colist" type="text/html">
    {{# if(d.data && d.data.length>0){ }}
    {{# for(var i=0; i<d.data.length; i++){ }}
    <div class="term">
      <div class="img"><a href="{{WST.U('home/goods/detail','goodsId='+d.data[i].goodsId)}}" target="_blank"><img class="contImg" data-original="__RESOURCE_PATH__/{{ d.data[i].goodsImg }}" title="{{ d.data[i].goodsName }}" width="50" height="50"></a></div>
      <div class="info"><a href="{{WST.U('home/goods/detail','goodsId='+d.data[i].goodsId)}}" target="_blank"><p class="name">{{ d.data[i].goodsName }}</p></a><p class="price"><span>￥{{ d.data[i].shopPrice }}</span><a href="javascript:contrastDel({{ d.data[i].goodsId }});" >删除</a></p></div>
    </div>
    {{# } }}
    {{# } }}
    {{# var data = (d.data)?d.data.length:0 }}
    {{# for(var i=data+1; i<5; i++){ }}
    <div class="term-empty">
      <div class="img">{{ i }}</div>
      <div class="info"><p>您还可以继续添加</p></div>
    </div>
    {{# } }}
    </script>
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


<script>
var goodsInfo = {
  id:<?php echo $goods['goodsId']; ?>,
  isSpec:<?php echo $goods['isSpec']; ?>,
  goodsStock:<?php echo $goods['goodsStock']; ?>,
  marketPrice:"<?php echo $goods['marketPrice']; ?>",
  goodsPrice:"<?php echo $goods['shopPrice']; ?>"
  <?php if(isset($goods['saleSpec'])): ?>
  ,sku:<?php echo json_encode($goods['saleSpec']); ?>
  <?php endif; ?>
}



</script>
<script type='text/javascript' src='__STYLE__/js/cloudzoom.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='__STYLE__/js/goods.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='/hkshop/qmdd/dxshop/static/js/qrcode.js?v=<?php echo $v; ?>'></script>
<script>
$(function(){
  layer.photos({
        photos: '#gallery-img-0',
    });

  layer.photos({
        photos: '#preview',
    });

  var url = '<?php echo url("wechat/goods/detail","","html",true); ?>?goodsId=<?php echo $goods["goodsId"]; ?>';
  var qrcode = new QRCode($(".qrcode")[0], {
      width : 300,
      height : 300,
    });
    qrcode.makeCode(url);

});
function goShop(id){
  location.href=WST.U('home/shops/index','shopId='+id);
}
</script>

</body>
</html>