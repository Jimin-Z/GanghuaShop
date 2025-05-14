<?php /*a:2:{s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\brands\list.html";i:1670290018;s:56:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\base.html";i:1669564546;}*/ ?>
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


<style>
    td .layui-table-cell{height:60px !important;line-height: 60px !important;overflow: inherit!important;}
    .layui-table img{max-width:200px!important;}
</style>

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

<div class="wst-grid">
<input type="hidden" id="isNew" value="1"/>
<div class="layui-tab layui-tab-brief" lay-filter="msgTab">
    <ul class="layui-tab-title">
        <li <?php if($type=='brand'): ?>class="layui-this"<?php endif; ?>>已审核品牌</li>
        <li <?php if($type=='new'): ?>class="layui-this"<?php endif; ?>>新品牌申请</li>
        <li <?php if($type=='join'): ?>class="layui-this"<?php endif; ?>>品牌加盟</li>
    </ul>
    <div class="layui-tab-content" style="padding: 0px 0;">
        <div class="layui-tab-item <?php if($type=='brand'): ?>layui-show<?php endif; ?>">
            <div class="wst-toolbar">
                <select id='catId'>
                    <option value='0'>所属商品分类</option>
                    <?php if(is_array($gcatList) || $gcatList instanceof \think\Collection || $gcatList instanceof \think\Paginator): $i = 0; $__LIST__ = $gcatList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value='<?php echo $vo['catId']; ?>'><?php echo $vo['catName']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <input type='text' id='key' placeholder='品牌名称'/>
                <button class="btn btn-primary" onclick='javascript:loadGrid(0)'><i class='fa fa-search'></i>查询</button>
                <?php if(WSTGrant('PPGL_01')): ?>
                <button class="btn btn-success f-right" onclick='javascript:toEdit(0)'><i class='fa fa-plus'></i>新增</button>
                <?php endif; ?>

                <div style='clear:both'></div>
            </div>
            <div class='wst-grid'>
                <div id="mmg" class="mmg"></div>
            </div>
        </div>
        <div class="layui-tab-item <?php if($type=='new'): ?>layui-show<?php endif; ?>">
            <div class="wst-toolbar wst-toolbar2">
                <input type='text' id='key2' placeholder='品牌名称'/>
                <button class="btn btn-primary" onclick='javascript:loadGrid2(0)'><i class='fa fa-search'></i>查询</button>
                <div style='clear:both'></div>
            </div>
            <div class='wst-grid'>
                <div id="mmg2" class="mmg2"></div>
            </div>
        </div>
        <div class="layui-tab-item <?php if($type=='join'): ?>layui-show<?php endif; ?>">
            <div class="wst-toolbar wst-toolbar3">
                <input type='text' id='key3' placeholder='品牌名称'/>
                <button class="btn btn-primary" onclick='javascript:loadGrid3(0)'><i class='fa fa-search'></i>查询</button>
                <div style='clear:both'></div>
            </div>
            <div class='wst-grid'>
                <div id="mmg3" class="mmg3"></div>
            </div>
        </div>
    </div>
</div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/brands/brands.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script>
$(function(){
    <?php if($type=='brand'): ?>
        initGrid(<?php echo $p; ?>);
    <?php elseif($type=='new'): ?>
        $('#isNew').val(1);
        initGrid2(<?php echo $p; ?>);
    <?php else: ?>
        $('#isNew').val(0);
        initGrid3(<?php echo $p; ?>);
    <?php endif; ?>
    var element = layui.element;
    element.on('tab(msgTab)', function(data){
        if(data.index==1){
            $('#isNew').val(1);
            initGrid2(<?php echo $p; ?>);
        }else if(data.index==2){
            $('#isNew').val(0);
            initGrid3(<?php echo $p; ?>);
        }else{
            initGrid(<?php echo $p; ?>);
        }
    });
});
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>