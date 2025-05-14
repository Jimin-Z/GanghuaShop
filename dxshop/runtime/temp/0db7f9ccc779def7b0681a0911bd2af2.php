<?php /*a:2:{s:80:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\orders\list_delivered.html";i:1670210818;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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

<style>
    .express-title{font-size: 15px;font-weight:bold;color:#333;padding-top:10px;}
</style>

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

<div class="wst-page">
  <div class='wst-toolbar'>
     <input type='text' class="s-ipt" id='orderNo' placeholder='订单号'/>
     <select name="payType" id="payType" class="s-ipt">
                <option value="-1">支付方式</option>
                <option value="0">货到付款</option>
                <option value="1">在线支付</option>
               </select>

     <select name="deliverType" id="deliverType" class="s-ipt">
                <option value="-1">配送方式</option>
                <option value="0">送货上门</option>
                <option value="1">自提</option>
               </select>

      <a class="btn btn-primary" onclick="deliveredByPage()"><i class="fa fa-search"></i>查询</a>
      <a class="btn btn-primary" style="float:right;" onclick="javascript:toExport(2,1,'')"><i class="fa fa-sign-out"></i>导出</a>
  </div>
  <div class='wst-grid'>
      <div class="layui-table-view layui-table-view-1 layui-form layui-border-box">
          <div class="layui-table-box">
              <div class="layui-table-header">
                  <table class='wst-order-list layui-table' style="width: 100%">
                      <thead>
                      <tr class='head'>
                          <th class="th-padding" style="border: 0"><div class="layui-table-cell">订单详情</div></th>
                          <th width="200" style="border: 0;text-align: center;"><div class="layui-table-cell">支付方式/配送信息</div></th>
                          <th width="200" style="border: 0;text-align: center;"><div class="layui-table-cell">金额</div></th>
                          <th width="110" style="text-align: center;"><div class="layui-table-cell">操作</div></th>
                      </tr>
                      </thead>
                  </table>
              </div>
              <div id="dataTable" class="layui-table-body layui-table-main">
                  <table class='wst-order-list layui-table' style="width: 100%">
                      <tbody id='loadingBdy'>
                      <tr id='loading' class='empty-row' style='display:none'>
                          <td colspan='4'><img src="__SHOP__/img/loading.gif">正在加载数据...</td>
                      </tr>
                      </tbody>
                       <script id="tblist" type="text/html">
                       {{# for(var i = 0; i < d.length; i++){ }}
                       <tbody class="j-order-row {{#if(d[i].payType==1){}}j-warn{{#} }}">
                        <tr>
                           <td class='order-head'>
                                  <div class='time'>{{d[i].createTime}}</div>
                                  <div class='orderno'>订单号：{{d[i].orderNo}}
                                    {{# if(d[i].orderSrc==0){ }}<i class="order-pc"></i>
                                    {{# }else if(d[i].orderSrc==1){ }}<i class="order-wx"></i>
                                    {{# }else if(d[i].orderSrc==2){ }}<i class="order-mo"></i>
                                    {{# }else if(d[i].orderSrc==3){ }}<i class="order-app"></i>
                                    {{# }else if(d[i].orderSrc==4){ }}<i class="order-ios"></i>
                                    {{# }else if(d[i].orderSrc==5){ }}<i class="order-weapp"></i>
                                    {{# } }}
                                    {{# if(d[i].orderCodeTitle!=""){ }}
                                      <span class="order_from">{{d[i].orderCodeTitle}}</span>
                                    {{# } }}
                                      {{# if(WST.blank(d[i].orderShopRemarks,'')!=''){ }}
                                      <i class="fa fa-flag" style="color:red" title="{{d[i].orderShopRemarks}}"></i>
                                      {{# } }}
                                  </div>
                           </td>
                           <td width="200"></td>
                           <td width="200"></td>
                           <td width="110"><div style="text-align:center;">{{d[i].status}}</div></td>
                         </tr>
                         {{#
                          var tmp = null,rows = d[i]['list'].length;
                          for(var j = 0; j < d[i]['list'].length; j++){
                             tmp = d[i]['list'][j];
                         }}
                         <tr class='goods-box'>
                             <td style="border-right: 1px solid #e5e5e5">
                               <div class='goods-img'>
                                <a href="{{WST.U('home/goods/detail','goodsId='+tmp.goodsId)}}" target='_blank'>
                                    <span class='weixin'><img class='img gImg' title='{{tmp.goodsName}}' style='height:60;width:60;' data-original='__RESOURCE_PATH__/{{tmp.goodsImg}}'><img class='imged' style='height:200px;width:200px;max-width: 200px;max-height: 200px; background: #fff' title='{{tmp.goodsName}}' src="__RESOURCE_PATH__/{{tmp.goodsImg}}"></span>
                                </a>
                               </div>
                               <div class='goods-name'>
                                 <div>{{tmp.goodsName}}{{# if(tmp.goodsCode=='gift'){}}【赠品】{{# } }}</div>
                                 <div>{{tmp.goodsSpecNames}}</div>
                               </div>
                               <div class='goods-extra'>{{tmp.goodsPrice}} x {{tmp.goodsNum}}</div>
                            </td>
                            {{# if(j==0){ }}
                            <td rowspan="{{rows}}">
                                <div style="text-align: center;">{{d[i].payTypeName}}</div>
                                <div style="text-align: center;">{{d[i].deliverTypeName}}</div>
                            </td>
                            <td rowspan="{{rows}}">
                                <div>商品金额：<span style="color: red">¥{{d[i].goodsMoney}}</span></div>
                                <div class='line'>运费：<span style="color: red">¥{{d[i].deliverMoney}}</span></div>
                                <div>实付金额：<span style="color: red">¥{{d[i].realTotalMoney}}</span></div>
                            </td>
                            <td rowspan="{{rows}}" width="110">
                                {{# if(d[i].orderStatus==1 && d[i].hasExpress==1){ }}
                                <div style="text-align: center;"><a href='#none' onclick='javascript:toEditOrderExpressInfo({{d[i].orderId}})'>【修改物流信息】</a></div>
                                {{#}}}
                                <div style="text-align: center;"><a target='blank' href='{{WST.U("shop/orders/orderPrint","id="+d[i].orderId)}}'>【打印订单】</a></div>
                                <div style="text-align: center;"><a href='#none' onclick="view({{d[i].orderId}},'delivered')">【订单详情】</a></div>
                                <div style="text-align: center;"><a href='#none' onclick="remarks({{d[i].orderId}},'delivered')">【备注订单】</a></div>
                                <?php echo hook('shopDocumentOrderListBtn'); ?>
                            </td>
                            {{#}}}
                         </tr>
                         {{# } }}
                          {{# if(WST.blank(d[i].orderRemarks)!=''){  }}
                         <tr>
                          <td colspan="4">
                               <div class="order_remaker">
                               【用户留言】{{d[i].orderRemarks}}
                               </div>
                          </td>
                         </tr>
                         {{# }  }}
                         <tr class='empty-row' style="border: 0px;">
                            <td colspan='4'>&nbsp;</td>
                         </tr>
                       </tbody>
                       {{# } }}
                       </script>
                  </table>
                  <div class="layui-none" style="display: none">无数据</div>
              </div>
          </div>
          <div id='pager' class="layui-table-column layui-table-page" align="right" style='padding:5px 0px 5px 0px'>&nbsp;</div>
      </div>
      <div id='deliverBox' style='display:none'>
          <div id="express-box"></div>
          <script id="expressList" type="text/html">
              <form id='deliverForm' autocomplete='off'>
              {{# for(var i = 0; i < d.length; i++){ }}
                  <input type="hidden" class="orderExpressId" value="{{d[i].id}}">
                  <table class='wst-form wst-box-top'>
                      <tr>
                          <div class="wst-flex-row wst-center express-title">包裹{{i+1}}</div>
                      </tr>
                      <tr class="deliver_express">
                          <th width='80'>快递公司：</th>
                          <td width='200'>
                              <select class='expressId'>
                                  <option value='0'>请选择</option>
                                  <?php if(is_array($express) || $express instanceof \think\Collection || $express instanceof \think\Paginator): $i = 0; $__LIST__ = $express;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                  <option value='<?php echo $vo["id"]; ?>' ><?php echo $vo["expressName"]; ?></option>
                                  <?php endforeach; endif; else: echo "" ;endif; ?>
                              </select>
                          </td>
                          <th width='80'>快递号：</th>
                          <td><input type='text' class='expressNo' maxLength='20' style='width:80%' value="{{d[i].expressNo}}"></td>
                      </tr>
                  </table>
              {{# } }}
              </form>
          </script>
      </div>
  </div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type="text/javascript" src="/hkshopNC/dxshop/static/js/jquery.min.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='__SHOP__/orders/orders.js?v=<?php echo $v; ?>'></script>
<script>
$(function(){
    WST.initTabHeight(90);
    $(window).resize(function(){
        WST.initTabHeight(90);
    })
	deliveredByPage(<?php echo $p; ?>);
})
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
