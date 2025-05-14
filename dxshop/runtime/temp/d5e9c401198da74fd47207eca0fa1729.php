<?php /*a:2:{s:75:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\shopstyles\index.html";i:1669276150;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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

<div class='wst-page'>
<div class="layui-tab layui-tab-brief" lay-filter="msgTab">
   <ul class="layui-tab-title">
   <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
      <li <?php if($key==0): ?>class="layui-this"<?php endif; ?>  onclick="listQuery('<?php echo $vo['styleSys']; ?>',1)"><?php echo $vo['styleSys']; ?></li>
   <?php endforeach; endif; else: echo "" ;endif; ?>
   </ul>
   <div class="layui-tab-content" style="padding: 10px 0;">
      <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
         <div id="style_<?php echo $vo['styleSys']; ?>" class="layui-tab-item <?php if($key==0): ?>layui-show<?php endif; ?>">
         </div>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<script id="tblist" type="text/html">
    {{# var dcat=d['cat'];var dcats=d['cats']; var dsys=d['sys'];}}
    <div class='style-txt' style="margin-left:10px;">分类：
        <select name="shopStylesCat" id="shopStylesCat" onchange="listQuery('{{dsys}}',1,this)">
            <option class="ipt" value="-1">全部分类</option>
            {{# for(var j = 0; j < dcats.length; j++){ }}
            <option class="ipt" value="{{dcats[j]['dataVal']}}" {{# if(dcat == dcats[j]['dataVal']){ }}selected{{# } }}>{{dcats[j]['dataName']}}</option>
            {{#}}}
        </select>
    </div>
{{# var dt = d['theme'];var dl = d['list']['data'];for(var i = 0; i < dl.length; i++){ }}
<div class='style-box' style="height:270px;">
   <div class='style-img'>
     <a href='#'>
         {{# if(d['sys']=='weapp'){  }}
         <img data-original='/hkshopNC/dxshop/wstmart/weapp/view/resources/{{dl[i]["screenshot"]}}' class='gImg' />
         {{# }else if(d['sys']=='app'){  }}
         <img data-original='/hkshopNC/dxshop/wstmart/app/view/resources/{{dl[i]["screenshot"]}}' class='gImg' />
         {{# }else{ }}
         <img data-original='/hkshopNC/dxshop/wstmart/{{d["sys"]}}/view/{{dl[i]["styleImgPath"]}}/{{dl[i]["screenshot"]}}' class='gImg' />
         {{# } }}
     </a>
   </div>
   <div class='style-txt' style="margin-bottom:10px;">标题：{{dl[i]['styleName']}}</div>
   <div class='style-op'>
   {{# if(dl[i]['stylePath']==dt){}}
   <button class='btn btn-disabled style_{{dl[i]['id']}}' dataid='{{dl[i]['id']}}' type='button' disabled><i class='fa fa-check-circle'></i>应用中</button>
   {{# }else{ }}
   <button class='btn btn-success style_{{dl[i]['id']}}' dataid='{{dl[i]['id']}}' type='button' style="margin-top: 0px;"><i class='fa fa-check-circle'></i>启用</button>
   {{# } }}
   </div>
</div>
{{#}}}
</script>
<div style="position:fixed;bottom:10px;width:100%;height:50px;">
    <div id='pager' align="center" style='padding:5px 0 5px 0'>&nbsp;</div>
</div>
<div class="f-clear"></div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script src="__SHOP__/shopstyles/styles.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
