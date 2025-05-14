<?php /*a:6:{s:69:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\goods_list.html";i:1669823956;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\base.html";i:1669564406;s:62:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\top.html";i:1738420029;s:65:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\header.html";i:1737808836;s:69:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\right_cart.html";i:1650787502;s:65:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\footer.html";i:1738136898;}*/ ?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php if($catInfo['seoTitle']): ?><?php echo $catInfo['seoTitle']; ?> - <?php echo WSTConf('CONF.mallName'); else: ?><?php echo $catNamePath; ?> - 商品列表 - <?php echo WSTConf('CONF.mallName'); ?><?php endif; ?></title>

<meta name="description" content="<?php if($catInfo['seoDes']): ?><?php echo $catInfo['seoDes']; else: ?><?php echo WSTConf('CONF.seoMallDesc'); ?><?php endif; ?>">
<meta name="keywords" content="<?php if($catInfo['seoKeywords']): ?><?php echo $catInfo['seoKeywords']; else: ?><?php echo WSTConf('CONF.seoMallKeywords'); ?><?php endif; ?>">

<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__STYLE__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet">

<link href="__STYLE__/css/goodslist.css?v=<?php echo $v; ?>" rel="stylesheet">

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




<div class='wst-hot-sales'>
   <div class='wst-sales-logo'>
   		&nbsp;<span class="wst-hot-icon">热卖推荐</span>
   </div>
   <ul class='wst-sales-box'>
     <?php $wstTagGoods =  model("common/Tags")->listGoods("recom",$catId,4,0); foreach($wstTagGoods as $key=>$vo){?>
      <li class="item">
     	<div class="img"><a target='_blank' href='<?php echo Url("home/goods/detail","goodsId=".$vo["goodsId"]); ?>'><img class='goodsImg' data-original="__RESOURCE_PATH__/<?php echo WSTImg($vo['goodsImg']); ?>" title="<?php echo WSTStripTags($vo['goodsName']); ?>" alt="<?php echo $vo['goodsName']; ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/></a></div>
     	<div class="des">
     		<div class="p-sale">已售<?php echo $vo['saleNum']; ?>件</div>
     		<div class="p-name"><a target='_blank' href='<?php echo Url("home/goods/detail","goodsId=".$vo["goodsId"]); ?>'><?php echo $vo['goodsName']; ?></a></div>
     		<div class="p-price">￥<?php echo $vo['shopPrice']; ?></div>
     		<div class="p-buy"><a href="javascript:WST.addCart(<?php echo $vo['goodsId']; ?>)">加入购物车</a></div>
     	</div>
      </li>
     <?php } ?>
   </ul>
</div>


