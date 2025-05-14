<?php /*a:2:{s:65:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\resources\index.html";i:1738761705;s:54:"D:\wamp64\www\qmdd\dxshop\wstmart\admin\view\base.html";i:1738761698;}*/ ?>
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
    .wst-grid .btn{    line-height: 20px;height: 20px;}
    .container{width:100%;padding-left:20px;}
    .red{color:red;}
    .desc{margin-top:20px;}
    .item{margin-top:20px;}
    .item label{margin-left:5px;cursor:pointer;}
    #progressBox{background:#fff;width:400px;height:100px;position: fixed;top:40%;left:40%;z-index:1000;border:1px solid #ccc;}
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

<div id='alertTips' class='alert alert-success alert-tips fade in'>
  <div id='headTip' class='head'><i class='fa fa-lightbulb-o'></i>操作说明</div>
  <ul class='body'>
    <li>该功能主要用于查看系统资源文件空间占用情况。绿色为有效资源文件，灰色为无效，可删除资源文件。</li>
    <li>只有商品信息、编辑器、文章、商品评价、订单投诉、反馈图片目录会生成缩略图，其余目录则不生成。</li>
  </ul>
</div>
<div id="main" class='mmGrid wst-grid' style="margin-bottom: 10px;">
<table class='mmg-head wst-grid-tree' width='100%' cellspacing='0' cellpadding='0'>
   <thead class='mmg-headWrapper'>
   <tr class='l-grid-hd-row wst-grid-tree-hd'>
       <td width='30' class='wst-grid-tree-hd-cel' height='28' style="width:26px;text-align:center;font-weight:bold;">#</td>
       <td width='150' class='wst-grid-tree-hd-cell' height='28' style='text-align:center;font-weight:bold;'>目录</td>
       <td class='wst-grid-tree-hd-cell' height='28' style='text-align:left;font-weight:bold;'>有效资源文件/无效资源文件</td>
       <td width='80' class='wst-grid-tree-hd-cell' height='28' style='text-align:center;font-weight:bold;'>M</td>
       <td width='260' class='wst-grid-tree-hd-cell' height='28' style='text-align:center;font-weight:bold;'>操作</td>
   </tr>
   </thead>
   <tbody id='list'></tbody>
</table>
</div>
<div id='picHandleBox' style='display:none'>
    <div class="wst-flex-column container">
        <div class='desc red wst-flex-row'>
            <p>说明：</p>
            <ul>
                <li>生成图片功能仅针对有效图片</li>
                <li>系统所有的图片都是以电脑端展示的大图作为原图进行合成移动端大图以及缩略图的</li>
            </ul>
        </div>
        <div class="wst-flex-column item">
            <div>
                <input type="radio" name="handleType" value="1" checked id="handleType1"/><label for='handleType1' >根据电脑端大图重新生成移动端图片</label>
            </div>
            <span class="red" style="margin-left:18px;">移动端图片以电脑端大图为准，大图有水印，移动端也有水印，大图没有水印，移动端也没有水印</span>
        </div>
        <div class="wst-flex-column item">
            <div>
                <input type="radio" name="handleType" value="2" id="handleType2"/><label for='handleType2' >重新生成所有图片</label>
            </div>
            <span class="red" style="margin-left:18px;">当电脑端大图已经有水印时，请勿勾选此项，以免生成的图片含有重复水印</span>
        </div>
    </div>
</div>
<script>
$(function(){initSummary();});
</script>

<script language="javascript" type="text/javascript" src="/qmdd/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/resources/resources.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>