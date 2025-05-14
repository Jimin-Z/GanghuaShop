<?php /*a:2:{s:64:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\homemenus\list.html";i:1738761701;s:54:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\base.html";i:1738761698;}*/ ?>
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


<style>
    .wst-grid .btn{height: 20px;line-height: 20px;}
</style>

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

<style>.mmGrid{border-bottom:0px;}</style>
<div id='alertTips' class='alert alert-success alert-tips fade in'>
  <div id='headTip' class='head'><i class='fa fa-lightbulb-o'></i>操作说明</div>
  <ul class='body'>
    <li>本功能为开发者功能，主要用于设置电脑版会员、商家、门店以及供货商菜单，普通使用者请勿随意修改，以免影响系统使用。</li>
  </ul>
</div>
<div class="wst-toolbar">
   <select id='s_menuType' onchange='loadGrid()'>
      <option value='0'>会员菜单</option>
      <option value='1'>商家菜单</option>
      <option value='2'>门店菜单</option>
      <?php if((WSTConf('CONF.isOpenSupplier')==1)): ?>
      <option value='3'>供货商菜单</option>
      <?php endif; ?>
   </select>
   <?php if(WSTGrant('QTCD_01')): ?>
   <button class="btn btn-success f-right" onclick="javascript:toEdit(0,0)"><i class='fa fa-plus'></i>新增</button>
   <?php endif; ?>
   <div style="clear:both"></div>
</div>
<div class='wst-grid'>
<div class='mmGrid layui-form' id="maingrid"></div>
</div>
<div id='menuBox' style='display:none'>
    <form id='menuForm'>
    <table class='wst-form wst-box-top'>
       <tr>
          <th>菜单名称<font color='red'>*</font>：</th>
          <td>
              <input type="text" id="menuName" name="menuName" class="ipt" maxLength='20' />
          </td>
       </tr>
       <tr>
          <th>菜单Url<font color='red'>*</font>：</th>
          <td>
              <input type="text" id="menuUrl" name="menuUrl" class="ipt" maxLength='200'/>
          </td>
       </tr>
       <tr>
          <th>附加资源：</th>
          <td>
              <textarea id="menuOtherUrl" name="menuOtherUrl" class="ipt" style='width:400px'></textarea>
          </td>
       </tr>

       <tr id="menuTypes">
          <th>菜单类型<font color='red'>*</font>：</th>
            <td>
        <select id="menuType" class="ipt">
          <option value="0">用户菜单</option>
          <option value="1">商家菜单</option>
          <option value='2'>门店菜单</option>
          <?php if((WSTConf('CONF.isOpenSupplier')==1)): ?>
	      <option value='3'>供货商菜单</option>
	      <?php endif; ?>
        </select>
            </td>
        </tr>

       <tr>
          <th>菜单排序<font color='red'>*</font>：</th>
          <td>
              <input type="text" id="menuSort" name="menuSort" class="ipt" maxLength='20' />
          </td>
       </tr>
       <tr>
          <th>是否显示<font color='red'>  </font>：</th>
          <td class="layui-form">
            <input type="checkbox" id="isShow" name="isShow" value="1" class="ipt" lay-skin="switch" lay-filter="isShow1" lay-text="显示|隐藏">
          </td>
       </tr>
    </table>
    </form>
</div>

<script language="javascript" type="text/javascript" src="/qmdd/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/js/wstgridtree.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script src="__ADMIN__/homemenus/homemenus.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>