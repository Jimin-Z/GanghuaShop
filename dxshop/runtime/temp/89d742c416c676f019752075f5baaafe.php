<?php /*a:2:{s:65:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\\index.html";i:1738237218;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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

<link rel="stylesheet" href="__SHOP__/css/index.css?t=1212" type="text/css"/>

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

<div class='wrapper'>
   <div class='layout-top' style=''>
      <div class='logo'><?php echo session('WST_USER.shopName'); ?></div>
      <ul class="layui-nav wstmenu">
        <?php if(is_array($sysMenus) || $sysMenus instanceof \think\Collection || $sysMenus instanceof \think\Paginator): $key0 = 0; $__LIST__ = $sysMenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$left0): $mod = ($key0 % 2 );++$key0;?>
        <li class="layui-nav-item <?php if($key0==1): ?>layui-this<?php endif; ?>"><a href="javascript:showMenus(<?php echo $left0['menuId']; ?>)"><?php echo $left0['menuName']; ?></a></li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
      <ul class="layui-nav nav layui-layout-right toMsg">
        <li class="layui-nav-item"><a href="javascript:;" class="msgIco"><i class='fa fa-bell fa-lg'></i><span class='msg-num'></span></a>
          <dl class="layui-nav-child">
           <?php if(WSTShopGrant('shop/messages/shopMessage')): ?>
           <div id='m-msg'><a href='javascript:void(0)' onclick='redirect(120)'>用户消息<span>0</span></a></div>
           <?php endif; if(WSTShopGrant('shop/orders/waitdelivery')): ?>
           <div id='m-24'><a href='javascript:void(0)' onclick='redirect(24)'>待发货订单<span>0</span></a></div>
           <?php endif; if(WSTShopGrant('shop/orders/waituserPay')): ?>
           <div id='m-55'><a href='javascript:void(0)' onclick='redirect(55)'>待付款订单<span>0</span></a></div>
           <?php endif; if(WSTShopGrant('shop/orders/failure')): ?>
           <div id='m-45'><a href='javascript:void(0)' onclick='redirect(45)'>待退款订单<span>0</span></a></div>
           <?php endif; if(WSTShopGrant('shop/ordercomplains/shopComplain')): ?>
           <div id='m-25'><a href='javascript:void(0)' onclick='redirect(25)'>投诉订单<span>0</span></a></div>
           <?php endif; if(WSTShopGrant('shop/orderservices/index')): ?>
           <div id='m-306'><a href='javascript:void(0)' onclick='redirect(306)'>售后信息<span>0</span></a></div>
           <?php endif; if(WSTShopGrant('shop/goods/stockWarnByPage')): ?>
           <div id='m-54'><a href='javascript:void(0)' onclick='redirect(54)'>库存预警<span>0</span></a></div>
           <?php endif; ?>
           <div id='mmm'><a href='<?php echo getWeliveUrl("客服服务"); ?>'' target='_blank'>在线客服<span></span></a></div>
          </dl>
      </li>
        <li class="layui-nav-item">
          <a href="javascript:;"><img src="<?php echo WSTUserPhoto(session('WST_USER.staffPhoto')); ?>"  class="layui-nav-img"><?php if(app('request')->session('WST_USER.userName')!=''): ?><?php echo app('request')->session('WST_USER.userName'); else: ?><?php echo app('request')->session('WST_USER.loginName'); ?><?php endif; ?></a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:editPassBox();" class='' style='font-size:12px'><i class='fa fa-key'></i>修改密码</a></dd>
            <hr>
            <dd><a href="javascript:logout()" class='j-logout' style='font-size:12px'><i class='fa fa-power-off'></i>退出</a></dd>
          </dl>
        </li>
      </ul>
   </div>
   <div class='layout-main' style=''>
      <div class='layout-sidebar'>
         <ul class="layui-nav layui-nav-tree layui-inline sidebar">
            <?php if(is_array($sysMenus) || $sysMenus instanceof \think\Collection || $sysMenus instanceof \think\Paginator): $key0 = 0; $__LIST__ = $sysMenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$left0): $mod = ($key0 % 2 );++$key0;if(!empty($left0['list'])): if(is_array($left0['list']) || $left0['list'] instanceof \think\Collection || $left0['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $left0['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$left1): $mod = ($i % 2 );++$i;?>
            <li class="layui-nav-item <?php if(!empty($top['child'])): ?>layui-nav-itemed<?php endif; ?> menu menu<?php echo $left0['menuId']; ?>" <?php if($key0>1): ?>style='display:none'<?php endif; ?>>
              <a href="javascript:void(0);" class='sidebar-menus'><i class='fa fa-<?php echo !empty($top['menuIcon']) ? $top['menuIcon'] : 'circle-o'; ?> fai'></i><?php echo $left1['menuName']; ?></a>
              <?php if(!empty($left1['list'])): ?>
              <dl class="layui-nav-child">
                <?php if(is_array($left1['list']) || $left1['list'] instanceof \think\Collection || $left1['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $left1['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$left2): $mod = ($i % 2 );++$i;?>
                <dd>
                <?php  if(stripos($left2['menuUrl'],'http://')!==false || stripos($left2['menuUrl'],'https://')!==false ){  ?>
                <a href="javascript:void(0);" class='sidebar-menus menuItem<?php echo $left2['menuId']; ?>' <?php if(isset($left2['menuUrl'])): ?>dataurl="<?php echo $left2['menuUrl']; ?><?php endif; ?>">
                <?php  }else{  ?>
                <a href="javascript:void(0);" class='sidebar-menus menuItem<?php echo $left2['menuId']; ?>' <?php if(isset($left2['menuUrl'])): ?>dataurl="<?php echo url($left2['menuUrl']); ?><?php endif; ?>">
                <?php  }  ?>
                <?php echo $left2['menuName']; ?>
                </a></dd>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <div style='clear:both;'></div>
              </dl>
              <?php endif; ?>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <?php endif; ?>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
      </div>
      <div class='layout-content'>
        <iframe id='iframe' class="iframe" width="100%" height="100%" frameborder="0" src="<?php echo url('shop/index/main'); ?>"></iframe>
      </div>
   </div>
</div>
<div id='editPassBox' style='display:none;padding-top:5px;'>
  <form id='editPassFrom' autocomplete="off">
   <table class='wst-form'>
      <tr>
         <th style='width:110px'>原密码：</th>
         <td><input type='password' id='oldPass' name='oldPass' class='ipt' data-rule="原密码: required;" maxLength='16'/></td>
      </tr>
      <tr>
         <th style='width:110px'>新密码：</th>
         <td><input type='password' id='newPass' name='newPass' class='ipt' data-rule="新密码: required;length[6~]" maxLength='16'/></td>
      </tr>
      <tr>
         <th style='width:110px'>确认密码：</th>
         <td><input type='password' id='newPass2' name='newPass2' class='ipt' data-rule="确认密码: required;match(newPass);" maxLength='16'/></td>
      </tr>
   </table>
  </form>
</div>

<input type='hidden' id='token' value='<?php echo WSTConf("CONF.pwdModulusKey"); ?>'/>
<audio id='orderTipVoice' controls style='display:none' src="/hkshopNC/dxshop/static/images/order.mp3"></audio>
<?php echo hook('shopDocumentListener'); ?>
<script>
var menus = <?php echo json_encode($sysMenus); ?>;
function showImg(opt){
  layer.photos(opt);
}
function showBox(opts){
  return WST.open(opts);
}
</script>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type="text/javascript" src="/hkshopNC/dxshop/static/js/rsa.js"></script>
<script src="__SHOP__/js/index.js?v=<?php echo $v; ?>"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