<input type="hidden" id="cat" class="sipt" value='<?php echo $catId; ?>'/>
<input type="hidden" id="brand" class="sipt" value='<?php echo $brandId; ?>'/>
<?php if(is_array($vs) || $vs instanceof \think\Collection || $vs instanceof \think\Paginator): $i = 0; $__LIST__ = $vs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
<input type="hidden" id="v_<?php echo $v; ?>" class="sipt" value='<?php echo $attrs["v_".$v]; ?>'/>
<?php endforeach; endif; else: echo "" ;endif; ?>
<input type="hidden" id="vs" class="sipt" value='<?php echo implode(",",$vs); ?>'/>
<input type="hidden" id="orderBy" class="sipt" value='<?php echo $orderBy; ?>'/>
<input type="hidden" id="order" class="sipt" value='<?php echo ($order=="0")?"1":"0"; ?>' autocomplete="off"/>
<input type="hidden" id="areaId" class="sipt" value='<?php echo $areaId; ?>' />
<div class='wst-filters'>
   <div class='item' style="border-left:2px solid #df2003;padding-left: 8px;">
      <a class='link' href='<?php echo url('home/index/index'); ?>'>首页</a>
      <i class="arrow">></i>
   </div>
   <?php if(($catId)): $_result=WSTPathGoodsCat($catId);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
   <div class='wst-lfloat'>
   	<div class='item dorpdown'>
     <div class='drop-down'>
        <a class='link' href='/hkshopNC/dxshop'><?php echo $vo['catName']; ?></a>
        <i class="drop-down-arrow"></i>
     </div>
     <div class="dorp-down-layer">
         <?php $_result=WSTGoodsCats($vo['parentId']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
         <div class="<?php echo $vo['parentId']>0 ? 'cat2' : 'cat1'; ?>"><a href='<?php echo Url("home/goods/lists","cat=".$vo2["catId"]); ?>'><?php echo $vo2['catName']; ?></a></div>
         <?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	</div>
	<i class="arrow">></i>
   </div>
  
   <?php endforeach; endif; else: echo "" ;endif; if(is_array($selector) || $selector instanceof \think\Collection || $selector instanceof \think\Paginator): $i = 0; $__LIST__ = $selector;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
   <div class='item dorpdown'>
   <a class='v-item' href='javascript:void(0);' onclick="javscript:removeFilter('<?php echo $vo['type']; ?>')">
     <span><?php echo $vo['label']; ?>：<?php echo $vo['val']; ?></span>
     <i>x</i>
   </a>
   <i class="arrow">></i>
   </div>
   <?php endforeach; endif; else: echo "" ;endif; else: ?>
   <div class='item'>
      <a class='link' href='javascript:void(0);'>全部商品分类</a>
   </div>
   <?php endif; ?>
   <div class='wst-clear'></div>
</div>

<div class="wst-selector">
    <div class='head'>商品筛选条件</div>
    <div class="main">
       <?php $selectorNum = 0; if(!empty($brandFilter)): $selectorNum++; ?>
       <div class='item'>
          <div class='label'>品牌：</div>
          <div class='label_item'>
          <ul class='content brand_itembox' >
          <?php if(is_array($brandFilter) || $brandFilter instanceof \think\Collection || $brandFilter instanceof \think\Paginator): $i = 0; $__LIST__ = $brandFilter;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bv): $mod = ($i % 2 );++$i;?>
          <li class='s-item brand_item' onclick='javascript:goodsFilter(this,1)' v="<?php echo $bv['brandId']; ?>">

          	<div class="g_bd_imgbox"><img src="__RESOURCE_PATH__/<?php echo $bv['brandImg']; ?>" class="g_bd_img" onerror="this.style.display='none'" /><?php echo $bv['brandName']; ?></div>

          	<a class="s_chk"><i></i></a>
          </li>
          <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
          <div class='extra'>
          	<a href="javascript:void(0)" class="extra_more" onClick="extra_brand_show(this)">更多<i></i></a>
          	<a href="javascript:void(0)" class="extra_multi" onClick="multibox_show(this,'brand')"><i></i>多选</a>
          	<div class="wst-clear"></div>
          </div>
        </div>
        <div class='wst-clear'></div>
       </div>
       <?php endif; if(is_array($goodsFilter) || $goodsFilter instanceof \think\Collection || $goodsFilter instanceof \think\Paginator): $i = 0; $__LIST__ = $goodsFilter;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gv): $mod = ($i % 2 );++$i;$selectorNum++; ?>
       <input type="hidden" id="v_<?php echo $gv['attrId']; ?>" class="sipt" value=''/>
       <div class='item <?=($selectorNum > 3)?"hideItem hide":"" ?>'>
          <div class='label'><?php echo $gv['attrName']; ?>：</div>
          <div class='label_item'>
	          <ul class='content' style='height: 30px;'>
	             <?php if(is_array($gv['attrVal']) || $gv['attrVal'] instanceof \think\Collection || $gv['attrVal'] instanceof \think\Paginator): $i = 0; $__LIST__ = $gv['attrVal'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gvi): $mod = ($i % 2 );++$i;?>
	             <li class='s-item' onclick='javascript:goodsFilter(this,3)' d="<?php echo $gv['attrId']; ?>" v="<?php echo $gvi; ?>">
	             	<a class="s_chk"><i></i><?php echo $gvi; ?></a>
	             </li>
	             <?php endforeach; endif; else: echo "" ;endif; ?>
	          </ul>
	          <div class='extra'>
	          	<a href="javascript:void(0)" class="extra_more" onClick="extra_show(this)">更多<i></i></a>
	          	<a href="javascript:void(0)" class="extra_multi" onClick="multibox_show(this,'attr')"><i></i>多选</a>
	          	<div class="wst-clear"></div>
	          </div>
	      </div>
	      <div class='wst-clear'></div>
       </div>
       <?php endforeach; endif; else: echo "" ;endif; $selectorNum++; if($minPrice=='' && $maxPrice=='' && isset($priceGrade)): ?>
       <div class='item <?=($selectorNum > 3)?"hideItem hide":"" ?>'>
          <div class='label'>价格：</div>
          <div class='label_item'>
	          <ul class='content'>
	          <?php if(is_array($priceGrade) || $priceGrade instanceof \think\Collection || $priceGrade instanceof \think\Paginator): $pKey = 0; $__LIST__ = $priceGrade;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($pKey % 2 );++$pKey;?>
	          <li class='s-item' onclick='javascript:goodsFilter(this,2)' v="<?php echo $key; ?>"><?php echo $vo; ?></li>
	          <?php endforeach; endif; else: echo "" ;endif; ?>
	          </ul>
	          <div class='extra'>&nbsp;</div>
	      </div>
          <div class='wst-clear'></div>
       </div>
       <?php endif; if($selectorNum > 3): ?>
       <div class="item-more-box">
          <div class='item-more' v="1"><span>更多选项</span><i class="drop-down"></i></div>
       </div>
       <?php endif; ?>
    </div>
    <div class='wst-clear'></div>
