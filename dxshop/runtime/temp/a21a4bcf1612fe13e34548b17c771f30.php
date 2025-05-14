<?php /*a:2:{s:77:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\reports\stat_sales.html";i:1669390456;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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
#mainTable{width:95%;text-align:center;border:1px solid #eee;margin: 0px auto;margin-bottom:40px;font-size:13px;}
.wst-list .num{text-align:center;}
.wst-list tr th{background:#f5f5f5;border-bottom:1px solid #eee;}
.wst-list tr td,.wst-list tr th {height: 35px;line-height: 35px;}
.wst-list tr td{border-bottom:1px dotted #eee;}
.wst-list tbody tr:hover{background:#f5f5f5;}
</style>
<div class='wst-page'>
<div class='wst-toolbar'>
    <span style="float: left; line-height: 40px">日期：</span><input type='text' class="laydate-icon j-ipt" id='startDate' value='<?php echo $startDate; ?>'/> <span style="line-height: 40px;">至</span>
    <input type='text' class="laydate-icon j-ipt" id='endDate' value='<?php echo $endDate; ?>'/>
    <span style="line-height: 40px">支付方式：</span><select id='payType' class='j-ipt'>
       <option value='-1'>全部</option>
       <option value='0'>货到付款</option>
       <option value='1'>在线支付</option>
    </select>
    <a class="s-btn btn btn-primary" onclick="loadStat()"><i class="fa fa-search"></i>查询</a>
    <a class="s-btn btn btn-primary f-right" onclick="toExport()"><i class="fa fa-sign-in"></i>导出</a>
</div>
<div class='wst-shop-content'>
    <div class="wst-tips-box">
        <div class="icon"></div>
        <div class="tips">该统计不含未支付的订单</div>
        <div style="clear:both"></div>
    </div>
    <div id='main' style='height:400px;width:99%'></div>
    <table id='mainTable' class='wst-list'>
        <thead>
            <tr>
              <th width='20'>&nbsp;&nbsp;</th>
              <th width='100'>日期</th>
              <th width='100'>订单数</th>
              <th width='130'>销售额</th>
              <th width='130'>取消金额</th>
              <th width='130'>拒收金额</th>
            </tr>
        </thead>
        <tbody id='list-box'></tbody>
        <script id="stat-tblist" type="text/html">
        {{# for(var i = 0; i < d.length; i++){ }}
            <tr>
              <td class='num'>{{(i+1)}}</td>
              <td>{{ d[i].day }}</td>
              <td>{{ d[i].num }}</td>
              <td>￥{{ d[i].val }}</td>
              <td>￥{{ d[i].cancelVal }}</td>
              <td>￥{{ d[i].rejectVal }}</td>
            </tr>
        {{# } }}
        </script>
    </table>
</div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script src="/hkshopNC/dxshop/static/plugins/echarts/echarts.min.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script type='text/javascript' src='__SHOP__/reports/stat_sales.js?v=<?php echo $v; ?>'></script>
<script>
$(function(){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    loadStat();
})
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
