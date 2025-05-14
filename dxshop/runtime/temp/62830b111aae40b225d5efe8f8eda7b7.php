<?php /*a:2:{s:65:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\import.html";i:1670082666;s:63:"D:\wamp\www\hkshopNC\dxshop\wstmart\shop\view\default\base.html";i:1738111633;}*/ ?>
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
.express li{float:left;margin-right: 15px;color:#000;background: #fff;border:1px solid #f5f5f5;border-radius: 5px;padding:5px;cursor: pointer;}
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
<div class="wst-body">
    <table class="wst-form">
        <tr>
            <td colspan='2' >
                <div class='wst-tips-box' style='margin-top:10px;'>
                    <div class='icon'></div>
                    <div class='tips' >
                        1.请确保商品价格必须大于0，否则将自动默认为0.01。<br/>
                        2.请确保商品库存不能为负数，否则将自动默认为0。<br/>
                        3.请勿重复上传, 否则将造成重复商品数据。<br/>
                        4.请保证导入的数据在Excel的第一个工作表(Sheet)。<br/>
                        5.若Excel上某一行第一列为空则代表商品数据导入完毕。<br/>
                        6.若没有数据模板，请点击<a href='/hkshopNC/dxshop/static/template/goods.xls' style='color:blue;' target='_blank'>下载Excel模板</a>。<br/>
                        7.推荐使用谷歌浏览器或者火狐浏览器Firefox以获得更佳体验。<br/>
                        8.快递公司需填写系统存在快递公司，以下是店铺已启用的快递公司列表，可点击以下快递公司名称复制：<br/>
                        <div id='list' class='express'>
                            <?php if(is_array($express) || $express instanceof \think\Collection || $express instanceof \think\Paginator): $i = 0; $__LIST__ = $express;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <li id="express_<?php echo $vo['id']; ?>" onclick="copyText('express_<?php echo $vo['id']; ?>');"><?php echo $vo['expressName']; ?></li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            <div style='clear:both;'></div>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </td>
        </tr>
        <tr>
            <th align='right' width='90'>商品数据：</th>
            <td>
                <div id="filePicker" style='margin-left:0px;'>导入商品数据</div>
            </td>
        </tr>
        <tr style="display: none;">
            <th align='top' style="color: red;font-weight: bold;vertical-align: text-top;" width='90'>错误信息：</th>
            <td id="errMsgBox"></td>
        </tr>
    </table>
</div>
</div>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__SHOP__/js/common.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="/hkshopNC/dxshop/static/plugins/lazyload/jquery.lazyload.min.js?v=<?php echo $v; ?>"></script>

<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>'></script>
<script>
    var uploading = null;
    $(function(){
        var uploader = WST.upload({
            server:"<?php echo url('shop/imports/importGoods'); ?>",pick:'#filePicker',
            formData: {dir:'temp'},
            callback:function(f,file){
                layer.close(uploading);
                uploader.removeFile(file);
                var json = WST.toJson(f);
                $('#errMsgBox').parent().hide();
                if(json.status==1){
                    uploader.refresh();
                    WST.msg('导入数据成功!已导入数据'+json.importNum+"条", {icon: 1});
                    if(json.specErrMsg && json.specErrMsg.length>0){
                        var _msg = json.specErrMsg.map(function(x){return "<div style='color: red;font-weight: bold;'>"+x.msg+"</div>"});
                        $('#errMsgBox').html(_msg.join('')).parent().show();
                    }
                }else{
                    WST.msg('导入数据失败,出错原因：'+json.msg, {icon: 2});
                }
            },
            progress:function(rate){
                uploading = WST.msg('正在导入数据，请稍后...');
            }
        });
    });

    function copyText(id) { // 复制指定元素中的文本内容
      var el = document.getElementById(id);
      if (!el) {
        throw new TypeError(`${id}的元素不存在！`);
      }
      var tagName = el.tagName;
      var formElList = ['input', 'textarea'];
      if (formElList.includes(tagName.toLowerCase())) { // 表单元素，如：input, textarea
        el.focus();
        if (el.setSelectionRange) {
          el.setSelectionRange(0, el.value.length);
        } else {
          el.select();
        }
      } else { // 非表单元素，如：div, span 等
        if (document.selection) { // IE
          var range = document.body.createTextRange();
          range.moveToElementText(el);
          range.select();
        } else if (window.getSelection) { // 非IE
          var selection = window.getSelection();
          var range = document.createRange();
          selection.removeAllRanges();
          range.selectNodeContents(el);
          selection.addRange(range);
        }
      }
      document.execCommand('copy');
      WST.msg("已复制好，可贴粘。",{icon:1});
    }
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>
