<?php /*a:2:{s:68:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\shop\view.html";i:1675778818;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="/hkshopNC/dxshop/static/plugins/webuploader/webuploader.css?v=<?php echo $v; ?>" />
<style>
    .webuploader-pick{background:#1890ff;}
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

<style>
label{margin-right:10px;}
th{height:25px;}
</style>
<div class='wst-page'>
<div id='tab' class="layui-tab layui-tab-brief">
    <ul class="layui-tab-title">
        <li class="layui-this">店铺信息</li>
        <li>银行信息</li>
		<li>经营信息</li>
        <?php if((WSTDatas('ADS_TYPE',2)!='' || WSTDatas('ADS_TYPE',3)!='' || WSTDatas('ADS_TYPE',5)!='')): ?>
        <li>店铺二维码</li>
        <?php endif; ?>
    </ul>
    <div class="layui-tab-content" style='width:99%;margin-bottom: 10px;'>
        <div class="layui-tab-item layui-show wst-box-top" style="position: relative;">
           <table id='vinfo_1' class='wst-form'>
			  <tr>
			     <th width='150'>店铺编号：</th>
			     <td><span style='padding: 0px 8px;'><?php echo $object['shopSn']; ?></span>
                 <a class="btn btn-blue" onclick="javascript:toEdit(1)" style='height:18px;line-height:18px'><i class="fa fa-pencil"></i>编辑</a>
			     </td>
			  </tr>
			  <tr>
			     <th>店铺名称：</th>
			     <td><?php echo $object['shopName']; ?></td>
			  </tr>
			  <tr>
			     <th>公司紧急联系人：</th>
			     <td><?php echo $object['shopkeeper']; ?></td>
			  </tr>
			  <tr>
			     <th>公司紧急联系人手机：</th>
			     <td><?php echo $object['telephone']; ?></td>
			  </tr>
			  <tr>
			     <th>公司名称：</th>
			     <td><?php echo $object['shopCompany']; ?></td>
			  </tr>
			  <tr>
			     <th>店铺联系电话：</th>
			     <td><?php echo $object['shopTel']; ?></td>
			  </tr>
			  <tr>
			     <th>店铺图标：</th>
			     <td>
			     <img id='v_shopImg' width='150' height='150' src='__RESOURCE_PATH__/<?php echo $object["shopImg"]; ?>'/>
			     </td>
			  </tr>
			  <tr>
			     <th>客服QQ：</th>
			     <td id='v_shopQQ'><?php echo $object['shopQQ']; ?></td>
			  </tr>
			  <tr>
			     <th>阿里旺旺：</th>
			     <td id='v_shopWangWang'><?php echo $object['shopWangWang']; ?></td>
			  </tr>
			  <tr>
			     <th>店铺地址：</th>
			     <td>
			       <?php echo $object['areaName']; ?>
			     </td>
			  </tr>
			  <tr>
			     <th>店铺详细地址：</th>
			     <td><?php echo $object['shopAddress']; ?></td>
			  </tr>
			  <tr>
			     <th>是否提供开发票：</th>
			     <td id='v_isInvoice'>
			        <?php if($object['isInvoice']==1): ?>提供发票<?php endif; if($object['isInvoice']==0): ?>不提供发票<?php endif; ?>
			     </td>
			  </tr>
			  <tr id='tr_isInvoice' <?php if($object['isInvoice']==0): ?>style='display:none'<?php endif; ?>>
			     <th>发票说明：</th>
			     <td id='v_invoiceRemarks'><?php echo $object['invoiceRemarks']; ?></td>
			  </tr>
			  <tr>
			     <th>营业状态：</th>
			     <td><span id='v_shopAtive'><?php if($object['shopAtive']==1): ?>营业中<?php else: ?>休息中<?php endif; ?></span>
			     </td>
			  </tr>
			  <tr>
			     <th>服务时间：</th>
			     <td><span id='v_serviceStartTime'><?php echo $object['serviceStartTime']; ?></span>至<span id='v_serviceEndTime'><?php echo $object['serviceEndTime']; ?></span>
			     </td>
			  </tr>
           </table>
           <form id='editFrom_1' autocomplete="off">
           <table id='einfo_1' class='wst-form hide'>
           	 <tr>
			     <th>店铺名称<font color='red'>*</font>：</th>
			     <td><input type='text' id='shopName' class='ipt_1' value="<?php echo $object['shopName']; ?>" data-rule="店铺名称:required" style="width: 500px; float: left;" /></td>
			  </tr>
			  <tr>
			     <th>公司紧急联系人<font color='red'>*</font>：</th>
			     <td><input type='text' id='shopkeeper' class='ipt_1' value="<?php echo $object['shopkeeper']; ?>" data-rule="公司紧急联系人:required" style="width: 500px; float: left;" /></td>
			  </tr>
			  <tr>
			     <th>公司紧急联系人手机<font color='red'>*</font>：</th>
			     <td><input type='text' id='telephone' class='ipt_1' value="<?php echo $object['telephone']; ?>" data-rule="公司紧急联系人手机:required" style="width: 500px; float: left;" /></td>
			  </tr>
			  <tr>
			     <th>公司名称<font color='red'>*</font>：</th>
			     <td><input type='text' id='shopCompany' class='ipt_1' value="<?php echo $object['shopCompany']; ?>" data-rule="公司名称:required" style="width: 500px; float: left;" /></td>
			  </tr>
			  <tr>
			     <th>店铺联系电话<font color='red'>*</font>：</th>
			     <td><input type='text' id='shopTel' class='ipt_1' value="<?php echo $object['shopTel']; ?>" data-rule="店铺联系电话:required" style="width: 500px; float: left;" /></td>
			  </tr>
			  <tr>
			     <th width='150'>店铺图标<font color='red'>*</font>：</th>
			     <td>
			     	<input type='text' id='shopImg' class='ipt_1' value='<?php echo $object["shopImg"]; ?>' style="width: 500px; float: left;" />
			     	<div id='shopImgPicker' style='float: left;'>上传</div><span id='uploadMsg'></span>
			     	<div id='shopImgBox' style='margin-bottom:5px; float: left; height: 30px; margin-left: 5px;'>
			     		<span class='weixin'>
			     			<img class='img' style='height:16px;width:18px;' src='/hkshopNC/dxshop/static/images/upload-common-select.png'>
			     			<img class='imged'  id='preview'  style='max-height:150px;max-width: 200px; border:1px solid #dadada; background:#fff' src="__RESOURCE_PATH__/<?php if($object['shopImg']!=''): ?><?php echo $object['shopImg']; else: ?><?php echo WSTConf('CONF.goodsLogo'); ?><?php endif; ?>">
			     		</span>
			     	</div>
			     </td>
			  </tr>
			  <tr>
			     <th>店铺地址：</th>
			     <td>
					<input type='hidden' id='areaIdPath1' value='<?php echo $object['areaIdPath']; ?>'/>
					<select id="areaIdPath_0" class="j-areaIdPath" data-name="areaIdPath" level="0" onchange="WST.ITAreas({id:'areaIdPath_0',val:this.value,isRequire:true,className:'j-areaIdPath'});" data-value='<?php echo $object["areaIdPath"]; ?>'>
	                    <option value="">-请选择-</option>
	                    <?php 
	                    $areas = WSTTable('areas',['isShow'=>1,'dataFlag'=>1,'parentId'=>0],'areaId,areaName',100,'areaSort desc');
	                    foreach($areas as $aky => $area){
	                     ?>
	                    <option value="<?php echo $area['areaId']; ?>"><?php echo $area['areaName']; ?></option>
	                    <?php } ?>
	                </select>

             		<?php if((WSTConf('CONF.mapKey'))): ?>
             		<button type='button' class='btn btn-primary' data-name="areaIdPath" onclick="javascript:mapCity(this)" style="top: 8px;font-size: 14px;font-weight: 400;"><i class='fa fa-map-marker'></i>地图定位</button>
             		<div id="container"  style='width:700px;height:400px'></div>

             		<?php endif; ?>
             		<input type='hidden' id='mapLevel' class='ipt_1'  value="<?php echo $object['mapLevel']; ?>"/>
                    <input type='hidden' id='longitude' class='ipt_1'  value="<?php echo $object['longitude']; ?>"/>
                    <input type='hidden' id='latitude' class='ipt_1'  value="<?php echo $object['latitude']; ?>"/>
			     </td>
			  </tr>
			  <tr>
			     <th>店铺详细地址：</th>
			     <td><input type='text' id='shopAddress' class='ipt_1' value='<?php echo $object["shopAddress"]; ?>' data-rule="店铺详细地址:required" style="width: 500px; float: left;"/></td>
			  </tr>
			  <tr>
			     <th>客服QQ：</th>
			     <td>
			     	<input class="ipt_1" id="shopQQ" value="<?php echo $object['shopQQ']; ?>" type="text">
			     </td>
			  </tr>
			  <tr>
			     <th> </th>
			     <td>
			     	<span style='color:gray;'>做为客服接收临时消息的QQ,需开通<a target="_blank" href="http://shang.qq.com/v3/index.html">QQ推广功能</a> -> '首页'-> '推广工具'-> '立即免费开通'</span>
			     </td>
			  </tr>
			  <tr>
			     <th>阿里旺旺：</th>
			     <td><input class="ipt_1" id="shopWangWang" value="<?php echo $object['shopWangWang']; ?>" type="text"></td>
			  </tr>
			  <tr>
			     <th>是否提供开发票<font color='red'>*</font>：</th>
			     <td class="layui-form">
			        <label>
			        	<input type='radio' value='1' class="ipt_1" name='isInvoice' onclick='javascript:WST.showHide(1,"#trInvoice")' <?php if($object['isInvoice']==1): ?>checked<?php endif; ?> title='提供'/>
			        </label>
			        <label>
			        	<input type='radio' value='0' class="ipt_1" name='isInvoice' onclick='javascript:WST.showHide(0,"#trInvoice")' <?php if($object['isInvoice']==0): ?>checked<?php endif; ?> title='不提供'/>
			        </label>
			     </td>
			  </tr>
			  <tr id='trInvoice' <?php if($object['isInvoice']==0): ?>style='display:none'<?php endif; ?>>
			     <th>发票说明<font color='red'>*</font>：</th>
			     <td><input class="ipt_1" id="invoiceRemarks" value="<?php echo $object['invoiceRemarks']; ?>" type="text" data-rule="发票说明:required(#isInvoice1:checked)"></td>
			  </tr>
			  <tr>
			     <th>营业状态<font color='red'>*</font>：</th>
			     <td class="layui-form">
			        <label>
			        	<input type='radio' value='1' class="ipt_1" name='shopAtive' <?php if($object['shopAtive']==1): ?>checked<?php endif; ?> title='营业中'/>
			        </label>
			        <label>
			        	<input type='radio' value='0' class="ipt_1" name='shopAtive' <?php if($object['shopAtive']==0): ?>checked<?php endif; ?> title='休息中'/>
			        </label>
			     </td>
			  </tr>
			  <tr>
			     <th>服务时间<font color='red'>*</font>：</th>
			     <td>
			     <select class='ipt_1' id='serviceStartTime' v="<?php echo $object['serviceStartTime']; ?>"></select>
		         至
		         <select class='ipt_1' id='serviceEndTime' v="<?php echo $object['serviceEndTime']; ?>"></select>
			     </td>
			  </tr>
			  <tr>
			  	<td colspan='2' style="padding-left: 155px;">
                    <button type="button" class="btn btn-primary btn-mright" onclick="javascript:editInfo()"><i class="fa fa-check"></i>保&nbsp;存</button>
                    <button type="button" class="btn" onclick="javascript:toCancel(1)" style="margin-left: 10px;"><i class="fa fa-angle-double-left"></i>返&nbsp;回</button>
			  	</td>
			  </tr>
           </table>
           </form>
        </div>

        <div class="layui-tab-item" style="display:none;">
           <table id='vinfo_2' class='wst-form wst-box-top'>
              <tr>
			     <th width='150'>开卡银行：</th>
			     <td><?php echo $object['bankName']; ?><button class="btn btn-blue" type="button" onclick="javascript:toEdit(2)"><i class="fa fa-pencil"></i>编辑</button></td>
			  </tr>
			  <tr>
			     <th width='150'>开卡地区：</th>
			     <td><?php echo $object['bankAreaName']; ?></td>
			  </tr>
              <tr>
			     <th>卡号：</th>
			     <td><?php echo $object['bankNo']; ?></td>
			  </tr>
			  <tr>
			     <th>持卡人：</th>
			     <td><?php echo $object['bankUserName']; ?></td>
			  </tr>
           </table>

		   <form id='editFrom_2' autocomplete="off">
			<table id='einfo_2' class='wst-form wst-box-top' style='display: none'>
			   <tr>
				  <th width='150'>开卡银行：</th>
				  <td>
					 <select id='bankId' class='ipt_2' data-rule="开卡地区: required;">
						 <option value=''>请选择</option>
						 <?php if(is_array($banks) || $banks instanceof \think\Collection || $banks instanceof \think\Paginator): $i = 0; $__LIST__ = $banks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						 <option value='<?php echo $vo["bankId"]; ?>' <?php if($object['bankId'] == $vo['bankId']): ?>selected<?php endif; ?>><?php echo $vo["bankName"]; ?></option>
						 <?php endforeach; endif; else: echo "" ;endif; ?>
					 </select>
				  </td>
			   </tr>
			   <tr>
				  <th width='150'>开卡地区：</th>
				  <td>
					   <input type='hidden' id='areaIdPath2' value='<?php echo $object['bankAreaIdPath']; ?>'/>
					  <select id="bankAreaIdPath_0" class='j-bankAreaIdPath ipt_2' level="0" onchange="WST.ITAreas({id:'bankAreaIdPath_0',val:this.value,isRequire:true,className:'j-bankAreaIdPath'});" data-rule="开卡地区: required;">
						 <option value="">请选择</option>
						 <?php foreach($areas as $a): ?>
						   <option value="<?php echo $a['areaId']; ?>"><?php echo $a['areaName']; ?></option>
						 <?php endforeach; ?>
					  </select>
				  </td>
			   </tr>
			   <tr>
				  <th>卡号：</th>
				  <td><input type='text' id='bankNo' class='ipt_2' value='<?php echo $object['bankNo']; ?>' style='width:250px' data-rule="卡号: required;"/></td>
			   </tr>
			   <tr>
				  <th>持卡人：</th>
				  <td><input type='text' id='bankUserName' class='ipt_2' value='<?php echo $object["bankUserName"]; ?>' style='width:250px' data-rule="持卡人: required;"/></td>
			   </tr>
			   <tr>
				   <td colspan='2' style="padding-left: 155px;">
					 <button type="button" class="btn btn-primary btn-mright" onclick="javascript:editBankInfo()"><i class="fa fa-check"></i>保存</button>
					 <button type="button" class="btn" onclick="javascript:toCancel(2)" style="margin-left: 10px;"><i class="fa fa-angle-double-left"></i>返回</button>
				   </td>
			   </tr>
			</table>
			</form>

        </div>

		<div class="layui-tab-item" style="display:none;">
			<table class='wst-form' style='margin-top:5px'>
			   <tr>
				  <th width='150'>经营类目：</th>
				  <td>
				   <?php if(is_array($object['catshopNames']) || $object['catshopNames'] instanceof \think\Collection || $object['catshopNames'] instanceof \think\Paginator): $i = 0; $__LIST__ = $object['catshopNames'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				   <div style='width:200px;float:left;line-height: 18px;'>
					   <?php echo $vo; ?>
				   </div>
				   <?php endforeach; endif; else: echo "" ;endif; ?>
				  </td>
			   </tr>
			   <tr>
				  <th>所属行业：</th>
				  <td>
				   <?php echo $object['tradeName']; ?>
				  </td>
			   </tr>
			   <tr>
				  <th>认证类型：</th>
				  <td>
					<?php $accredLen = count($object['accreds']); if(is_array($object['accreds']) || $object['accreds'] instanceof \think\Collection || $object['accreds'] instanceof \think\Paginator): $i = 0; $__LIST__ = $object['accreds'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<?php echo $vo["accredName"]; if($i < $accredLen): ?>、<?php endif; ?>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				  </td>
			   </tr>
			</table>
		 </div>


        <?php if((WSTDatas('ADS_TYPE',2)!='' || WSTDatas('ADS_TYPE',3)!='' || WSTDatas('ADS_TYPE',5)!='')): ?>
        <div class="layui-tab-item" style="display:none;">
           <table class='wst-form wst-box-top'>
           	<?php if((WSTDatas('ADS_TYPE',2)!='' || WSTDatas('ADS_TYPE',3)!='')): ?>
    			<tr>
			   		<th width='150'>手机/微信二维码</th>
			   		<td>
						<div id="moQrcode" style="margin: 10px;"></div>
			   		</td>
			  	</tr>
            <?php endif; if((WSTDatas('ADS_TYPE',5)!='')): ?>
    			<tr>
			   		<th width='150'>小程序二维码</th>
			   		<td>
						<div id="weQrcode" style="margin: 10px;"></div>
			   		</td>
			  	</tr>
            <?php endif; ?>
           </table>
        </div>
        <?php endif; ?>
    </div>
</div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>'></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.min.js?v=<?php echo $v; ?>"></script>
<script charset="utf-8" src="<?php echo WSTProtocol(); ?>map.qq.com/api/js?v=2.exp&key=<?php echo WSTConf('CONF.mapKey'); ?>"></script>
<script type='text/javascript' src='__SHOP__/shop/shops.js?v=<?php echo $v; ?>'></script>
<script>
$(function(){
	<?php if((WSTDatas('ADS_TYPE',2)!='' || WSTDatas('ADS_TYPE',3)!='')): ?>
	WST.createShopQrcode(1);
	<?php endif; if((WSTDatas('ADS_TYPE',5)!='')): ?>
	WST.createShopQrcode(2);
	<?php endif; ?>

	if(window.conf.MAP_KEY){
        var longitude = $('#longitude').val();
        var latitude = $('#latitude').val();
        var mapLevel = $('#mapLevel').val();
        initQQMap(longitude,latitude,mapLevel);
    }

})
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
