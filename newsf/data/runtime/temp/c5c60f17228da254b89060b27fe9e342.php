<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:35:"./template/pc/lists_article_img.htm";i:1726152780;s:47:"D:\wamp\www\hkshop\newsf\template\pc\header.htm";i:1732155593;s:47:"D:\wamp\www\hkshop\newsf\template\pc\footer.htm";i:1728737210;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript"> 
<!--
//图片按比例缩放
var flag=false;
function DrawImage(ImgD,iwidth,iheight){
    //参数(图片,允许的宽度,允许的高度)
    var image=new Image();
    image.src=ImgD.src;
    if(image.width>0 && image.height>0){
    flag=true;
    if(image.width/image.height>= iwidth/iheight){
        if(image.width>iwidth){  
        ImgD.width=iwidth;
        ImgD.height=(image.height*iwidth)/image.width;
        }else{
        ImgD.width=image.width;  
        ImgD.height=image.height;
        }
        ImgD.alt=image.width+"×"+image.height;
        }
    else{
        if(image.height>iheight){  
        ImgD.height=iheight;
        ImgD.width=(image.width*iheight)/image.height;        
        }else{
        ImgD.width=image.width;  
        ImgD.height=image.height;
        }
        ImgD.alt=image.width+"×"+image.height;
        }
    }
} 
//-->
</script>
<script language="javascript">
function killErrors() {
    return true;
}
window.onerror = killErrors;
</script>
<title><?php echo $eyou['field']['seo_title']; ?></title>
<meta name="description" content="<?php echo $eyou['field']['seo_description']; ?>" />
<meta name="keywords" content="<?php echo $eyou['field']['seo_keywords']; ?>" />
<link href="<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_ico"); echo $__VALUE__; ?>" rel="shortcut icon" type="image/x-icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/css/bootstrap.css","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/css/font.css","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/css/amazeui.min.css","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/css/base.css","","","","",""); echo $__VALUE__; ?>
<style type="text/css">
body, td, th {
	font-family: "微软雅黑", Helvetica, Arial, Tahoma, SimSun, sans-serif;
}
</style>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<?php  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/js/html5shiv.min.js","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/js/respond.min.js","","","","",""); echo $__VALUE__; ?>      
<![endif]-->
</head><body>
  <link rel="shortcut icon" target="_blank" href="https://www.globevisa.com.cn/favicon.ico">
  <link rel="stylesheet" href="./ymcg/reset1.css">
<!-- -->
  <link rel="stylesheet" href="./ymcg/common1.css">
 <!-- -->
  <link rel="stylesheet" href="./ymcg/window1.css">
  <link rel="stylesheet" href="./ymcg/advisers1.css">
  <script async="" charset="UTF-8" src="./ymcg/bigdata.js"></script>
  <script async="" charset="UTF-8" src="./ymcg/loader.js"></script>
  <script async="" src="./ymcg/gtm.js"></script>
  <script src="./ymcg/hm.js"></script>

 <script type="text/javascript" src="./ymcg/entrytalk.js"> </script>

  <link rel="stylesheet" href="./ymcg/flag_window.css">
  <link rel="stylesheet" href="./ymcg/flag.css">

<link rel="stylesheet" href="./ymcg/index.css">
<link rel="stylesheet" href="./ymcg/swiper.css">
<link rel="stylesheet" href="./ymcg/fifth_module.css">
<link rel="stylesheet" href="./ymcg/mqgwReset.css">
 
<head>
<meta charset="utf-8">
<!-- js open B不能使用 -->
<script type="text/javascript" src="/hsytt/assets/fb04db1/jquery.min.js"></script> 
<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/css/public.css" />
<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/css/font.css" />
<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/js/jquery.fallr/jquery.fallr.css" />
<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/js/jquery.datetimepicker/jquery.datetimepicker.css" />
<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/js/jquery.uploadifive/uploadifive.css" />

<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/js/artDialog/skins/default.css" />
<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/js/jquery.contextMenu/jquery.contextMenu.css" />

<script type="text/javascript" src="https://www.globevisa.com.cn/static/index/js/lang1.js"></script>
<script type="text/javascript" src="https://www.globevisa.com.cn/static/index/js/jquery.lazyload1.js"></script>
<style type="text/css">
.fhm-cl-p{height:220px;}
.fhm-cl-p .info{    width: 240px;  height: 124px;    color: rgba(255,255,255,1);
    overflow: hidden;    margin-top: -3px;    line-height: 25px;}
