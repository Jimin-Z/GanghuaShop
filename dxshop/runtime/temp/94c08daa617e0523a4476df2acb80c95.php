<?php /*a:2:{s:55:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\index.html";i:1738761698;s:54:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\base.html";i:1738761698;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>后台管理中心 - <?php echo WSTConf('CONF.mallName'); ?></title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<script src="/qmdd/dxshop/static/js/jquery.min.js"></script>
<link rel="stylesheet" href="/qmdd/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/qmdd/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__ADMIN__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />


<link rel="stylesheet" href="__ADMIN__/css/index.css" type="text/css"/>

<?php 
$msgGrant = [];
if(WSTGrant('TSDD_00'))$msgGrant[] = 'shopapply';
if(WSTGrant('DSHSP_00'))$msgGrant[] = 'goodsaudit';
if(WSTGrant('TSDD_00'))$msgGrant[] = 'ordercomplains';
if(WSTGrant('JBSP_00'))$msgGrant[] = 'informs';
 ?>
<script>
window.conf = {"DOMAIN":"<?php echo str_replace('index.php','',app('request')->root(true)); ?>","ROOT":"/qmdd/dxshop","APP":"/qmdd/dxshop/index.php","STATIC":"/qmdd/dxshop/static","SUFFIX":"<?php echo config('url_html_suffix'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>",'GRANT':'<?php echo implode(",",session("WST_STAFF.privileges")); ?>',"IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>","ROUTES":'<?php echo WSTRoute(); ?>',"MAP_KEY":"<?php echo WSTConf('CONF.mapKey'); ?>","__HTTP__":"<?php echo WSTProtocol(); ?>",'RESOURCE_PATH':'<?php echo WSTConf('CONF.resourcePath'); ?>','RESOURCE_DOMAIN':'<?php echo WSTConf('CONF.resourceDomain'); ?>',MSG_GRANT:'<?php echo implode(',',$msgGrant); ?>'}
</script>
<script language="javascript" type="text/javascript" src="/qmdd/dxshop/static/js/common.js"></script>
</head>
<body>
<input type='hidden' id='WSTP' value="<?php echo input('p'); ?>"/>
<input type='hidden' id='WSTTYPE'  value="<?php echo isset($tabType)?$tabType:''; ?>"/>
<input type='hidden' id='WSTReferer' value="<?php if(isset($_SERVER['HTTP_REFERER'])): ?><?php echo $_SERVER['HTTP_REFERER']; ?><?php endif; ?>"/>
<div id="j-loader"><img src="__ADMIN__/img/ajax-loader.gif"/></div>

<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo layui-hide-xs layui-bg-black">
      <a href="javascript:goHome();" class="logo">
        <span class="logo-mini"><?php echo WSTConf("CONF.sysShortTitle"); ?></span>
        <span class="logo-lg"><?php echo WSTConf("CONF.sysTitle"); ?></span>
      </a>
    </div>
    <!-- 头部区域（可配合layui 已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item wst-menu-hide" lay-header-event="menuRight">
        <i class="layui-icon layui-icon-shrink-right"></i>
      </li>
      <li class="layui-nav-item wst-menu-show" lay-header-event="menuLeft" style='display: none'>
        <i class="layui-icon layui-icon-spread-left"></i>
      </li>
      <?php if(is_array($sysMenus) || $sysMenus instanceof \think\Collection || $sysMenus instanceof \think\Paginator): $key0 = 0; $__LIST__ = $sysMenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top): $mod = ($key0 % 2 );++$key0;?>
      <li class="layui-nav-item <?php if($key0==1): ?>layui-this<?php endif; ?>"><a href="javascript:showMenus(<?php echo $top['menuId']; ?>)" class='top-menu' dataid='<?php echo $top['menuId']; ?>'><i class="fa fa-<?php echo $top['menuIcon']; ?>"></i> <span><?php echo $top['menuName']; ?></span></a></li>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>

   <ul class="layui-nav layui-layout-right toMsg">
        <li class="layui-nav-item"><a href="javascript:;" class="msgIco"><i class='fa fa-bell fa-lg'></i><span class='msg-num'></span></a>
          <dl class="layui-nav-child">
           <?php if(WSTGrant('TSDD_00')): ?>
           <dd id='m-45'>
            <a href='javascript:void(0)' onclick='redirect(45)'>开店申请<span></span></a>
           </dd>
           <?php endif; if(WSTGrant('DSHSP_00')): ?>
           <dd id='m-54'>
            <a href='javascript:void(0)' onclick='redirect(54)'>待审核商品<span></span></a>
           </dd>
           <?php endif; if(WSTGrant('TSDD_00')): ?>
           <dd id='m-51'>
            <a href='javascript:void(0)' onclick='redirect(51)'>待处理投诉<span></span></a>
           </dd>
           <?php endif; if(WSTGrant('JBSP_00')): ?>
           <dd id='m-188'>
            <a href='javascript:void(0)' onclick='redirect(188)'>待处理举报<span></span></a>
           </dd>
           <?php endif; ?>
          </dl>
      </li>
      <li id='toMall' class='layui-nav-item inner' data-tip="点击打开商城首页"><a target='_blank' href='<?php echo app('request')->root(true); ?>'><i class='fa fa-television'></i></a></li>
      <li id='toSelft' class='layui-nav-item inner' data-tip="点击打开自营店铺"><a target='_blank' href='<?php echo Url("admin/shops/inself"); ?>'><i class='fa fa-podcast'></i></a></li>
      <li id='toTechSupp' class='layui-nav-item inner' data-tip="点击打开技术支持页面"><a target='_blank' href='http://hk-city.com'><i class='fa fa-handshake-o'></i></a></li>
      <li id='toClearCache' class='layui-nav-item inner' data-tip="点击清除服务器缓存"><a class='j-clear-cache' href='#'><i class='fa fa-spinner'></i></a></li>
      <li id='toLogout' class='layui-nav-item inner' data-tip="点击退出系统"><a class='j-logout' href='#'><i class='fa fa-power-off'></i></a></li>

      <!-- <li class="layui-nav-item layui-hide layui-show-md-inline-block">
        <a href="javascript:;">
          <img src="" class="layui-nav-img">
          tester
        </a>
        <dl class="layui-nav-child">
          <dd><a href="">Your Profile</a></dd>
          <dd><a href="">Settings</a></dd>
          <dd><a href="">Sign out</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item" lay-header-event="menuRight" lay-unselect>
        <a href="javascript:;">
          <i class="layui-icon layui-icon-more-vertical"></i>
        </a>
      </li> -->
    </ul>
  </div>

  <div class="layui-side">
    <div class="layui-side-scroll">
      <div class='user-panel'>
       <div class="image"><img src="__RESOURCE_PATH__/<?php echo app('session')->get('WST_STAFF.staffPhoto'); ?>"></div>
       <div class='info'>
          <p><?php echo app('session')->get('WST_STAFF.loginName'); ?></p>
          <p><?php echo app('session')->get('WST_STAFF.roleName'); ?></p>
       </div>
       <div style='clear:both;'></div>
       <div class='button'>
          <a href='javascript:void(0);' class='j-edit-pass edit-pass'><i class='fa fa-key'></i><span> 修改密码</span></a>
          <a href='javascript:void(0);' class='j-logout logout'><i class='fa fa-power-off'></i><span> 退出系统</span></a>
       </div>
    </div>

    <div class="layui-panel">
      <ul class="layui-menu">
        <?php if(is_array($sysMenus) || $sysMenus instanceof \think\Collection || $sysMenus instanceof \think\Paginator): $key0 = 0; $__LIST__ = $sysMenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$left0): $mod = ($key0 % 2 );++$key0;if(!empty($left0['child'])): if(is_array($left0['child']) || $left0['child'] instanceof \think\Collection || $left0['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $left0['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$left1): $mod = ($i % 2 );++$i;?>
        <li class="layui-menu-item-group layui-menu-item-up menu<?php echo $left0['menuId']; ?> menu wstmenu-p" <?php if($key0>1): ?>style='display:none'<?php endif; ?> >
          <div class="layui-menu-body-title">
            <a class="" href="javascript:;"><i class="fa fa-<?php echo !empty($left1['menuIcon']) ? $left1['menuIcon'] : 'eercast'; ?>"></i> <span class='wstmenu-txt'><?php echo $left1['menuName']; ?></span></a> <i class="layui-icon layui-icon-up"></i>
          </div>
          <?php if(!empty($left1['child'])): ?>
          <ul class='wstmenu-c'>
            <?php if(is_array($left1['child']) || $left1['child'] instanceof \think\Collection || $left1['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $left1['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$left2): $mod = ($i % 2 );++$i; if(stripos($left2['privilegeUrl'],'http://')!==false || stripos($left2['privilegeUrl'],'https://')!==false ){  ?>
                <li onclick='javascript:addTab(this)' href="javascript:void(0)" id="menuItem<?php echo $left2['menuId']; ?>" dataval="<?php echo $left2['privilegeUrl']; ?>" dataid='<?php echo $left2['menuId']; ?>'>
                  <a href="javascript:void(0)" ><i class="fa fa-<?php echo !empty($left2['menuIcon']) ? $left2['menuIcon'] : 'circle-o'; ?>"></i> <?php echo $left2['menuName']; ?></a>
                </li>
              <?php  }else{  ?>
              <li onclick='javascript:addTab(this)' href="javascript:void(0)" id="menuItem<?php echo $left2['menuId']; ?>" dataval="<?php echo Url($left2['privilegeUrl']); ?>" dataid='<?php echo $left2['menuId']; ?>'>
                  <a href="javascript:void(0)" ><i class="fa fa-<?php echo !empty($left2['menuIcon']) ? $left2['menuIcon'] : 'circle-o'; ?>"></i> <?php echo $left2['menuName']; ?></a>
              </li>
              <?php  }  ?>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
          <div class="layui-panel layui-menu-body-panel">
            <ul>
              <?php if(is_array($left1['child']) || $left1['child'] instanceof \think\Collection || $left1['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $left1['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$left2): $mod = ($i % 2 );++$i;?>
              <li>
                  <?php  if(stripos($left2['privilegeUrl'],'http://')!==false || stripos($left2['privilegeUrl'],'https://')!==false ){  ?>
                    <div class="layui-menu-body-title" onclick='javascript:addTab(this)' href="javascript:void(0)" id="menuItem<?php echo $left2['menuId']; ?>" dataval="<?php echo $left2['privilegeUrl']; ?>" dataid="<?php echo $left2['menuId']; ?>">
                      <a href="javascript:void(0)" ><i class="fa fa-<?php echo !empty($left2['menuIcon']) ? $left2['menuIcon'] : 'circle-o'; ?>"></i> <?php echo $left2['menuName']; ?></a>
                    </div>
                  <?php  }else{  ?>
                  <div class="layui-menu-body-title" onclick='javascript:addTab(this)' href="javascript:void(0)" id="menuItem<?php echo $left2['menuId']; ?>" dataval="<?php echo Url($left2['privilegeUrl']); ?>" dataid="<?php echo $left2['menuId']; ?>">
                      <a href="javascript:void(0)"><i class="fa fa-<?php echo !empty($left2['menuIcon']) ? $left2['menuIcon'] : 'circle-o'; ?>"></i> <?php echo $left2['menuName']; ?></a>
                  </div>
                  <?php  }  ?>
              </li>
              <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
          <?php endif; ?>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <?php endif; ?>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
    </div>
  </div>

  <div class="layui-body">
   <div class="layui-tab layui-tab-card" lay-allowclose="true" lay-filter="wsttab">
        <ul class="layui-tab-title"></ul>
        <div class="layui-tab-content" style="height: 100%;"></div>
   </div>
  </div>
</div>
<div id='editPassBox' style='display:none;padding-top:5px;'>
  <form id='editPassFrom' autocomplete="off">
   <table class='wst-form'>
      <tr>
         <th style='width:100px'>原密码：</th>
         <td><input type='password' id='srcPass' style='width:210px' name='srcPass' class='ipt' data-rule="原密码: required;" maxLength='20'/></td>
      </tr>
      <tr>
         <th style="vertical-align: top;padding-top:20px;">新密码：</th>
         <td style="padding-bottom: 0;">
         <input type='password' id='newPass' style='width:210px' name='newPass' class='ipt' data-rule="新密码: required;length[8~];rpwd" data-rule-rpwd="[/^(?=.*[a-z])(?=.*[A-Z])(?=.*[1-9])(?=.*[\W|_]).{8,}$/, '密码规则错误']" maxLength='20'/>
          <div class="notic">密码必须是包含大小写字母、数字、符号,且长度为8-20位</div>
         </td>
      </tr>
      <tr>
         <th>确认密码：</th>
         <td><input type='password' id='newPass2' style='width:210px' name='newPass2' class='ipt' data-rule="确认密码: required;match(newPass);" maxLength='20'/></td>
      </tr>
   </table>
  </form>
</div>
<div id='photoBox' style='display:none'></div>
<script>
$(function(){
  // var element = layui.element,layer = layui.layer,util = layui.util;
  // util.event('lay-header-event', {
  //   menuLeft: function(othis){
  //     layer.msg('展开左侧菜单的操作', {icon: 0});
  //   }
  //   ,menuRight: function(){
  //     layer.open({
  //       type: 1
  //       ,content: '<div style="padding: 15px;">处理右侧面板的操作</div>'
  //       ,area: ['260px', '100%']
  //       ,offset: 'rt' //右上角
  //       ,anim: 5
  //       ,shadeClose: true
  //     });
  //   }
  // });
})
</script>
<script>
function showImg(opt){
  layer.photos(opt);
}
var menus = <?php echo json_encode($sysMenus); ?>;

function showBox(opts){
  return WST.open(opts);
}
$(function(){
    $(".inner").mouseenter(function (){
        layui.layer.tips($(this).data('tip'), this, {
            tips: [1, '#000']
        });
    });
})
</script>

<script language="javascript" type="text/javascript" src="/qmdd/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/js/index.js"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>