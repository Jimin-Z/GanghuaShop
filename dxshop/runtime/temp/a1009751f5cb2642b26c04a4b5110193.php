<?php /*a:5:{s:69:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\goods\edit.html";i:1675585648;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;s:70:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\goods\edit0.html";i:1646811096;s:70:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\goods\edit1.html";i:1602835854;s:70:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\goods\edit2.html";i:1580961480;}*/ ?>
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
<link rel="stylesheet" type="text/css" href="/hkshopNC/dxshop/static/plugins/webuploader/batchupload.css?v=<?php echo $v; ?>" />
<link href="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.css?v=<?php echo $v; ?>" rel="stylesheet">

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
#specsAttrBox .webuploader-container,#specsAttrBox .webuploader-container .webuploader-pick{width:80px;height:27px;line-height:27px;overflow:hidden;}
#specTby td{padding-bottom:5px;}
#spec-sale-tby td{padding:2px;}
.attr-table td,.attr-table th{padding:2px;}
label{font-weight: normal;width:20%;line-height:30px;}
.labelhide{overflow:hidden;height:90px;}
.labela{display:inline-block;width:100%;text-align:right;text-decoration:none;}
#mouldBox{display: inline-block;position: relative;height: 30px;border: 1px solid #ddd;border-radius: 4px;line-height: 30px;padding: 0 10px;padding-right: 20px;}
#mouldTitleBox{min-width: 100px;height: 30px;line-height: 30px;cursor: pointer;}
#mouldTitleBox .jright{transform: rotate(-90deg);top: 9px;position: absolute;right: 10px;}
#mouldItemBox{position: absolute;width: 148px;border: 1px solid #ddd;background: #fff;left: -1px;top: 28px;display: none;}
.mouldItem{position: relative;}
.mouldItem .itemBox{height: 30px;line-height: 30px;padding: 0 10px;cursor: pointer;padding-right: 50px;position: relative; overflow: hidden;}
.mouldItem .del{float: right;position: absolute;top:10px;right: 10px;cursor: pointer;}
.mouldItem .edit{float: right;position: absolute;top: 10px;margin-right: 10px;right: 20px;cursor: pointer;}
.spec-sale-goodsNo{width:160px!important;}
</style>
<div id='tab' class="wst-tab-box">
	<ul class="wst-tab-nav">
	   <li>商品信息</li>
	   <li>规格属性</li>
	   <li>商品相册</li>
	</ul>
    <div class="wst-tab-content" style='width:100%;margin-bottom: 60px;border: 1px solid #f1f1f1; border-top: 0px;margin-top: 0px;'>
      <form id='editform' autocomplete='off'>
        <div class="wst-tab-item" style="position: relative;">
        <input type='hidden' id='goodsId' class='j-ipt' value='<?php echo $object["goodsId"]; ?>'/>
