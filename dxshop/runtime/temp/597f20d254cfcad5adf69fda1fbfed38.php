<?php /*a:2:{s:84:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\orders\list_wait_delivery.html";i:1670210818;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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
.notice{padding: 3px 6px;color: #e55454}
.notice_icon{vertical-align: text-bottom;}
#deliverForm{margin:1rem;}
.delivery_good img{width:50px;height:50px;margin:10px;}
.goods_info{border: 1px solid #f1f1f1;}
.goods_info th{background: #F3F7FD;}
.goods_info tr th,.goods_info tr td{text-align: center;}
label{font-weight: normal;;margin-right:15px;}
input[type=text], input[type=password] {
    border: 1px solid #f1f1f1 !important;
    height: 30px !important;
    line-height: 17px !important;
    padding: 2px !important;
    width:175px !important;
}
select{
    width:auto !important;
}
/**修改用户地址**/
.add-addr{font-weight: normal;color:#005ea7;display: block;float:right;margin-right: 5px;}
.add-addr:hover{color:red;}
.address-box{border-top:2px solid #FC7A64;border-left:1px solid #eeeeee;border-right:1px solid #eeeeee;padding:5px 0px 10px 10px;}
.j-show-box,.j-edit-box,.j-list-box,.wst-list-box,.invoic-box{padding:5px 0px 20px 15px;}
.j-list-box li{height:40px;line-height:40px;}
.j-edit-box .rows{width:auto;height:auto;}
.j-edit-box .label{float:left;width:120px;text-align:right;padding:2px 0px 2px 0px;color:#333 !important;line-height: 38px !important;;}
.j-edit-box .field{float:left;padding:2px 0px 2px 0px;}
.field label{margin-right:20px;}
#saveAddressBtn{margin-left:120px;background:#1890ff;}
.j-show-box .address{line-height:36px;}
.j-show-box .address a{color: #1c9eff;}
.j-show-box .address a:hover{text-decoration:underline;}
.wst-frame1.j-selected i,.wst-frame2.j-selected i{font-size: 0;line-height: 0;background: url(../img/img_gd_sel.png) no-repeat 0 0;display: block; width: 11px;height: 11px;position: absolute;z-index: 1;right: -1px;bottom: -1px;}
.wst-cart-reda{font-size: 14px;color:#ffffff;background: #df2003;text-align:center;border-radius:3px;font-family:"microsoft yahei";box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);}
.wst-cart-reda:hover{color:#ffffff;background:#ea3232;box-shadow: 0 0px 0px rgba(0, 0, 0, 0.3);}
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


      <a class="btn btn-primary" onclick="waitDivleryByPage()"><i class="fa fa-search"></i>查询</a>
      <a class="btn btn-primary" style="float:right;" onclick="javascript:toExportDeliver()"><i class="fa fa-sign-out"></i>导入发货单</a>
      <a class="btn btn-primary" style="float:right;margin-right:10px" onclick="javascript:toDeliverTemplate()"><i class="fa fa-sign-out"></i>导出发货模板</a>
      <a class="btn btn-primary" style="float:right;margin-right:10px" onclick="javascript:toExport(2,0,'',1)"><i class="fa fa-sign-out"></i>导出订单</a>
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
                       <tbody class="j-order-row">
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
                                    {{# if(d[i].noticeDeliver==1){ }}
                                    <span class="notice">
                                      <img class="notice_icon" src="__SHOP__/img/nocite_deliver.png" alt="发货提醒" width="20" height="20" />
                                      尽快发货
                                    </span>
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
                                    <span class='weixin'><img class='img gImg' title='{{tmp.goodsName}}' style='height:40px;width:40px;' data-original='__RESOURCE_PATH__/{{tmp.goodsImg}}'><img class='imged' style='height:200px;width:200px;max-width: 200px;max-height: 200px; background: #fff;' title='{{tmp.goodsName}}' src="__RESOURCE_PATH__/{{tmp.goodsImg}}"></span>
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
                            <td rowspan="{{rows}}">
                                <div style="text-align: center;"><a href='#none' onclick='javascript:deliver({{d[i].orderId}},{{d[i].deliverType}})'>【发货】</a></div>
                                {{# if(d[i].deliverType==0 && d[i].isDeliver==0){ }}
                                <div style="text-align: center;"><a href='#none' onclick='javascript:toEditOrderReceiveInfo({{d[i].orderId}})'>【修改收货地址】</a></div>
                                {{#}}}
                                <div style="text-align: center;"><a target='blank' href='{{WST.U("shop/orders/orderPrint","id="+d[i].orderId)}}'>【打印订单】</a></div>
                                <div style="text-align: center;"><a href='#none' onclick="view({{d[i].orderId}},'waitDelivery')">【订单详情】</a></div>
                                <div style="text-align: center;"><a href='#none' onclick="remarks({{d[i].orderId}},'waitDelivery')">【备注订单】</a></div>
                                <?php echo hook('shopDocumentOrderListBtn'); ?>
                            </td>
                            {{#}}}
                         </tr>
                         {{# } }}
                         {{# if(WST.blank(d[i].orderRemarks)!=''){  }}
                         <tr>
                          <td colspan="4">
                               <div class="order_remaker">【用户留言】{{d[i].orderRemarks}}</div>
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
       <form id='deliverForm' autocomplete='off'>
        <table class='wst-form wst-box-top goods_info' border="1" >
           <tr>
            <th class='delivery_select'><input type='checkbox' onclick="javascript:WST.checkChks(this,'.chk')"/></th>
            <th>图片</th><th width=500>商品</th><th>数量</th><th>状态</th>
          </tr>
          <tbody id='goods_info'></tbody>
        </table>
       <table class='wst-form wst-box-top'>
           <tr>
               <th width='80'>发货方式：</th>
               <td>
                  <label>
                   <input type='radio'  name='delivery_type' value='0' >无需物流</input>
                   </label>
                   <label>
                   <input type='radio'  name='delivery_type' checked value='1' >需要物流</input>
                  </label>
               </td>
           </tr>
           <tr class="deliver_express">
            <th width='80'>快递公司：</th>
                <td>
                   <select id='expressId'>
                      <option value=''>请选择</option>
                      <?php if(is_array($express) || $express instanceof \think\Collection || $express instanceof \think\Paginator): $i = 0; $__LIST__ = $express;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                      <option value='<?php echo $vo["id"]; ?>'><?php echo $vo["expressName"]; ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                   </select>
                </td>
          </tr>
          <tr class="deliver_express">
                <th>快递号：</th>
                <td><input type='text' id='expressNo' maxLength='20' style='width:80%'></td>
           </tr>
           <tr>
               <th>收货人：</th>
               <td class="user_name"></td>
           </tr>
           <tr>
               <th>收货地址：</th>
               <td class="user_address"></td>
           </tr>
           <tr>
               <th>联系电话：</th>
               <td class="user_phone"></td>
           </tr>
       </table>
       </form>
    </div>
    <div id='editMoneyBox' style='display:none'>
       <form id='newOrderForm' autocomplete='off'>
       <table class='wst-form wst-box-top'>
          <tr>
            <th width='120'>订单号：</th>
            <td><span id='m_orderNo'></span></td>
          </tr>
          <tr>
            <th>商品总价格：</th>
            <td>¥<span id='m_goodsMoney'></span></td>
          </tr>
          <tr>
            <th>运费：</th>
            <td>¥<span id='m_deliverMoney'></span></td>
          </tr>
          <tr>
            <th>商品总价格：</th>
            <td>¥<span id='m_totalMoney'></span></td>
          </tr>
           <tr>
            <th>实际支付价格：</th>
            <td>¥<span id='m_realTotalMoney' class='j-warn-order-money'></span></td>
          </tr>
          <tr>
            <th>新价格：</th>
            <td><input type='text' id='m_newOrderMoney' maxLength='10' style='width:150px' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberdoteKey(event,true)" onblur='javascript:WST.limitDecimal(this,2)'></td>
          </tr>
       </table>
       </form>
    </div>
  </div>
<!-- 新增编辑地址 -->
<div class='j-edit-box hide'>
    <form id='addressForm' autocomplete='off'>
        <input type='hidden' class='j-eipt' id='orderId' value=''/>
        <div class='wst-flex-row'>
            <div class='label'>收货人<font color='red'>*</font>：</div>
            <div class='field'><input type='text' class='j-eipt' id='userName' maxLength='15'/></div>
            <div class='wst-clear'></div>
        </div>
        <div class='wst-flex-row'>
            <div class='label'>收货地址<font color='red'>*</font>：</div>
            <div class='field'>
                <select id="area_0" class='j-areas' level="0" onchange="WST.ITAreas({id:'area_0',val:this.value,isRequire:true,className:'j-areas'});">
                    <option value="">-请选择-</option>
                    <?php if(is_array($areaList) || $areaList instanceof \think\Collection || $areaList instanceof \think\Paginator): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['areaId']; ?>"><?php echo $vo['areaName']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>

            </div>
            <div class='wst-clear'></div>
        </div>
        <div class='wst-flex-row'>
            <div class='label'>详细地址<font color='red'>*</font>：</div>
            <div class='field'><input type='text' class='j-eipt' id='userAddress' style='width:300px' maxLength='50'/>  </div>
            <div class='wst-clear'></div>
        </div>
        <div class='wst-flex-row'>
            <div class='label'>联系电话<font color='red'>*</font>：</div>
            <div class='field'><input type='text' id='userPhone' class='j-eipt' name="addrUserPhone" maxLength='11'/>  </div>
            <div class='wst-clear'></div>
        </div>
        <div class='rows'>
            <a href='javascript:void(0)' class='wst-cart-reda' id='saveAddressBtn' onclick='javascript:saveAddress()' style='width:105px;line-height:33px;padding:6px 15px;color:#fff !important;text-decoration:none !important;'>保存收货人地址</a>
        </div>
    </form>
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
	waitDivleryByPage(<?php echo $p; ?>);
    $("input[name='delivery_type']").change(function() {
        if (this.value == 1) {
            $('.deliver_express').show();
        }else{
            $('.deliver_express').hide();
        }
    });
})
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
