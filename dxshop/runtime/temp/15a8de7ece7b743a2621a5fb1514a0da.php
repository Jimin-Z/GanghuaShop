<?php /*a:2:{s:66:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\goodscats\edit.html";i:1669886662;s:56:"D:\wamp\www\hkshopNC\dxshop\wstmart\admin\view\base.html";i:1669564546;}*/ ?>
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


<link rel="stylesheet" type="text/css" href="/hkshopNC/dxshop/static/plugins/webuploader/webuploader.css?v=<?php echo $v; ?>" />

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

<form id='goodscatsForm' autocomplete="off">
<div id='tab' class="layui-tab layui-tab-brief">
    <ul class="layui-tab-title">
        <li class="layui-this">分类信息</li>
        <li>seo设置</li>
        <li>模板设置</li>
    </ul>
    <div class="layui-tab-content" style='width:99%;margin-bottom: 10px;'>
        <div class="layui-tab-item layui-show wst-box-top" style="position: relative;">
            <div class='layui-form'>
                    <input type='hidden' id='parentId' name="parentId" class='ipt' value="<?php echo $object['parentId']; ?>"/>
                    <input type="hidden" id="catId" name="catId" class="ipt" value="<?php echo $object['catId']; ?>"/>
                    <table class='wst-form wst-box-top'>
                        <tr>
                            <th width='100'>商品分类名称<font color='red'>*</font>：</th>
                            <td><input type='text' id='catName' name="catName" class='ipt' maxLength='20' value="<?php echo $object['catName']; ?>" /></td>
                        </tr>
                        <tr>
                            <th width='100'>分类名缩写<font color='red'>*</font>：</th>
                            <td><input type='text' id='simpleName' name="simpleName" class='ipt' maxLength='20' value="<?php echo $object['simpleName']; ?>"/></td>
                        </tr>
                        <tr>
                            <th>移动端图标：</th>
                            <td>
                                <input type="text" readonly="readonly"  id='catImg' name="catImg" class="ipt" value="<?php echo $object['catImg']; ?>" style="float: left;width: 355px;" />
                                <div id='catFilePicker'>上传</div><span id='uploadMsg'></span>
                                <div style="min-height:30px; float: left; margin-left: 5px;" id="preview"><?php if($object['catImg']): ?><img src="__RESOURCE_PATH__/<?php echo $object['catImg']; ?>" height="30" /><?php endif; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th width='100'>佣金<font color='red'>*</font>：</th>
                            <td height='24'>
                                <input type="text" id="commissionRate" name="commissionRate" class="ipt" data-target="#msg_commissionRate" size='7' class='ipt' value="<?php echo $object['commissionRate']; ?>">%<span id='msg_commissionRate'>（-1代表继承上级佣金）</span>
                            </td>
                        </tr>
                        <tr>
                            <th width='100'>是否显示<font color='red'>*</font>：</th>
                            <td height='24'>
                                <input type="checkbox" id="isShow" <?php if($object['isShow']==1): ?>checked<?php endif; ?> name="isShow" value="1" class="ipt" lay-skin="switch" lay-filter="isShow1" lay-text="显示|隐藏">
                            </td>
                        </tr>
                        <tr>
                            <th width='150'>是否首页楼层<font color='red'>*</font>：</th>
                            <td height='24'>
                                <input type="checkbox" id="isFloor" <?php if($object['isFloor']==1): ?>checked<?php endif; ?> name="isFloor" value="1" class="ipt" lay-skin="switch" lay-filter="isFloor1" lay-text="是|否">
                            </td>
                        </tr>
                        <tr>
                            <th width='100'>楼层副标题<font color='red'> </font>：</th>
                            <td><input type='text' id='subTitle' name='subTitle' class='ipt' value="<?php echo $object['subTitle']; ?>"/></td>
                        </tr>

                        <tr>
                            <th width='100'>商品显示方式<font color='red'> </font>：</th>
                            <td>
                                 <input type='radio' id='showWay' name='showWay' class='ipt'  value="0"  title="一行两个" <?php if($object['showWay'] == '0'): ?>checked<?php endif; ?>/>
                                 <input type="radio" id='showWay2' name='showWay' class='ipt'  value="1" title="一行一个" <?php if($object['showWay'] == '1'): ?>checked<?php endif; ?>/>
                            </td>
                        </tr>

                        <tr>
                            <th width='100'>排序号<font color='red'>*</font>：</th>
                            <td><input type='text' id='catSort' name='catSort' class='ipt' style='width:60px;' onkeypress='return WST.isNumberKey(event);' onkeyup="javascript:WST.isChinese(this,1)" maxLength='10' value='<?php echo $object['catSort']; ?>'/></td>
                        </tr>
                        <tr>
                            <td colspan='2' align='center'>
                                <button type="submit" class="btn btn-primary btn-mright" ><i class="fa fa-check"></i>保&nbsp;存</button>
                                <button type="button" class="btn" onclick="javascript:parent.closeEditBox()"><i class="fa fa-angle-double-left"></i>返&nbsp;回</button>
                            </td>
                        </tr>
                    </table>

            </div>
        </div>
        <div class="layui-tab-item" style="display:none;">
                <table class='wst-form wst-box-top'>
                    <tr>
                        <th width='150'>seo标题：</th>
                        <td>
                            <input type="text" id='seoTitle' name='seoTitle' class='ipt' value="<?php echo $object['seoTitle']; ?>" maxLength='100'/>
                            <span >(展示格式:seo标题 - 商城名称，为空则为:商品分类 - 商品列表 - 商城名称)</span>
                        </td>
                    </tr>
                    <tr>
                        <th>seo关键字：</th>
                        <td>
                            <input type="text" id='seoKeywords' name='seoKeywords' class='ipt' value="<?php echo $object['seoKeywords']; ?>" maxLength='100'/>
                            <span >(为空则取商城seo关键字)</span>
                        </td>
                    </tr>
                    <tr>
                        <th>seo描述：</th>
                        <td>
                            <textarea id='seoDes' name='seoDes' class=" ipt" style='width:400px;'><?php echo $object['seoDes']; ?></textarea>
                            <span >(为空则取商城seo描述)</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' align='center'>
                            <button type="submit" class="btn btn-primary btn-mright" ><i class="fa fa-check"></i>保&nbsp;存</button>
                            <button type="button" class="btn" onclick="javascript:parent.closeEditBox()"><i class="fa fa-angle-double-left"></i>返&nbsp;回</button>
                        </td>
                    </tr>
                </table>
        </div>
        <div class="layui-tab-item" style="display:none;">
                <?php 
                    $pcStyle = WSTConf('CONF.wsthomeStyle')?WSTConf('CONF.wsthomeStyle'):'default';
                    $mobileStyle = WSTConf('CONF.wstmobileStyle')?WSTConf('CONF.wstmobileStyle'):'default';
                    $wechatStyle = WSTConf('CONF.wstwechatStyle')?WSTConf('CONF.wstwechatStyle'):'default';
                 ?>
                <table class='wst-form wst-box-top'>
                    <tr>
                        <td colspan="2"><div class='wst-tips-box'>
                               <div class='icon'></div>
                               <div class='tips'>
                               1.模板名请以英文、数值或者下划线"_"为组合。<br/>
                               2.建议建立特定的风格目录来存放风格模板，以免文件杂乱，例如：theme/goods/分类风格名/goods_list。</div>
                               <div style="clear:both"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th width='150' style="text-align: left;padding-left:10px;">电脑端</th>
                    </tr>
                    <tr>
                        <th>商品列表模板名<font color='red'>*</font>: </th>
                        <td>
                            <span>wstmart/home/<?php echo $pcStyle; ?>/</span><input type="text" id='catListTheme' name='catListTheme' class='ipt' value="<?php echo $object['catListTheme']; ?>" maxLength='200' data-rule='商品列表模板名:required;length[~2000];' data-target="#catListThemeText"/><span>.html</span><span id='catListThemeText' class="msg-box"></span>
                        </td>
                    </tr>
                    <tr>
                        <th>商品详情模板名<font color='red'>*</font>: </th>
                        <td>
                            <span>wstmart/home/<?php echo $pcStyle; ?>/</span><input type="text" id='detailTheme' name='detailTheme' class='ipt' value="<?php echo $object['detailTheme']; ?>" maxLength='200' data-rule='商品详情模板名:required;length[~2000];' data-target="#detailThemeText"/><span>.html</span><span id='detailThemeText' class="msg-box"></span>
                        </td>
                    </tr>
                    <?php if(WSTDatas('ADS_TYPE',3)!=''): ?>
                    <tr>
                        <th style="text-align: left;padding-left:10px;">手机端</th>
                    </tr>
                    <tr>
                        <th>商品列模板名<font color='red'>*</font>: </th>
                        <td>
                            <span>wstmart/mobile/<?php echo $mobileStyle; ?>/</span><input type="text" id='mobileCatListTheme' name='mobileCatListTheme' class='ipt' value="<?php echo $object['mobileCatListTheme']; ?>" maxLength='200' data-rule='商品列表模板名:required;length[~2000];' data-target="#mobileCatListThemeText"/><span>.html</span><span id='mobileCatListThemeText' class="msg-box"></span>
                        </td>
                    </tr>
                    <tr>
                        <th>商品详情模板名<font color='red'>*</font>: </th>
                        <td>
                            <span>wstmart/mobile/<?php echo $mobileStyle; ?>/</span><input type="text" id='mobileDetailTheme' name='mobileDetailTheme' class='ipt' value="<?php echo $object['mobileDetailTheme']; ?>" maxLength='200' data-rule='商品详情模板名:required;length[~2000];' data-target="#mobileDetailThemeText"/><span>.html</span><span id='mobileDetailThemeText' class="msg-box"></span>
                        </td>
                    </tr>
                    <?php endif; if(WSTDatas('ADS_TYPE',2)!=''): ?>
                    <tr>
                        <th style="text-align: left;padding-left:10px;">微信端</th>
                    </tr>
                    <tr>
                        <th>商品列模板名<font color='red'>*</font>: </th>
                        <td>
                            <span>wstmart/wechat/<?php echo $wechatStyle; ?>/</span><input type="text" id='wechatCatListTheme' name='wechatCatListTheme' class='ipt' value="<?php echo $object['wechatCatListTheme']; ?>" maxLength='200' data-rule='商品列表模板名:required;length[~2000];' data-target="#wechatCatListThemeText"/><span>.html</span><span id='wechatCatListThemeText' class="msg-box"></span>
                        </td>
                    </tr>
                    <tr>
                        <th>商品详情模板名<font color='red'>*</font>: </th>
                        <td>
                            <span>wstmart/wechat/<?php echo $wechatStyle; ?>/</span><input type="text" id='wechatDetailTheme' name='wechatDetailTheme' class='ipt' value="<?php echo $object['wechatDetailTheme']; ?>" maxLength='200' data-rule='商品详情模板名:required;length[~2000];' data-target="#wechatCatListThemeText"/><span>.html</span><span id='wechatCatListThemeText' class="msg-box"></span>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan='2' style='padding-left:100px' >
                            <label style='font-weight:normal'>
                            <input id="isForce" name='isForce' lay-skin="primary" class="ipt" value="1" type="checkbox" title=''/>同步修改本分类下的子分类模板设置
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' align='center'>
                            <button type="submit" class="btn btn-primary btn-mright" ><i class="fa fa-check"></i>保&nbsp;存</button>
                            <button type="button" class="btn" onclick="javascript:parent.closeEditBox()"><i class="fa fa-angle-double-left"></i>返&nbsp;回</button>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