<table class='wst-form'>
  <tr>
     <th>商品名称<font color='red'>*</font>：</th>
     <td>
        <input type="text" class='j-ipt ipwd' id='goodsName' maxLength='150' data-rule='商品名称:required;' value="<?php echo $object["goodsName"]; ?>">
     </td>
  </tr>
  <tr>
     <th>商品类型<font color='red'>*</font>：</th>
     <td>
       <select id='goodsType' class='j-ipt ipwd' onchange="changeGoodsType(this.value)" <?php if($object["goodsId"]>0): ?>disabled<?php endif; ?>>
         <option value='0' <?php if(($object["goodsType"]==0)): ?>selected<?php endif; ?>>实物商品</option>
         <option value='1' <?php if(($object["goodsType"]==1)): ?>selected<?php endif; ?>>虚拟商品</option>
       </select>
     </td>
  </tr>
  <tr>
     <th>商城分类<font color='red'>*</font>：</th>
     <td>
         <select id="cat_0" class='ipt j-goodsCats' level="0" onchange="WST.ITGoodsCats({id:'cat_0',val:this.value,isRequire:true,className:'j-goodsCats',afterFunc:'lastGoodsCatCallback'});getBrands('brandId',this.value)" style="width: 395px" data-rule='商城分类:required;'>
          <option value="">-请选择-</option>
          <?php $_result=WSTShopApplyGoodsCats(0);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
          <option value="<?php echo $vo['catId']; ?>"><?php echo $vo['catName']; ?></option>
          <?php endforeach; endif; else: echo "" ;endif; ?>
       </select>
     </td>
  </tr>
  <tr>
     <th>本店分类：</th>
     <td>
         <select id="shopCatId1" class='j-ipt' onchange="getShopsCats('shopCatId2',this.value,'');" style="width: 395px">
            <option value="">-请选择-</option>
            <?php $_result=WSTShopCats(0);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['catId']; ?>" <?php if($object['shopCatId1']==$vo['catId']): ?>selected<?php endif; ?>><?php echo $vo['catName']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
         </select>
         <select id='shopCatId2' class='j-ipt' style="width: 395px">
             <option value=''>请选择</option>
         </select>
     </td>
  </tr>
  <tr>
     <th>品牌：</th>
     <td>
         <select id="brandId" class='j-ipt ipwd'>
            <option value="0">-请选择-</option>
         </select>
     </td>
  </tr>
  <tr>
    <th>商品图片<font color='red'>*</font>：</th>
    <td>
        <input type="text" id='goodsImg' readonly="readonly" value='<?php if($object["goodsImg"]!=''): ?><?php echo $object["goodsImg"]; ?><?php endif; ?>' class="j-ipt" style="float: left; width: 655px;" />
        <div id='goodsImgPicker' style="float: left;margin-top: 5px;">上传</div><span id='uploadMsg'></span>
        <div id='goodsImgBox' style='margin-bottom:5px; float: left; height: 30px; margin-left: 5px;'>
            <span class='weixin'>
                  <img class='img' style='height:16px;width:18px;' src='/hkshopNC/dxshop/static/images/upload-common-select.png'>
                  <img class='imged'  id='preview'  style='max-height:150px;max-width: 200px; border:1px solid #dadada; background:#fff' src="__RESOURCE_PATH__/<?php if($object['goodsImg']!=''): ?><?php echo $object['goodsImg']; else: ?><?php echo WSTConf('CONF.goodsLogo'); ?><?php endif; ?>">
                </span>
        </div>
        <div class="f-clear"></div>
        <span class='msg-box' id='msg_goodsImg'></span>
    </td>
  </tr>
  <tr>
    <th></th>
    <td><span>(图片大小为800x800，格式为jpg或者png)</span></td>
  </tr>
  <tr>
    <th>商品视频：</th>
    <td>
      <input type='text' id='goodsVideo' class='j-ipt'  value='<?php echo $object["goodsVideo"]; ?>' readonly="readonly" style="float: left; width: 655px;" />
      <div id='goodsVideoPicker' style="float: left;margin-top: 5px;">上传</div>
      <span id='uploadVideoMsg'></span>

      <div id='goodsVedioBox' style='margin-bottom:5px; float: left; height: 30px; margin-left: 5px;'>
          <span  class='weixin'>
            <img class='img' style='height:16px;width:18px;' src='/hkshopNC/dxshop/static/images/upload-common-select.png'>
            <video  class='imged' id='goodsVideoPlayer' src="__RESOURCE_PATH__/<?php echo $object["goodsVideo"]; ?>" controls="controls"  style='max-height:150px;max-width: 200px; border:1px solid #dadada; background:#fff'></video>
            <span class="vedio-del" <?php if($object["goodsVideo"]!=''): ?>style='display:inline-block'<?php endif; ?> onclick="javascript:clearVedio(this)"></span>
          </span>

      </div>
    </td>
  </tr>
  <tr>
    <th></th>
    <td><span>(视频格式为3gp,mp4,rmvb,mov,avi)</span></td>
  </tr>
  <tr>
     <th>商品编号<font color='red'>*</font>：</th>
     <td><input type='text' class='j-ipt ipwd' id='goodsSn' value='<?php echo $object["goodsSn"]; ?>' maxLength='20' data-rule='商品编号:required;'/></td>
  </tr>
  <tr>
     <th width='150'>商品货号<font color='red'>*</font>：</th>
     <td>
        <input type='text' class='j-ipt ipwd' id='productNo' value='<?php echo $object["productNo"]; ?>' maxLength='20' data-rule='商品货号:required;'/>
     </td>
  </tr>
  <tr>
     <th>市场价格<font color='red'>*</font>：</th>
     <td><input type='text' class='j-ipt ipwd' id='marketPrice' value='<?php echo $object["marketPrice"]; ?>' maxLength='9' data-rule='市场价格:required;price' data-rule-price="[/^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/, '价格必须大于0']" onblur="javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"/></td>
  </tr>
  <tr>
     <th>店铺价格<font color='red'>*</font>：</th>
     <td><input type='text' class='j-ipt ipwd' id='shopPrice' value='<?php echo $object["shopPrice"]; ?>' maxLength='9' data-rule='店铺价格:required;price' data-rule-price="[/^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/, '价格必须大于0']" onblur="javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"/></td>
  </tr>
   <?php if(is_array($shopMemberGroups) || $shopMemberGroups instanceof \think\Collection || $shopMemberGroups instanceof \think\Paginator): $k = 0; $__LIST__ = $shopMemberGroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;
        $reduceMoney = '';
        if(isset($object['memberReduceMoney'])){
            foreach($object['memberReduceMoney'] as $key => $voo){
                if($voo['groupId'] == $vo['id']){
                    $reduceMoney = $voo['reduceMoney'];
                }
            }
        }
     ?>
    <tr>
        <th><?php echo $vo['groupName']; ?>立减价格：</th>
        <td><input type='text' class='j-ipt ipwd member-reduce-money'  value="<?php echo $reduceMoney; ?>" style='width:200px !important;margin-right:5px;' maxLength='10'  onblur="javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"/><span>(如果有多规格的话，则此会员价格为=普通多规格价格-立减价格)</span><input type="hidden" class='member-group-id' value="<?php echo $vo['id']; ?>"></td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  <tr>
     <th>成本价：</th>
     <td><input type='text' class='j-ipt ipwd' id='costPrice' value='<?php echo $object["costPrice"]; ?>' maxLength='9' onblur="javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"/></td>
  </tr>
  <tr id='goodsStockTr' <?php if(($object["goodsType"]==1)): ?>style='display:none'<?php endif; ?>>
     <th>商品库存<font color='red'>*</font>：</th>
     <td><input type='text' class='j-ipt ipwd' id='goodsStock' value='<?php echo $object["goodsStock"]; ?>' maxLength='10' data-rule='商品库存:required;integer[+0]' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)"/></td>
  </tr>
  <tr>
     <th>预警库存<font color='red'>*</font>：</th>
     <td colspan='2'><input type='text' class='j-ipt ipwd' id='warnStock' value='<?php echo $object["warnStock"]; ?>' maxLength='10' data-rule='预警库存:required;integer[+0]' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)"/></td>
  </tr>
  <tr>
     <th>商品单位<font color='red'>*</font>：</th>
     <td><input type='text' class='j-ipt ipwd' id='goodsUnit' value='<?php echo $object["goodsUnit"]; ?>' maxLength='10' data-rule='商品单位:required;'/></td>
  </tr>
  <tr id='goodsWeightTr' <?php if(($object["goodsType"]==1)): ?>style='display:none'<?php endif; ?>>
     <th>商品重量(kg)<font color='red'>*</font>：</th>
     <td><input type='text' class='j-ipt ipwd' id='goodsWeight' value='<?php echo $object["goodsWeight"]; ?>' maxLength='10' onblur="javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"/></td>
  </tr <?php if(($object["goodsType"]==1)): ?>style='display:none'<?php endif; ?>>
  <tr id='goodsVolumeTr' <?php if(($object["goodsType"]==1)): ?>style='display:none'<?php endif; ?>>
     <th>商品体积(m³)<font color='red'>*</font>：</th>
     <td><input type='text' class='j-ipt ipwd' id='goodsVolume' value='<?php echo $object["goodsVolume"]; ?>' maxLength='10' onblur="javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"/></td>
  </tr>
  <tr>
     <th>SEO关键字：</th>
     <td><input type='text' class='j-ipt ipwd' id='goodsSeoKeywords' maxLength='100' value='<?php echo $object["goodsSeoKeywords"]; ?>' /></td>
  </tr>
  <tr>
     <th>SEO描述：</th>
     <td><input type='text' class='j-ipt ipwd' id='goodsSeoDesc' maxLength='200' value='<?php echo $object["goodsSeoDesc"]; ?>' /></td>
  </tr>
  <tr>
     <th>商品促销信息：</th>
     <td><input class='j-ipt ipwd' type="text" id='goodsTips' maxLength='100' value="<?php echo $object["goodsTips"]; ?>" /></td>
  </tr>
  <?php echo hook('shopDocumentShopEditGoods',['goodsId'=>$object["goodsId"]]); ?>
  <tr>
     <th>商品状态<font color='red'>*</font>：</th>
     <td class="layui-form">
        <label><input type='radio' name='isSale' id="isSale-1" class='j-ipt' value='1' <?php if($object['isSale']==1): ?>checked<?php endif; ?> title='上架'/></label>
        <label><input type='radio' name='isSale' id="isSale-0" class='j-ipt' value='0' <?php if($object['isSale']==0): ?>checked<?php endif; ?> title='下架'/></label>
     </td>
  </tr>
  <tr>
     <th>商品属性：</th>
     <td class='layui-form'>
          <input id="isRecom" name='isRecom' lay-skin="primary" class="j-ipt" <?php if($object['isRecom']==1): ?>checked<?php endif; ?> value="1" type="checkbox" title='推荐' />
          <input id="isBest" name="isBest" lay-skin="primary" class="j-ipt" <?php if($object['isBest']==1): ?>checked<?php endif; ?> value="1" type="checkbox" title='精品'/>
          <input id="isNew" name="isNew" lay-skin="primary" class="j-ipt" <?php if($object['isNew']==1): ?>checked<?php endif; ?> value="1" type="checkbox" title='新品'/>
          <input id="isHot" name="isHot" lay-skin="primary" class="j-ipt" <?php if($object['isHot']==1): ?>checked<?php endif; ?> value="1" type="checkbox" title='热销'/>
     </td>
  </tr>
  <tr id="isFreeShippingTr" <?php if(($object["goodsType"]==1)): ?>style='display:none'<?php endif; ?>>
     <th>是否包邮：</th>
     <td class="layui-form">
        <label><input type='radio' name='isFreeShipping' id="isFreeShipping-1" lay-filter="isFreeShipping" class='j-ipt' value='1' <?php if($object['isFreeShipping']==1): ?>checked<?php endif; ?> title='包邮'/></label>
        <label><input type='radio' name='isFreeShipping' id="isFreeShipping-0" lay-filter="isFreeShipping" class='j-ipt' value='0' <?php if($object['isFreeShipping']==0): ?>checked<?php endif; ?> title='买家承担运费'/></label>
     </td>
  </tr>
  <tr id="shippingFeeTypeTr" <?php if($object["goodsType"]==1 || $object['isFreeShipping']==1): ?>style='display:none'<?php endif; ?>>
     <th>计价方式<font color='red'>*</font>：</th>
     <td class="layui-form">
        <label><input type='radio' name='shippingFeeType' lay-filter="shippingFeeType" class='j-ipt' value='1' <?php if($object['shippingFeeType']==1): ?>checked<?php endif; ?> title='计件'/></label>
        <label><input type='radio' name='shippingFeeType' lay-filter="shippingFeeType" class='j-ipt' value='2' <?php if($object['shippingFeeType']==2): ?>checked<?php endif; ?> title='重量'/></label>
        <label><input type='radio' name='shippingFeeType' lay-filter="shippingFeeType" class='j-ipt' value='3' <?php if($object['shippingFeeType']==3): ?>checked<?php endif; ?> title='体积'/></label>

     </td>
  </tr>
  <tr id="shopExpressTr" <?php if($object["goodsType"]==1 || $object['isFreeShipping']==1): ?>style='display:none'<?php endif; ?>>
     <th>快递公司<font color='red'>*</font>：</th>
     <td>
        <select id='shopExpressId' class='j-ipt ipwd'>
          <option value="">-请选择-</option>
          <?php if(is_array($shopExpressList) || $shopExpressList instanceof \think\Collection || $shopExpressList instanceof \think\Paginator): $i = 0; $__LIST__ = $shopExpressList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
          <option value="<?php echo $vo['id']; ?>" <?php if(($object["shopExpressId"]==$vo['id'])): ?>selected<?php endif; ?>><?php echo $vo['expressName']; ?></option>
          <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
     </td>
  </tr>
  <tr>
     <th>商品描述<font color='red'>*</font>：</th>
     <td>
         <textarea rows="2" cols="60" id='goodsDesc' class='j-ipt' name='goodsDesc' data-rule='商品描述:required;'><?php echo $object['goodsDesc']; ?></textarea>
     </td>
  </tr>
  <tr>
     <td align='center' style='text-align:center;padding-top:10px;'></td>
  </tr>
