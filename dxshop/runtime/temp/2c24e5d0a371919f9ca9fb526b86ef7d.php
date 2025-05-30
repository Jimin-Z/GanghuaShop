<?php /*a:2:{s:60:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\menus\list.html";i:1738761703;s:54:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\base.html";i:1738761698;}*/ ?>
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


<link href="/qmdd/dxshop/static/plugins/ztree/css/zTreeStyle/zTreeStyle.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />


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

<div id='alertTips' class='alert alert-success alert-tips fade in'>
  <div id='headTip' class='head'><i class='fa fa-lightbulb-o'></i>操作说明</div>
  <ul class='body'>
    <li>左侧为菜单栏，点击菜单，然后再点击右键添加菜单，菜单中的图标使用<a href='http://fontawesome.dashgame.com/' target='_blank'>Fontawesome</a>图标，不需要fa-前缀。</li>
    <li>右侧为菜单对应的操作权限。若想为系统添加一个菜单则要一个设置为“菜单权限”的权限，该菜单才能显示。</li>
    <li>该功能为开发者功能，普通使用者请勿随意修改，以免影响系统使用。</li>
  </ul>
</div>
<div class="j-layout">
    <div class='j-layout-left'>
        <div class='j-layout-panel layui-colla-title'>菜单管理</div>
        <ul id="menuTree" class="ztree" style='overflow:auto'></ul>
    </div>
    <div class='j-layout-center' style='border:1px solid #f1f1f1;float:left;margin-left:5px;'>
      <div class='j-layout-panel layui-colla-title privilege-title'>权限管理</div>
      <?php if(WSTGrant('QXGL_01')): ?>
      <div class="wst-toolbar" style='display:none'>
          <button class="btn btn-success btn-sm f-right" onclick='javascript:toEdit(0)'><i class='fa fa-plus'></i>新&nbsp;增</button>
          <div style='clear:both'></div>
      </div>
      <?php endif; ?>
      <div id="maingrid"  class='wst-grid' style='display:none'>
        <div id="mmg" class="mmg"></div>
      </div>
    </div>
    <div style='clear:both;'></div>
</div>
<div id='menuBox' style='display:none'>
<form id='menuForm'>
  <input type='hidden' id='parentId' class='ipt2' maxLength='20'/>
  <table class='wst-form wst-box-top'>
     <tr>
        <th width='100'>菜单名称<font color='red'>*</font>：</th>
        <td><input type='text' id='menuName' class='ipt2' maxLength='20' data-rule="菜单名称: required;"/></td>
     </tr>
     <tr>
        <th width='100'>菜单图标<font color='red'>*</font>：</th>
        <td><input type='text' id='menuIcon' class='ipt2' maxLength='20'/></td>
     </tr>
     <tr>
        <th width='100'>菜单排序<font color='red'>*</font>：</th>
        <td><input type='text' id='menuSort' class='ipt2' maxLength='5'/></td>
     </tr>
  </table>
</form>
</div>
<div id='privilegeBox' style='display:none'>
  <form id='privilegeForm' autocomplete='off'>
  <table class='wst-form wst-box-top'>
     <tr>
        <th width='110'>权限名称<font color='red'>*</font>：</th>
        <td><input type='text' id='privilegeName' class='ipt' maxLength='20' data-rule="权限名称: required;"/></td>
     </tr>
     <tr>
        <th>权限代码<font color='red'>*</font>：</th>
        <td>
        <input type='hidden' id='privilegeId' value="0" />
        <input type='text' id='privilegeCode' class='ipt' maxLength='30' onblur='javascript:checkPrivilegeCode(this)' data-rule="权限代码: required;"/></td>
     </tr>
     <tr>
        <th>是否菜单权限<font color='red'>*</font>：</th>
        <td height='24'>
           <label>
              <input type="radio" id="isMenuPrivilege1" name="isMenuPrivilege" class="ipt" value="1">是
           </label>
           <label>
              <input type="radio" id="isMenuPrivilege1" name="isMenuPrivilege" class="ipt" value="0" checked>否
           </label>
        </td>
     </tr>
     <tr>
        <th>权限资源：</th>
        <td><input type='text' id='privilegeUrl' class='ipt' maxLength='100'/></td>
     </tr>
     <tr>
        <th>关联资源：<br/>(以,号分隔)&nbsp;&nbsp;&nbsp;</th>
        <td>
        <textarea id='otherPrivilegeUrl' class='ipt' style='width:400px;height:60px;'></textarea>
        </td>
     </tr>
  </table>
  </form>
</div>
<div id="rMenu">
  <ul>
    <?php if(WSTGrant('CDGL_01')): ?><li id="m_add" >新增菜单</li><?php endif; if(WSTGrant('CDGL_02')): ?><li id="m_edit">编辑菜单</li><?php endif; if(WSTGrant('CDGL_03')): ?><li id="m_del" style='border-bottom:0px;'>删除菜单</li><?php endif; ?>
  </ul>
</div>

<script language="javascript" type="text/javascript" src="/qmdd/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="/qmdd/dxshop/static/plugins/ztree/jquery.ztree.all-3.5.js?v=<?php echo $v; ?>"></script>
<script src="__ADMIN__/menus/menu.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>