</div>
</form>

<script language="javascript" type="text/javascript" src="/hkshopNC/dxshop/static/plugins/layui/layui.js"></script>
<script language="javascript" type="text/javascript" src="__ADMIN__/js/common.js"></script>

<script src="__ADMIN__/js/wstgridtree.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script src="__ADMIN__/goodscats/goodscats.js?v=<?php echo $v; ?>" type="text/javascript"></script>
<script type='text/javascript' src='/hkshopNC/dxshop/static/plugins/webuploader/webuploader.js?v=<?php echo $v; ?>'></script>
<script>
$(function () {
    initUpload();
    $('#goodscatsForm').validator({
        fields: {
            catName: {
                tip: "请输入商品分类名称",
                rule: '商品分类名称:required;length[~20];'
            },
            simpleName: {
                tip: "请输入商品分类名缩写",
                rule: '商品分类名缩写:required;length[~20];'
            },
            commissionRate: {
                tip: "请输入分类的佣金",
                rule: '分类的佣金:required;'
            },
            catSort: {
                tip: "请输入排序号",
                rule: '排序号:required;length[~8];'
            }
        },
        valid: function(form){
            var catId = $('#catId').val();
            toEdits(catId);
        }
    });
});
</script>

<?php echo hook('initCronHook'); ?>
</body>
</html>