</table>

        </div>
        <div class="wst-tab-item" style="position: relative;display:none">
        <div id="selMouldBox" style='display:none'>
模板：
<div id="mouldCol1" style="display: inline-block;">
	<input id="mouldId" type="hidden" name="mouldId"/>
	<div id="mouldBox">
		<div id="mouldTitleBox" style=""><span id="mouldTitle">请选择规格属性模板</span> <i class="fa fa-angle-left jright" style=""></i></div>
		<div id="mouldItemBox">
			
		</div>
	</div>
</div>
<button id="updateMould" type="button" class="btn" onclick="toUpdateMould()" style="margin-left: 10px;">更新模板</button>
<button id="addMould" type="button" class="btn" onclick="toSaveMould(0)" style="margin-left: 10px;">存为新模板</button>
</div>
<div id='specsAttrBox'></div>
<div id='specTips' style='display:none'>
<div class='wst-tips-box' style='margin-left:0px;'>1.若改动商品规格时，销售规则表将会重新绘制，填写销售规格表前前选择好商品规格</div>
</div>
<div id='specMouldBox' style='display:none'>
	<div id="specMouldForm">
	    <input type='hidden' id='catId' class='ipt'/>
		<table class='wst-form wst-box-top'>
		  <tr>
		       <tr>
		          <th>模板名称<font color='red'>*</font>：</th>
		          <td>
		              <input type="text" id="mouldName" name="mouldName" class="ipt" maxLength='20' />
		          </td>
		       </tr>
		</table>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$("#mouldTitleBox").on({
		click : function(){
			$("#mouldItemBox").toggle();
		}
	});
	
});

