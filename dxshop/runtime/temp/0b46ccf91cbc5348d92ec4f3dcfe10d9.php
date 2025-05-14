<?php /*a:6:{s:69:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\index.html";i:1738761715;s:68:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\base.html";i:1738761714;s:67:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\top.html";i:1738761716;s:70:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\header.html";i:1738761715;s:74:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\right_cart.html";i:1738761715;s:70:"D:\wamp64\www\hkshop\qmdd\dxshop\wstmart\home\view\default\footer.html";i:1738761714;}*/ ?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo WSTConf('CONF.mallName'); ?> - <?php echo WSTConf('CONF.mallSlogan'); ?></title>

<meta name="description" content="<?php echo WSTConf('CONF.seoMallDesc'); ?>">
<meta name="keywords" content="<?php echo WSTConf('CONF.seoMallKeywords'); ?>">

<link rel="stylesheet" href="/hkshop/qmdd/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/hkshop/qmdd/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__STYLE__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet">

<link href="__STYLE__/css/index.css?v=<?php echo $v; ?>" rel="stylesheet">

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



<div class="home-container">

<div class="wst-ads" style="position:relative;" >
	<div class="wst-slide" id="wst-slide">
		<ul class="wst-slide-items">
			<?php $wstTagAds =  model("common/Tags")->listAds("ads-index",99,86400); foreach($wstTagAds as $key=>$vo){?>
				<a href="<?php echo $vo['adURL']; ?>" <?php if(($vo['isOpen'])): ?>target='_blank'<?php endif; if(($vo['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $vo['adId']; ?>)"<?php endif; ?>><li style="background: url(__RESOURCE_PATH__/<?php echo $vo['adFile']; ?>) no-repeat  scroll center top;background-size:cover;" ></li></a>
			<?php } ?>
		</ul>
		<div class="wst-slide-numbox">
			<div style="position:absolute;right:0;top:-420px;">
				<div class='wst-right-panel' <?php if(!isset($hideCategory)): ?>style="display:none;" <?php endif; ?>>
		      	<?php $signScore=explode(",",WSTConf('CONF.signScore')); if((WSTConf('CONF.signScoreSwitch')==1 && $signScore[0]>0)): ?>
		    		<div class="ws-right-user">
		    			<?php if(session('WST_USER.userId') >0): ?>
			    			<div class="top" <?php if((WSTConf('WST_ADDONS.auction')=='')): ?>style="margin-top:10px"<?php endif; ?>>
			    				<img class="usersImg" data-original="<?php echo WSTUserPhoto(session('WST_USER.userPhoto')); ?>">
			    				<div class="name">
				    					<a href="<?php echo Url('home/users/index'); ?>"><p class="uname">欢迎您，<?php echo session('WST_USER.userName')?session('WST_USER.userName'):session('WST_USER.loginName'); ?></p></a>
			    				</div>
			    			</div>
			    			<div class="bottom">
			    				<a class='btn regist' href='<?php echo url('home/userscores/index'); ?>' onclick="WST.position(13,0)">积分明细</a>
			    				<?php if((session('WST_USER.signScoreTime')==date('Y-m-d'))): ?>
			    				<a class='btn login actives' id="j-sign" href='javascript:void'>已签到</a>
			    				<?php else: ?>
			    				<a class='btn login' onclick="javascript:inSign();" id="j-sign" href='javascript:void'>签到领积分</a>
			    				<?php endif; ?>
			    			</div>
		    			<?php else: ?>
		    			    <div class="top" <?php if((WSTConf('WST_ADDONS.auction')=='')): ?>style="margin-top:10px"<?php endif; ?>>
			    				<img class="usersImg" data-original="<?php echo WSTUserPhoto(session('WST_USER.userPhoto')); ?>">
			    				<div class="name">
		    				      <div class='uoname'><div>Hi,游客</div><div>欢迎您来到本商城</div></div>
		    				    </div>
		    				</div>
			    			<div class="bottom" >
			    				<a class='btn regist' href='<?php echo url("home/users/regist"); ?>'>注册</a>
			    				<a class='btn login' href='<?php echo url("home/users/login"); ?>'>登录</a>
			    			</div>
		    		    <?php endif; ?>
		    			<div class="wst-clear"></div>
		    		</div>
		    	    <?php endif; ?>
		    	    
		    		<div id="wst-right-ads">
						<?php if((WSTConf('WST_ADDONS.auction')!='') && count(auction_list())>0): $auction=auction_list(); ?>
		    			<div class="aution_out">
		    				<p class="aution_tit">拍卖活动</p>
		    				<div class="aution_list" sc="<?php echo date('Y-m-d H:i:s'); ?>">
								<?php if(is_array($auction) || $auction instanceof \think\Collection || $auction instanceof \think\Paginator): $i = 0; $__LIST__ = $auction;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$au): $mod = ($i % 2 );++$i;?>
			    				<div class="aution_main" sv="<?php echo $au['startTime']; ?>" ev="<?php echo $au['endTime']; ?>">
		    						<a class="aution_item" target='_blank' href="<?php echo addon_url('auction://goods/detail','id='.$au['auctionId']); ?>">
		    							<img title="<?php echo WSTStripTags($au['goodsName']); ?>" alt="<?php echo WSTStripTags($au['goodsName']); ?>" class='goodsImg' data-original="__RESOURCE_PATH__/<?php echo WSTImg($au['goodsImg']); ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/>
										<div class="aution_time">
											距离结束：
											<span class="aution_h">12</span>
											:
											<span class="aution_i">23</span>
											:
											<span class="aution_s">55</span>
										</div>
		    						</a>
			    				</div>
								<?php endforeach; endif; else: echo "" ;endif; ?>
			    				<div class="wst-clear"></div>
		    				</div>
		    				<span class="au_l_btn"><</span>
		    				<span class="au_r_btn">></span>
		    			</div>
						<?php else: $wstTagAds =  model("common/Tags")->listAds("index-art",1,86400); foreach($wstTagAds as $key=>$vo){?>
			              <a <?php if(($vo['isOpen'])): ?>target='_blank'<?php endif; if(($vo['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $vo['adId']; ?>)"<?php endif; ?> href="<?php echo $vo['adURL']; ?>" onfocus="this.blur()">
			                <img data-original="__RESOURCE_PATH__/<?php echo $vo['adFile']; ?>" class="goodsImg" />
			              </a>
			    	   <?php } ?>
			    	   <?php endif; ?>
		            <div class="index-user-tab">
		             <div id='index-tab' class="wst-tab-box">

		    	          <div class="wst-tab-nav">
		    	          	    <?php if(WSTConf('CONF.isOpenShopApply')==1): ?>
		    	             	<div class="tab">招商入驻</div>
		    	             	<?php endif; ?>
		    	             	<div class="tab">商城快讯</div>
		    	          	</div>
		    	          <div class="wst-tab-content" style='width:99%;'>
		    	          	<?php if(WSTConf('CONF.isOpenShopApply')==1): ?>
		    	          	<div class="wst-tab-item" style="position: relative;">
		    	               <a class='apply-btn' target='_blank' href='<?php echo Url("home/shops/join"); ?>' onclick="WST.currentUrl('<?php echo url("home/shops/join"); ?>');"></a>
		    	               <a class='shop-login' target='_blank' href='<?php echo Url("shop/index/login"); ?>' onclick="WST.currentUrl();"><i class='fa fa-cog'></i> 登录商家中心</a>
		    	              </div>
		    	              <?php endif; ?>
		    	              <div class="wst-tab-item" style="position: relative;display:none">
		    	              <div id="wst-right-new-list"<?php if((!session('WST_USER.userId'))): ?>class="visitor-new-list"<?php endif; ?> >
		    	                <?php $wstTagArticle =  model("common/Tags")->listArticle("new",5,86400); foreach($wstTagArticle as $key=>$vo){?>
		    	                <div><a href="<?php echo url('home/news/view',['id'=>$vo['articleId']]); ?>"><?php echo $vo['articleTitle']; ?></a></div>
		    	                <?php } ?>
		    	              </div>
		    	              </div>

		    	          </div>
		    	      </div>
		    	    </div>

		          <span class="wst-clear"></span>
		        </div>
		      </div>
			</div>
			<div class="wst-slide-controls">
			  	<?php $wstTagAds =  model("common/Tags")->listAds("ads-index",99,86400); foreach($wstTagAds as $k=>$vo){if($k+1 == 1): ?>
				  		 <span class="curr"><?php echo $k+1; ?></span>
				  	<?php else: ?>
				  		 <span class=""><?php echo $k+1; ?></span>
				  	<?php endif; } ?>
			</div>
		</div>
	</div>
</div>

<div class='wst-main' style='background:#F4F4F4;padding-top:10px'>
   
	<?php if((WSTConf('WST_ADDONS.coupon')!='') && count(coupon_list())>0): ?>
	<script type='text/javascript' src='/hkshop/qmdd/dxshop/addons/coupon/view/home/index/index.js?v=<?php echo $v; ?>'></script>
	<?php $coupon=coupon_list('',['s.shopImg'],4); ?>
	<div class="coupon_out">
		<a href="<?php echo addon_url('coupon://coupons/index'); ?>" class="fl coupon_bg">
			<p class="coupon_tit">领券中心</p>
			<p class="coupon_desc">为您汇总所有优惠券</p>
		</a>
		<div class="coupon_box">
			<?php if(is_array($coupon) || $coupon instanceof \think\Collection || $coupon instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($coupon) ? array_slice($coupon,0,4, true) : $coupon->slice(0,4, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cn): $mod = ($i % 2 );++$i;?>
			<div class="fl coupon_item">
				<div class="coupon_tit"><span class='unit'>￥</span><?php echo $cn['couponValue']; ?></div>
				<div class="coupon_desc">
					<div>优惠券</div>
					<div>
					<?php if($cn['useCondition']==1): ?>
						满<?php echo $cn['useMoney']; ?>减<?php echo $cn['couponValue']; else: ?>
						无门槛券
					<?php endif; ?>
				    </div>
				</div>
				<div class="r_btn" style='cursor: pointer;' onclick='indexReceive(<?php echo $cn['couponId']; ?>,this)'>立即领取</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="wst-clear"></div>
	</div>
	<?php endif; ?>
   
   <div class="ads_wall">
   		<div class="ads_wall_l fl">
   			
   			<?php $wstTagAds =  model("common/Tags")->listAds("wall-left-top",1,86400); foreach($wstTagAds as $key=>$aw){?>
   			<a <?php if(($aw['isOpen'])): ?>target='_blank'<?php endif; if(($aw['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $aw['adId']; ?>)"<?php endif; ?> href="<?php echo $aw['adURL']; ?>" onfocus="this.blur()" class="ads_wall_item_top">
   				<img data-original="__RESOURCE_PATH__/<?php echo $aw['adFile']; ?>" class="goodsImg" />
   				<div class="ads_wall_more">
   					<div class="ads_wall_line fl"></div>
   					<p class="fl">查看更多 >></p>
   					<div class="wst-clear"></div>
   				</div>
   			</a>
   			<?php } $wstTagAds =  model("common/Tags")->listAds("wall-left-bottom",1,86400); foreach($wstTagAds as $key=>$aw){?>
   			<a <?php if(($aw['isOpen'])): ?>target='_blank'<?php endif; if(($aw['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $aw['adId']; ?>)"<?php endif; ?> href="<?php echo $aw['adURL']; ?>" onfocus="this.blur()" class="ads_wall_item_bottom">
   				<img data-original="__RESOURCE_PATH__/<?php echo $aw['adFile']; ?>" class="goodsImg" />
   				<div class="ads_wall_more">
   					<div class="ads_wall_line fl"></div>
   					<p class="fl">查看更多 >></p>
   					<div class="wst-clear"></div>
   				</div>
   			</a>
   			<?php } ?>
   		</div>
   		<div class="ads_wall_c fl">
   			
   			<?php $wstTagAds =  model("common/Tags")->listAds("wall-center",1,86400); foreach($wstTagAds as $key=>$aw){?>
   			<a <?php if(($aw['isOpen'])): ?>target='_blank'<?php endif; if(($aw['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $aw['adId']; ?>)"<?php endif; ?> href="<?php echo $aw['adURL']; ?>" onfocus="this.blur()">
   				<img data-original="__RESOURCE_PATH__/<?php echo $aw['adFile']; ?>" class="goodsImg" />
   				<div class="ads_wall_more" style="left:0;right:0;">
   					<p>查看更多 >></p>
				</div>
   			</a>
   			<?php } ?>
   		</div>
   		<div class="ads_wall_r fr">
   			
   			<?php $wstTagAds =  model("common/Tags")->listAds("wall-right-top",1,86400); foreach($wstTagAds as $key=>$aw){?>
   			<a <?php if(($aw['isOpen'])): ?>target='_blank'<?php endif; if(($aw['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $aw['adId']; ?>)"<?php endif; ?> href="<?php echo $aw['adURL']; ?>" onfocus="this.blur()" class="ads_wall_item_top">
   				<img data-original="__RESOURCE_PATH__/<?php echo $aw['adFile']; ?>" class="goodsImg" />
   				<div class="ads_wall_more">
   					<div class="ads_wall_line wall_r_line fl"></div>
   					<p class="fl">查看更多 >></p>
   					<div class="wst-clear"></div>
   				</div>
   			</a>
   			<?php } $wstTagAds =  model("common/Tags")->listAds("wall-right-bottom",1,86400); foreach($wstTagAds as $key=>$aw){?>
   			<a <?php if(($aw['isOpen'])): ?>target='_blank'<?php endif; if(($aw['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $aw['adId']; ?>)"<?php endif; ?> href="<?php echo $aw['adURL']; ?>" onfocus="this.blur()" class="ads_wall_item_bottom">
   				<img data-original="__RESOURCE_PATH__/<?php echo $aw['adFile']; ?>" class="goodsImg" />
   				<div class="ads_wall_more">
   					<div class="ads_wall_line wall_r_line fl"></div>
   					<p class="fl">查看更多 >></p>
   					<div class="wst-clear"></div>
   				</div>
   			</a>
   			<?php } ?>
   		</div>
   		<div class="wst-clear"></div>
   </div>
   
   <?php $brands = model('common/Tags')->listBrand(0,10,7200); if(count($brands)>0): ?>
   <div class="brand_street_out">
   	   <p class="bs_tit">品牌街</p>
	   <ul class="brand_street">
	   		<?php if(is_array($brands) || $brands instanceof \think\Collection || $brands instanceof \think\Paginator): $i = 0; $__LIST__ = $brands;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brd): $mod = ($i % 2 );++$i;?>
		   	<li>
		   		<a href="<?php echo Url('home/goods/lists',['brand'=>$brd['brandId'],'cat'=>$brd['catId']]); ?>">
		   			<img data-original="__RESOURCE_PATH__/<?php echo $brd['brandImg']; ?>" class="goodsImg" />
		   		</a>
		   	</li>
		   	<?php endforeach; endif; else: echo "" ;endif; ?>
		   	<div class="wst-clear"></div>
	   </ul>
	</div>
	<?php endif; ?>
	<div class="rec_area">
		<div class="ral fl">
			<?php if((WSTConf('WST_ADDONS.groupon')!='')): $groupon=groupon_list('',['gu.orderNum','gu.grouponNum','gu.grouponPrice']); if(count($groupon)>0): ?>
				<div class="ral_box">
					<a target='_blank' href="<?php echo addon_url('groupon://goods/lists'); ?>">
						<p class="ral_box_tit">爱上团购</p>
						<p class="ral_desc">尽享美好生活</p>
					</a>
				</div>
				<div class="groupon_list_out">
					<div class="groupon_view">
						<ul class="groupon_list">
							<?php if(is_array($groupon) || $groupon instanceof \think\Collection || $groupon instanceof \think\Paginator): $i = 0; $__LIST__ = $groupon;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gn): $mod = ($i % 2 );++$i;?>
							<li>
								<a target='_blank' href="<?php echo addon_url('groupon://goods/detail','id='.$gn['grouponId']); ?>">
									<p style='float:left;'>
									<img data-original="__RESOURCE_PATH__/<?php echo $gn['goodsImg']; ?>" class="goodsImg" />
								    </p>
									<p class='groupon_goods'><?php echo $gn['goodsName']; ?></p>
									<?php $rate = round($gn["orderNum"]/($gn["orderNum"]+$gn["grouponNum"]),4)*100; ?>
									<div class='time-in' <?php if($gn['status']=='0'): ?>style='display:none'<?php endif; ?>>
								      	<div class='saleNum'><div class='saleRate' style='width:<?php echo $rate; ?>%'></div></div>
							            <div class=' groupon-saleTxt'>已团<?php echo $rate; ?>%</div>
							        </div>
									<p class='groupon_goodsprice'><span class="f12">￥</span><?php echo $gn['grouponPrice']; ?></p>
									<div class="wst-clear"></div>
								</a>
							</li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
				<?php else: $wstTagAds =  model("common/Tags")->listAds("rbnh-left-ads",1,86400); foreach($wstTagAds as $key=>$rbnh){?>
					<a <?php if(($rbnh['isOpen'])): ?>target='_blank'<?php endif; if(($rbnh['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $rbnh['adId']; ?>)"<?php endif; ?> href="<?php echo $rbnh['adURL']; ?>" onfocus="this.blur()">
						<img data-original="__RESOURCE_PATH__/<?php echo $rbnh['adFile']; ?>" class="goodsImg" />
					</a>
					<?php } ?>
				<?php endif; else: $wstTagAds =  model("common/Tags")->listAds("rbnh-left-ads",1,86400); foreach($wstTagAds as $key=>$rbnh){?>
				<a <?php if(($rbnh['isOpen'])): ?>target='_blank'<?php endif; if(($rbnh['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $rbnh['adId']; ?>)"<?php endif; ?> href="<?php echo $rbnh['adURL']; ?>" onfocus="this.blur()">
					<img data-original="__RESOURCE_PATH__/<?php echo $rbnh['adFile']; ?>" class="goodsImg" />
				</a>
				<?php } ?>
			<?php endif; ?>
		</div>
		<div class="rac fl">
			<div class="rac_t">
				<p class="rac_t_tit">最新上架</p>
				<ul class="rac_t_main">
					<?php $wstTagGoods =  model("common/Tags")->listGoods("new",0,2,7200); foreach($wstTagGoods as $key=>$racb){?>
					<li>
						<a class="rac_t_img" href="<?php echo Url('home/goods/detail','goodsId='.$racb['goodsId']); ?>">
							<img width="120" data-original="__RESOURCE_PATH__/<?php echo $racb['goodsImg']; ?>" class="goodsImg" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/>
						</a>
						<a href="<?php echo Url('home/goods/detail','goodsId='.$racb['goodsId']); ?>">
						<div class="rac_t_info">
							<p class="c14_333 rac_gname"><?php echo $racb['goodsName']; ?></p>
							<p class="c14_333 rac_gprice"><span class="f12">￥</span><?php echo $racb['shopPrice']; ?></p>
						</div>
						</a>
					</li>
					<?php } ?>
					<div class="wst-clear"></div>
				</ul>
			</div>
			<div class="rac_t">
				<p class="rac_t_tit" style='border-top:1px solid #ddd;'>热销上架</p>
				<ul class="rac_t_main">
					<?php $wstTagGoods =  model("common/Tags")->listGoods("hot",0,2,7200); foreach($wstTagGoods as $key=>$racb){?>
					<li>
						<a class="rac_t_img" href="<?php echo Url('home/goods/detail','goodsId='.$racb['goodsId']); ?>">
							<img width="120" data-original="__RESOURCE_PATH__/<?php echo $racb['goodsImg']; ?>" class="goodsImg" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/>
						</a>
						<a href="<?php echo Url('home/goods/detail','goodsId='.$racb['goodsId']); ?>">
						<div class="rac_t_info">
							<p class="c14_333 rac_gname"><?php echo $racb['goodsName']; ?></p>
							<p class="c14_333 rac_gprice"><span class="f12">￥</span><?php echo $racb['shopPrice']; ?></p>
						</div>
						</a>
					</li>
					<?php } ?>
					<div class="wst-clear"></div>
				</ul>
			</div>
		</div>
		<div class="rar fr">
			<p class="rar_tit">推荐商品</p>
			<div class="rar_glist">
				<div class='recomgd_view'>
					<ul class='recomgd_list'>
				    <?php $wstTagGoods =  model("common/Tags")->listGoods("recom",0,5,7200); foreach($wstTagGoods as $key=>$racb){?>
					<li>
						<a href="<?php echo Url('home/goods/detail','goodsId='.$racb['goodsId']); ?>" class="rar_gitem">
							<div class="rar_img">
								<img  data-original="__RESOURCE_PATH__/<?php echo $racb['goodsImg']; ?>" class="J_rarimg" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/>
							</div>
							<p class="rar_gname"><?php echo WSTMSubStr($racb['goodsName'],0,10,'utf-8'); ?></p>
							<div class="rar_line"></div>
							<p class="rar_gdesc"><?php echo WSTMSubStr($racb['goodsTips'],0,20,'utf-8'); ?></p>
							<p class="rar_price">
								<span class="f12">￥</span><?php echo $racb['shopPrice']; ?>
							</p>
				        </a>
				    </li>
				    <?php } ?>
				    </ul>
				</div>
				<div class='recomgd_btns'>
				<?php $wstTagGoods =  model("common/Tags")->listGoods("recom",0,5,0); foreach($wstTagGoods as $gn_k=>$gn){?>
					<span <?php if(($gn_k==1)): ?>class="curr"<?php endif; ?>></span>
                <?php } ?>
                </div>
			</div>
		</div>
		<div class="wst-clear"></div>
	</div>
	
	<?php if((WSTConf('WST_ADDONS.integral')!='') && count(integral_list())>0): $integral=integral_list(); ?>
	<div class="intergral_out">
   	   <p class="itl_tit">积分商城</p>
   	   <div class="itl_main">
   	   	 <a href="<?php echo addon_url('integral://goods/lists'); ?>" class="itl_bg fl">
   	   	 	<img src="__STYLE__/img/integral_bg.png" alt="" />
   	   	 </a>
   	   	 <?php if(is_array($integral) || $integral instanceof \think\Collection || $integral instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($integral) ? array_slice($integral,0,2, true) : $integral->slice(0,2, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$itl): $mod = ($i % 2 );++$i;?>
   	   	 <a href="<?php echo addon_url('integral://goods/detail','id='.$itl['id']); ?>" class="itl_item fl">
   	   	 	<p class="itl_name"><?php echo $itl['goodsName']; ?></p>
   	   	 	<p class="itl_price_box">
   	   	 		<span class="itl_price">￥<?php echo $itl['goodsPrice']; ?></span> + <span class="itl_score"><?php echo $itl['integralNum']; ?>积分</span>
   	   	 	</p>
   	   	 	<span class="itl_btn">立即兑换</span>
   	   	 	<img  data-original="__RESOURCE_PATH__/<?php echo $itl['goodsImg']; ?>" class="goodsImg" />
   	   	 </a>
   	   	 <?php endforeach; endif; else: echo "" ;endif; ?>
   	   	 <div class="wst-clear"></div>
   	   </div>
	</div>
	<?php endif; if((WSTConf('WST_ADDONS.distribut')!='') && count(distribut_list())>0): $distribut=distribut_list(); ?>
	<p class="distribute_tit">分销商品</p>
	<div class="distribute_out">
		<div class="dis_left_bg fl">
			<a href="<?php echo addon_url('distribut://goods/glist'); ?>">
				<img src="__STYLE__/img/index_distribute_bg.png" />
			</a>
		</div>
		<ul class="dis_list fl">
			<?php if(is_array($distribut) || $distribut instanceof \think\Collection || $distribut instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($distribut) ? array_slice($distribut,0,4, true) : $distribut->slice(0,4, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dis): $mod = ($i % 2 );++$i;?>
			<li>
				<a href="<?php echo Url("home/goods/detail","goodsId=".$dis["goodsId"]); ?>">
				<img class='goodsImg' data-original="__RESOURCE_PATH__/<?php echo WSTImg($dis['goodsImg']); ?>"  title="<?php echo WSTStripTags($dis['goodsName']); ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/>
				<div class="dis_gname"><?php echo $dis['goodsName']; ?></div>
				<div class="dis_gprice">
					<span class="f12">￥</span><?php echo $dis['shopPrice']; ?>
				</div>
				</a>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			<div class="wst-clear"></div>
		</ul>
		<div class="wst-clear"></div>
	</div>
	<?php endif;  $shopStreet = model('common/Tags')->listShop(0,4,7200); if(count($shopStreet)>0): ?>
	<div class="shop_street_out">
   	   <p class="ss_tit">店铺街</p>
	   <ul class="shop_street">
		   	<li>
		   		<a href="<?php echo url('home/shops/shopStreet'); ?>">
		   		<img src="__STYLE__/img/shop_street_bg.png" alt="" />
		   		</a>
		   	</li>
		   <?php if(is_array($shopStreet) || $shopStreet instanceof \think\Collection || $shopStreet instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($shopStreet) ? array_slice($shopStreet,0,4, true) : $shopStreet->slice(0,4, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$st): $mod = ($i % 2 );++$i;?>
		   	<li>
		   		<a href="<?php echo url('home/shops/index',['shopId'=>$st['shopId']]); ?>" target="_blank" class="ss_entry">
		   		<img src="__RESOURCE_PATH__/<?php echo $st['shopStreetImg']; ?>" alt="<?php echo $st['shopName']; ?>" /></a>
		   	</li>
		   	<?php endforeach; endif; else: echo "" ;endif; ?>
		   	<div class="wst-clear"></div>
	   </ul>
	</div>
	<?php endif; ?>
	<div class='wst-container'>
    
	<?php if(is_array($floors) || $floors instanceof \think\Collection || $floors instanceof \think\Paginator): $l = 0;$__LIST__ = is_array($floors) ? array_slice($floors,0,10, true) : $floors->slice(0,10, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($l % 2 );++$l;?>
	
	<div class="floor-top-ads">
	<?php $adsCode = "ads-".$l."-1"; $wstTagAds =  model("common/Tags")->listAds("$adsCode",1,86400); foreach($wstTagAds as $key=>$tad){?>
		<div class="floor_ads">
			<a href="<?php echo $tad['adURL']; ?>" <?php if(($tad['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $tad['adId']; ?>)"<?php endif; ?> >
				<img class='goodsImg' data-original="__RESOURCE_PATH__/<?php echo $tad['adFile']; ?>">
			</a>
		</div>
	<?php } ?>
	</div>
	<div class="floor-box">
		<div class="floor-header c<?php echo $l; ?>" id="c<?php echo $l; ?>">
			<div class="floor-header-f<?php echo $l; ?>">
				<p class="floor-right-title"><?php echo str_replace('、','、',$vo['catName']); ?></p>
			</div>

			<ul class="tab">
				<li class="tab-item<?php echo $l; ?> j-tab-selected<?php echo $l; ?>" id="fl_<?php echo $l; ?>_0" onmouseover="gpanelOver(this);" c=<?php echo $l; ?>>
					<a href="<?php echo Url('home/goods/lists','cat='.$vo['catId']); ?>">热门</a>
				</li>
				
				<?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): $l2 = 0;$__LIST__ = is_array($vo['children']) ? array_slice($vo['children'],0,7, true) : $vo['children']->slice(0,7, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($l2 % 2 );++$l2;?>
				<li class="tab-item<?php echo $l; ?>" id="fl_<?php echo $l; ?>_<?php echo $l2; ?>" onmouseover="gpanelOver(this);" c=<?php echo $l; ?>><a href="<?php echo Url('home/goods/lists','cat='.$vo1['catId']); ?>"><?php echo $vo1['catName']; ?></a></li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		
		<div class="floor-right" id="fl_<?php echo $l; ?>_0_pl">
			<div class="floor-right-ads">
			    
				<div class="wst-floor-slide-<?php echo $l; ?>" id="wst-floor-slide-<?php echo $l; ?>">
					<ul class="wst-floor-slide-items">
					    <?php $adsCode = "index-floor-left-".$l; $wstTagAds =  model("common/Tags")->listAds("$adsCode",99,7200); foreach($wstTagAds as $key=>$rad){?>
							<li style="z-index: 1;">
								<a href="<?php echo $rad['adURL']; ?>" <?php if(($rad['adURL']!='')): ?>onclick="WST.recordClick(<?php echo $rad['adId']; ?>)"<?php endif; ?>><img class='goodsImg' data-original="__RESOURCE_PATH__/<?php echo $rad['adFile']; ?>"></a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>

			<div class="goods-list">
		     
			  <?php $wstTagGoods =  model("common/Tags")->listGoods("hot",$vo['catId'],8,7200); foreach($wstTagGoods as $key=>$cs){?>
		      <div class="goods goods-f<?php echo $l; ?>">
		      	<div class="img"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$cs['goodsId']); ?>" title="<?php echo WSTStripTags($cs['goodsName']); ?>"><img title="<?php echo WSTStripTags($cs['goodsName']); ?>" class='goodsImg' data-original="__RESOURCE_PATH__/<?php echo WSTImg($cs['goodsImg']); ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/></a></div>
		      	<div class="p-name"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$cs['goodsId']); ?>" class="wst-redlink" title="<?php echo WSTStripTags($cs['goodsName']); ?>"><?php echo WSTStripTags($cs['goodsName']); ?></a></div>
		      	<div class="info wst-flex-row wst-jsb wst-ac">
		      		<div class="p-price">￥<?php echo $cs['shopPrice']; ?></div>
					<div class="cart" onclick="javascript:WST.addCart(<?php echo $cs['goodsId']; ?>);"></div>
		      	</div>
		      </div>
		      <?php } ?>
		     <div class='wst-clear'></div>
		   	</div>
			<div class="wst-clear"></div>
		</div>

		
		<?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): $l2 = 0; $__LIST__ = $vo['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($l2 % 2 );++$l2;?>
		<div class="floor-right" id="fl_<?php echo $l; ?>_<?php echo $l2; ?>_pl" style="display:none;">
			<div class="goods-list">
		     
			 <?php $wstTagGoods =  model("common/Tags")->listGoods("recom",$vo1['catId'],10,7200); foreach($wstTagGoods as $key=>$vo2){?>
		      <div class="goods goods-f<?php echo $l; ?>">
		      	<div class="img"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$vo2['goodsId']); ?>" title="<?php echo WSTStripTags($vo2['goodsName']); ?>"><img title="<?php echo WSTStripTags($vo2['goodsName']); ?>" class='goodsImg' data-original="__RESOURCE_PATH__/<?php echo WSTImg($vo2['goodsImg']); ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/></a></div>
		      	<div class="p-name"><a target='_blank' href="<?php echo Url('home/goods/detail','goodsId='.$vo2['goodsId']); ?>" class="wst-redlink" title="<?php echo WSTStripTags($vo2['goodsName']); ?>"><?php echo WSTStripTags($vo2['goodsName']); ?></a></div>
			  <div class="info wst-flex-row wst-jsb wst-ac">
				  <div class="p-price"><span class="f12">￥</span><?php echo $vo2['shopPrice']; ?></div>
				  <div class="cart" onclick="javascript:WST.addCart(<?php echo $vo2['goodsId']; ?>);"></div>
			  </div>
		      </div>
		      <?php } ?>
		     <div class='wst-clear'></div>
		   	</div>
		</div>
		<?php endforeach; endif; else: echo "" ;endif; ?>
		<div class="wst-clear"></div>
	</div>
	<?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="wst-clear"></div>
    <div class='wst-container'>
	    
		<div class="like_goods_list">
			<div class="lg_tit">猜你喜欢</div>
			<div class="lg_glist">
			<?php $wstTagGoods =  model("common/Tags")->listGoods("guess",0,10,7200); foreach($wstTagGoods as $key=>$cs){?>
				<div class="fmr_gitem fl" title="<?php echo WSTStripTags($cs['goodsName']); ?>">
					<div class="fmr_img" >
						<a target='_blank'  href="<?php echo Url('home/goods/detail','goodsId='.$cs['goodsId']); ?>">
							<img title="<?php echo WSTStripTags($cs['goodsName']); ?>" class='goodsImg' data-original="__RESOURCE_PATH__/<?php echo WSTImg($cs['goodsImg']); ?>" src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.goodsLogo'); ?>"/>
						</a>
					</div>
					<p class="fmr_gname"><a target='_blank'  href="<?php echo Url('home/goods/detail','goodsId='.$cs['goodsId']); ?>"><?php echo WSTStripTags($cs['goodsName']); ?></a></p>
					<!--<p class="fmr_gprice">-->
						<!--<span class="f12">￥</span><?php echo $cs['shopPrice']; ?>-->
					<!--</p>-->
					<div class="info wst-flex-row wst-jsb wst-ac">
						<div class="fmr_gprice"><span class="f12">￥</span><?php echo $cs['shopPrice']; ?></div>
						<div class="cart" onclick="javascript:WST.addCart(<?php echo $cs['goodsId']; ?>);"></div>
					</div>
				</div>
			<?php } ?>
			<div class="wst-clear"></div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="decoration-container">
    <?php echo hook('homeDocumentIndexDisplay'); ?>
</div>
<?php 
	$ads4 = WSTAds('home-pop-ads',1,86400,1);
 if((!empty($ads4))): ?>
	<div id="pop_ad_box" style="display: none;">
		<a <?php if(($ads4['isOpen'])): ?>target='_blank'<?php endif; if(($ads4['adURL']!='')): ?>
		onClick="WST.setCookie('WST_HOME_POP_AD', <?php echo $ads4['adId']; ?> ,86400);WST.recordClick(<?php echo $ads4['adId']; ?>)"
		<?php else: ?>
		onClick="WST.setCookie('WST_HOME_POP_AD', <?php echo $ads4['adId']; ?> ,86400);"
		<?php endif; ?>
		 href="<?php echo $ads4['adURL']; ?>"
		 onFocus="this.blur()">
		<img src="__RESOURCE_PATH__/<?php echo $ads4['adFile']; ?>" style="width:800px;height: 500px;display: block;">
		</a>
	</div>
<?php endif; ?>

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


<script async="async" type='text/javascript' src='__STYLE__/js/index.js?v=<?php echo $v; ?>'></script>
<?php if((!empty($ads4))): ?>
<script >
$(function(){
	if(WST.getCookie('WST_HOME_POP_AD')!=<?php echo $ads4['adId']; ?>){
		WST.open({
		  	type: 1,
		  	title: false,
		  	area:['800px','500px'],
		  	content: $('#pop_ad_box'),
		  	end: function(){
		   		WST.setCookie('WST_HOME_POP_AD', <?php echo $ads4['adId']; ?> ,86400);
		  	}
		});
	}
});
</script>
<?php endif; ?>

</body>
</html>