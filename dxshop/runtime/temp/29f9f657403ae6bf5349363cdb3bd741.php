<?php /*a:2:{s:78:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\goodsappraises\list.html";i:1670318518;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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

<style>
.wst-order-list .order-head{color:unset;background: #f5f5f5}
.wst-order-list td{border:1px solid #eee;padding:10px!important;}
.score-item{display: inline-block;width: 165px;text-align: left;}
</style>
<div class="wst-page">
  <div class="wst-toolbar">
    <select name="cat1" id="cat1" onchange="getCat(this.value)" class="s-query">
        <option value="">-请选择商品分类-</option>
      <?php $_result=WSTShopCats(0);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['catId']; ?>" ><?php echo $vo['catName']; ?></option>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </select>
    <select name="cat2" id="cat2" class="s-query"><option value="">-请选择商品分类-</option></select>
    <input type="text" name="goodsName" id="goodsName" class="s-query" placeholder='商品名称' />
    <a class="s-btn btn btn-primary" onclick="loadGrid(0)"><i class="fa fa-search"></i>查询</a>
</div>
<div class='wst-grid'>
    <div class="layui-table-view layui-table-view-1 layui-form layui-border-box" >
        <div class="layui-table-box">
            <div class="layui-table-header">
                <table class='wst-order-list layui-table' style="width: 100%">
                    <thead>
                    <tr class='head'>
                        <th width="350" style="border: 0"><div class="layui-table-cell">商品</div></th>
                        <th style="border: 0;"><div class="layui-table-cell">评价</div></th>
                        <th width="110" style="text-align: center;"><div class="layui-table-cell">操作</div></th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div id="dataTable" class="layui-table-body layui-table-main">
                <table class='wst-order-list layui-table' style="width: 100%">
                    <tbody id='loadingBdy'>
                    <tr id='loading' class='empty-row' style='display:none'>
                        <td colspan='5'><img src="__SHOP__/img/loading.gif">正在加载数据...</td>
                    </tr>
                    </tbody>
                     <script id="tblist" type="text/html">
                       {{# for(var i = 0; i < d.length; i++){ }}
                        <table class='wst-order-list j-order-row' style='border-bottom:0px'>
                         <tr style='background: #f9f9f9'>
                             <td style='border-right: 0px'>订单编号：{{ d[i].orderNo }}</td>
                             <td colspan="2" style='text-align: right;border-left: 0px'>
                                <span class="score-item">
                                 商品评分:
                                 {{# for(var g = 0; g < d[i].goodsScore; g++){ }}
                                 <img src='<?php echo WSTConf('CONF.resourcePath'); ?>/static/plugins/raty/img/star-on.png'>
                                 {{# } }}
                                </span>
                                 <span class="score-item">
                                 服务评分:
                                 {{# for(var g = 0; g < d[i].serviceScore; g++){ }}
                                 <img src='<?php echo WSTConf('CONF.resourcePath'); ?>/static/plugins/raty/img/star-on.png'>
                                 {{# } }}
                                </span>
                                 <span class="score-item">
                                 时效评分:
                                 {{# for(var g = 0; g < d[i].timeScore; g++){ }}
                                 <img src='<?php echo WSTConf('CONF.resourcePath'); ?>/static/plugins/raty/img/star-on.png'>
                                 {{# } }}
                                </span>
                             </td>
                         </tr>
                         <tr>
                             <td width="350">
                                 <div style="width:330px">
                                     <div style="float:left;width:50px">
                                         <img src="<?php echo WSTConf('CONF.resourcePath'); ?>/{{d[i].goodsImg}}" style='height:50px;width:50px;' >
                                     </div>
                                     <div style="float:left;width:235px;margin-left:5px;">{{d[i].goodsName}}</div>
                                 </div>
                             </td>
                           <td >
                               买家昵称：{{ d[i].loginName }}<br/>
                              {{ d[i].content }}
                              <div id="img-file-{{i}}" style="margin-top:5px">
                              {{#
                              if(WST.blank(d[i]['images'])!=''){
                                var img = d[i]['images'].split(',');
                                var length = img.length;
                                var html ="";
                                for(var g=0;g<length;g++){
                                    html += "<img src='"+window.conf.RESOURCE_PATH+'/'+img[g].replace('.','_thumb.')+"' style='cursor: pointer;' layer-src='"+window.conf.RESOURCE_PATH+"/"+img[g]+"' width='60' height='60' />";
                                }
                              }}
                              {{-html}}
                              {{#
                              }
                              }}
                              </div>
                              <div style="margin-top:5px;">{{d[i].createTime}}</div>
                              {{#  if(d[i]['shopReply']==null || d[i]['shopReply']==''){ }}
                              <div id="reply{{d[i].gaId}}"></div>
                              {{# }else{ }}
                              <hr/>
                              商家回复：{{d[i]['shopReply']}}【{{d[i]['replyTime']}}】
                              {{# } }}
                            </td>
                           <td width="110" style="text-align: center;">
                               {{#  if(d[i]['shopReply']==null || d[i]['shopReply']==''){ }}
                               <a id="r{{d[i].gaId}}" href="javascript:reply({{d[i].gaId}})">回复</a>
                               {{# } }}
                               {{#  if(d[i]['isReport']==0){ }}
                               <a href="javascript:report({{d[i].gaId}})">举报</a>
                               {{# } }}
                           </td>
                         </tr>
                       </table>
                       {{# } }}
                    </script>
                </table>
                <div class="layui-none" style="display: none">无数据</div>
            </div>
        </div>
        <div id='pager' class="layui-table-column layui-table-page" align="right" style='padding:5px 0px 5px 0px'>&nbsp;</div>
    </div>
</div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='__SHOP__/goodsappraises/goodsappraises.js?v=<?php echo $v; ?>'></script>
<script>
$(function(){
    WST.initTabHeight(90);
    $(window).resize(function(){
        WST.initTabHeight(90);
    })
    queryByPage();
})
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
