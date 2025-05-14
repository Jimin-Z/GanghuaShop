<?php /*a:4:{s:76:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\users\orders\view.html";i:1738420029;s:69:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\users\base.html";i:1669879436;s:62:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\top.html";i:1738420029;s:65:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\footer.html";i:1738136898;}*/ ?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>订单详情 - 会员中心</title>
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/layui/css/layui.css"/>
<link href="__STYLE__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/user.css?v=<?php echo $v; ?>" rel="stylesheet">

<style>
    .map{width: 700px;height:400px;}
    .location-icon{width:20px;height:20px;margin:0 5px;}
    .express-text{width:100px;height:30px;text-align: right;color:#707070;}
    .express-val{height:30px;}
    .express-line{width:300px;margin:0 0 10px 40px;border-bottom:1px dashed #999;}
</style>

<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<script type="text/javascript" src="/hkshopNC/dxshop/static/js/jquery.min.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js?v=<?php echo $v; ?>"></script>	  
<script type='text/javascript' src='/hkshopNC/dxshop/static/js/common.js?v=<?php echo $v; ?>'></script>

<script type='text/javascript' src='__STYLE__/js/common.js?v=<?php echo $v; ?>'></script>
<script>
window.conf = {"ROOT":"/hkshopNC/dxshop","APP":"/hkshopNC/dxshop","STATIC":"/hkshopNC/dxshop/static", "SUFFIX":"<?php echo config('url_html_suffix'); ?>","SMS_VERFY":"<?php echo WSTConf('CONF.smsVerfy'); ?>","PHONE_VERFY":"<?php echo WSTConf('CONF.phoneVerfy'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>","IS_LOGIN":"<?php if((int)session('WST_USER.userId')>0): ?>1<?php else: ?>0<?php endif; ?>","TIME_TASK":"1","ROUTES":'<?php echo WSTRoute(); ?>',"IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>","HTTP":"<?php echo WSTProtocol(); ?>",'RESOURCE_PATH':'<?php echo WSTConf('CONF.resourcePath'); ?>'}
$(function() {
	WST.initUserCenter();
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



<div class='wst-lite-bac'>
<div class='wst-lite-container'>
   <div class='wst-logo'><a href='<?php echo app('request')->root(true); ?>'><img src="__RESOURCE_PATH__/<?php echo WSTConf('CONF.mallLogo'); ?>" height="80" width='160'></a></div>
   <div class="wst-lite-tit"><span>会员中心</span><a class="wst-lite-in" href='<?php echo app('request')->root(true); ?>'>返回商城首页</a></div>
   <div class="wst-lite-cart">
   	<a href="<?php echo url('home/carts/index'); ?>" target="_blank" onclick="WST.currentUrl('<?php echo url("home/carts/index"); ?>');"><span class="word j-word"><i class='fa fa-shopping-cart fa-2x'></i> 我的购物车<span class="num" id="goodsTotalNum" style='display:none'>0</span></span></a>
   	<div class="wst-lite-carts hide">
      <div class='spacer'></div>
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
   <div class="wst-lite-sea">
      <div class='search'>
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
	      <input type="text" id='search-ipt' class='search-ipt' value='<?php echo isset($keyword)?$keyword:""; ?>'/>
	      <div id='search-btn' class="search-btn" onclick='javascript:WST.search(this.value)'><i class='fa fa-search'></i></div>
      </div>
   </div>
   <div class="wst-clear"></div>
</div>
<div class="wst-clear"></div>
</div>

<div class="wst-wrap">
          <div class='wst-header' style='border-bottom: 1px solid #ffffff;'>
			<div class="wst-shop-nav">
				<div class="wst-nav-box">
					<?php $homeMenus = WSTHomeMenus(0); if(is_array($homeMenus['menus']) || $homeMenus['menus'] instanceof \think\Collection || $homeMenus['menus'] instanceof \think\Paginator): $i = 0; $__LIST__ = $homeMenus['menus'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<a href="/hkshopNC/dxshop/<?php echo $vo['menuUrl']; ?>?homeMenuId=<?php echo $vo['menuId']; ?>"><li class="liselect wst-lfloat <?php if(($vo['menuId'] == $homeMenus['menuId1'])): ?>wst-nav-boxa<?php endif; ?>"><?php echo $vo['menuName']; ?></li></a>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					<div class="wst-clear"></div>
				</div>
			</div>
			<div class="wst-clear"></div>
		</div>
          <div class='wst-nav'></div>
          <div class='wst-main'>
            <div class='wst-menu'>
              <?php if(isset($homeMenus['menus'][$homeMenus['menuId1']]['list'])): if(is_array($homeMenus['menus'][$homeMenus['menuId1']]['list']) || $homeMenus['menus'][$homeMenus['menuId1']]['list'] instanceof \think\Collection || $homeMenus['menus'][$homeMenus['menuId1']]['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $homeMenus['menus'][$homeMenus['menuId1']]['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menus): $mod = ($i % 2 );++$i;?>
              	<span class='wst-menu-title'><?php echo $menus['menuName']; ?><img src="__STYLE__/img/user_icon_sider_zhankai.png"></span>
              	<ul>
                <?php if(isset($menus['list'])): if(is_array($menus['list']) || $menus['list'] instanceof \think\Collection || $menus['list'] instanceof \think\Paginator): $k = 0; $__LIST__ = $menus['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($k % 2 );++$k;?>
                  	<li class="<?php if(($homeMenus['menuId3']==$menu['menuId'])): ?>wst-menua<?php endif; ?> wst-menuas" onclick="getMenus('<?php echo $menu['menuId']; ?>','<?php echo $menu['menuUrl']; ?>')">
                  	<?php echo $menu['menuName']; ?>
                  	<span id="mId_<?php echo $menu['menuId']; ?>"></span>
                  	</li>
                	<?php endforeach; endif; else: echo "" ;endif; ?>
                <?php endif; ?>
              	</ul>
              	<?php endforeach; endif; else: echo "" ;endif; ?>
              <?php endif; ?>
              
            </div>
            <div class='wst-content'>
            
<div class="wst-user-head"><span>订单详情</span>
  <?php if(($src!="")): ?>
  <a href="<?=url('home/orders/'.$src,'p='.$p);?>">返回</a>
  <?php else: ?>
  <a href="<?=url('home/users/index');?>">返回</a>
  <?php endif; ?>
</div>
<div class='wst-user-content'>
   <div class='order-box'>
    <div class='box-head'>日志信息</div>
    <?php if(in_array($object['orderStatus'],[-2,0,1,2])): ?>
	<div class='log-box'>
<div class="state">
<?php if($object['payType']==1): ?>
<div class="icon">
	<span class="icons <?php if(($object['orderStatus']==-2)OR($object['orderStatus']==0)OR($object['orderStatus']==1)OR($object['orderStatus']==2)): ?>icon12 <?php else: ?>icon11 <?php endif; if(($object['orderStatus']==-2)): ?>icon13 <?php endif; ?>"></span>
</div>
<div class="arrow <?php if(($object['orderStatus']==0) OR ($object['orderStatus']==1) OR ($object['orderStatus']==2)): ?>arrow2<?php endif; ?>">··················></div>
	<div class="icon"><span class="icons <?php if(($object['orderStatus']==0)OR($object['orderStatus']==1)OR($object['orderStatus']==2)): ?>icon22 <?php else: ?>icon21<?php endif; if(($object['orderStatus']==0)): ?>icon23 <?php endif; ?>"></span></div>
	<div class="arrow <?php if(($object['orderStatus']==1) OR ($object['orderStatus']==2)): ?>arrow2<?php endif; ?>">··················></div>
<?php else: ?>
<div class="icon">
	<span class="icons <?php if(($object['orderStatus']==-2)OR($object['orderStatus']==0)OR($object['orderStatus']==1)OR($object['orderStatus']==2)): ?>icon12 <?php else: ?>icon11 <?php endif; if(($object['orderStatus']==0)): ?>icon13 <?php endif; ?>"></span>
</div>
<div class="arrow <?php if(($object['orderStatus']==1) OR ($object['orderStatus']==2)): ?>arrow2<?php endif; ?>">··················></div>
<?php endif; ?>
<div class="icon">
	<span class="icons <?php if(($object['orderStatus']==1)OR($object['orderStatus']==2)OR($object['orderStatus']==1)): ?>icon32 <?php else: ?>icon31 <?php endif; if(($object['orderStatus']==1)): ?>icon33 <?php endif; ?>"></span>
</div>
<div class="arrow <?php if(($object['orderStatus']==2)): ?>arrow2<?php endif; ?>">··················></div>
<div class="icon"><span class="icons  <?php if(($object['orderStatus']==2)AND($object['isAppraise']==1)): ?>icon42 <?php else: ?>icon41 <?php endif; if(($object['orderStatus']==2)AND($object['isAppraise']==0)): ?>icon43 <?php endif; ?>"></span></div>
<div class="arrow <?php if(($object['isAppraise']==1)): ?>arrow2<?php endif; ?>">··················></div>
<div class="icon"><span class="icons <?php if(($object['isAppraise']==1)): ?>icon53 <?php else: ?>icon51 <?php endif; ?>"></span></div>
</div>
   <div class="state2">
   <div class="path">
   <?php if(is_array($object['log']) || $object['log'] instanceof \think\Collection || $object['log'] instanceof \think\Paginator): $i = 0; $__LIST__ = $object['log'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lo): $mod = ($i % 2 );++$i;?>
   	<span><?php echo $lo['logContent']; ?><br/><?php echo $lo['logTime']; ?></span>
   <?php endforeach; endif; else: echo "" ;endif; ?>
   </div>
   <p>下单</p><?php if($object['payType']==1): ?><p>等待支付</p><?php endif; ?><p>商家发货</p><p>确认收货</p><p>订单结束<br/>双方互评</p>
   </div>
   <div class="wst-clear"></div>
   </div>
    <?php else: ?>
        <div>
          <table class='log'>
            <?php if(is_array($object["log"]) || $object["log"] instanceof \think\Collection || $object["log"] instanceof \think\Paginator): $i = 0; $__LIST__ = $object["log"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
             <tr>
               <td><?php echo $vo['logTime']; ?></td>
               <td><?php echo $vo['logContent']; ?></td>
             </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </table>
        </div>
    <?php endif; ?>
   </div>
   <!-- 订单信息 -->
   <div class='order-box'>
      <div class='box-head'>订单信息</div>
      <table class='wst-form'>
         <tr>
           <th width='100'>订单编号：</th>
           <td><?php echo $object['orderNo']; ?></td>
         </tr>
         <tr>
           <th>支付方式：</th>
           <td><?php echo WSTLangPayType($object['payType']); ?></td>
         </tr>
         <?php if(($object['payType']==1 && $object['isPay']==1)): ?>
         <tr>
           <th>支付时间：</th>
           <td><?php echo $object['payTime']; ?></td>
         </tr>
         <tr>
           <th>支付信息：</th>
           <td>【<?php echo WSTLangPayFrom($object['payFrom']); ?>】<?php echo $object['tradeNo']; ?></td>
         </tr>
         <?php endif; if(($object['orderType']==0)): ?>
         <tr>
            <th>配送方式：</th>
            <td><?php echo WSTLangDeliverType($object['deliverType']); ?></td>
         </tr>
          <?php endif; ?>
         <tr>
            <th valign="top">用户留言：</th>
            <td style='line-height: 20px'><?php echo $object['orderRemarks']; ?></td>
         </tr>
      </table>
   </div>

   <?php echo hook('homeDocumentOrderView',['orderId'=>$object['orderId']]); if($object['isRefund']==1): ?>
   <!-- 退款信息 -->
   <div class='order-box'>
      <div class='box-head'>退款信息</div>
      <table class='wst-form'>
         <tr>
            <th width='100'>退款金额：</th>
            <td>¥<?php echo $object['backMoney']; ?></td>
         </tr>
         <tr>
            <th width='100'>退款备注：</th>
            <td><?php echo $object['refundRemark']; ?></td>
         </tr>
         <tr>
            <th>退款时间：</th>
            <td><?php echo $object['refundTime']; ?></td>
         </tr>
      </table>
   </div>
   <?php endif; ?>
   <!-- 发票信息 -->
   <div class='order-box'>
      <div class='box-head'>发票信息</div>
      <table class='wst-form'>
         <tr>
           <th width='100'>是否需要发票：</th>
           <td><?php if($object['isInvoice']==1): ?>需要<?php else: ?>不需要<?php endif; ?></td>
         </tr>
         <?php if($object['isInvoice']==1): $invoiceArr = json_decode($object['invoiceJson'],true); ?>

          <tr>
          <th>发票状态：</th>
          <td><?php if($object['isMakeInvoice']==1): ?>已开<?php else: ?>未开<?php endif; ?></td>
      </tr>

         <tr>
           <th>发票抬头：</th>
           <td>
            <?php if($object['isInvoice']==1): ?>
              <?php echo $invoiceArr['invoiceHead']; ?>
            <?php endif; ?>
          </td>
         </tr>
        <?php if(isset($invoiceArr['invoiceCode'])): ?>
         <tr>
           <th>发票税号：</th>
           <td>
              <?php echo $invoiceArr['invoiceCode']; ?>
          </td>
         </tr>
         <?php endif; if(isset($invoiceArr['invoiceType']) && $invoiceArr['invoiceType']==1): ?>
          <tr>
              <th>注册地址：</th>
              <td>
                  <?php echo $invoiceArr['invoiceAddr']; ?>
              </td>
          </tr>
          <tr>
              <th>注册电话：</th>
              <td>
                  <?php echo $invoiceArr['invoicePhoneNumber']; ?>
              </td>
          </tr>
          <tr>
              <th>开户银行：</th>
              <td>
                  <?php echo $invoiceArr['invoiceBankName']; ?>
              </td>
          </tr>
          <tr>
              <th>银行账号：</th>
              <td>
                  <?php echo $invoiceArr['invoiceBankNo']; ?>
              </td>
          </tr>
          <?php endif; ?>
        <?php endif; ?>
      </table>
   </div>
   <!-- 收货人信息 -->
   <?php if(($object['orderType']==0)): if(($object['deliverType']==0)): ?>
       <div class='order-box'>
          <div class='box-head'>收货人信息</div>
          <table class='wst-form'>
             <tr>
               <th width='100'>收货人：</th>
               <td><?php echo $object['userName']; ?></td>
             </tr>
             <?php if(($object['deliverType']==0)): ?>
             <tr>
               <th>收货地址：</th>
               <td><?php echo $object['userAddress']; ?></td>
             </tr>
             <?php endif; ?>
             <tr>
                <th>联系方式：</th>
                <td><?php echo $object['userPhone']; ?></td>
             </tr>

          </table>
       </div>
        <?php if($object['expressData']): ?>
        <div class='order-box' id="expressDataBox">
            <div class='box-head'>物流信息</div>
            <div class='wst-form'>
                <?php if(is_array($object['expressData']) || $object['expressData'] instanceof \think\Collection || $object['expressData'] instanceof \think\Paginator): $i = 0; $__LIST__ = $object['expressData'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="wst-flex-row">
                    <div class="express-text">物流公司：</div>
                    <div class="express-val"><?php echo $vo['expressName']; ?></div>
                </div>
                <div class="wst-flex-row">
                    <div class="express-text">物流单号：</div>
                    <div class="express-val"><?php echo $vo['expressNo']; ?></div>
                </div>
                <?php if(($key+1)!=count($object['expressData'])): ?><div class="express-line"></div><?php endif; ?>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <?php endif; ?>
     <?php endif; if(($object['deliverType']==1)): ?>
       <div class='order-box'>
          <div class='box-head'>自提信息</div>
          <table class='wst-form'>
          <?php if(($object['deliverType']==1 && $object['verificationCode']>0 )): ?>
             <tr>
               <th>订单核验码：</th>
               <td><span class="vcode"><?php echo join(" ",str_split($object['verificationCode'],4));?></span></td>
             </tr>
             <?php endif; if((isset($object['store']))): ?>
            <tr>
               <th width='100'>自提门店：</th>
               <td><?php echo $object['store']['storeName']; ?></td>
             </tr>
             <tr>
               <th width='100'>联系电话：</th>
               <td><?php echo $object['store']['storeTel']; ?></td>
             </tr>
             <tr>
               <th width='100'>自提地址：</th>
               <td>
                   <div class="wst-flex-row wst-ac">
                       <p><?php echo $object['store']['areaNames']; ?><?php echo $object['store']['storeAddress']; ?></p>
                       <?php if(WSTConf('CONF.mapKey')!=''): ?>
                       <img class='location-icon' src="__STYLE__/img/location-icon.png"/><a href="https://apis.map.qq.com/uri/v1/search?keyword=<?php echo $object['store']['storeAddress']; ?>&referer=<?php echo WSTConf('CONF.mapKey'); ?>" target="_blank">导航去这里</a>
                       <?php endif; ?>
                   </div>
               </td>
             </tr>
              <?php if(WSTConf('CONF.mapKey')!=''): ?>
              <tr>
                  <th width='100'>自提点位置：</th>
                  <td>
                      <input type="hidden" id="latitude" value="<?php echo $object['store']['latitude']; ?>">
                      <input type="hidden" id="longitude" value="<?php echo $object['store']['longitude']; ?>">
                      <input type="hidden" id="storeName" value="<?php echo $object['store']['storeName']; ?>">
                      <div class="store-position">
                          <div class="map"  id="container"></div>
                      </div>
                  </td>
              </tr>
              <?php endif; else: ?>
            <tr>
            <th width='100'>自提地址：</th>
                <td>
                    <div class="wst-flex-row wst-ac">
                        <p><?php echo $object['shopAddress']; ?></p>
                        <?php if(WSTConf('CONF.mapKey')!=''): ?>
                        <img class='location-icon' src="__STYLE__/img/location-icon.png"/><a href="https://apis.map.qq.com/uri/v1/search?keyword=<?php echo $object['shopAddress']; ?>&referer=<?php echo WSTConf('CONF.mapKey'); ?>" target="_blank">导航去这里</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php if(WSTConf('CONF.mapKey')!=''): ?>
            <tr>
                <th width='100'>自提点位置：</th>
                <td>
                    <input type="hidden" id="latitude" value="<?php echo $object['latitude']; ?>">
                    <input type="hidden" id="longitude" value="<?php echo $object['longitude']; ?>">
                    <input type="hidden" id="storeName" value="<?php echo $object['shopName']; ?>">
                    <div class="store-position">
                        <div class="map"  id="container"></div>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
            <?php endif; ?>
          </table>
       </div>
     <?php endif; ?>
   <?php endif; ?>
   <!-- 商品信息 -->
   <div class='order-box'>
       <div class='box-head'>商品清单</div>
       <div class='goods-head'>
          <div class='goods'>商品</div>
          <div class='price'>单价</div>
          <div class='num'>数量</div>
          <div class='t-price'>总价</div>
       </div>
       <div class='goods-item'>
          <div class='shop'>
          <?php echo $object['shopName']; if($object['shopQQ'] !=''): ?>
          <a href="tencent://message/?uin=<?php echo $object['shopQQ']; ?>&Site=QQ交谈&Menu=yes">
			  <img border="0" style='vertical-align:middle;' src="<?php echo WSTProtocol(); ?>wpa.qq.com/pa?p=1:<?php echo $object['shopQQ']; ?>:7" alt="QQ交谈" width="71" height="24" />
		  </a>
          <?php endif; if($object['shopWangWang'] !=''): ?>
          <a target="_blank" href="<?php echo getWeliveUrl("客户服务"); ?>">
			  <img border="0" style='vertical-align:middle;' src="<?php echo WSTProtocol(); ?>amos.alicdn.com/realonline.aw?v=2&uid=<?php echo $object['shopWangWang']; ?>&site=cntaobao&s=1&charset=utf-8" alt="和我联系" />
		  </a>
          <?php endif; ?>
          </div>
          <div class='goods-list'>
             <?php if(is_array($object["goods"]) || $object["goods"] instanceof \think\Collection || $object["goods"] instanceof \think\Paginator): $i = 0; $__LIST__ = $object["goods"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
             <?php echo hook('homeDocumentOrderViewGoodsPromotion',['goods'=>$vo2]); ?>
             <div class='item j-g<?php echo $vo2['goodsId']; ?>'>
		        <div class='goods'>
		            <div class='img'>
		                <a href='<?php echo Url("home/goods/detail","goodsId=".$vo2["goodsId"]); ?>' target='_blank'>
			            <img src='__RESOURCE_PATH__/<?php echo $vo2["goodsImg"]; ?>' width='80' height='80' title='<?php echo WSTStripTags($vo2["goodsName"]); ?>'/>
			            </a>
		            </div>
		            <div class='name'><?php if($vo2['goodsCode']=='gift'): ?>【赠品】<?php endif; ?><?php echo $vo2["goodsName"]; ?></div>
		            <div class='spec'><?php echo str_replace('@@_@@','<br/>',$vo2["goodsSpecNames"]); ?></div>
		        </div>
		        <div class='price'>¥<?php echo $vo2['goodsPrice']; ?></div>
		        <div class='num'><?php echo $vo2['goodsNum']; ?></div>
		        <div class='t-price'>¥<?php echo $vo2['goodsPrice']*$vo2['goodsNum']; ?></div>
		        <div class='wst-clear'></div>
             </div>
             <?php if($vo2['goodsType']==1 && $object['orderStatus']==2): ?>
             <table width='100%' style='margin-top:5px;'>
             <?php if(is_array($vo2["extraJson"]) || $vo2["extraJson"] instanceof \think\Collection || $vo2["extraJson"] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo2["extraJson"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vgcard): $mod = ($i % 2 );++$i;?>
               <tr>
                 <td>卡券号：<?php echo $vgcard['cardNo']; ?></td>
                 <td>卡券密码：<?php echo $vgcard['cardPwd']; ?></td>
               </tr>
             <?php endforeach; endif; else: echo "" ;endif; ?>
             </table>
             <?php endif; ?>
             <?php endforeach; endif; else: echo "" ;endif; ?>
          </div>
       </div>
       <div class='goods-footer'>
          <div class='goods-summary' style='text-align:right'>
             <div class='summary'>商品总金额：¥<span><?php echo $object['goodsMoney']; ?></span></div>
             <div class='summary'>运费：¥<span><?php echo $object['deliverMoney']; ?></span></div>
             <div class='summary line'>应付总金额：¥<span><?php echo $object['totalMoney']; ?></span></div>
             <?php echo hook('homeDocumentOrderSummaryView',['order'=>$object]); if($object['useScore'] > 0): ?>
             <div class='summary '>使用积分数：<span><?php echo $object['useScore']; ?>个</span></div>
             <div class='summary '>积分抵扣金额：¥-<span><?php echo $object['scoreMoney']; ?></span></div>
             <?php endif; ?>
             <div class='summary'>实付总金额：¥<span><?php echo $object['realTotalMoney']; ?></span></div>
             <div>可获得积分：<span class='orderScore'><?php echo $object["orderScore"]; ?></span>个</div>
          </div>
       </div>
   </div>
</div>

            </div>
          </div>
          <div style='clear:both;'></div>
          <br/>
</div>

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


<script charset="utf-8" src="<?php echo WSTProtocol(); ?>map.qq.com/api/js?v=2.exp&key=<?php echo WSTConf('CONF.mapKey'); ?>"></script>
<script type='text/javascript' src='__STYLE__/users/orders/orders.js?v=<?php echo $v; ?>'></script>
<?php if(($object['deliverType']==1)): ?>
<script>
    $(function(){
        storeMap();
    })
</script>
<?php endif; ?>

<script>
function getMenus(menuId,menuUrl){
    $.post(WST.U('home/index/getMenuSession'), {menuId:menuId}, function(data){
      if(menuUrl.indexOf('http://')>-1 || menuUrl.indexOf('https://')>-1){
          location.href=menuUrl;
      }else{
          location.href=WST.U(menuUrl);
      }
    });
}
</script>
</body>
</html>