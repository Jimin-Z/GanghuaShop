<?php /*a:2:{s:66:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\sysconfigs\buy.html";i:1614070806;s:56:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\base.html";i:1669564546;}*/ ?>
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

	<fieldset class="layui-elem-field layui-field-title">
	  <legend>订单设置</legend>
	  <table class='wst-form wst-box-top layui-form'>
	  <tr>
	     <th width='150'>开启积分支付：</th>
	     <td>
	      <input type="checkbox" <?php if($object['isOpenScorePay']==1): ?>checked<?php endif; ?> class="ipt" id="isOpenScorePay" name="isOpenScorePay" value='1' lay-skin="switch" lay-filter="isOpenScorePay" lay-text="开|关">
	     </td>
	  </tr>
	  <tr class='scoreToMoneyTr' <?php if($object['isOpenScorePay']==0): ?>style='display:none'<?php endif; ?>>
	     <th>积分兑换金额：</th>
	     <td>
	     积分支付时<input type="text" id='scoreToMoney' class='ipt' value="<?php echo $object['scoreToMoney']; ?>" maxLength='5' style='width:60px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>个积分抵1元
	     </td>
	  </tr>
	  <tr class='scoreToMoneyTr' <?php if($object['isOpenScorePay']==0): ?>style='display:none'<?php endif; ?>>
	     <th>下单可用积分比例：</th>
	     <td>
	      <input type="text" id='orderUsableScoreRate' class='ipt' value="<?php echo $object['orderUsableScoreRate']; ?>" maxLength='3' style='width:60px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>%
	     </td>
	  </tr>
	  <tr>
	     <th>开启下单获积分：</th>
	     <td>
	      <input type="checkbox" <?php if($object['isOrderScore']==1): ?>checked<?php endif; ?> class="ipt" id="isOrderScore" name="isOrderScore" value='1' lay-skin="switch" lay-filter="isOrderScore" lay-text="开|关">
	     </td>
	  </tr>
	  <tr id='moneyToScoreTr' <?php if($object['isOrderScore']==0): ?>style='display:none'<?php endif; ?>>
	     <th>金额兑换积分：</th>
	     <td>
	     下单后订单金额1元可获得<input type="text" id='moneyToScore' class='ipt' value="<?php echo $object['moneyToScore']; ?>" maxLength='5' style='width:60px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberdoteKey(event)"/>个积分
	     <span style='color:gray;'>
	     </span>
	     </td>
	  </tr>
	  <tr>
	     <th>开启评价获积分：</th>
	     <td>
	     <input type="checkbox" <?php if($object['isAppraisesScore']==1): ?>checked<?php endif; ?> class="ipt" id="isAppraisesScore" name="isAppraisesScore" value='1' lay-skin="switch" lay-filter="isAppraisesScore" lay-text="开|关">
	     </td>
	  </tr>
	  <tr id='appraisesScoreTr' <?php if($object['isAppraisesScore']==0): ?>style='display:none'<?php endif; ?>>
	     <th>评价获得积分：</th>
	     <td>
	     <input type="text" id='appraisesScore' class='ipt' value="<?php echo $object['appraisesScore']; ?>" maxLength='5' style='width:60px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberdoteKey(event)"/>个积分
	     <span style='color:gray;'>
	     </span>
	     </td>
	  </tr>
	  <tr>
	  <tr style='display:none'>
	     <th>积分与金钱兑换比例：</th>
	     <td><input type="text" id='scoreCashRatio' class='ipt' value="<?php echo $object['scoreCashRatio']; ?>" maxLength='20'/></td>
	  </tr>
	  </table>
	</fieldset>


	<fieldset class="layui-elem-field layui-field-title">
	  <legend>信息设置</legend>
	  <table class='wst-form wst-box-top layui-form'>
	  <tr>
	     <th width='150'>商城咨询默认显示：</th>
	     <td>
	      <input type="checkbox" <?php if($object['isConsult']==1): ?>checked<?php endif; ?> class="ipt" id="isConsult" name="isConsult" value='1' lay-skin="switch" lay-filter="isConsult" lay-text="是|否">
	     </td>
	  </tr>
	  <tr>
	     <th width='150'>订单评价默认显示：</th>
	     <td>
	      <input type="checkbox" <?php if($object['isAppraise']==1): ?>checked<?php endif; ?> class="ipt" id="isAppraise" name="isAppraise" value='1' lay-skin="switch" lay-filter="isAppraise" lay-text="是|否">
	     </td>
	  </tr>
	  </table>
	</fieldset>
	<fieldset class="layui-elem-field layui-field-title">
	  <legend>提现设置</legend>
	  <table class='wst-form wst-box-top layui-form'>
	  <tr>
	     <th width='150'>用户提现设置：</th>
	     <td>至少<input type="text" id='drawCashUserLimit' class='ipt' value="<?php echo $object['drawCashUserLimit']; ?>" maxLength='10' style='width:80px' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>元以上方能申请提现。</td>
	  </tr>
	  <tr>
	     <th>商家提现设置：</th>
	     <td>至少<input type="text" id='drawCashShopLimit' class='ipt' value="<?php echo $object['drawCashShopLimit']; ?>" maxLength='10' style='width:80px' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>元以上方能申请提现。</td>
	  </tr>
      <tr>
          <th width='150'>余额提现手续费：</th>
          <td><input type="text" id='drawCashCommission' class='ipt' value="<?php echo $object['drawCashCommission']; ?>" maxLength='10' style='width:80px' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return  WST.isNumberKey(event)"/>% (余额提现手续费设置范围:0至100)</td>
      </tr>
	  </table>
	</fieldset>

	<fieldset class="layui-elem-field layui-field-title">
	  <legend>定时设置</legend>
	  <table class='wst-form wst-box-top layui-form'>
	  <tr>
	     <th width='170'>未支付订单失效时间：</th>
	     <td>下单后<input type="text" id='autoCancelNoPayDays' class='ipt' value="<?php echo $object['autoCancelNoPayDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>小时</td>
	  </tr>
	  <tr>
	     <th>自动收货期限：</th>
	     <td>发货后<input type="text" id='autoReceiveDays' class='ipt' value="<?php echo $object['autoReceiveDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>天自动收货</td>
	  </tr>
	  <tr>
	     <th>自动评价期限：</th>
	     <td>确认收货后<input type="text" id='autoAppraiseDays' class='ipt' value="<?php echo $object['autoAppraiseDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>天自动好评</td>
	  </tr>
	  <tr>
		  <th>商家处理退款期限：</th>
		  <td>用户申请退款后<input type="text" id='shopHandleRefundDays' class='ipt' value="<?php echo $object['shopHandleRefundDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>天商家不处理，系统自动同意退款申请</td>
	  </tr>
	  <?php if(WSTConf('CONF.isOpenSupplierApply')==1): ?>
	  <tr>
		  <th>供货商处理退款期限：</th>
		  <td>商家申请退款后<input type="text" id='supplierHandleRefundDays' class='ipt' value="<?php echo $object['supplierHandleRefundDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>天供货商不处理，系统自动同意退款申请</td>
	  </tr>
	  <?php endif; ?>
	  <tr>
	     <th>售后-售后服务期限：</th>
	     <td>
			 确认收货后<input type="text" id='afterSaleServiceDays' class='ipt' value="<?php echo $object['afterSaleServiceDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>天
			 (售后服务期限 > 商家受理期限+用户发货期限+商家收货期限+商家发货期限+用户收货期限 )
		</td>
	  </tr>
	  <tr>
	     <th>售后-商家受理期限：</th>
	     <td>用户提交售后单后<input type="text" id='shopAcceptDays' class='ipt' value="<?php echo $object['shopAcceptDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>天</td>
	  </tr>
	  <tr>
	     <th>售后-用户发货期限：</th>
	     <td>商家受理售后单后<input type="text" id='userSendDays' class='ipt' value="<?php echo $object['userSendDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>天</td>
	  </tr>
	  <tr>
	     <th>售后-商家收货期限：</th>
	     <td>用户发货后<input type="text" id='shopReceiveDays' class='ipt' value="<?php echo $object['shopReceiveDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>天</td>
	  </tr>
	  <tr>
		<th>售后-商家发货期限：</th>
		<td>商家收货后<input type="text" id='shopSendDays' class='ipt' value="<?php echo $object['shopSendDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>天</td>
	 </tr>
	  <tr>
	     <th>售后-用户收货期限：</th>
	     <td>商家发货后<input type="text" id='userReceiveDays' class='ipt' value="<?php echo $object['userReceiveDays']; ?>" maxLength='3' style='width:40px;margin:0 5px;' onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberKey(event)"/>天</td>
	  </tr>
	  <?php if(WSTGrant('GWSZ_02')): ?>
	  <tr>
	     <td colspan='2' align='center'>
	       <button type="button" onclick='javascript:edit()' class='btn btn-primary btn-mright'><i class="fa fa-check"></i>保存</button>
            <button type="reset"  class='btn'><i class="fa fa-refresh"></i>重置</button>
	     </td>
	  </tr>
	  <?php endif; ?>
	 </table>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/sysconfigs/buy.js?v=<?php echo $v; ?>" type="text/javascript"></script>

<?php echo hook('initCronHook'); ?>
</body>
</html>