.fhm-cl-p p{    width: 355px;height:85px;margin:0;overflow:hidden}
.videomq{display:none;width:125px;height:36px;top:90px;left:5px;background:rgba(0,0,0,0.5) url('/static/index/images/customer/video1.png') no-repeat 14px center;border-radius:20px 5px 5px 20px;color:#f00;line-height:36px;text-indent:36px;font-size:14px;text-decoration:underline;color:#BA1F1B}
.videomq:hover{color:#f00}
.videoImg{display:none;width:32px;height:32px;top:92px;left:7px;transition:ease-in 0.4s;transform:rotate(0deg);-webkit-transform:rotate(0deg);z-index:4;}
.fhm-cl-b li {width:115px;height:28px;line-height:30px;border-radius:5px;background-color:#a67e3d;}
.fhm-cl-b li:last-child a {  text-align: center;  text-indent:20px;
  /*background:url(/static/index/images/customer/areaCode.png) no-repeat;*/
  background:url(/static/index/images/customer/tel.png) no-repeat;
  background-position: 8px 8px;  letter-spacing:6px }

.fhm-cl-b li:first-child a {text-indent:30px;background:url(/static/index/images/customer/weixin.png) no-repeat;  background-position: 8px 8px; letter-spacing:6px}

</style>
<style type="text/css">
  /*.mainInfo{
    display: none;
  }*/
  /* 国编样式 */
    .jt{        top: 18px;    right: 14px;/* background-color: ; */  }
    .flex_father{   border: 0 !important;    }
    .flex dt { margin-right: 10px; font-size: 16px; color: #fff;  display: inline-block; }
    .flex dd .select-i:not(:last-of-type) {        margin-right: 30px;    }
    .ul-select { width: 278px; top: 47px;left: -4px; z-index: 2; max-height: 220px;
        background-color: rgba(254,253,253,.9); border-bottom: 1px solid #c8c8c8; }
    .select-i { position: relative; width: 80px; }
    .select-i .input-txt { height: 39px;   line-height: 39px;
        background-color: rgba(254,253,253,.9);   color: #626262;
        vertical-align: middle; box-sizing: border-box;  display: inline-block;
        margin-left: -4px; text-indent: 10px; width: 100%; border-radius: 4px;
        font-size: 15px; border: 1px solid #BFBFBF; white-space: nowrap;
        text-overflow: ellipsis;  overflow: hidden; cursor: pointer;
    }
  .flex .countryCode2 li{  margin-top: -4px;  }
</style>

  <!-- 统计代码 -->
  <script type="text/javascript">
    var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?18a409a10b8bfecaa9d787af52ffd315";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})(); </script>
    <!-- 统计代码 -->
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
  var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
  j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
  f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-T3TLZVV3');</script>
  <!-- End Google Tag Manager -->
  <!-- 美恰代码 -->
  <script type="text/javascript">

    (function(a, b, c, d, e, j, s) {
      a[d] = a[d] || function() {  (a[d].a = a[d].a || []).push(arguments)  };
      j = b.createElement(c),
          s = b.getElementsByTagName(c)[0];
      j.async = true;
      j.charset = 'UTF-8';
      j.src = 'https://static.meiqia.com/widget/loader.js';
      s.parentNode.insertBefore(j, s);
    })(window, document, 'script', '_MEIQIA');

    _MEIQIA('entId', '957e34975a78a7c54892fec1cc077db3');
    // 获取聊天窗口可见性

    var timer = null;
    var times =1;
//    setTimeout(function(){  _MEIQIA('showPanel'); }, 30000);//访客进来5s后打开聊天窗口

    setTimeout(function(){ bweline(); }, 3000000);//访客进来5s后打开聊天窗口
    _MEIQIA('getPanelVisibility', yourFunction);
   // $product=$('#product');
   // 'http://116.205.242.68/welive/kefu.php?a=6168
  function bweline(){
 //   $.dialog.data('id', 0);
    $.dialog.open('/welive/kefu.php?a=6168',{
            id:'xiajia', lock:true, opacity:0.3, title:'选择咨询专员',
            width:'50%',height:'80%',
            close: function() {  }
    });
   }
    function yourFunction(visibility) {
      if (visibility === 'visible') {
        clearInterval(timer);
      } else {
        if(times==1){
          setTimeout(function(){    _MEIQIA('showPanel') }, 60000);
          times++;
          return false;
        }else{
          setTimeout(function(){  _MEIQIA('showPanel')  }, 90000);
        }
      }
    }// 美洽聊天窗口没有显示后，多长时间弹出美洽聊天窗口  （可选项，各自项目人员自己选择）
    function openMeiqia(assignParams, fromParams,clickPlaceType='',pageType='') {
      MeiqiaRecord(clickPlaceType,pageType);
      /*
                美恰区分，此步骤第一步先走IP判断，国内的reCode 不等于 1  不走分配机制，国外的reCode 是0 提前随机该地区对应分配给的分公司取一个，返回group_token 根据三个参数，IP、cookieID和时间戳，返回是否已咨询，存在则返回旧的group_token
                https://127.0.0.1/hkshop/shop/index.php?r=gfClubCustomerServiceGroupMember/service_chat&id=587
                http://127.0.0.1/welive/kefu.php?a=6168&g=客服组id
            */
      $.post("http://116.205.242.68/welive/kefu.php?a=6168", function(msg) {  },'json')
          .complete(function(msg) {
            var groupToken;
            if (msg.responseText != undefined && msg.responseText.indexOf('reCode') != -1 && eval('(' + msg.responseText + ')').reCode == 0) {
              groupToken = eval('(' + msg.responseText + ')').reMsg.group_token;
            }else{
            //  console.log('(' + msg.responseText + ')');
            }
            var params, extra;
            if (assignParams && assignParams.agent_token){
              params = {agentToken: assignParams    .agent_token};
            } else if (assignParams && assignParams.group_token){
              params = {groupToken: assignParams.group_token};
            } else if (groupToken){
              params = {groupToken:groupToken}
            }
            var mqCookie = $(".mqCookie").html();
            if (fromParams){
              _MEIQIA('metadata', { 
                from: fromParams,
                // gender:mqCookie
              });
            }
            _MEIQIA('showPanel', params);
          });
    }

    //美恰咨询 弹窗  执行具体人员
    function Meiqia(token,fromParams,clickPlaceType='',pageType='') {
      // 设置 fallback
      _MEIQIA('fallback', 2);
      MeiqiaRecord(clickPlaceType,pageType);
      if (fromParams){   _MEIQIA('metadata', { from: fromParams,  }); }  // 指定客服
      _MEIQIA('showPanel', {  agentToken: token,  });
    }
    //美恰咨询 弹窗  执行具体客服组
    function MeiqiaGroup(token,clickPlaceType='',pageType='') {
      console.log('正常执行_客服组: '+token+' 点击位置: '+clickPlaceType+' 点击页面: '+pageType);
      MeiqiaRecord(clickPlaceType,pageType);  // 指定客服组
      _MEIQIA('showPanel', {  groupToken: token,  });
    }
    //记录点击美恰
    function MeiqiaRecord(clickPlaceType='',pageType='') {
      //调用记录方法
      recordUserAction('2');
      //clickPlaceType 点击位置   pageType 点击页面
      if (clickPlaceType !='' && pageType !=''){
        $.ajax({
          url:'https://www.globevisa.com.cn/globevisapc/index/MeiqiaRecord',
          type:'post',
          data:'clickPlaceType='+clickPlaceType+"&pageType="+pageType+"&type=1"+"&url="+window.location.href ,
          dateType:'json',
          success:function(msg){   console.log(msg.status); }
        })
      }else{  console.log("参数不完整!"); }
    }
  </script>
  <!-- 美恰代码 -->
<link rel="stylesheet" href="./ymcg/layer1.css" id="layui_layer_skinlayer1css" style="">
<style data-styled="" data-styled-version="4.4.1"></style>

</head>
<body><script src="./ymcg/bl.js" crossorigin=""></script>
  <!-- Google Tag Manager (noscript) -->
  <noscript>
  <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T3TLZVV3" height="0" width="0" style="display:none;visibility:hidden">
  </iframe>
  </noscript>
  <!-- End Google Tag Manager (noscript) -->
  <script>
    !(function(c,b,d,a){c[a]||(c[a]={});c[a].config=
        {
          pid:"cg1fd@263414299dee23c", urlHelper:[/\/$/],appType:"web",
          imgUrl:"https://arms-retcode.aliyuncs.com/r.png?",
          sendResource:true, enableLinkTrace:true,  behavior:true
        };
      with(b)with(body)with(insertBefore(createElement("script"),firstChild))setAttribute("crossorigin","",src=d)
    })(window,document,"https://retcode.alicdn.com/retcode/bl.js","__bl");
  </script>
<script src="./ymcg/flash.js"></script>
<script src="./ymcg/swiper1.js"></script>
<script type="text/javascript" src="./ymcg/advisers.js"></script>
<script type="text/javascript" src="./ymcg/fifth_module.js"></script>
<script>
    $(function() {
      $(".cp_panel_ym").each(function() {
        if ($(this).find('ul li').length >= 1) {
          $(this).parents('.mainInfo').show();
        }
      })
        var swiper = new Swiper('.cc_slide', {
            autoplay: {  delay: 4000,  disableOnInteraction: true,   },
            loop : true,
            navigation: {  nextEl: '.next_btn', prevEl: '.prev_btn',  },
        });
        $(".clr_list dl .join").click(function() {
            if ($(this).hasClass('on')) {
                $(this).removeClass('on');
                $(this).html('加入对比');
            }else{
                $(this).addClass('on');
                $(this).html('取消对比');
            }
            var ids = '';
            $(".clr_list dl").each(function() {
                if ($(this).find('.join').hasClass('on')) {
                    ids += ','+$(this).attr('data');
                }
            })
            $("#contrastsID").val(ids.substring(1));
            if ($.trim($("#contrastsID").val()) == '') {
                $(".look").attr('href',"javascript:layer.msg('请选择对比国家！');");
            }else{
                $(".look").attr('href',"/contrast_result.html?countryIDS=" + $.trim($("#contrastsID").val()))
            }
        })

        $(".pf_list span").click(function(){
            var num = $(this).parents("dl").index()+1;
            $(this).find("ul").slideToggle();
            $(this).parents("dl").siblings("dl").find("ul").slideUp();
            $(".type li").click(function(){
                var txt = $(this).text();
                var typeID = $(this).attr("attr-id");
                $(".typeName").val(typeID);
                $(this).parents("ul").siblings("em").text(txt);
            })

            $(".project li").click(function(){
                var txt = $(this).text();
                var projectName = $(this).attr("attr-id");
                $(".projectName").val(projectName);
                $(this).parents("ul").siblings("em").text(txt);
            })

            $(".renshu li").click(function(){
                var txt = $(this).text();
                $(".person").val(txt);
                $(this).parents("ul").siblings("em").text(txt);
            })

            $(".city li").click(function(){
                var txt = $(this).text();
                $(".cityName").val(txt);
                $(this).parents("ul").siblings("em").text(txt);
            })
            var text = $('.pf_' + num + ' em').text();
            $('#pf_' + num ).val(text);
        });
    })
</script>

<input type="hidden" value="" id="iotest">
<input type="hidden" value="" id="yxgj_">
<input type="hidden" value="" id="ymmd_">
<span class="mqCookie" style="display:none"></span>
<!-- 头部 -->
<style>
  .gskh{    position: absolute;   left: 0px;    /*top: -11px;*/ }
  .gskhs{   position: absolute;   margin-left: 600px;   margin-top: 0px;  }
  .zzfu{
    /* margin-top: 280px; */
    margin-top: 153px;    margin-left: -200px;  }
  .nav_addS_imgs {margin-top: 10px;width: 270px;background: #F6EEE1;box-sizing: border-box;
    padding: 10px;  }
  .sel_country{display:none; margin-left: 15px; }
          .sel_country div{   /* display:inline-block; */
            border:1px solid #EDE1C9;height:36px;line-height:36px;border-radius:25px;
          }
          .sel_country ul{position: absolute;
            top: 37px;left: 14px;border: 1px solid #EDE1C9; background: #f1efeb;
            width: 88px;padding: 4px 0px;}
          .sel_country ul li{ font-size: 14px;height:26px;line-height:26px;text-align:center;  }
          .sel_country ul li a:hover{ color:#990000;}
          .sel_country ul li:hover/* background:#a67f3e; */  color:#990000;
          .search_type{width: 49px;text-align: right;padding-right: 13px;font-size: 12px;
            float: left;height: 100%;border-right: #EDE1C9 1px solid;
            background:url("/static/index/images/header_xl.png") no-repeat right;
          }
          #ac:hover .sel_country {display: block; text-decoration:none;}
          .ureg.zt {  display: none !important;}

</style>
<script>
  function setClassName(name1,name2){
    document.getElementById(name1).className += " zt";
    document.getElementById(name2).className = "ureg";
  }
  $(function(){
    var zc = zh_getLang();
    if(zc){setClassName('ft','jt'); }else { setClassName('jt','ft');}
  });
</script> 
  <section class="g-header-top  g-box-sizing">
    <div class="g-center-block login_box">
<ul class="g-hdt-left fl">
<li class="fl"><a href="/hkshop/shop/index.php?r=datashow/success" target="_blank" title="成功案例" rel="nofollow">成功案例</a></li>
<li class="fl"><a href="/hkshop/shop/index.php?r=datashow/pays" target="_blank" title="費用計算" rel="nofollow">費用計算</a></li>
<li class="fl"><a href="/hkshop/shop/index.php?r=datashow/types" target="_blank" title="護照對比" rel="nofollow">護照對比</a></li>
<li class="fl"><a href="/hkshop/shop/index.php?r=datashow/country" target="_blank" title="國家對比" rel="nofollow">國家對比</a></li><li class="fl"><a href="/hkshop/shop/index.php?r=datashow/pays" target="_blank" title="條件測評" rel="nofollow">條件測評</a></li></ul>
<ul class="g-hdt-right fr">
<li class="g-hdt-mobile J_hdt_mobile">
  <a href="javascript:;" target="_blank" class="">手機版</a>
  <span class="g-hdt-qrCode g-box-sizing J_hdt_qrCode" style="display: none;">
  <img src="./ymcg/g-hdt-qrCode.png">
  <em>掃一掃，進入手機版</em> 
</span>
</li>
<li class="uwelcome"> <a href="javascript:;" target="_blank">您好，****</a></li>
<li class="uout"><a href="javascript:loginout();">退出</a></li>
<li class="ulogin" style="display: list-item;"><a rel="nofollow" href="javascript:login();">登錄</a></li>
<li class="ureg" style="display: list-item;"><a rel="nofollow" href="javascript:register();">註冊</a></li>
<li class="ureg" id="ft" style="display: list-item;"><a rel="nofollow" href="javascript:zh_tran(&#39;t&#39;);">繁體</a></li>
<li class="ureg zt" id="jt" style="display: list-item;"><a rel="nofollow" href="javascript:zh_tran(&#39;s&#39;);">簡體</a></li>
<li class="ulogin ac" id="ac" style="padding-right: 18px; background: url(&quot;/static/index/images/header_xl.png&quot;) right center no-repeat; display: list-item;">
  <!--<a rel="nofollow" href="https://www.huanqiuchuguo.com/en/index.shtml">English</a>-->
</li>

  </ul>
    </div>
  </section>

<div class="white_bg">
  <div class="container">
    <div class="row pt20 pb20">
      <div class="col-md-3 text-left  index01"> <a href="<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_basehost"); echo $__VALUE__; ?>"><img src="<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_logo"); echo $__VALUE__; ?>" border="0" height="60"></a> </div>
<ul class="g-hd-right" style="margin-right:0px;">
<li style="background: url(/static/index/images/mfpg_03new2.png) no-repeat left center;background-size: 118px 37px;">
<a href="<?php echo $spath;?>.cn/ympg.html" rel="nofollow" target="_blank" title="免費移民評估" style="width:120px;">免費評估</a>
</li>

<li class="g-hd-video-resolution" style="margin:0;" id="hqgm">
<a href="<?php echo $spath;?>/about.html#page0" target="_blank" rel="nofollow" title="" style="background: url(/static/index/images/hqgm_03new2.png) no-repeat left center;background-size: 32px 32px;"></a>

<div class="hq_city_nav clearfix" style="height: 350px;padding: 44px 0 33px 0;width: 700px;"></div>
</li>

<li class="g-hd-video-resolution">
<a href="<?php echo $spath;?>/projectsList.html" target="_blank" rel="nofollow" title="熱門推薦">熱門推薦</a>
<!-- <a href="/globevisapc/index/hqyw" target="_blank" rel="nofollow" title="环球业务">环球业务</a> -->
<!--<a href="javascript:;" target="_blank" rel="nofollow" title="环球业务">环球业务</a>-->
</li>
<li class="g-hd-video-Member">
<a href="<?php echo $spath;?>/vip/login.html" target="_blank" rel="nofollow" title="會員中心">會員中心</a>
</li>
<style>
  .g-hd-search{   width: 210px;   margin-left: 15px;  margin-top: 10px; }
  .g-hd-search div{border:1px solid #EDE1C9;height:36px;line-height:36px;border-radius:25px;  }
  .g-hd-search ul{    display:none;position: absolute;top: 37px;left: 14px;
    border: 1px solid #EDE1C9;background: #faf7f1;width: 48px;
  }
  .g-hd-search ul li{   height:20px;    line-height:20px;   text-align:center;  }
  .g-hd-search ul li:hover{   background:#a67f3e;   color:#fff; }
  .search_type{  width: 49px;text-align: right;padding-right: 13px;
    font-size: 12px;float: left;height: 100%;border-right: #EDE1C9 1px solid;
    background:url("/static/index/images/header_xl.png") no-repeat right;
  }
  .g-hd-search input{ width:107px;float:left;height:100%;background:#faf7f1;
    font-size: 12px;padding-left: 7px;  }
  .header_search{    width: 22px;
    background: #faf7f1 url(/static/index/images/header_search.png) no-repeat center;
    display: block; height: 34px;float: left;background-size: 27px;
  }
  .g-hd-right > li + li{    margin:0 0 0 15px }
  .g-logo{    width:435px;  }
  .g-cctv-logo{   width: 250px;   background-size: 250px 36px;  }
  .nav_column:nth-of-type(n+2){
    /* margin-left: 68px; */
  }
</style>

      </ul>
    </div>

  </div>
</div>
<div class="nav_bg">
  <div class="container">
    <ul class="clearfix">
      <li><a <?php if(\think\Request::instance()->param('m') == 'Index'): ?> class="active"<?php endif; ?> href="https://qmdd.net/hkshop/newsf/">首页</a></li>
       <?php  echo $eyou['mainmenu']; ?>
     </ul>
  </div>
</div>


<a><img src="<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_templets_pc"); echo $__VALUE__; ?>/skin/images/ban01.jpg" width='120%' height="100" /></a>
<div class="pt10 container inside_nav"> 您的位置： <?php  $typeid = ""; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  $tagPosition = new \think\template\taglib\eyou\TagPosition; $__VALUE__ = $tagPosition->getPosition($typeid, "", ""); echo $__VALUE__; ?> </div>
<div class="container">
  <div class="inside_navbar"> <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 100; endif; $tagChannel = new \think\template\taglib\eyou\TagChannel; $_result = $tagChannel->getChannel($typeid, "first", "active", ""); if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $e = 1;$__LIST__ = is_array($_result) ? array_slice($_result,0, $row, true) : $_result->slice(0, $row, true); if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field2): $field2["typename"] = text_msubstr($field2["typename"], 0, 100, false); $__LIST__[$key] = $_result[$key] = $field2;$i= intval($key) + 1;$mod = ($i % 2 ); ?><a href="<?php echo $field2['typeurl']; ?>" class="<?php echo $field2['currentstyle']; ?>"><?php echo $field2['typename']; ?></a> <?php ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field2 = []; ?> </div>
  <div class="mt10 white_bg mb30 active01">
    <div class="clearfix"> <?php  $typeid = "";  if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  $param = array(      "typeid"=> $typeid,      "notypeid"=> "",      "flag"=> "",      "noflag"=> "",      "channel"=> "",      "keyword"=> "",      "idlist"=> "",      "idrange"=> "", ); $tagList = new \think\template\taglib\eyou\TagList; $_result_tmp = $tagList->getList($param, 16, "", "", "desc", "on","off","");if(!empty($_result_tmp) && (is_array($_result_tmp) || $_result_tmp instanceof \think\Collection || $_result_tmp instanceof \think\Paginator)): $i = 0; $e = 1; $__LIST__ = $_result = $_result_tmp["list"]; $__PAGES__ = $_result_tmp["pages"];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $aid = $field["aid"];$users_id = $field["users_id"];$field["title"] = text_msubstr($field["title"], 0, 100, false);$field["seo_description"] = text_msubstr($field["seo_description"], 0, 160, true);$i= intval($key) + 1;$mod = ($i % 2 ); ?>
      <div class="col-md-3 col-xs-6"> <a href="<?php echo $field['arcurl']; ?>"><img src="<?php echo $field['litpic']; ?>" alt="<?php echo $field['title']; ?>"></a>
        <h2><a href="<?php echo $field['arcurl']; ?>"><?php echo $field['title']; ?></a></h2>
      </div>
      <?php ++$e; $aid = 0; $users_id = 0; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?> </div>
    <div class="text-center">
      <nav aria-label="Page navigation">
        <ul class="pagination">
           <?php  $__PAGES__ = isset($__PAGES__) ? $__PAGES__ : ""; $tagPagelist = new \think\template\taglib\eyou\TagPagelist; $__VALUE__ = $tagPagelist->getPagelist($__PAGES__, "pre,pageno,next", "5"); echo $__VALUE__; ?>
        </ul>
      </nav>
    </div>
  </div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="./ymcg/layer1.js"></script>
<script type="text/javascript" src="./ymcg/swiper1.js"></script>
<script type="text/javascript" src="./ymcg/nav1.js"></script>
<script type="text/javascript" src="./ymcg/warp_hq1.js"></script>
<script type="text/javascript" src="./ymcg/window1.js"></script>
<script type="text/javascript" src="./ymcg/functions1.js"></script>
<script type="text/javascript" src="./ymcg/md5AndCaptcha.js"></script>
<script type="text/javascript" id="domain" domain="0" src="./ymcg/main.js"></script>
<script type="text/javascript" src="./ymcg/AjaxFormSubmit.js"></script>
<script type="text/javascript" src="./ymcg/pctomobile1.js"></script>
<script type="text/javascript" src="./ymcg/cost.js"></script>
<!-- <script src="https://m.globevisa.com.cn/static/index/js/userInfo.js?1683710040225"></script> -->
<footer>
  <div class="container"> <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 6; endif; $tagChannel = new \think\template\taglib\eyou\TagChannel; $_result = $tagChannel->getChannel($typeid, "top", "", ""); if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $e = 1;$__LIST__ = is_array($_result) ? array_slice($_result,0, $row, true) : $_result->slice(0, $row, true); if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $field["typename"] = text_msubstr($field["typename"], 0, 100, false); $__LIST__[$key] = $_result[$key] = $field;$i= intval($key) + 1;$mod = ($i % 2 ); ?>
    <div class="col-md-2 col-xs-6">
      <h2><a href="<?php echo $field['typeurl']; ?>"><?php echo $field['typename']; ?></a></h2>
      <p> <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 6; endif;if(is_array($field['children']) || $field['children'] instanceof \think\Collection || $field['children'] instanceof \think\Paginator): $i = 0; $e = 1;$__LIST__ = is_array($field['children']) ? array_slice($field['children'],0,6, true) : $field['children']->slice(0,6, true); if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field2): $field2["typename"] = text_msubstr($field2["typename"], 0, 100, false); $__LIST__[$key] = $_result[$key] = $field2;$i= intval($key) + 1;$mod = ($i % 2 ); ?> <a href="<?php echo $field2['typeurl']; ?>"><?php echo $field2['typename']; ?></a><?php ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field2 = []; ?> </p>
    </div>
    <?php ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?> </div>
  <div class="container">
 <!--
    <div class="col-md-12 white footer01"> <?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_copyright"); echo $__VALUE__; ?> <br>
      <?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attrname_1"); echo $__VALUE__; ?>：<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attr_1"); echo $__VALUE__;  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attrname_2"); echo $__VALUE__; ?>：<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attr_2"); echo $__VALUE__; ?> <br>
      <?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attrname_3"); echo $__VALUE__; ?>：<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attr_3"); echo $__VALUE__;  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attrname_4"); echo $__VALUE__; ?>：<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attr_4"); echo $__VALUE__;  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attrname_5"); echo $__VALUE__; ?>：<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attr_5"); echo $__VALUE__; ?> 
      </div>
    -->
  </div>
</footer>
<?php  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/js/jquery-3.7.0.min.js","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/js/bootstrap.js","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/js/amazeui.min.js","","","","",""); echo $__VALUE__; ?> 
<!-- 应用插件标签 start --> 
 <?php  $tagWeapp = new \think\template\taglib\eyou\TagWeapp; $__VALUE__ = $tagWeapp->getWeapp("default"); echo $__VALUE__; ?> 
<!-- 应用插件标签 end -->
</body>
</html>
