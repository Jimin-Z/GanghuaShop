<?php /*a:5:{s:73:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\shop_join_step.html";i:1669886710;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\base.html";i:1669564406;s:62:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\top.html";i:1738420029;s:65:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\header.html";i:1737808836;s:65:"D:\wamp\www\hkshopNC\dxshop\wstmart\home\view\default\footer.html";i:1738136898;}*/ ?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $currStep['flowName']; ?> - 商家入驻 - <?php echo WSTConf('CONF.mallName'); ?></title>

<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__STYLE__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet">

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



<link rel="stylesheet" type="text/css" href="/hkshopNC/dxshop/static/plugins/webuploader/webuploader.css?v=<?php echo $v; ?>" />
<link href="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="__STYLE__/css/shopapply.css?v=<?php echo $v; ?>" rel="stylesheet">
<div class="wst-container">
    <input type="hidden" id="flowId" value="<?php echo $flowId; ?>">
    <div class="flow-container">
        <div id="stepflex" class="stepflex">
            <?php if(is_array($shopFlows) || $shopFlows instanceof \think\Collection || $shopFlows instanceof \think\Paginator): $i = 0; $__LIST__ = $shopFlows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <dl class="first <?php if($vo['sort'] <= $currStep['sort']): ?>doing<?php endif; ?>">
                <dt class="<?php if($vo['sort'] <= $currStep['sort']): ?>s-num<?php else: ?>s-num1<?php endif; ?>"><?php echo $key+1; ?></dt>
                <dd class="<?php if($vo['sort'] <= $currStep['sort']): ?>s-text<?php else: ?>s-text1<?php endif; ?>"><?php echo $vo['flowName']; ?></dd>
                <dd></dd>
            </dl>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div class='wst-clear'></div>
    <div class='main-head'><?php echo $currStep['flowName']; ?></div>
    <?php if($flowId==1): ?>
        <div class='apply-agreement-box'>
         <?php $article = WSTTable('articles',['articleId'=>109],'articleContent'); ?>
         <?php echo htmlspecialchars_decode($article['articleContent']); ?>
        </div>
        <form id='applyFrom' autocomplete='off'>
        <div class='agreement_box'>
          <label>
             <input type='checkbox' id="protocol" onclick='checkProtocol(this)' name="protocol" data-rule="checked" data-target="#protocolTip" data-msg-checked="必须同意协议才能申请入驻"/>我已阅读并同意以上协议
          </label>
          <span id='protocolTip' class="msg-box"></span>
          </span>
        </div>
        </form>
    <?php elseif($flowId==4): if($pkey && $apply['applyStatus']==0): ?>
        <div class='apply-box'>
            <?php if($payStep==1): ?>
            <input type="hidden" id="pkey" value="<?php echo $pkey; ?>">
            <div>
                <div class="pay-tip1"></div>
            </div>
            <div class='pay-sbox'>
                <div class="tips-box">
                    请及时付款，以便快速处理您的入驻申请，在线实付年费金额(年费为店铺所属行业的类目费用)<span class="wst-fred">&nbsp;¥<?php echo $catFee; ?>&nbsp;</span>
                </div>
                <div class="pay-type">选择支付方式</div>
                <div class="pay-list">
                    <input type="hidden" id="payCode" name="payCode" />
                    <?php if(is_array($payments) || $payments instanceof \think\Collection || $payments instanceof \think\Paginator): $i = 0; $__LIST__ = $payments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$payment): $mod = ($i % 2 );++$i;if($payment['isOnline'] == 1): ?>
                    <div class="wst-payCode-<?php echo $payment['payCode']; ?>" data="<?php echo $payment['payCode']; ?>"></div>
                    <?php endif; ?>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <div class="wst-clear"></div>
                </div>
                <div class="bnt-box">
                    <div onclick='javascript:getPayUrl();' class="wst-pay-bnt"></div>
                </div>
            </div>
            <div id="alipayform" style="display:none;"></div>
            <?php elseif($payStep==2): if($payType=='weixinpays'): ?>
                    <div>
                        <div class="pay-tip2"></div>
                    </div>
                    <div class='pay-sbox' >
                        <div class="qrcode-box">
                            <div class="pbox">
                                请您扫描以下二维码，支付年费金额：<span class="wst-fred">￥<?php echo $needPay; ?></span>
                            </div>
                            <div id="qrcode" class="wst-qrcode"></div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" id="token" value='<?php echo WSTConf("CONF.pwdModulusKey"); ?>'/>
                    <div>
                        <div class="pay-tip2"></div>
                    </div>
                    <div class='pay-sbox'>
                        <div class="balance-box">
                            <div class='tips-box'>待支付年费总额：<span class="wst-fred">￥<?php echo $needPay; ?></span></div>
                            <div class='wst-wallet-box'>
                                <div class='wst-wallte-item'>
                                    钱包余额：<span class="wst-fred">￥<?php echo $userMoney; ?></span>
                                </div>
                                <div style='float:right;'>支付：<span class="wst-fred">￥<?php echo $needPay; ?></span></div>
                            </div>
                            <?php if(($userMoney>=$needPay)): ?>
                            <div class="pbox">
                                <input type='hidden' id='pkey' value='<?php echo $pkey; ?>' class='j-ipt' autocomplete="off" />
                                <?php if(($hasPayPwd==1)): ?>
                                支付密码：<input type='password' class='u-query j-ipt' id='payPwd' autocomplete='off'>
                                <a class='pbox-tip' maxlength='6' href='<?php echo url("home/users/editPayPass"); ?>'>忘记密码?</a>
                                <?php else: ?>
                                您尚未设置支付密码，请先设置支付密码
                                <div id="paypwd-box" class="j-paypwd-box" style="display:none;padding:20px;">
                                    <table class="wst-table">
                                        <tr class="wst-login-tr">
                                            <td align='right'>支付密码：</td>
                                            <td><input type="password" class='j-ipt' id="payPwd" name="payPwd" style="width:250px;" maxlength="6" aria-required="true"></td>
                                        </tr>
                                        <tr class="wst-login-tr">
                                            <td align='right'>确认支付密码：</td>
                                            <td><input type="password" class="ipt n-invalid" id="reNewPass" name="reNewPass" style="width:250px;" maxlength="6" aria-required="true" aria-invalid="true"></td>
                                        </tr>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="pbox2">
                                <?php if(($hasPayPwd==1)): ?>
                                <button class="pay-btn" type="button" style="width:100px;height: 30px;" onclick='javascript:payByWallet()'>确认支付</button>
                                <?php else: ?>
                                <button class="pay-btn" type="button" style="width:100px;height: 30px;" onclick='javascript:setPaypwd()'>去设置支付密码</button>
                                <?php endif; ?>
                            </div>
                            <?php else: ?>
                            <div class="pbox">
                                <img src='__STYLE__/img/icon_jinggao.png'>&nbsp;很抱歉，您的钱包余额不足，不能进行支付。<a class='pbox-tip' href='javascript:void(0)' onclick="javascript:history.go(-1)">返回上一页</a>。
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class='apply-box'>
            <div class='examine-tips'>
                <?php if($apply['applyStatus']==1): ?>
                <img src='/hkshopNC/dxshop/wstmart/home/view/default/img/examine.png' style="vertical-align:middle"/>&nbsp;
                您的入驻申请已提交审核，请等待审核结果...
                <?php endif; if($apply['applyStatus']==-1): ?>
                <img src='/hkshopNC/dxshop/wstmart/home/view/default/img/error_1.png' style="vertical-align:middle"/>
                很抱歉，您的入驻申请因【<?php echo $apply['applyDesc']; ?>】审核不通过。。。
                <div style='clear:both;'></div>
                <?php endif; if($apply['applyStatus']==2): ?>
                <img src='/hkshopNC/dxshop/wstmart/home/view/default/img/apply-ok.png' style="vertical-align:middle"/>&nbsp;
                您的入驻申请已通过，赶紧开始上架商品吧~
                <?php endif; ?>
            </div>
        </div>
        <?php endif; else: ?>
        <div <?php if($stepFields): ?>class='apply-box'<?php else: ?>class='apply-box2'<?php endif; ?>>
            <form id='applyFrom' autocomplete='off'>
                <table class='agreement-table' style='margin-top:10px;margin-bottom:10px;'>
                <?php if(is_array($stepFields) || $stepFields instanceof \think\Collection || $stepFields instanceof \think\Paginator): $i = 0; $__LIST__ = $stepFields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;switch($vo['fieldType']): case "input": if($vo['isShow']==1): ?>
                            <tr <?php if($vo['isRelevance']): ?>id="<?php echo $vo['fieldName']; ?>Tr"<?php endif; if($vo['isRelevance'] && $apply[$vo['fieldRelevance']] == 0): ?>style='display:none;'<?php endif; ?> >
                                <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                                <td>
                                    <?php if($vo['isRelevance']): ?>
                                    <input type='text' id="<?php echo $vo['fieldName']; ?>" class='a-ipt' <?php if($vo['isRequire']==1): ?>data-rule="<?php echo $vo['fieldTitle']; ?>:required(#<?php echo $vo['fieldRelevance']; ?>1:checked)"<?php endif; ?>  value="<?php echo $apply[$vo['fieldName']]; ?>" maxlength="<?php echo $vo['fieldAttr']; ?>" /><?php if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><?php endif; else: ?>
                                    <input type='text' id="<?php echo $vo['fieldName']; ?>" class='a-ipt' <?php if($vo['isRequire']==1): ?>data-rule="<?php echo $vo['fieldTitle']; ?>:required;"<?php endif; ?> value="<?php echo $apply[$vo['fieldName']]; ?>" maxlength="<?php echo $vo['fieldAttr']; ?>" /><?php if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; break; case "textarea": if($vo['isShow']==1): $fieldAttr = explode(',',$vo['fieldAttr']); ?>
                        <tr>
                            <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                            <td>
                                <textarea id="<?php echo $vo['fieldName']; ?>" class='a-ipt' rows="<?php echo $fieldAttr[0]; ?>" cols="<?php echo $fieldAttr[1]; ?>" <?php if($vo['isRequire']==1): ?>data-rule="<?php echo $vo['fieldTitle']; ?>:required;"<?php endif; ?>><?php echo $apply[$vo['fieldName']]; ?></textarea>
                                <?php if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; break; case "radio": if($vo['isShow']==1): $fieldAttr = explode(',',$vo['fieldAttr']); ?>
                        <tr>
                            <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                            <td>
                                <?php if(is_array($fieldAttr) || $fieldAttr instanceof \think\Collection || $fieldAttr instanceof \think\Paginator): $i = 0; $__LIST__ = $fieldAttr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;$fieldAttrValue = explode('||',$voo); ?>
                                <label>
                                    <input type='radio' name="<?php echo $vo['fieldName']; ?>"  id="<?php echo $vo['fieldName']; ?><?php echo $fieldAttrValue[0]; ?>" class='a-ipt' value="<?php echo $fieldAttrValue[0]; ?>" onclick='javascript:WST.showHide(<?php echo $fieldAttrValue[0]; ?>,"#<?php echo $vo['fieldRelevance']; ?>Tr")' <?php if($apply[$vo['fieldName']]==$fieldAttrValue[0]): ?>checked<?php endif; ?>/><?php echo $fieldAttrValue[1]; ?>
                                </label>
                                <?php endforeach; endif; else: echo "" ;endif; if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; break; case "checkbox": if($vo['fieldAttr'] == 'custom'): ?>
                        <tr>
                            <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                            <td>
                                <?php $_result=WSTGoodsCats(0);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?>
                                <label class='goodsCat'>
                                    <input type='checkbox' class='a-ipt goods-cat' name="<?php echo $vo['fieldName']; ?>" value='<?php echo $voo["catId"]; ?>' <?php if($i == 1): ?>data-rule="<?php echo $vo['fieldTitle']; ?>:checked" <?php endif; if(array_key_exists($voo['catId'],$apply['catshops'])): ?>checked<?php endif; ?> data-target="#msg_<?php echo $vo['fieldName']; ?>"/><?php echo $voo["catName"]; ?>
                                </label>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                <span class='msg-box' id="msg_<?php echo $vo['fieldName']; ?>"></span>
                            </td>
                        </tr>

                        <?php else: if($vo['isShow']==1): $fieldAttr = explode(',',$vo['fieldAttr']); ?>
                                <tr >
                                    <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                                    <td>
                                        <?php if(is_array($fieldAttr) || $fieldAttr instanceof \think\Collection || $fieldAttr instanceof \think\Paginator): $i = 0; $__LIST__ = $fieldAttr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;$fieldAttrValue = explode('||',$voo); ?>
                                        <label>
                                            <input type='checkbox' name="<?php echo $vo['fieldName']; ?>"  id="<?php echo $vo['fieldName']; ?>" class='a-ipt' value="<?php echo $fieldAttrValue[0]; ?>"  <?php if($vo['isRequire'] == 1): ?>data-rule="<?php echo $vo['fieldTitle']; ?>:checked" <?php endif; if($apply[$vo['fieldName']]==$fieldAttrValue[0]): ?>checked<?php endif; ?>/><?php echo $fieldAttrValue[1]; ?>
                                        </label>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </td>
                                    <?php if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><?php endif; ?>
                                </tr>
                            <?php endif; ?>
                        <?php endif; break; case "select": if($vo['isShow']==1):  if($vo['fieldAttr']!='custom')$fieldAttr = explode(',',$vo['fieldAttr']); if($vo['fieldName']=='tradeId'): ?>
                        <tr>
                            <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                            <td>
                                <select id="<?php echo $vo['fieldName']; ?>" class='a-ipt' onchange="changeCatFee(this)" style="width: auto;">
                                    <?php $_result=WSTTrades(0);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$td): $mod = ($i % 2 );++$i;?>
                                    <option tradeFee="<?php echo $td['tradeFee']; ?>" value="<?php echo $td['tradeId']; ?>" <?php if($apply[$vo['fieldName']]==$td['tradeId']): ?>selected<?php endif; ?>><?php echo $td['tradeName']; ?> (<?php echo $td['tradeFee']; ?>元)</option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <?php if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>年费：</th>
                            <td><span id="totalCatFee">0</span>元（年费为店铺所属行业的类目费用）</td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                            <td>
                                <select id="<?php echo $vo['fieldName']; ?>" class='a-ipt'>
                                    <?php if($vo['fieldAttr']!='custom'): if(is_array($fieldAttr) || $fieldAttr instanceof \think\Collection || $fieldAttr instanceof \think\Paginator): $i = 0; $__LIST__ = $fieldAttr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;$fieldAttrValue = explode('||',$voo); ?>
                                            <option value="<?php echo $fieldAttrValue[0]; ?>" <?php if($apply[$vo['fieldName']]==$fieldAttrValue[0]): ?>selected<?php endif; ?> ><?php echo $fieldAttrValue[1]; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; else: 
                                            $banks = WSTTable('banks',['dataFlag'=>1,'isShow'=>1],'bankId,bankName',100);
                                            foreach($banks as $aky => $bank){
                                         ?>
                                            <option value="<?php echo $bank['bankId']; ?>" <?php if($apply[$vo['fieldName']]==$bank['bankId']): ?>selected<?php endif; ?>><?php echo $bank['bankName']; ?></option>
                                        <?php } ?>
                                    <?php endif; ?>
                                </select>
                                <?php if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>


                        <?php endif; break; case "other": switch($vo['fieldAttr']): case "area": if($vo['isShow']==1): ?>
                                <tr>
                                    <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                                    <td>
                                        <select id="<?php echo $vo['fieldName']; ?>_0" class="j-<?php echo $vo['fieldName']; ?>" data-name="<?php echo $vo['fieldName']; ?>" level="0" onchange="changeArea(this)" data-value="<?php echo $apply[$vo['fieldName']]; ?>">
                                            <option value="">-请选择-</option>
                                            <?php 
                                            $areas = WSTTable('areas',['isShow'=>1,'dataFlag'=>1,'parentId'=>0],'areaId,areaName',100,'areaSort desc');
                                            foreach($areas as $aky => $area){
                                             ?>
                                            <option value="<?php echo $area['areaId']; ?>"><?php echo $area['areaName']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php if($vo['isMap']): if((WSTConf('CONF.mapKey'))): ?> <button type='button' class='map-btn' data-name="<?php echo $vo['fieldName']; ?>" onclick="javascript:mapCity(this)" "><i class='fa fa-map-marker'></i>地图定位</button><?php endif; ?>
                                        <?php endif; if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><br><?php endif; ?>
                                    </td>
                                </tr>
                                <?php if($vo['isMap']): if((WSTConf('CONF.mapKey'))): ?>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <td>
                                                <div id="container"  style='width:700px;height:400px'></div>
                                                <input type='hidden' id='mapLevel' class='a-ipt'  value="<?php echo $apply['mapLevel']; ?>"/>
                                                <input type='hidden' id='longitude' class='a-ipt'  value="<?php echo $apply['longitude']; ?>"/>
                                                <input type='hidden' id='latitude' class='a-ipt'  value="<?php echo $apply['latitude']; ?>"/>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php endif; break; case "date": if($vo['isShow']==1): ?>
                                    <tr>
                                        <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                                        <td>
                                            <input type='text' id="<?php echo $vo['fieldName']; ?>" readonly class='a-ipt laydate-icon' <?php if($vo['isRequire']==1): ?>data-rule="<?php echo $vo['fieldTitle']; ?>:required;"<?php endif; ?> data-target="#msg_<?php echo $vo['fieldName']; ?>" data-timely="2" value="<?php echo $apply[$vo['fieldName']]; ?>"/>
                                            <script>$(function(){layui.laydate.render({elem: "#<?php echo $vo['fieldName']; ?>"});})</script>
                                            <?php if($vo['dateRelevance']): $dateRelevance = explode(',',$vo['dateRelevance']); if(array_key_exists($dateRelevance[0],$apply) && array_key_exists($dateRelevance[1],$apply)): ?>
                                                    - <input type='text' id="<?php echo $dateRelevance[0]; ?>" readonly class='a-ipt laydate-icon'  data-timely="2" value="<?php echo $apply[$dateRelevance[0]]; ?>" <?php if($apply[$dateRelevance[1]]==1): ?>style='display:none'<?php endif; ?> />&nbsp;&nbsp;&nbsp;<label><input type='checkbox' name='<?php echo $dateRelevance[1]; ?>' id='<?php echo $dateRelevance[1]; ?>' class='a-ipt' onclick='WST.showHide(this.checked?0:1,"#<?php echo $dateRelevance[0]; ?>")' <?php if($apply[$dateRelevance[1]]==1): ?>checked<?php endif; ?>  value='1'/><?php echo $dateRelevance[2]; ?></label>
                                                    <script>$(function(){layui.laydate.render({elem: "#<?php echo $dateRelevance[0]; ?>"});})</script>
                                                    <?php endif; ?>
                                            <?php endif; if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><br><?php endif; ?>
                                            <span class='msg-box' id="msg_<?php echo $vo['fieldName']; ?>"></span>
                                        </td>
                                    </tr>
                                <?php endif; break; case "time": if($vo['isShow']==1): ?>
                                    <tr>
                                        <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                                        <td>
                                            <select class='a-ipt time-component' id="<?php echo $vo['fieldName']; ?>" v="<?php echo $apply[$vo['fieldName']]; ?>"></select>
                                            <?php if($vo['timeRelevance']): ?>
                                                至
                                                <select class='a-ipt time-component' id="<?php echo $vo['timeRelevance']; ?>" v="<?php echo $apply[$vo['timeRelevance']]; ?>"></select>
                                            <?php endif; if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; break; case "file": if($vo['isShow']==1): ?>
                                <tr>
                                    <th <?php if($vo['fieldComment']): ?>valign="top" style='padding-top:16px;'<?php endif; ?>><?php echo $vo['fieldTitle']; if($vo['isRequire']==1): ?><font color='red'>*</font><?php endif; ?>：</th>
                                    <td>
                                        <input type='hidden' id="<?php echo $vo['fieldName']; ?>" fileNum="<?php echo $vo['fileNum']; ?>" class='a-ipt' <?php if($vo['isRequire']==1): ?>data-rule="<?php echo $vo['fieldTitle']; ?>:required;"<?php endif; ?> data-target="#msg_<?php echo $vo['fieldName']; ?>" value="<?php echo $apply[$vo['fieldName']]; ?>"/>
                                        <div id="<?php echo $vo['fieldName']; ?>Picker" class="upload-picker">请上传<?php echo $vo['fieldTitle']; ?></div>
                                        <span id="<?php echo $vo['fieldName']; ?>Msg"></span>
                                        <div id="<?php echo $vo['fieldName']; ?>Box"></div>
                                        <?php if((int)$vo['fileNum']>1): $imgArr = array_filter(explode(',',$apply[$vo['fieldName']])); ?>
                                        <div id="<?php echo $vo['fieldName']; ?>ImgBox">
                                            <?php if(is_array($imgArr) || $imgArr instanceof \think\Collection || $imgArr instanceof \think\Paginator): $i = 0; $__LIST__ = $imgArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?>
                                            <div style="width:75px;float:left;margin-right:5px;">
                                                <a href='__RESOURCE_PATH__/<?php echo $voo; ?>' target='_blank'>
                                                    <img class="<?php echo $vo['fieldName']; ?>_step_pic" width="75" height="75" src="__RESOURCE_PATH__/<?php echo $voo; ?>" v="<?php echo $voo; ?>">
                                                </a>
                                                <div style="position:relative;top:-80px;left:60px;cursor:pointer;background: rgba(0,0,0,0.5);width: 18px;height: 18px;text-align: center;border-radius: 50%;" onclick='javascript:delVO(this)' selector="<?php echo $vo['fieldName']; ?>">
                                                    <img src="/hkshopNC/dxshop/wstmart/home/view/default/img/seller_icon_error.png">
                                                </div>
                                            </div>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </div>
                                        <?php else: ?>
                                        <img id="<?php echo $vo['fieldName']; ?>Preview" src="__RESOURCE_PATH__/<?php echo $apply[$vo['fieldName']]; ?>" <?php if($apply[$vo['fieldName']] ==''): ?>style='display:none'<?php endif; ?> width='150'>
                                        <?php endif; if($vo['fieldComment']): ?><div class="c-tip"><?php echo htmlspecialchars_decode($vo['fieldComment']); ?></div><br><?php endif; ?>
                                        <span class='msg-box' id="msg_<?php echo $vo['fieldName']; ?>"></span>
                                    </td>
                                </tr>
                                <?php endif; break; default: ?>
                        <?php endswitch; break; default: ?>
                <?php endswitch; ?>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                 </table>
            </form>
        </div>
    <?php endif; if(!empty($nextStep)): ?>
     <div class='agreement-bottom'>
        <?php if(!empty($prevStep)): ?>
        <a href="<?php echo url('home/shops/joinStepNext','id='.$prevStep['flowId']); ?>" class='btn-cancel'>上一步</a>
        <?php else: ?>
        <a href="<?php echo url('home/shops/join'); ?>" class='btn-cancel'>上一步</a>
        <?php endif; ?>
        <a class='btn-submit'  href='javascript:saveStep(<?php echo $flowId; ?>,<?php echo $nextStep['flowId']; ?>)'>下一步</a>
        <div class='wst-clear'></div>
     </div>
    <?php endif; ?>
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


<script type="text/javascript" src="/hkshopNC/dxshop/static/js/rsa.js"></script>
<script charset="utf-8" src="<?php echo WSTProtocol(); ?>map.qq.com/api/js?v=2.exp&key=<?php echo WSTConf('CONF.mapKey'); ?>"></script>
<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>'></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.min.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='__STYLE__/js/apply.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='/hkshopNC/dxshop/static/js/qrcode.js?v=<?php echo $v; ?>'></script>
<script>
    $(function() {
        $(".upload-picker").each(function (idx, item) {
            var id_selector = $(item).prev().attr('id');
            if(id_selector=='shopImg'){
                WST.upload({
                    pick: "#" + id_selector + 'Picker',
                    formData: {dir: 'shops',isThumb:1},
                    accept: {extensions: 'gif,jpg,jpeg,png', mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
                    callback: function (f) {
                        var json = WST.toJson(f);
                        if (json.status == 1) {
                            $('#' + id_selector + 'Msg').empty().hide();
                            $('#' + id_selector + 'Preview').attr('src', WST.conf.RESOURCE_PATH + "/" + json.savePath + json.thumb).show();
                            $('#' + id_selector).val(json.savePath + json.name);
                            $('#msg_' + id_selector).hide();
                        }
                    },
                    progress: function (rate) {
                        $('#' + id_selector).show().html('已上传' + rate + "%");
                    }
                });
            }else{
                var fileNumLimit = $(item).prev().attr('fileNum');
                var uploader = WST.upload({
                    pick: "#" + id_selector + 'Picker',
                    formData: {dir: 'shopextras'},
                    accept: {extensions: 'gif,jpg,jpeg,png', mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
                    fileNumLimit:fileNumLimit,
                    callback: function (f,file) {
                        var json = WST.toJson(f);
                        if (json.status == 1) {
                            if(fileNumLimit>1){
                                $('#' + id_selector + 'ImgBox').empty();
                                var tdiv = $("<div style='height:75px;float:left;margin:0px 5px;position:relative'><a target='_blank' href='"+WST.conf.RESOURCE_PATH+"/"+json.savePath+json.name+"'>"+
                                    "<img class='"+id_selector+"_step_pic"+"' height='75' src='"+WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb+"' v='"+json.savePath+json.name+"'></a></div>");
                                var btn = $('<div style="position: absolute;top: -5px;right: 0px;cursor: pointer;background: rgba(0,0,0,0.5);width: 18px;height: 18px;text-align: center;border-radius: 50%;" ><img src="'+WST.conf.ROOT+'/wstmart/home/view/default/img/seller_icon_error.png"></div>');
                                tdiv.append(btn);
                                $('#' + id_selector + 'Box').append(tdiv);
                                $('#msg_' + id_selector).hide();
                                var imgPath = [];
                                $('.'+id_selector+'_step_pic').each(function(){
                                    imgPath.push($(this).attr('v'));
                                });
                                $('#' + id_selector).val(imgPath.join(','));
                                btn.on('click','img',function(){
                                    uploader.removeFile(file);
                                    $(this).parent().parent().remove();
                                    uploader.refresh();
                                    if($('#'+id_selector+'Box').children().size()<=0){
                                        $('#msg_' + id_selector).show();
                                    }
                                    var imgPath = [];
                                    $('.'+id_selector+'_step_pic').each(function(){
                                        imgPath.push($(this).attr('v'));
                                    });
                                    $('#' + id_selector).val(imgPath.join(','));
                                });
                            }else{
                                $('#' + id_selector + 'Msg').empty().hide();
                                $('#' + id_selector + 'Preview').attr('src', WST.conf.RESOURCE_PATH + "/" + json.savePath + json.thumb).show();
                                $('#' + id_selector).val(json.savePath + json.name);
                                $('#msg_' + id_selector).hide();
                                uploader.reset();
                            }
                        }
                    },
                    progress: function (rate) {
                        $('#' + id_selector).show().html('已上传' + rate + "%");
                    }
                });
            }
        });

        if(window.conf.MAP_KEY){
            var longitude = $('#longitude').val();
            var latitude = $('#latitude').val();
            var mapLevel = $('#mapLevel').val();
            initQQMap(longitude,latitude,mapLevel);
        }

        $(".time-component").each(function (idx, item) {
            var id_selector = $(item).attr('id');
            initTime('#'+id_selector,$('#'+id_selector).attr('v'));
        });

        $("select[class^='j-']").each(function(idx,item){
            var id_selector = $(item).attr('id');
            var class_selector = $(item).attr('class');
            var datavalue = $(item).attr('data-value');
            if(datavalue){
                var areaPath = datavalue.split("_");
                $('#'+id_selector).val(areaPath[0]);
                var aopts = {id:id_selector,val:areaPath[0],childIds:areaPath,className:class_selector,isRequire:true}
                WST.ITSetAreas(aopts);
            }
        });
        $("div[class^=wst-payCode]").click(function(){
            var payCode = $(this).attr("data");
            $("div[class^=wst-payCode]").each(function(){
                $(this).removeClass().addClass("wst-payCode-"+$(this).attr("data"));
            });
            $(this).removeClass().addClass("wst-payCode-"+payCode+"-curr");
            $("#payCode").val(payCode);
        });
        if($("div[class^=wst-payCode]").length>0){
            $("div[class^=wst-payCode]")[0].click();
        }
        if($("#totalCatFee").html()!=undefined){
            changeCatFee();
        }
    });
    function changeArea(obj){
        var id_selector = $(obj).attr('id');
        var class_selector = $(obj).attr('class');
        var value = $("select[id="+id_selector+"]").val();
        WST.ITAreas({id:id_selector,val:value,isRequire:true,className:class_selector});
    }
    function changeCatFee(){
        var tradeFee = $("#tradeId option:selected").attr("tradeFee");
        $("#totalCatFee").html(tradeFee);
    }

    <?php if(isset($out_trade_no)): if($out_trade_no != '' and $code_url!=''): ?>
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                width : 260,
                height : 260
            });
            qrcode.makeCode("<?php echo $code_url; ?>");
        <?php endif; ?>
        setInterval(function(){
            var params = {};
            params.trade_no = "<?php echo $out_trade_no; ?>";
            $.ajax({
                url:"<?php echo url('home/weixinpays/getPayStatus'); ?>",
                data:params,
                type:"POST",
                dataType:"json",
                success:function(data){
                    if(data.status==1){
                        location.href = "<?php echo url('home/weixinpays/payAnnualFeeSuccess',array('flowId'=>$flowId)); ?>";
                    }
                }
            });
        },1500);
    <?php endif; ?>
</script>

</body>
</html>