</script>
        </div>
        <div class="wst-tab-item" style="position: relative;display:none">
        <style>
/*.wst-batchupload .webuploader-pick{
    height: 40px;line-height: 40px;
}*/
#filePicker{height: auto;width: auto;}
</style>
<div id="batchUpload" class="wst-batchupload">
    <div class="queueList filled">
        <div id="dndArea" class="placeholder <?php if(!empty($object['gallery'])): ?>element-invisible<?php endif; ?>">
            <div id="filePicker"></div>
            <p style='color:#888'>或将照片拖到这里，单次最多可选50张，每张最大不超过5M</p>
        </div>
        <ul class="filelist" >
            <?php if(is_array($object['gallery']) || $object['gallery'] instanceof \think\Collection || $object['gallery'] instanceof \think\Paginator): $i = 0; $__LIST__ = $object['gallery'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		    <li  class="state-complete" style="border: 1px solid rgb(59, 114, 165);">
		       <p class="title"></p>
		       <p class="imgWrap">
		          <img src="__RESOURCE_PATH__/<?php echo $vo; ?>">
		       </p>
		       <input type="hidden" v="<?php echo $vo; ?>" iv="<?php echo $vo; ?>" class="j-gallery-img">
		       <span class="btn-del">删除</span>
		    </li>
		    <?php endforeach; endif; else: echo "" ;endif; ?>
	    </ul>
    </div>
    <div class="statusBar" <?php if(empty($object['gallery'])): ?>style="display: none;"<?php endif; ?>>
        <div class="progress" style="display: none;">
            <span class="text">0%</span>
            <span class="percentage" style="width: 0%;"></span>
        </div>
        <div class="info"></div>
        <div class="btns">
            <div id="filePicker2" style="height: auto;"></div><div class="uploadBtn">开始上传</div>
        </div>
    </div>
</div>

        </div>
     </form>
     <div class="flbtn">
    <button type='button' class="btn btn-primary btn-mright" onclick='javascript:save(<?php echo $p; ?>)' style="margin-left: 40%;"><i class="fa fa-check"></i>保&nbsp;存</button>
    <button type='button' class="btn" onclick="javascript:WST.backPrePage()" style="margin-left: 10px;"><i class="fa fa-angle-double-left"></i>返&nbsp;回</button>
    </div>
    </div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>'></script>
<script src="/hkshopNC/dxshop/static/plugins/kindeditor/NKeditor-all.js?v=<?php echo $v; ?>" type="text/javascript" ></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.min.js?v=<?php echo $v; ?>"></script>
<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/webuploader/batchupload.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='__SHOP__/goods/goods.js?v=<?php echo $v; ?>'></script>
<script>
var initBatchUpload = false,editor1 = null,specNum = 0,src='<?php echo $src; ?>';
<?php unset($object['goodsDesc']); ?>
var OBJ = <?=json_encode($object)?>;
$(function(){initEdit()});
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
