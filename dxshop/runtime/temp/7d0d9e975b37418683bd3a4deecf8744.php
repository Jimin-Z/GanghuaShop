<?php /*a:2:{s:66:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\shopflows\list.html";i:1669133238;s:56:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\base.html";i:1669564546;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>后台管理中心 - <?php echo WSTConf('CONF.mallName'); ?></title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<script src="/hkshopNC/dxshop/static/js/jquery.min.js"></script>
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/layui/css/layui.css" type="text/css" />
<link rel="stylesheet" href="/hkshopNC/dxshop/static/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<link href="__ADMIN__/css/common.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" />


<link rel="stylesheet" type="text/css" href="/hkshopNC/dxshop/static/plugins/webuploader/webuploader.css?v=<?php echo $v; ?>" />

<?php 
$msgGrant = [];
if(WSTGrant('TSDD_00'))$msgGrant[] = 'shopapply';
if(WSTGrant('DSHSP_00'))$msgGrant[] = 'goodsaudit';
if(WSTGrant('TSDD_00'))$msgGrant[] = 'ordercomplains';
if(WSTGrant('JBSP_00'))$msgGrant[] = 'informs';
 ?>
<script>
window.conf = {"DOMAIN":"<?php echo str_replace('index.php','',app('request')->root(true)); ?>","ROOT":"/hkshopNC/dxshop","APP":"/hkshopNC/dxshop/index.php","STATIC":"/hkshopNC/dxshop/static","SUFFIX":"<?php echo config('url_html_suffix'); ?>","GOODS_LOGO":"<?php echo WSTConf('CONF.goodsLogo'); ?>","SHOP_LOGO":"<?php echo WSTConf('CONF.shopLogo'); ?>","MALL_LOGO":"<?php echo WSTConf('CONF.mallLogo'); ?>","USER_LOGO":"<?php echo WSTConf('CONF.userLogo'); ?>",'GRANT':'<?php echo implode(",",session("WST_STAFF.privileges")); ?>',"IS_CRYPT":"<?php echo WSTConf('CONF.isCryptPwd'); ?>","ROUTES":'<?php echo WSTRoute(); ?>',"MAP_KEY":"<?php echo WSTConf('CONF.mapKey'); ?>","__HTTP__":"<?php echo WSTProtocol(); ?>",'RESOURCE_PATH':'<?php echo WSTConf('CONF.resourcePath'); ?>','RESOURCE_DOMAIN':'<?php echo WSTConf('CONF.resourceDomain'); ?>',MSG_GRANT:'<?php echo implode(',',$msgGrant); ?>'}
</script>
<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/js/common.js"></script>
</head>
<body>
<input type='hidden' id='WSTP' value="<?php echo input('p'); ?>"/>
<input type='hidden' id='WSTTYPE'  value="<?php echo isset($tabType)?$tabType:''; ?>"/>
<input type='hidden' id='WSTReferer' value="<?php if(isset($_SERVER['HTTP_REFERER'])): ?><?php echo $_SERVER['HTTP_REFERER']; ?><?php endif; ?>"/>
<div id="j-loader"><img src="__ADMIN__/img/ajax-loader.gif"/></div>

<div id='alertTips' class='alert alert-success alert-tips fade in'>
    <div id='headTip' class='head'><i class='fa fa-lightbulb-o'></i>操作说明</div>
    <ul class='body'>
        <li>基础步骤无法删除与隐藏。请保持“签订入驻协议”和“入驻审核”分别为首尾步骤，请勿在这两个步骤中新增字段。</li>
        <li>前台页面将按照步骤排序进行展示。</li>
        <li>当隐藏步骤时，前台页面则不显示该步骤。</li>
    </ul>
</div>
<?php if(WSTGrant('RZLC_01')): ?>
<div class="wst-toolbar">
   <button class="btn btn-success f-right" onclick="javascript:toEdit(0)"><i class='fa fa-plus'></i>新增</button>
   <div style="clear:both"></div>
</div>
<?php endif; ?>
<div class='wst-grid'>
 <div id="mmg" class="mmg"></div>
</div>

<div id='flowBox' style='display:none'>
    <form id='flowForm' method="post" autocomplete="off">
        <table class='wst-form wst-box-top'>
            <tr>
                <th width='150'>步骤名称<font color='red'>*</font>：</th>
                <td><input type='text' id='flowName' name="flowName"  class='ipt' maxLength='20' style='width:200px;'/></td>
            </tr>
            <tr>
                <th width='150'>排序：</th>
                <td><input type='text' id='sort' name="sort"  class='ipt' maxLength='20' style='width:200px;'/></td>
            </tr>
        </table>
    </form>
</div>
<script>
  $(function(){initGrid(<?php echo $p; ?>)});
</script>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/shopflows/shopflows.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>'></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>