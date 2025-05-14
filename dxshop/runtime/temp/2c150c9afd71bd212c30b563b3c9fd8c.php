<?php /*a:2:{s:79:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\shopconfigs\shop_cfg.html";i:1669390454;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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

<script>
$(function(){
  $('.state-complete').css('border-color','#ddd');
})
</script>
<style>
.filelist .btn-del,.webuploader-pick,.wst-batchupload .placeholder .webuploader-pick,.wst-batchupload .statusBar .btns .uploadBtn{background: #1890ff;}
.wst-batchupload .statusBar .btns .uploadBtn:hover {background: #e45525 none repeat scroll 0 0;}
.shopbanner{position: relative;}
.del-banner{position: absolute;top:0px;right:0px;background: #e45050 none repeat scroll 0 0;  z-index: 55;color: #ffffff;cursor: pointer;height: 18px;line-height: 18px;padding: 0 5px;background: rgba(0,0,0,0.6);width: 18px;border-radius: 50%;color: #fff !important;}
.wst-batchupload .filelist li{background:#ffffff;height: 220px!important;}
#filePicker,#filePicker .webuploader-pick,#filePicker2,#filePicker2 .webuploader-pick{height:32px;line-height: 32px;}
/*#filePicker2{width:120px;}*/
#shopCfg span{color: red}
</style>
<div class="wst-page">
   <div class="wst-shop-content">
        <table class="wst-form">
        <form name="shopCfg"  id="shopCfg" autocomplete="off">
        <tbody>
           <tr>
             <th width='120' align='right'>店铺Title关键字<font color='red'>*</font>：</th>
             <td><input type='text' id='shopTitleWords' name='shopTitleWords' class="ipt"  value='<?php echo $object['shopTitleWords']; ?>' data-rule='店铺Title关键字:required;' maxLength='50' /></td>
           </tr>
           <tr>
             <th width='120' align='right'>店铺SEO关键字<font color='red'>*</font>：</th>
             <td><input type='text' id='shopKeywords' name='shopKeywords' class="ipt"  value='<?php echo $object['shopKeywords']; ?>' data-rule='关键字:required;' maxLength='100' /></td>
           </tr>
           <tr>
           <th width='120'>店铺SEO描述：</th>
           <td colspan='3'>
               <textarea rows="2" style='width:568px;' class="ipt" id='shopDesc' name='shopDesc' maxLength='200'><?php echo $object['shopDesc']; ?></textarea>
           </td>
           </tr>
           <tr>
           <th width='120'>店铺热搜关键词：</th>
           <td><input type='text' id='shopHotWords' name='shopHotWords' class="ipt"  value='<?php echo $object['shopHotWords']; ?>' placeholder="店铺主页搜索栏下的引导搜索词" maxLength='100'/></td>
         </tr>


          <tr style="height:80px">
             <th width='120' align='right' valign='top'>店铺街背景：</th>
             <td>
                <input type="text" readonly="readonly" id="shopStreetImg" value="<?php echo $object['shopStreetImg']; ?>" class="ipt" style="width: 483px;float: left;" />
                <div id="shopStreetImgPicker"style='margin-left:0px;height:30px;float: left; overflow:hidden'>上传</div>
                <div style="float: left; height: 30px;margin-left: 5px;">
                  <span class='weixin'>

                  <img class='img' style='height:16px;width:18px;' src='/hkshopNC/dxshop/static/images/upload-common-select.png'>
                  <img class='imged' id="shopStreetImgPreview"  style='max-height:150px;max-width: 200px; border:1px solid #dadada; background:#fff' src="__RESOURCE_PATH__/<?php echo $object['shopStreetImg']; ?>">
                  </span>
                </div>
                <div class="f-clear"></div>
              <div>图片大小:<span>228 x 138</span> (px)(格式为 <span>gif</span>, <span>jpg</span>, <span>jpeg</span>, <span>png</span>)</div>
             </td>
           </tr>
           <tr style="height:80px">
             <th width='120' align='right' valign='top'>顶部广告：</th>
             <td>
                <input type="text" readonly="readonly" id="shopBanner" value="<?php echo $object['shopBanner']; ?>" class="ipt" style="width: 483px;float: left;" />
                <div id="shopBannerPicker" style='margin-left:0px;height:30px;float: left; overflow:hidden'>上传</div>
                <div style="float: left; height: 30px;margin-left: 5px;">
                <span class='weixin'>
                  <img class='img' style='height:16px;width:18px;' src='/hkshopNC/dxshop/static/images/upload-common-select.png'>
                  <img class='imged' id="shopBannerPreview"  style='max-height:150px;max-width: 200px; border:1px solid #dadada; background:#fff' src="__RESOURCE_PATH__/<?php echo $object['shopBanner']; ?>">
                </span>
              </div>
                <div class="f-clear"></div>
              <div>图片大小:<span>1920 x 110</span> (px)(格式为 <span>gif</span>, <span>jpg</span>, <span>jpeg</span>, <span>png</span>)</div>

             </td>
           </tr>

            <tr style="height:80px">
             <th width='120' align='right' valign='top'>移动端顶部广告：</th>
             <td>
                <input type="text" readonly="readonly" id="shopMoveBanner" value="<?php echo $object['shopMoveBanner']; ?>" class="ipt" style="width: 483px;float: left;" />
                <div id="shopMoveBannerPicker" style='margin-left:0px;height:30px;float: left; overflow:hidden'>上传</div>
                <div style="float: left; height: 30px;margin-left: 5px;">
                  <span class='weixin'>
                  <img class='img' style='height:16px;width:18px;' src='/hkshopNC/dxshop/static/images/upload-common-select.png'>
                  <img class='imged' id="shopMoveBannerPreview"  style='max-height:150px;max-width: 200px; border:1px solid #dadada; background:#fff' src="__RESOURCE_PATH__/<?php echo $object['shopMoveBanner']; ?>">
                </span>
              </div>
                <div class="f-clear"></div>
              <div>图片大小:<span>414 x 190</span> (px)(格式为 <span>gif</span>, <span>jpg</span>, <span>jpeg</span>, <span>png</span>)</div>

             </td>
           </tr>
           <tr>
             <th width='120' align='right'>滚动广告<font color='red'>*</font>：</th>
             <td>
                  <div id="batchUpload" class="wst-batchupload" style="border:1px solid #f1f1f1;width: 568px;">
                    <div style="border-bottom:1px solid #f1f1f1;padding-left:10px;height:30px;line-height:30px">
                      图片大小:<span>1200 x 400</span> (px)(格式为 <span>gif</span>, <span>jpg</span>, <span>jpeg</span>, <span>png</span>)
                    </div>
                    <div class="queueList filled">
                        <div id="dndArea" class="placeholder <?php if(!empty($object['shopAds'])): ?>element-invisible<?php endif; ?>">
				            <div id="filePicker"></div>
				            <p>或将照片拖到这里，单次最多可选5张，每张最大不超过5M</p>
				        </div>
                        <ul class="filelist" >
                            <?php if(is_array($object['shopAds']) || $object['shopAds'] instanceof \think\Collection || $object['shopAds'] instanceof \think\Paginator): $i = 0; $__LIST__ = $object['shopAds'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <li  class="state-complete" style="border: 1px solid #ddd;">
                               <p class="title"></p>
                               <p class="imgWrap">
                                  <img src="__RESOURCE_PATH__/<?php echo $vo; ?>">
                               </p>
                               <input type="hidden" v="<?php echo $vo; ?>" iv="<?php echo $vo; ?>" class="j-gallery-img">
                               <span class="btn-del">删除</span>
                               <input class="cfg-img-url" type="text" value="<?php echo $object['shopAdsUrl'][$key]; ?>" style="width:170px;" placeholder="广告路径">
                            </li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                      </ul>
                    </div>
                    <div class="statusBar" >
                        <div class="progress" style="display: none;">
                            <span class="text">0%</span>
                            <span class="percentage" style="width: 0%;"></span>
                        </div>
                        <div class="info"></div>
                        <div class="btns">
                            <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
                        </div>
                    </div>
                </div>

              <div style='clear:both;'></div>
             </td>
           </tr>
          </tbody>
          </form>
          <tfoot>
           <tr>
             <td colspan='2' style='padding:20px 0px 20px 155px;'>
                 <button type="submit" class="btn btn-primary btn-mright" onclick="javascript:save()"><i class="fa fa-check"></i>保&nbsp;存</button>
<button type="button" class="btn" onclick="javascript:location.reload();" style="margin-left: 10px;"><i class="fa fa-refresh"></i>重&nbsp;置</button>
             </td>
           </tr>
           </tfoot>
        </table>
   </div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='__SHOP__/shopconfigs/shop_cfg.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>'></script>
<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/webuploader/batchupload.js?v=<?php echo $v; ?>'></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/validator/jquery.validator.min.js?v=<?php echo $v; ?>"></script>
<script>
$(function(){
})
function delbanner(obj){
    var c = WST.confirm({content:'您确定要删除顶部广告图片吗?',yes:function(){
             $('#shopBannerPreview').attr('src','');
             $('#shopBanner').val('');
             $(obj).hide();
             layer.close(c);
          }})
  }
  function delmovebanner(obj){
    var c = WST.confirm({content:'您确定要删除移动端顶部广告图片吗?',yes:function(){
             $('#shopMoveBannerPreview').attr('src','');
             $('#shopMoveBanner').val('');
             $(obj).hide();
             layer.close(c);
          }})
  }
function delShopStreetBg(obj){
  var c = WST.confirm({content:'您确定要删除店铺街背景图片吗?',yes:function(){
             $('#shopStreetImgPreview').attr('src','');
             $('#shopStreetImg').val('');
             $(obj).hide();
             layer.close(c);
          }})
}
</script>


<?php echo hook('initCronHook'); ?>
</body>
</html>
