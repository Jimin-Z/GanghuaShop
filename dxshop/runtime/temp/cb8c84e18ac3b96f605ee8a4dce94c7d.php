<?php /*a:2:{s:70:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\orders\view.html";i:1738420029;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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
    .express-text{width:150px;height:40px;line-height:40px;text-align: right;color:#333;font-size:12px;}
    .express-val{height:40px;line-height:40px;font-size:12px;}
    .express-line{width:300px;margin:0 0 0px 90px;border-bottom:1px dashed #999;}
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
<div class='wst-grid'>
   <div class='order-box'>
    <div class='box-head'>日志信息</div>
    <?php if(in_array($object['orderStatus'],[-2,0,1,2])): ?>
	<div class='log-box'>
<div class="state">
<?php if($object['payType']==1): ?>
<div class="icon">
	<span class="icons <?php if(($object['orderStatus']==-2)OR($object['orderStatus']==0)OR($object['orderStatus']==1)OR($object['orderStatus']==2)): ?>icon12 <?php else: ?>icon11 <?php endif; if(($object['orderStatus']==-2)): ?>icon13 <?php endif; ?>"></span>
</div>
<div class="arrow <?php if(($object['orderStatus']==0) OR ($object['orderStatus']==1) OR ($object['orderStatus']==2)): ?>arrow2<?php endif; ?>">··························></div>
	<div class="icon"><span class="icons <?php if(($object['orderStatus']==0)OR($object['orderStatus']==1)OR($object['orderStatus']==2)): ?>icon22 <?php else: ?>icon21<?php endif; if(($object['orderStatus']==0)): ?>icon23 <?php endif; ?>"></span></div>
	<div class="arrow <?php if(($object['orderStatus']==1) OR ($object['orderStatus']==2)): ?>arrow2<?php endif; ?>">····························></div>
<?php else: ?>
<div class="icon">
	<span class="icons <?php if(($object['orderStatus']==-2)OR($object['orderStatus']==0)OR($object['orderStatus']==1)OR($object['orderStatus']==2)): ?>icon12 <?php else: ?>icon11 <?php endif; if(($object['orderStatus']==0)): ?>icon13 <?php endif; ?>"></span>
</div>
<div class="arrow <?php if(($object['orderStatus']==1) OR ($object['orderStatus']==2)): ?>arrow2<?php endif; ?>">··························></div>
<?php endif; ?>
<div class="icon">
	<span class="icons <?php if(($object['orderStatus']==1)OR($object['orderStatus']==2)OR($object['orderStatus']==1)): ?>icon32 <?php else: ?>icon31 <?php endif; if(($object['orderStatus']==1)): ?>icon33 <?php endif; ?>"></span>
</div>
<div class="arrow <?php if(($object['orderStatus']==2)): ?>arrow2<?php endif; ?>">····························></div>
<div class="icon"><span class="icons  <?php if(($object['orderStatus']==2)AND($object['isAppraise']==1)): ?>icon42 <?php else: ?>icon41 <?php endif; if(($object['orderStatus']==2)AND($object['isAppraise']==0)): ?>icon43 <?php endif; ?>"></span></div>
<div class="arrow <?php if(($object['isAppraise']==1)): ?>arrow2<?php endif; ?>">····························></div>
<div class="icon"><span class="icons <?php if(($object['isAppraise']==1)): ?>icon53 <?php else: ?>icon51 <?php endif; ?>"></span></div>
</div>
   <div class="state2">
   <div class="path">
   <?php if(is_array($object['log']) || $object['log'] instanceof \think\Collection || $object['log'] instanceof \think\Paginator): $i = 0; $__LIST__ = $object['log'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lo): $mod = ($i % 2 );++$i;?>
   	<span><?php echo $lo['logContent']; ?><br/><?php echo $lo['logTime']; ?></span>
   <?php endforeach; endif; else: echo "" ;endif; ?>
   </div>
   <p>下单</p><?php if($object['payType']==1): ?><p>等待支付</p><?php endif; ?><p>商家发货</p><p>确认收货</p><p>订单结束<br/>双方互评</p>
   </div>
   <div class="f-clear"></div>
   </div>
    <?php else: ?>
        <div>
          <table class='log'>
            <?php if(is_array($object["log"]) || $object["log"] instanceof \think\Collection || $object["log"] instanceof \think\Paginator): $i = 0; $__LIST__ = $object["log"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
             <tr>
               <td><?php echo $vo['logTime']; ?></td>
               <td><?php echo $vo['logContent']; ?></td>
             </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </table>
        </div>
    <?php endif; ?>
   </div>
   <!-- 订单信息 -->
   <div class='order-box'>
      <div class='box-head'>订单信息</div>
      <table class='wst-form'>
         <tr>
           <th width='100'>订单编号：</th>
           <td><?php echo $object['orderNo']; ?></td>
         </tr>
         <tr>
           <th>支付方式：</th>
           <td><?php echo WSTLangPayType($object['payType']); ?></td>
         </tr>
         <?php if(($object['payType']==1 && $object['isPay']==1)): ?>
         <tr>
           <th>支付时间：</th>
           <td><?php echo $object['payTime']; ?></td>
         </tr>
         <tr>
           <th>支付信息：</th>
           <td>【<?php echo WSTLangPayFrom($object['payFrom']); ?>】<?php echo $object['tradeNo']; ?></td>
         </tr>
         <?php endif; if(($object['orderType']==0)): ?>
         <tr>
            <th>配送方式：</th>
            <td>
            <?php echo WSTLangDeliverType($object['deliverType']); ?>
            </td>
         </tr>
          <?php endif; ?>
         <tr>
            <th>用户留言：</th>
            <td><?php echo $object['orderRemarks']; ?></td>
         </tr>
      </table>
   </div>
   <?php echo hook('shopDocumentOrderView',['orderId'=>$object['orderId']]); if($object['isRefund']==1): ?>
   <!-- 退款信息 -->
   <div class='order-box'>
      <div class='box-head'>退款信息</div>
      <table class='wst-form'>
         <tr>
            <th width='100'>退款金额：</th>
            <td>¥<?php echo $object['backMoney']; ?></td>
         </tr>
         <tr>
            <th width='100'>退款备注：</th>
            <td><?php echo $object['refundRemark']; ?></td>
         </tr>
         <tr>
            <th>退款时间：</th>
            <td><?php echo $object['refundTime']; ?></td>
         </tr>
      </table>
   </div>
   <?php endif; ?>
   <!-- 发票信息 -->
   <div class='order-box'>
      <div class='box-head'>发票信息</div>
      <table class='wst-form'>
         <tr>
           <th width='100'>是否需要发票：</th>
           <td><?php if($object['isInvoice']==1): ?>需要<?php else: ?>不需要<?php endif; ?></td>
         </tr>

          <tr>
              <th width='100'>发票状态：</th>
              <td><?php if($object['isMakeInvoice']==1): ?>已开<?php else: ?>未开<?php endif; ?></td>
          </tr>

         <?php if($object['isInvoice']==1): $invoiceArr = json_decode($object['invoiceJson'],true); ?>
         <tr>
           <th>发票抬头：</th>
           <td>
            <?php if($object['isInvoice']==1): ?>
              <?php echo $invoiceArr['invoiceHead']; ?>
            <?php endif; ?>
          </td>
         </tr>
        <?php if(isset($invoiceArr['invoiceCode'])): ?>
         <tr>
           <th>发票税号：</th>
           <td>
              <?php echo $invoiceArr['invoiceCode']; ?>
          </td>
         </tr>
         <?php endif; if(isset($invoiceArr['invoiceType']) && $invoiceArr['invoiceType']==1): ?>
          <tr>
              <th>注册地址：</th>
              <td>
                  <?php echo $invoiceArr['invoiceAddr']; ?>
              </td>
          </tr>
          <tr>
              <th>注册电话：</th>
              <td>
                  <?php echo $invoiceArr['invoicePhoneNumber']; ?>
              </td>
          </tr>
          <tr>
              <th>开户银行：</th>
              <td>
                  <?php echo $invoiceArr['invoiceBankName']; ?>
              </td>
          </tr>
          <tr>
              <th>银行账号：</th>
              <td>
                  <?php echo $invoiceArr['invoiceBankNo']; ?>
              </td>
          </tr>
          <?php endif; ?>
        <?php endif; ?>
      </table>
   </div>
    <!-- 收货人信息 -->
   <?php if(($object['orderType']==0)): if(($object['deliverType']==0)): ?>
       <div class='order-box'>
          <div class='box-head'>收货人信息</div>
          <table class='wst-form'>
             <tr>
               <th width='100'>收货人：</th>
               <td><?php echo $object['userName']; ?></td>
             </tr>
             <?php if(($object['deliverType']==0)): ?>
             <tr>
               <th>收货地址：</th>
               <td><?php echo $object['userAddress']; ?></td>
             </tr>
             <?php endif; ?>
             <tr>
                <th>联系方式：</th>
                <td><?php echo $object['userPhone']; ?></td>
             </tr>
          </table>
       </div>
        <?php if($object['expressData']): ?>
        <div class='order-box' id="expressDataBox">
            <div class='box-head'>物流信息</div>
            <div class='wst-form'>
                <?php if(is_array($object['expressData']) || $object['expressData'] instanceof \think\Collection || $object['expressData'] instanceof \think\Paginator): $i = 0; $__LIST__ = $object['expressData'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="wst-flex-row">
                    <div class="express-text">物流公司：</div>
                    <div class="express-val"><?php echo $vo['expressName']; ?></div>
                </div>
                <div class="wst-flex-row">
                    <div class="express-text">物流单号：</div>
                    <div class="express-val"><?php echo $vo['expressNo']; ?></div>
                </div>
                <?php if(($key+1)!=count($object['expressData'])): ?><div class="express-line"></div><?php endif; ?>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <?php endif; ?>
      <?php endif; if(($object['deliverType']==1)): ?>
       <div class='order-box'>
          <div class='box-head'>自提信息</div>
          <table class='wst-form'>
            <?php if((isset($object['store']))): ?>
            <tr>
               <th width='100'>自提门店：</th>
               <td><?php echo $object['store']['storeName']; ?></td>
             </tr>
             <tr>
               <th width='100'>联系电话：</th>
               <td><?php echo $object['store']['storeTel']; ?></td>
             </tr>
             <tr>
               <th width='100'>自提地址：</th>
               <td><?php echo $object['store']['areaNames']; ?><?php echo $object['store']['storeAddress']; ?></td>
             </tr>
            <?php else: ?>
            <tr>
               <th width='100'>自提地址：</th>
               <td><?php echo $object['shopAddress']; ?></td>
            </tr>
            <?php endif; ?>
          </table>
       </div>
     <?php endif; ?>
   <?php endif; ?>
   <!-- 商品信息 -->
   <div class='order-box'>
       <div class='box-head'>商品清单</div>
       <div class='goods-head'>
          <div class='goods'>商品</div>
          <div class='number'>商品货号</div>
          <div class='price'>单价</div>
          <div class='num'>数量</div>
          <div class='t-price'>总价</div>
       </div>
       <div class='goods-item'>
          <div class='shop'>
          <?php echo $object['shopName']; if($object['shopQQ'] !=''): ?>
          <a href="tencent://message/?uin=<?php echo $object['shopQQ']; ?>&Site=QQ交谈&Menu=yes">
			  <img border="0" style='vertical-align:middle;' src="<?php echo WSTProtocol(); ?>wpa.qq.com/pa?p=1:<?php echo $object['shopQQ']; ?>:7" alt="QQ交谈" width="71" height="24" />
		  </a>
          <?php endif; if($object['shopWangWang'] !=''): ?>
          <a target="_blank" href="<?php echo getWeliveUrl("客户服务"); ?>">
			  <img border="0" style='vertical-align:middle;' src="<?php echo WSTProtocol(); ?>amos.alicdn.com/realonline.aw?v=2&uid=<?php echo $object['shopWangWang']; ?>&site=cntaobao&s=1&charset=utf-8" alt="和我联系" />
		  </a>
          <?php endif; ?>
          </div>
          <div class='goods-list'>
             <?php if(is_array($object["goods"]) || $object["goods"] instanceof \think\Collection || $object["goods"] instanceof \think\Paginator): $i = 0; $__LIST__ = $object["goods"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
             <?php echo hook('shopDocumentOrderViewGoodsPromotion',['goods'=>$vo2]); ?>
             <div class='item j-g<?php echo $vo2['goodsId']; ?>'>
		         <div class='goods'>
		            <div class='img'>
		                <a href='<?php echo Url("home/goods/detail","goodsId=".$vo2["goodsId"]); ?>' target='_blank'>
			            <img src='__RESOURCE_PATH__/<?php echo $vo2["goodsImg"]; ?>' width='80' height='80' title='<?php echo WSTStripTags($vo2["goodsName"]); ?>'/>
			            </a>
		            </div>
		            <div class='name'><?php if($vo2['goodsCode']=='gift'): ?>【赠品】<?php endif; ?><?php echo $vo2["goodsName"]; ?></div>
		            <div class='spec'><?php echo str_replace('@@_@@','<br/>',$vo2["goodsSpecNames"]); ?></div>
		         </div>
		         <div class="number"><?php echo $vo2['productNo']; ?></div>
		         <div class='price' style="color: red">¥<?php echo $vo2['goodsPrice']; ?></div>
		         <div class='num'><?php echo $vo2['goodsNum']; ?></div>
		         <div class='t-price' style="color: red">¥<?php echo $vo2['goodsPrice']*$vo2['goodsNum']; ?></div>
		         <div class='f-clear'></div>
             </div>
             <?php if($vo2['goodsType']==1 && $object['orderStatus']==2): ?>
             <table width='100%' style='margin-top:5px;'>
             <?php if(is_array($vo2["extraJson"]) || $vo2["extraJson"] instanceof \think\Collection || $vo2["extraJson"] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo2["extraJson"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vgcard): $mod = ($i % 2 );++$i;?>
               <tr>
                 <td>卡券号：<?php echo $vgcard['cardNo']; ?></td>
                 <td>卡券密码：<?php echo $vgcard['cardPwd']; ?></td>
               </tr>
             <?php endforeach; endif; else: echo "" ;endif; ?>
             </table>
             <?php endif; ?>
             <?php endforeach; endif; else: echo "" ;endif; ?>
          </div>
       </div>
       <div class='goods-footer'>
          <div class='goods-summary' style='text-align:right'>
             <div class='summary'>商品总金额：¥<span style="color: red"><?php echo $object['goodsMoney']; ?></span></div>
             <div class='summary'>运费：¥<span style="color: red"><?php echo $object['deliverMoney']; ?></span></div>
             <div class='summary line'>应付总金额：¥<span style="color: red"><?php echo $object['totalMoney']; ?></span></div>
             <?php echo hook('shopDocumentOrderSummaryView',['order'=>$object]); if($object['useScore'] > 0): ?>
             <div class='summary '>使用积分数：<span style="color: red"><?php echo $object['useScore']; ?>个</span></div>
             <div class='summary'>积分抵扣金额：¥-<span style="color: red"><?php echo $object['scoreMoney']; ?></span></div>
             <?php endif; ?>
             <div class='summary'>实付总金额：¥<span style="color: red"><?php echo $object['realTotalMoney']; ?></span></div>
             <div>可获得积分：<span class='orderScore' style="color: red"><?php echo $object["orderScore"]; ?></span>个</div>
          </div>
       </div>
   </div>
<div style="text-align: center;margin: 20px 0;"><button type="button" class="btn" onclick="toBacks(<?php echo $p; ?>,'<?php echo $src; ?>')"><i class="fa fa-angle-double-left"></i>返&nbsp;回</button></div>
</div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='__SHOP__/orders/orders.js?v=<?php echo $v; ?>'></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