</div>


<div class="wst-container">
	<div class='goods-side'>
		<div class="guess-like">
			<div class="title">猜你喜欢</div>
			<?php $wstTagGoods =  model("common/Tags")->listGoods("guess",$catId,3,0); foreach($wstTagGoods as $key=>$vo){?>
			<div class="item">
				<div class="img"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$vo['goodsId']); ?>"><img  data-original="__RESOURCE_PATH__/<?php echo WSTImg($vo['goodsImg']); ?>" class='goodsImg' alt="<?php echo WSTStripTags($vo['goodsName']); ?>" title="<?php echo WSTStripTags($vo['goodsName']); ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/></a></div>
				<div class="p-name"><a class="wst-hide wst-redlink"><?php echo $vo['goodsName']; ?></a></div>
				<div class="p-price">￥<?php echo $vo['shopPrice']; ?><span class="v-price">￥<?php echo $vo['marketPrice']; ?></span></div>
			</div>
			<?php } ?>
		</div>
		<div class="hot-goods">
			<div class="title">热销商品</div>
			<?php $wstTagGoods =  model("common/Tags")->listGoods("hot",$catId,3,0); foreach($wstTagGoods as $key=>$vo){?>
			<div class="item">
				<div class="img"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$vo['goodsId']); ?>"><img class='goodsImg' data-original="__RESOURCE_PATH__/<?php echo WSTImg($vo['goodsImg']); ?>" alt="<?php echo WSTStripTags($vo['goodsName']); ?>" title="<?php echo WSTStripTags($vo['goodsName']); ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/></a></div>
				<div class="p-name"><a class="wst-hide wst-redlink"><?php echo $vo['goodsName']; ?></a></div>
				<div class="p-price">￥<?php echo $vo['shopPrice']; ?><span class="v-price">￥<?php echo $vo['marketPrice']; ?></span></div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class='goods-main'>
	   <div class='goods-filters'>
	      <div class='line line2'>
			<a class="<?php if($orderBy == 5): ?>curr <?php endif; ?>" href='javascript:void(0)' onclick='javascript:goodsOrder(5)'>综合排序</a>
	        <a class="<?php if($orderBy == 0): ?>curr <?php endif; ?>" href='javascript:void(0)' onclick='javascript:goodsOrder(0)'>销量 <i class="fa fa-<?php if($orderBy != 0): ?>arrow-down<?php endif; if($orderBy == 0 and $order == 1): ?>arrow-down<?php endif; if($orderBy == 0 and $order == 0): ?>arrow-up<?php endif; ?>"></i></a>
	        <a class="<?php echo $orderBy==1 ? 'curr' : ''; ?>" href='javascript:void(0)' onclick='javascript:goodsOrder(1)'>价格 <i class="fa fa-<?php if($orderBy != 1): ?>arrow-down<?php endif; if($orderBy == 1 and $order == 1): ?>arrow-down<?php endif; if($orderBy == 1 and $order == 0): ?>arrow-up<?php endif; ?>"></i></a>
	        <a class="<?php echo $orderBy==2 ? 'curr' : ''; ?>" href='javascript:void(0)' onclick='javascript:goodsOrder(2)'>评论数 <i class="fa fa-<?php if($orderBy != 2): ?>arrow-down<?php endif; if($orderBy == 2 and $order == 1): ?>arrow-down<?php endif; if($orderBy == 2 and $order == 0): ?>arrow-up<?php endif; ?>"></i></a>
	        <a class="<?php echo $orderBy==3 ? 'curr' : ''; ?>" href='javascript:void(0)' onclick='javascript:goodsOrder(3)'>人气 <i class="fa fa-<?php if($orderBy != 3): ?>arrow-down<?php endif; if($orderBy == 3 and $order == 1): ?>arrow-down<?php endif; if($orderBy == 3 and $order == 0): ?>arrow-up<?php endif; ?>"></i></a>
	        <a class="<?php echo $orderBy==4 ? 'curr' : ''; ?>" href='javascript:void(0)' onclick='javascript:goodsOrder(4)'>上架时间 <i class="fa fa-<?php if($orderBy != 4): ?>arrow-down<?php endif; if($orderBy == 4 and $order == 1): ?>arrow-down<?php endif; if($orderBy == 4 and $order == 0): ?>arrow-up<?php endif; ?>"></i></a>
        	<div class="wst-price-ipts">
			<span class="wst-price-ipt1">￥</span><span class="wst-price-ipt2">￥</span>
			<input type="text" class="sipt wst-price-ipt" id="minPrice" value="<?php echo $minPrice; ?>" style="margin-left:8px;" onkeypress='return WST.isNumberdoteKey(event);' onkeyup="javascript:WST.isChinese(this,1)">
			- <input type="text" class="sipt wst-price-ipt" id="maxPrice" value="<?php echo $maxPrice; ?>" onkeypress='return WST.isNumberKey(event);' onkeyup="javascript:WST.isChinese(this,1)">
			</div>
			<button class="wst-price-but" type="submit" style="width:60px;height: 25px;" onclick='javascript:goodsOrder()'>确定</button>
			

			<div class="page" style="float:right;">
			<a href="javascript:;"  onclick="page('prev')">上一页</a>
			<a href="javascript:;"  onclick="page('next')" >下一页</a>
			</div>
	      </div>
	   	  <div class='line'>
	   	  <div class='wst-lfloat chk'>发货地</div>
	        <div class='city wst-address'>
		    <div class='item dorpdown'>
		     <div class='drop-down'>
		        <a class='link' href='/hkshopNC/dxshop'>
		        	<?php if(empty($areaInfo['areaName'])): ?>
		        	请选择
		        	<?php else: ?>
		        		<?php echo $areaInfo['areaName']; ?>
		        	<?php endif; ?>
		        </a>
		        <i class="drop-down-arrow"></i>
		     </div>


     <div class="dorp-down-layer">
     	<div class="tab-header">
     	 <ul class="tab">
     	 	<li class="tab-item1" id="fl_1_1" onclick="gpanelOver(this);" c="1" >
     	 		<?php if(isset($areaInfo)): ?>
     	 		<a href='javascript:void(0)'><?php echo $areaInfo[0]['areaName']; ?></a>
     	 		<?php else: ?>
     	 		<a href='javascript:void(0)'>请选择</a>
     	 		<?php endif; ?>
     	 	</li>

     	 	<?php if(isset($areaInfo)): ?>
     	 	<li class="tab-item1" id="fl_1_2" onclick="gpanelOver(this);" c="1" >
				<a href="javascript:void(0)"><?php echo $areaInfo[1]['areaName']; ?></a>
			</li>
			<li class="tab-item1 j-tab-selected1" id="fl_1_3" onclick="gpanelOver(this);" c="1" >
				<a href="javascript:void(0)"><?php echo $areaInfo[2]['areaName']; ?></a>
			</li>
			<?php else: ?>
			<li class="tab-item1" id="fl_1_2" onclick="gpanelOver(this);" c="1" pid="" >
				<a href="javascript:void(0)">请选择</a>
			</li>
			<li class="tab-item1 j-tab-selected1" id="fl_1_3" onclick="gpanelOver(this);" c="1" pid="" >
				<a href="javascript:void(0)">请选择</a>
			</li>
			<?php endif; ?>


			
     	 </ul>
     	</div>
     	 <ul class="area-box" id="fl_1_1_pl" style="display:none;">
     	 	<?php if(is_array($area1) || $area1 instanceof \think\Collection || $area1 instanceof \think\Paginator): $i = 0; $__LIST__ = $area1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$area1): $mod = ($i % 2 );++$i;?>
			<li onclick="choiceArea(this,<?php echo $area1['areaId']; ?>)"><a href="javascript:void(0)"><?php echo $area1['areaName']; ?></a></li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<ul class="area-box" id="fl_1_2_pl" style="display:none;">
			<?php if(is_array($area2) || $area2 instanceof \think\Collection || $area2 instanceof \think\Paginator): $i = 0; $__LIST__ = $area2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$area2): $mod = ($i % 2 );++$i;?>
			<li onclick="choiceArea(this,<?php echo $area2['areaId']; ?>)"><a href="javascript:void(0)"><?php echo $area2['areaName']; ?></a></li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>

		<ul class="area-box" id="fl_1_3_pl" >
			<?php if(is_array($area3) || $area3 instanceof \think\Collection || $area3 instanceof \think\Paginator): $i = 0; $__LIST__ = $area3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$area3): $mod = ($i % 2 );++$i;?>
			<li onclick="choiceArea(this,<?php echo $area3['areaId']; ?>)"><a href="javascript:void(0)"><?php echo $area3['areaName']; ?></a></li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>

	</div>
			</div>
			</div>
	        <div class='chk'>
			 <div class="checkbox-box-s">
		     <input name='isStock' value='1' class="sipt wst-checkbox-s" onclick="goodsFilter(this,4)" type='checkbox' id="stock" <?php if($isStock==1): ?>checked<?php endif; ?>/>
		     <label for="stock"></label>
		     </div>
	         仅显示有货</div>
	        <div class='chk'>
	         <div class="checkbox-box-s">
		     <input name='isNew' value='1' class="sipt wst-checkbox-s" onclick="goodsFilter(this,4)" type='checkbox' id="new" <?php if($isNew==1): ?>checked<?php endif; ?>/>
		     <label for="new"></label>
		     </div>
	        新品</div>
	        <div class='chk'>
	         <div class="checkbox-box-s">
		     <input name='isFreeShipping' value='1' class="sipt wst-checkbox-s" onclick="goodsFilter(this,4)" type='checkbox' id="freeShipping" <?php if($isFreeShipping==1): ?>checked<?php endif; ?>/>
		     <label for="freeShipping"></label>
		     </div>
	        包邮</div>
	      </div>
	   </div>
	   <div class="goods-list">
	      <?php if(is_array($goodsPage["data"]) || $goodsPage["data"] instanceof \think\Collection || $goodsPage["data"] instanceof \think\Paginator): $i = 0; $__LIST__ = $goodsPage["data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	      <div class="goods">
	      	<div class="img">
	      		<a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$vo['goodsId']); ?>">
	      			<img title="<?php echo WSTStripTags($vo['goodsName']); ?>" alt="<?php echo WSTStripTags($vo['goodsName']); ?>" class='goodsImg2' data-original="__RESOURCE_PATH__/<?php echo $vo['goodsImg']; ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/>
	      		</a>
	      	</div>
	      	<?php 
				$img_listarr = explode(',',$vo['gallery']);
				array_unshift($img_listarr,$vo['goodsImg']);
	      	 ?>
	      	<ul class="img_list">
	      		<?php if(is_array($img_listarr) || $img_listarr instanceof \think\Collection || $img_listarr instanceof \think\Paginator): $ils_k = 0;$__LIST__ = is_array($img_listarr) ? array_slice($img_listarr,0,8, true) : $img_listarr->slice(0,8, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ils): $mod = ($ils_k % 2 );++$ils_k;if(($ils!='')): ?>
	      			<li class="<?php if(($ils_k==1)): ?>curr<?php endif; ?>"><img title="<?php echo WSTStripTags($vo['goodsName']); ?>" alt="<?php echo WSTStripTags($vo['goodsName']); ?>" class='goodsImg2' src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>" data-original="__RESOURCE_PATH__/<?php echo WSTImg($ils); ?>"/></li>
	      		<?php endif; ?>
	      		<?php endforeach; endif; else: echo "" ;endif; ?>
	      		<div class="wst-clear"></div>
	      	</ul>
	      	<div class="p-name"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$vo['goodsId']); ?>" class="wst-redlink" title="<?php echo WSTStripTags($vo['goodsName']); ?>"><?php echo $vo['goodsName']; ?></a></div>
	      	<div>
	      		<div class="p-price">￥<?php echo $vo['shopPrice']; ?></div>
	      		<div class="p-hsale">
	      			<div class="sale-num">成交数：<span class="wst-fred"><?php echo $vo['saleNum']; ?></span></div>
		      		<a class="p-add-cart" style="display:none;" href="javascript:WST.addCart(<?php echo $vo['goodsId']; ?>);">加入购物车</a>
	      		</div>
	      		<div class='wst-clear'></div>
	      	</div>
	      	<div>
	      		<div class="p-mprice">市场价<span>￥<?php echo $vo['marketPrice']; ?></span></div>
	      		<div class="p-appraise">已有<span class="wst-fred"><?php echo $vo['appraiseNum']; ?></span>人评价</div>
	      		<div class='wst-clear'></div>
	      	</div>
	      	<div class="p-shop">
		      	<a href="<?php echo Url('home/shops/index','shopId='.$vo['shopId']); ?>" target='_blank' class="wst-redlink"><?php echo $vo['shopName']; ?></a>
		      	<a class="contrast" href="javascript:void(0);" onclick="javascript:contrastGoods(1,<?php echo $vo['goodsId']; ?>,1)"><i></i>对比</a>
	      	</div>
	      	<div class="tags">
	      	  <?php if(is_array($vo['tags']) || $vo['tags'] instanceof \think\Collection || $vo['tags'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['tags'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tv): $mod = ($i % 2 );++$i;?>
	      	  <?php echo $tv; ?>
	      	  <?php endforeach; endif; else: echo "" ;endif; ?>
	      	</div>
	      </div>
	      
	      <?php endforeach; endif; else: echo "" ;endif; ?>
	     <div class='wst-clear'></div>
	   	</div>
	   	<div style="position: absolute;bottom: -50px;width:980px;">
	  		<div id="wst-pager"></div>
		</div>
		
	</div>
	<div class='wst-clear'></div>
	<div style="height: 50px;"></div>
	
	
	<?php if(cookie("history_goods")!=''): ?>
	<div class="wst-gview">
		<div class="title">您最近浏览的商品</div>
		<div class="view-goods">
	       <?php $wstTagGoods =  model("common/Tags")->listGoods("history",$catId,7,0); foreach($wstTagGoods as $key=>$vo){?>
			<div class="item">
				<div class="img"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$vo['goodsId']); ?>"><img class='goodsImg' data-original="__RESOURCE_PATH__/<?php echo WSTImg($vo['goodsImg']); ?>" alt="<?php echo WSTStripTags($vo['goodsName']); ?>" title="<?php echo WSTStripTags($vo['goodsName']); ?>" src="<?php echo WSTConf('CONF.goodsLogo'); ?>"/></a></div>
				<div class="p-name"><a class="wst-hide wst-redlink" href="<?php echo Url('home/goods/detail','goodsId='.$vo['goodsId']); ?>"><?php echo $vo['goodsName']; ?></a></div>
				<div class="p-price">￥<?php echo $vo['shopPrice']; ?><span class="v-price">￥<?php echo $vo['marketPrice']; ?></span></div>
			</div>
	       <?php } ?>
	     	<div class='wst-clear'></div>
	   	</div>
	</div>
	<?php endif; ?>
</div>

<div class="wst-cont-frame" id="j-cont-frame">
	<div class="head"><span>对比栏</span><a href="javascript:void(0);" class="close" onclick="javascript:contrastGoods(0,0,0)">关闭</a></div>
	<div class="list">
		<div class="goods" id="contrastList"></div>
		<div class="term-contrast">
			<p><a class="contrast" href="<?php echo Url('home/goods/contrast'); ?>" target="_blank">对比</a></p>
			<p><a href="javascript:void(0);" onclick="javascript:contrastDels(0)" class="empty">清空</a></p>
		</div>
	</div>
	<script id="colist" type="text/html">
		{{# if(d.data && d.data.length>0){ }}
		{{# for(var i=0; i<d.data.length; i++){ }}
		<div class="term">
			<div class="img"><a href="{{WST.U('home/goods/detail','goodsId='+d.data[i].goodsId)}}" target="_blank"><img class="contImg" data-original="__RESOURCE_PATH__/{{ d.data[i].goodsImg }}" title="{{ d.data[i].goodsName }}" width="50" height="50"></a></div>
			<div class="info"><a href="{{WST.U('home/goods/detail','goodsId='+d.data[i].goodsId)}}" target="_blank"><p class="name">{{ d.data[i].goodsName }}</p></a><p class="price"><span>￥{{ d.data[i].shopPrice }}</span><a href="javascript:contrastDels({{ d.data[i].goodsId }});" >删除</a></p></div>
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


<script type='text/javascript' src='__STYLE__/js/goodslist.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript'>
$(function(){
	<?php if(!isset($areaInfo)): ?>
	$('#fl_1_1').click();
	<?php endif; ?>
	contrastGoods(1,0,2);
	layui.laypage.render({
	    elem: 'wst-pager',
	    count:<?php echo $goodsPage["total"]; ?>,
	    limit:<?php echo $goodsPage["per_page"]; ?>,
	    curr: <?php echo $goodsPage["current_page"]; ?>,
	    layout: ['prev', 'page', 'next', 'skip','count'],
	    skin: '#e23e3d',
	    groups: 3, //连续显示分页数
	    curr: function(){ //通过url获取当前页，也可以同上（pages）方式获取
	        var page = location.search.match(/page=(\d+)/);
	        return page ? page[1] : 1;
	    }(), 
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
})



var total = <?php echo $goodsPage["last_page"]; ?>;
function page(t){
	var page = location.search.match(/page=(\d+)/);
	var curr = 1;
	if(page && page.length>1){ //说明当前url上有page参数
		curr = page[1]; // 当前页
	}
	var nuewurl = WST.splitURL("page"); // 当前url
	var ulist = nuewurl.split("?"); // 将传递的参数与url分开
	// 说明当前有参数. 需要带着参数一起传递
	var url = (ulist.length>1)?nuewurl+'&page=':'?page=';

	if(t=='prev'){ // 上一页
		if(curr<=1)return;
		curr = parseInt(curr)-1;
		location.href = url+curr;
	}else{ // 下一页
		if(curr>=total)return;
		curr = parseInt(curr)+1;
		location.href = url+curr;
	}
	
}
</script>

</body>
</html>