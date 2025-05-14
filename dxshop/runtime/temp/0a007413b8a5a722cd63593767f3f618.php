<?php /*a:4:{s:89:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\users\orders\list_wait_receive.html";i:1669880526;s:69:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\users\base.html";i:1669879436;s:62:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\top.html";i:1738420029;s:65:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\footer.html";i:1738136898;}*/ ?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>待收货订单 - 会员中心</title>
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/layui/css/layui.css"/>
<link href="__STYLE__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/user.css?v=<?php echo $v; ?>" rel="stylesheet">


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
            
  <div class="wst-user-head"><span>待收货订单</span></div>
  <div class='wst-user-tbar'>
     订单号：<input type='text'  class="u-query" id='orderNo'/> 
     店铺名称：<input type='text' class="u-query" id='shopName'/> 
     <button class="wst-sec-but u-btn" onclick="waitReceiveByPage()">查询</button>
  </div>
  <div class='wst-user-content'>
    <table class='wst-order-list'>
       <thead>
	      <tr class='head'>
	         <th>订单详情</th>
           <th width="115">支付方式/配送信息</th>
           <th width="150">金额</th>
           <th width="110">操作</th>
	      </tr>
	   </thead>
	   <tbody id='loadingBdy'>
	       <tr id='loading' class='empty-row' style='display:none'>
	            <td colspan='4'><img src="__STYLE__/img/loading.gif">正在加载数据...</td>
	       </tr>
       </tbody>
       <script id="tblist" type="text/html">
       {{# for(var i = 0; i < d.length; i++){ }}
       <tbody class="j-order-row">
         <tr class='empty-row'>
            <td colspan='4'>&nbsp;</td>
         </tr>
         <tr class='order-head'>
            <td colspan='4' align='right'>
              <div class='time'>{{d[i].createTime}}</div>
              <div class='orderno'>订单号：{{d[i].orderNo}}
    			    {{# if(d[i].orderSrc==0){ }}<i class="fa fa-desktop"></i>
              {{# }else if(d[i].orderSrc==1){ }}<i class="fa fa-wechat"></i>
              {{# }else if(d[i].orderSrc==2){ }}<i class="fa fa-mobile fa-lg"></i>
              {{# }else if(d[i].orderSrc==3){ }}<i class="fa fa-android"></i>
              {{# }else if(d[i].orderSrc==4){ }}<i class="fa fa-apple"></i>
              {{# }else if(d[i].orderSrc==5){ }}<i class="fa fa-gg-circle"></i>
              {{# } }}	
              {{# if(d[i].orderCodeTitle!=""){ }}
                <span class="order_from">{{d[i].orderCodeTitle}}</span>
              {{# } }}
    			  </div>
              <div class='shop'>{{d[i].shopName}}</div>
              <div class='link'>{{-WST.shopQQ(d[i].shopQQ)}}{{-WST.shopWangWang(d[i].shopWangWang)}}</div>
              <div>
               {{d[i].status}}
               {{#if(d[i].orderStatus==0){}}&nbsp;|&nbsp;<a href='#none' onclick='javascript:cancel({{d[i].orderId}},1)'>取消订单</a>{{# } }}
              </div>
            </td>
         </tr>
         {{# 
            var tmp = null,rows = d[i]['list'].length;
            for(var j = 0; j < d[i]['list'].length; j++){ 
            tmp = d[i]['list'][j];
         }}
         <tr class='goods-box'>
            <td>
               <div class='goods-img'>
                <a href="{{WST.U('home/goods/detail','goodsId='+tmp.goodsId)}}" target='_blank'>
                <img data-original='__RESOURCE_PATH__/{{tmp.goodsImg}}'  title='{{tmp.goodsName}}' class="gImg">
                </a>
               </div>
               <div class='goods-name'>
                 <div>{{tmp.goodsName}}</div>
                 <div>{{tmp.goodsSpecNames}}</div>
               </div>
               <div class='goods-extra'>{{tmp.goodsPrice}} x {{tmp.goodsNum}}</div>
            </td>
            {{#if(j==0){}}
            <td class="wst-align-center" rowspan="{{rows}}">
                <div>{{d[i].payTypeName}}</div>
                <div>{{d[i].deliverTypeName}}</div>
            </td>
            <td rowspan="{{rows}}">
                <div>商品金额：¥{{d[i].goodsMoney}}</div>
                <div class='line'>运费：¥{{d[i].deliverMoney}}</div>
                <div>实付金额：¥{{d[i].realTotalMoney}}</div>
            </td>
            <td class="wst-align-center" rowspan="{{rows}}">
                {{#if(d[i].orderStatus==0 && d[i].noticeDeliver==0){}}
                <div>
                  <a href='#none' onclick='javascript:noticeDeliver({{d[i].orderId}})'>【提醒发货】</a>
                </div>
                {{# } }}

                {{#if(d[i].orderStatus==1){}}
                <div>
                <a href='#none' onclick='javascript:toReceive({{d[i].orderId}})'>【确认收货】</a>
                </div>
                <div>
                <a href='#none' onclick='javascript:toReject({{d[i].orderId}})'>【拒绝收货】</a>
                </div>
                {{# } }}
                <div><a href='#none' onclick="view({{d[i].orderId}},'waitReceive')">【订单详情】</a></div>

                {{# if(d[i].isComplain==''){ }}
                <div><a href='#none' onclick='complain({{d[i].orderId}},"waitReceive")'>【订单投诉】</a></div>
                {{# } }}
            </td>
            {{#}}}
         </tr>
         {{# } }}
         <tr>
          <td colspan="4">
            {{# if(WST.blank(d[i].orderRemarks)!=''){  }}
               <div class="order_remaker">【我的留言】{{d[i].orderRemarks}}</div>
             {{# }  }}
          </td>
         </tr>
       </tbody>
       {{# } }}
       </script>
       <tr class='empty-row'>
            <td colspan='4' id='pager' align="center" style='padding:5px 0px 5px 0px'>&nbsp;</td>
       </tr>
    </table>
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


<script type='text/javascript' src='__STYLE__/users/orders/orders.js?v=<?php echo $v; ?>'></script>
<script>
$(function(){
	waitReceiveByPage(<?php echo $p; ?>);
})
</script>

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