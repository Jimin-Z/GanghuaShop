<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:23:"./template/pc/index.htm";i:1730944647;s:62:"D:\wampserver\wamp64\www\hkshop\newsf\template\pc\headerym.htm";i:1729046592;s:60:"D:\wampserver\wamp64\www\hkshop\newsf\template\pc\hkcase.htm";i:1727227568;s:61:"D:\wampserver\wamp64\www\hkshop\newsf\template\pc\showman.htm";i:1728738220;s:71:"D:\wampserver\wamp64\www\hkshop\newsf\template\pc\showbottomWindows.htm";i:1726644997;s:62:"D:\wampserver\wamp64\www\hkshop\newsf\template\pc\footerym.htm";i:1728738479;}*/ ?>
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
    ImgD.width=image.width; ImgD.height=image.height;
    if(image.width/image.height>= iwidth/iheight){
        if(image.width>iwidth){  
          ImgD.width=iwidth;  ImgD.height=(image.height*iwidth)/image.width;
        }
    }  else{
        if(image.height>iheight){    ImgD.height=iheight;
        ImgD.width=(image.width*iheight)/image.height;        
        }
    }
    ImgD.alt=image.width+"×"+image.height;
    }
} 
//-->
</script>

<script language="javascript">
function killErrors() {    return true;}
window.onerror = killErrors;
</script>
<title><?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_title"); echo $__VALUE__; ?>_<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_name"); echo $__VALUE__; ?></title>
<meta name="description" content="<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_description"); echo $__VALUE__; ?>" />
<meta name="keywords" content="<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_keywords"); echo $__VALUE__; ?>" />
<link href="<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_ico"); echo $__VALUE__; ?>" rel="shortcut icon" type="image/x-icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/css/bootstrap.css","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/css/font.css","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/css/amazeui.min.css","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/css/base.css","","","","",""); echo $__VALUE__; ?>
<style type="text/css">
body, td, th {  font-family: "微软雅黑", Helvetica, Arial, Tahoma, SimSun, sans-serif;}
</style>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<?php  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/js/html5shiv.min.js","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/js/respond.min.js","","","","",""); echo $__VALUE__; ?>    

<![endif]-->
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
   // 'http://shenhailao.com/welive/kefu.php?a=6168
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
      $.post("/welive/kefu.php?a=6168", function(msg) {  },'json')
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
  <a href="javascript:;" target="_blank" class=""></a>
  <span class="g-hdt-qrCode g-box-sizing J_hdt_qrCode" style="display: none;">
  <img src="./ymcg/g-hdt-qrCode.png">
  <em></em> 
</span>
</li>
<li class="uwelcome"> <a href="javascript:;" target="_blank">您好，****</a></li>
<li class="uout"><a href="javascript:loginout();">退出</a></li>
<li class="ulogin" style="display: list-item;"><a rel="nofollow" href="/hkshop/shop/viplogin.php">登錄</a></li>
<li class="ureg" style="display: list-item;"><a rel="nofollow" href="/hkshop/shop/viplogin.php">註冊</a></li>
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

</li>

<li class="g-hd-video-resolution" style="margin:0;" id="hqgm">


<div class="hq_city_nav clearfix" style="height: 350px;padding: 44px 0 33px 0;width: 700px;"></div>
</li>

<li class="g-hd-video-resolution">
<a href="<?php echo $spath;?>/projectsList.html" target="_blank" rel="nofollow" title="熱門推薦">熱門推薦</a>
<!-- <a href="/globevisapc/index/hqyw" target="_blank" rel="nofollow" title="环球业务">环球业务</a> -->
<!--<a href="javascript:;" target="_blank" rel="nofollow" title="环球业务">环球业务</a>-->
</li>
<li class="g-hd-video-Member">
<a href="/hkshop/shop/viplogin.php" target="_blank" rel="nofollow" title="會員中心">會員中心</a>
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
      <li><a <?php if(\think\Request::instance()->param('m') == 'Index'): ?> class="active"<?php endif; ?> href="<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_basehost"); echo $__VALUE__; ?>">首页</a></li>
       <?php  echo $eyou['mainmenu']; ?>
     </ul>
  </div>
</div>


</head><body>
<div class="post" style="display: none"><input type="text" value="1"></div>
<!-- 左侧飘窗
<div class="sider_left">
  <div class="sl_online_box">
    <div class="sl_online">
      <h3 style="background-image: url(/static/index/images/online_iconnew2.png)"></h3>
      <em>专家在线</em>
    </div>
  </div>
  <div class="sl_area"> <div class="sl_name">
      <dl> <dt>国际</dt>
      <dd><ul>
      <li class="li1"><a class="a1" href="javascript:;" onclick="openMeiqia({group_token: &#39;4fc608044644d5e2c7f0c20f8a43f33b&#39;}, &#39;gnpc-UpperLeft-Dubai&#39;,&#39;1&#39;,)">
            阿联酋迪拜               </a>     </li>
      
  </ul>        </dd>      </dl>
   <dl>        <dt>国内</dt>        <dd>          <ul>
      <li><a class="a2" href="javascript:;" onclick="openMeiqia({group_token: &#39;b4927f81a99d57a1d318b7cd91fc0ff9&#39;}, &#39;gnpc-UpperLeft-Shenzhen&#39;,&#39;1&#39;,)">深圳</a></li>
        <li><a class="a2" href="javascript:;" onclick="openMeiqia({group_token: &#39;0e6379e93b12c02eec9bcc24b4ba823c&#39;}, &#39;gnpc-UpperLeft-Hubei&#39;,&#39;1&#39;,)">武汉</a></li> </ul>        </dd>      </dl>
    </div>  </div>
  <div class="sl_close"></div>
</div> -->
<!-- 右侧弹窗-->
<div class="wrap" style="opacity: 1; display: block;">
    <ul>
        <li><a href="javascript:;" onclick="bweline()">在線諮詢  </a>  </li>
        <!-- <li ><a target="_blank" href="parent.openMeiqia(null,&#39;upperRight&#39;,&#39;2&#39;,)">条件测评</a></li> -->

    <li><a href="javascript:;" onclick="xxhz()">項目合作</a></li>

        <!--<li><a target="_blank" href="<?php echo $spath;?>/contrast.html&amp;ycpc">國家對比</a></li>
        <li ><a target="_blank" href="/sqzl.html&ycpc">免费材料</a></li>-->
        <li class="oli" style="margin-top: 13px;">
            <a href="<?php echo $spath;?>/zhongguoxianggang/index.html##">關註微信</a>
            
        </li>
        <!-- <li ><a target="_blank" href="/contentus.html?ycpc">联系我们</a></li> -->
        <li id="toTop" class="J_backTop" style="display: none;">
            <span class="top"></span>
            <a href="javascript:;">返回頂部</a>
        </li>
    </ul>
</div>
<!--项目合作弹窗-->
<!--广告图显示开始-->
  <?php  echo $eyou['slideads']; ?>  
<!--广告图显示结束-->

<div class="container">
  <div class="row"> <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = "26"; endif; if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 10; endif; $tagChannelartlist = new \think\template\taglib\eyou\TagChannelartlist; $_result = $tagChannelartlist->getChannelartlist($typeid, "self",""); if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $e = 1;$__LIST__ = is_array($_result) ? array_slice($_result,0, $row, true) : $_result->slice(0, $row, true); if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$channelartlist): $channelartlist["typename"] = text_msubstr($channelartlist["typename"], 0, 100, false); $__LIST__[$key] = $_result[$key] = $channelartlist;$i= intval($key) + 1;$mod = ($i % 2 ); ?>
    <div class="col-md-4">
      <h2 class="index_tit"><b>视频</b>中心<small>最新的活动 </small><a href="javascript:;" onclick="bweline();"> 在线咨询</a></h2>
      <div style="background: white;">
        <div class="video"> <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 1; endif; $modelid = ""; $param = array(      "typeid"=> $typeid,      "notypeid"=> "",      "flag"=> "",      "noflag"=> "",      "channel"=> $modelid,      "joinaid"=> "",      "keyword"=> "",      "release"=> "off",      "idlist"=> "",      "idrange"=> "",      "aid"=> "", ); $tag = array (
  'loop' => '1',
  'titlelen' => '20',
  'r' => 'eyou:artlist',
  'row' => '1',
); $tagArclist = new \think\template\taglib\eyou\TagArclist; $_result = $tagArclist->getArclist($param, $row, "", "","desc","",$tag,"0","on","off","","");if(!empty($_result["list"]) && (is_array($_result["list"]) || $_result["list"] instanceof \think\Collection || $_result["list"] instanceof \think\Paginator)): $i = 0; $e = 1; $__LIST__ = is_array($_result["list"]) ? array_slice($_result["list"],0, $row, true) : $_result["list"]->slice(0, $row, true);  $__TAG__ = $_result["tag"];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $aid = $field["aid"];$users_id = $field["users_id"];$field["title"] = text_msubstr($field["title"], 0, 20, false);if($field["is_b"] == 1) : $field["title"] = "<strong>".$field["title"]."</strong>";endif;$field["seo_description"] = text_msubstr($field["seo_description"], 0, 160, true);$i= intval($key) + 1;$mod = ($i % 2 ); ?>
          <video style="margin: 0 5%" width="90%" height="360" controls="controls" loop="loop">
            <source src="<?php  $aid = $field['aid']; $tagField = new \think\template\taglib\eyou\TagField; $__VALUE__ = $tagField->getField("shipin", $aid); echo $__VALUE__; unset($aid); ?>" type="video/mp4">
            Your browser does not support the video tag. </video>
          <?php ++$e; $aid = 0; $users_id = 0; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?> </div>
        <a class="btn btn-default" href="<?php  $__VALUE__ = isset($channelartlist["typeurl"]) ? $channelartlist["typeurl"] : "变量名不存在"; echo $__VALUE__; ?>" style="margin: 18px 20px;">查看更多</a> </div>
    </div>
    <?php ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $typeid = $row = ""; unset($channelartlist);  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = "2"; endif; if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 10; endif; $tagChannelartlist = new \think\template\taglib\eyou\TagChannelartlist; $_result = $tagChannelartlist->getChannelartlist($typeid, "self",""); if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $e = 1;$__LIST__ = is_array($_result) ? array_slice($_result,0, $row, true) : $_result->slice(0, $row, true); if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$channelartlist): $channelartlist["typename"] = text_msubstr($channelartlist["typename"], 0, 100, false); $__LIST__[$key] = $_result[$key] = $channelartlist;$i= intval($key) + 1;$mod = ($i % 2 ); ?>
    <div class="col-md-4">
      <h2 class="index_tit"><b>香港移民</b>动态<small>信息 </small></h2>
      <div class="index02 white_bg"> <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 1; endif; $modelid = ""; $param = array(      "typeid"=> $typeid,      "notypeid"=> "",      "flag"=> "p",      "noflag"=> "",      "channel"=> $modelid,      "joinaid"=> "",      "keyword"=> "",      "release"=> "off",      "idlist"=> "",      "idrange"=> "",      "aid"=> "", ); $tag = array (
  'limit' => '0,1',
  'titlelen' => '15',
  'flag' => 'p',
  'r' => 'eyou:artlist',
); $tagArclist = new \think\template\taglib\eyou\TagArclist; $_result = $tagArclist->getArclist($param, $row, "", "","desc","",$tag,"0","on","off","","");if(!empty($_result["list"]) && (is_array($_result["list"]) || $_result["list"] instanceof \think\Collection || $_result["list"] instanceof \think\Paginator)): $i = 0; $e = 1; $__LIST__ = is_array($_result["list"]) ? array_slice($_result["list"],0, $row, true) : $_result["list"]->slice(0, $row, true);  $__TAG__ = $_result["tag"];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $aid = $field["aid"];$users_id = $field["users_id"];$field["title"] = text_msubstr($field["title"], 0, 15, false);if($field["is_b"] == 1) : $field["title"] = "<strong>".$field["title"]."</strong>";endif;$field["seo_description"] = text_msubstr($field["seo_description"], 0, 160, true);$i= intval($key) + 1;$mod = ($i % 2 ); ?> <a hre5f="<?php echo $field['arcurl']; ?>"><img src="<?php echo $field['litpic']; ?>" border="0" alt="<?php echo $field['title']; ?>" style="width:336px; height:150px;"></a> 
      <?php ++$e; $aid = 0; $users_id = 0; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?>
        <ul>
          <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 7; endif; $modelid = ""; $param = array(      "typeid"=> $typeid,      "notypeid"=> "",      "flag"=> "",      "noflag"=> "",      "channel"=> $modelid,      "joinaid"=> "",      "keyword"=> "",      "release"=> "off",      "idlist"=> "",      "idrange"=> "",      "aid"=> "", ); $tag = array (
  'limit' => '1,7',
  'titlelen' => '20',
  'r' => 'eyou:artlist',
); $tagArclist = new \think\template\taglib\eyou\TagArclist; $_result = $tagArclist->getArclist($param, $row, "", "","desc","",$tag,"0","on","off","","");if(!empty($_result["list"]) && (is_array($_result["list"]) || $_result["list"] instanceof \think\Collection || $_result["list"] instanceof \think\Paginator)): $i = 0; $e = 1; $__LIST__ = is_array($_result["list"]) ? array_slice($_result["list"],1, $row, true) : $_result["list"]->slice(1, $row, true);  $__TAG__ = $_result["tag"];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $aid = $field["aid"];$users_id = $field["users_id"];$field["title"] = text_msubstr($field["title"], 0, 20, false);if($field["is_b"] == 1) : $field["title"] = "<strong>".$field["title"]."</strong>";endif;$field["seo_description"] = text_msubstr($field["seo_description"], 0, 160, true);$i= intval($key) + 1;$mod = ($i % 2 ); ?>
          <li><a href="<?php echo $field['arcurl']; ?>"><?php echo $field['title']; ?></a></li>
          <?php ++$e; $aid = 0; $users_id = 0; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?>
        </ul>
        <a class="btn btn-default" href="<?php  $__VALUE__ = isset($channelartlist["typeurl"]) ? $channelartlist["typeurl"] : "变量名不存在"; echo $__VALUE__; ?>">查看更多</a> </div>
    </div>
    <?php ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $typeid = $row = ""; unset($channelartlist);  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = "5"; endif; if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 10; endif; $tagChannelartlist = new \think\template\taglib\eyou\TagChannelartlist; $_result = $tagChannelartlist->getChannelartlist($typeid, "self",""); if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $e = 1;$__LIST__ = is_array($_result) ? array_slice($_result,0, $row, true) : $_result->slice(0, $row, true); if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$channelartlist): $channelartlist["typename"] = text_msubstr($channelartlist["typename"], 0, 100, false); $__LIST__[$key] = $_result[$key] = $channelartlist;$i= intval($key) + 1;$mod = ($i % 2 ); ?>
    <div class="col-md-4">
      <h2 class="index_tit"><b>热门地区</b>公告<small>信息 </small></h2>
      <div class="index02 white_bg">
        <ul>
          <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 10; endif; $modelid = ""; $param = array(      "typeid"=> $typeid,      "notypeid"=> "",      "flag"=> "",      "noflag"=> "",      "channel"=> $modelid,      "joinaid"=> "",      "keyword"=> "",      "release"=> "off",      "idlist"=> "",      "idrange"=> "",      "aid"=> "", ); $tag = array (
  'loop' => '10',
  'titlelen' => '20',
  'r' => 'eyou:artlist',
  'row' => '10',
); $tagArclist = new \think\template\taglib\eyou\TagArclist; $_result = $tagArclist->getArclist($param, $row, "", "","desc","",$tag,"0","on","off","","");if(!empty($_result["list"]) && (is_array($_result["list"]) || $_result["list"] instanceof \think\Collection || $_result["list"] instanceof \think\Paginator)): $i = 0; $e = 1; $__LIST__ = is_array($_result["list"]) ? array_slice($_result["list"],0, $row, true) : $_result["list"]->slice(0, $row, true);  $__TAG__ = $_result["tag"];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $aid = $field["aid"];$users_id = $field["users_id"];$field["title"] = text_msubstr($field["title"], 0, 20, false);if($field["is_b"] == 1) : $field["title"] = "<strong>".$field["title"]."</strong>";endif;$field["seo_description"] = text_msubstr($field["seo_description"], 0, 160, true);$i= intval($key) + 1;$mod = ($i % 2 ); ?>
          <li><a href="<?php echo $field['arcurl']; ?>"><?php echo $field['title']; ?></a></li>
          <?php ++$e; $aid = 0; $users_id = 0; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?>
        </ul>
        <a class="btn btn-default" href="<?php  $__VALUE__ = isset($channelartlist["typeurl"]) ? $channelartlist["typeurl"] : "变量名不存在"; echo $__VALUE__; ?>">查看更多</a> </div>
    </div>
    <?php ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $typeid = $row = ""; unset($channelartlist); ?> </div>
</div>
<div class="main">
  <?php  echo $eyou['hkproject']; ?>  
</div>
 <div class="c_scase">
	<div class="main">

		<div class="pub_title"><h1 class="index_tit"><b>成功案例</b></h1>
		<a target="_blank" href="https://www.globevisa.com.cn/success.html"><s></s></a></div>
		<div class="cs_box clearfix">
			<ul class="cs_list">
			<?php  echo $eyou['hkase']; ?>
								<li>
					<a href="https://www.globevisa.com.cn/zhongguoxianggang/news/64338.html" target="_blank">
					<h1><img data-original="/uploadfile/2024/0822/20240822094459_4387.jpg" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"></h1>
					<h3><em>「案例分享」</em><span>客戶說｜爲兩個兒子未來發展鋪路，我還是選擇了香港...</span></h3>
					<p>環球出國邀請香港高才通客戶趙女士講述自己爲兩個兒子未來教育、職業規劃從而成功獲得香港身份的故事，趙女士講述了自己在辦理香..</p>
					</a>
					<dl>
						<dt style="background-image: url(&quot;https://img.globevisa.com.cn/images/customers/000f2f63-0000-0000-0000-00004161ed8d/2024013100000001295203/2024-01-31Alice曹婷[caoting]137X132中文官网头像.jpg&quot;); background-size: 100%;"></dt>
						<dd><span><em>广州-Alice曹</em><i>16676779478</i></span></dd>
						<a href="javascript:;" onclick="Meiqia(&#39;ab0110d08573262ff1bd0c63f18b5103&#39;)">專家連線</a>
					</dl>
				</li>
								<li>
					<a href="https://www.globevisa.com.cn/zhongguoxianggang/news/64322.html" target="_blank">
					<h1><img data-original="/uploadfile/2024/0811/20240811180214_5716.jpg" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"></h1>
					<h3><em>「案例分享」</em><span>這個香港身份獲批率高達96%？！...</span></h3>
					<p>根據香港立法會7月16日公布的文件顯示，截至2024年6月底，共收到了超過32萬份申請，已獲批了近20萬份申請。從5月至..</p>
					</a>
					<dl>
						<dt style="background-image: url(&quot;https://img.globevisa.com.cn/images/customers/000bf4c6-0000-0000-0000-0000e9f2d867/2024030400000001298936/2024-03-04Cindy陈小英[chenxiaoying]137X132中文官网头像.jpg&quot;); background-size: 100%;"></dt>
						<dd><span><em>广州-Cindy陈</em><i>18589266859</i></span></dd>
						<a href="javascript:;" onclick="Meiqia(&#39;18cfddc4824aec56573704c589eb08b9&#39;)">專家連線</a>
					</dl>
				</li>
								<li>
					<a href="https://www.globevisa.com.cn/zhongguoxianggang/news/64261.html" target="_blank">
					<h1><img data-original="/uploadfile/2024/0715/20240715181822_3651.jpg" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"></h1>
					<h3><em>「案例分享」</em><span>客戶說丨4個月收到港大Offer是什麽樣的體驗...</span></h3>
					<p>香港研究生不需要雅思就能申請，只需要一年時間就能完成學歷升級，同時收獲一個香港身份。今天我們請到一位香港研究生在讀的老客..</p>
					</a>
					<dl>
						<dt style="background-image: url(&quot;https://img.globevisa.com.cn/images/customers/000834d5-0000-0000-0000-0000221c1015/2022061500000001191948/2022-06-15Sherry黄珊珊[huangshanshanym]137X132中文官网头像.jpg&quot;); background-size: 100%;"></dt>
						<dd><span><em>广州-Sherry黄</em><i>18588768729</i></span></dd>
						<a href="javascript:;" onclick="Meiqia(&#39;bc48520786bb1c1f65609ee34ad0462f&#39;)">專家連線</a>
					</dl>
				</li>
							</ul>
			<div class="cs_panel">
				<form action="https://www.globevisa.com.cn/zhongguoxianggang/index.html">
					<span>GLOBEVISA</span>
					<h3>馬上預約</h3>
					<h2>免費訂制方案吧</h2>
					<h4>貼心服務減少後顧之憂</h4>
					<div class="csp_form">
						<dl class="clearfix PopupHidUserName"><label for="">姓名：</label><input type="text" name="userName" placeholder="请输入姓名"></dl>
						<dl>
							<label for="">國編：</label>
							<!-- <select name="countrycode"></select> -->
							<div class="flex">
								<div class="select-i" style="width: 142px;">
									<p class="input-txt" id="" style="height: 32px; background-color: #f2f2f2; line-height: 32px;border: 0; font-size: 12px;">國編</p>
									<i class="jt" style="top: 2px;"><img src="./ymcg/form_flag_select_pull.png" alt=""></i>
									<ul class="ul-select un-fold countryCode2" id="countryCode" style="width: 142px; 
top: 37px;
border: 1px solid #fbf5ea;
background-color: #fff;
max-height:231px;

									">
									</ul>
								</div>
							</div>
						</dl>
						<dl><label for="">手機号：</label><input type="text" name="tel" placeholder="请输入您的手机号"></dl>
						<dl>
							<label for="">選擇公司：</label>
							<div class="sel_company">選擇公司</div>
                            <div class="company_info">
                               	<div class="info_top">
                                    <i class="info_close"></i>
                                    <img src="./ymcg/info2_top_icon.png">
                                </div>
                                <div class="info_middle clearfix" id="SSGS">
	                                <p>國内公司</p>
	                                <p>國際公司</p>
                                    <input type="hidden" name="SSGS">
									<input type="hidden" name="SSGSSS" value="">
                                    <ul class="clearfix ssgs_gn" style="margin-left: 19px;"><li value="0004EE0D-0000-0002-0000-00001C265F0C">深圳</li><li value="000E9A95-0000-0000-0000-000065D64048">北京</li><li value="0004EE0D-0000-0001-0000-00001C265D4D">上海</li><li value="000E6081-0000-002B-0000-00002B587B39">苏州</li><li value="000655C4-0000-0000-0000-0000130F3AD3">南京</li><li value="0004EE0D-0000-0006-0000-00001C266612">青岛</li><li value="0004EE0D-0000-000A-0000-00001C267789">沈阳</li><li value="0004EE0D-0000-0003-0000-00001C2660C8">广州</li><li value="0004EE0D-0000-0004-0000-00001C266296">杭州</li><li value="000F42A6-0000-0002-0000-0000887036A5">重庆</li><li value="0010838C-0000-0000-0000-0000E5D19EA0">成都</li><li value="0004EE0D-0000-0009-0000-00001C266E37">大连</li><li value="0004EE0D-0000-000B-0000-00001C267928">武汉</li><li value="000C6559-0000-0001-0000-00002B7B1E75">中国香港</li><li value="001029E7-0000-0000-0000-00000AF06C1A">无锡</li><li value="0004EE0D-0000-0007-0000-00001C2667C4">济南</li><li value="00038810-0000-0000-0000-00003EBFA71E">郑州</li><li value="00070633-0000-0000-0000-000028E5435E">长沙</li><li value="000A05EF-0000-0001-0000-0000DBE24EA4">天津</li></ul>
                                    <div class="line"></div>
                                    <ul class="clearfix ssgs_hw"><li value="000E8E14-0000-0000-0000-0000F58D2859">阿联酋迪拜</li><li value="0006BA1D-0000-0000-0000-0000545F4233">澳大利亚悉尼</li><li value="000DA67A-0000-0001-0000-0000F3B71CA5">英国伦敦</li><li value="0007D04E-0000-0000-0000-0000945BBC46">加拿大温哥华</li><li value="0007F564-0000-0000-0000-0000C88F3C3D">新加坡</li><li value="00106E8A-0000-0000-0000-000070188A57">马来西亚吉隆坡</li><li value="000A39EA-0000-0000-0000-0000EBAE4D26">美国洛杉矶</li></ul>
                                </div> 
                            </div>

						</dl>
					</div>
					<input type="hidden" name="countrycode" value="0086">
					<input type="hidden" name="action" value="srdz">
					<input type="hidden" name="Differ" value="1">
					<div class="csp_btn"><a href="javascript:;" class="ajaxBtn">立即預約獲取方案</a></div>

				</form>
			</div>
		</div>
	</div>
</div>
  

<!DOCTYPE html>
<head>
	<meta name="baidu-site-verification" content="SoQ0DR1Aps" /><!-- 百度资源搜索平台，C老师让加的，20.10.28 -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="shortcut icon" target="_blank" href="https://www.globevisa.com.cn/favicon.ico">
	<link rel="stylesheet" type="text/css" href="https://www.globevisa.com.cn/static/index/css/fix_flex.css?82897">
	<link rel="stylesheet" href="https://www.globevisa.com.cn/static/index/css/company/index2.css?10463">
    <link rel="stylesheet" href="https://www.globevisa.com.cn/static/index/css/swiper/swiper.css">
    <link rel="stylesheet" href="https://www.globevisa.com.cn/static/index/css/company/jinrErweima.css">


</head>
<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T3TLZVV3" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<script>
		!(function(c,b,d,a){c[a]||(c[a]={});c[a].config=
				{
					pid:"cg1fd@263414299dee23c",
					urlHelper:[/\/$/],	appType:"web",
					imgUrl:"https://arms-retcode.aliyuncs.com/r.png?",
					sendResource:true,	enableLinkTrace:true,behavior:true
				};
			with(b)with(body)with(insertBefore(createElement("script"),firstChild))setAttribute("crossorigin","",src=d)
		})(window,document,"https://retcode.alicdn.com/retcode/bl.js","__bl");
	</script>

<input type="hidden" value="" id="iotest">
<input type="hidden" value="" id="yxgj_">
<input type="hidden" value="" id="ymmd_">
<span class="mqCookie" style="display:none"></span>
<!-- 头部 -->
<style>
	.gskh{	position: absolute;	left: 0px;	}
	.gskhs{		position: absolute;		margin-left: 600px;		margin-top: 0px;	}
	.zzfu{	margin-top: 153px;	margin-left: -200px;}
	.nav_addS_imgs {margin-top: 10px;width: 270px;background: #F6EEE1;box-sizing: border-box;
		padding: 10px;}
	.sel_country{display:none;margin-left: 15px;	/* width: 210px; */		}
	.sel_country div{
		/* display:inline-block; */
		border:1px solid #EDE1C9;height:36px;line-height:36px;border-radius:25px;}
	.sel_country ul{position: absolute;	top: 37px;left: 14px;
		border: 1px solid #EDE1C9;background: #f1efeb;width: 88px;padding: 4px 0px;	}
	.sel_country ul li{	font-size: 14px;height:26px;line-height:26px;text-align:center;}
	.sel_country ul li a:hover{	color:#990000;	}
	.sel_country ul li:hover{	/* background:#a67f3e; */	color:#990000;}
	.search_type{width: 49px;text-align: right;	padding-right: 13px;
		font-size: 12px;float: left;height: 100%;border-right: #EDE1C9 1px solid;
		background:url("https://www.globevisa.com.cn/static/index/images/header_xl.png") no-repeat right;
	}
	#ac:hover .sel_country {display: block;	text-decoration:none;}
	.ureg.zt {display: none !important;	}
</style>
<link rel="stylesheet" href="https://www.globevisa.com.cn/static/index/css/fifth_module.css?24421449">
<link rel="stylesheet" href="https://www.globevisa.com.cn/static/index/css/mqgwReset.css">
<style type="text/css">
.fhm-cl-p{height:220px;}
.fhm-cl-p .info{ width: 236px;  height: 124px;  color: rgba(255,255,255,1);
    overflow: hidden;   margin-top: -3px;   line-height: 25px;}
.fhm-cl-p p{    width: 355px;height:85px;margin:0;overflow:hidden}
.videomq{display:none;width:125px;height:36px;top:90px;left:5px;background:rgba(0,0,0,0.5) url('/static/index/images/customer/video1.png') no-repeat 14px center;border-radius:20px 5px 5px 20px;color:#f00;line-height:36px;text-indent:36px;font-size:14px;text-decoration:underline;color:#BA1F1B}
.videomq:hover{color:#f00}
.videoImg{display:none;width:32px;height:32px;top:92px;left:7px;transition:ease-in 0.4s;transform:rotate(0deg);-webkit-transform:rotate(0deg);z-index:4;}

.fhm-cl-b li {	width:115px;height:28px;line-height:30px;border-radius:5px;	background-color:#a67e3d;}
.fhm-cl-b li:last-child a {
	text-align: center;	text-indent:20px;
	/*background:url(/static/index/images/customer/areaCode.png) no-repeat;*/
	background:url(/static/index/images/customer/tel.png) no-repeat;
	background-position: 7px 10px;letter-spacing:6px;	font-size:14px;
}

.fhm-cl-b li:first-child a {
	text-indent:30px;
	background:url(/static/index/images/customer/weixin.png) no-repeat;
	background-position: 8px 8px;	letter-spacing:6px;	font-size:14px;
}
.c_keys{padding: 60px 0;background: #fff;}
</style>
<div class="c_keys">
	<div class="main">
	<div class="pub_title"><h1 class="index_tit"><b>專業團隊是申請成功的關鍵</b><span><font size='4'>—24小時爲您提供諮詢服務，根據您的實際需求制定專屬方案</font></span></h1>

		<section class="fifth-module" id="changeAdvisor" style="margin-top:20px;"></section>
		<section class="fhm-corresponding" style="font-size: 14px">

	
<section class="fhm-c-list pr dbk showGW" name="13" >
		<ul class="pa fhm-cl-ul"> <?php  echo $eyou['showman']; ?>  </ul>
	</section>
		</section>
	</div>
</div>

<!--表单-->

<section class="g-center-block ke_xs_z clearfix">
	<div class="ke_xs_w">
		<div class="ke_xs">
			<div class="swiper-wrapper" >
			<?php  echo $eyou['succcase']; ?>
			</div>
			<div class="swiper-button-next"></div><div class="swiper-button-prev"></div>
		</div>
	</div>
</section>
<!--成功案例-->
<!-- 弹窗 -->
<!-- 选择公司弹窗 -->
<style>
  .right-div {  float: right;}
	.xq_phone{
		width: 410px;height: 40px;box-sizing: border-box;line-height: 38px;
		border: 1px solid #D2D2D2;background:#FFFFFF;color: #D2D2D2;font-size: 16px;
	}
	.xq_phone select{
		height: 38px;width: 204px;box-sizing: border-box;padding-left: 20px;
		float: left;line-height: 38px;border-right: 1px solid #D2D2D2;font-size: 16px;
	}
	.xq_phone input{width: 204px;height: 38px;font-size: 16px;float: left;padding-left: 19px;}

/* 国编样式 */
.ul-select-window::-webkit-scrollbar-track {    border-radius:0;}
.ul-select-window::-webkit-scrollbar-thumb {    border-radius:0; }
	.flex_window{		float: left;	}
	.ul-select-window li{		margin-top: -5px;	}
	.jt_window{        top: 18px;		right: 2px;    }
    .flex_father{        border: 0 !important;    }
    .flex_window dt {
        /* flex-shrink: 0; */
        margin-right: 10px;
        /* text-align: right; */
        font-size: 16px;
        color: #fff;
        display: inline-block;
        /* vertical-align: middle; */
    }

    .flex_window dd .select-i-window:not(:last-of-type) {        margin-right: 30px;    }

    .ul-select-window {
		padding-top:10px;
        width: 205px;
        top: 41px;
		left: -1px;
		padding-left: 22px;
		background-color: rgba(254,253,253,.9);
		border: 1px solid #D2D2D2;
		border-radius: 0;
    }
    .select-i-window {        position: relative;        width: 194px;    }
    .select-i-window .input-txt-window {
		margin-top:-2px;
        height: 38px;
        line-height: 38px;
        /* background-color: rgba(254,253,253,.9); */
        color: #626262;
        vertical-align: middle;
        box-sizing: border-box;
        display: inline-block;
        margin-left: 10px;
        text-indent: 10px;
        width: 100%;
		border: 0;
		border-radius: 0;
        /* border-radius: 4px; */
        font-size: 14px;
        border-right: 1px solid #BFBFBF;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        cursor: pointer;
    }
	.gfc_left_gg>ul li input{	height: 38px; 	line-height: 39px;}

</style>
<div id="windows_comanySelect">
	<i class="company_close"></i>
	<img class="company_top_img" src="https://www.globevisa.com.cn/static/index/images/country/info_top_iconnew2.png">
	<p class="company_desc">请选择为您致电的公司</p>
	<div class="company_middle">
		<input type="hidden" name="SSGS">
		<input type="hidden" name="SSGSSS" value="">
		<p>国内公司</p><ul class="clearfix ssgs_gn"></ul>
		<p>国际公司</p><ul class="clearfix ssgs_hw"></ul>
	</div>
	<a class="company_btn" href="javascript:;">确认</a>
</div>
<!-- 右侧弹窗 http://127.0.0.1/welive/welive.php?a=6168&group=2-->
<div class = "wrap">
    <ul>
        <li><a href="javascript:;" onclick="bweline();"> 在线咨询</a> </li>
     	<li ><a href="javascript:;" onclick="xxhz()">项目合作</a></li>
        <li ><a target="_blank" href="/contrast.html&ycpc">国家对比</a></li>
        <li class="oli" style="margin-top: 13px;"> <a href="##" id="btn" class="btn">关注微信</a>
            <img src="https://www.globevisa.com.cn/static/index/images/wx1new2.jpg" alt="" class="pic2" style="width:78px;">
        </li>
        <li id="toTop" class="J_backTop"><span class="top"></span><a href="javascript:;">返回顶部</a></li>
    </ul>
</div>

<!--项目合作弹窗-->
<section class="xxhz">
	<em></em>
	<img  src="https://www.globevisa.com.cn/static/index/images/index/xx_03new2.png" class="xx_img2">
	<span>项目合作, 请您联系:</span>
	<img  src="https://www.globevisa.com.cn/static/index/images/zhaopin/8new2_1.png" class="qrcode">
	<ul>
		<li>邮箱: bellaluo@globevisa.com</li>
		<!-- <li>微信号: Hq_13051479093</li>
		<li>联系电话: 400-630-8353转1883</li> -->
	</ul>
</section>
<!-- 给您回电弹窗  -->
<!-- 表单弹窗 -->
<!-- 短信弹窗 -->
<div class="wind"></div>
<div class="windowsimgall">
	<a target="_blank" href="https://www.globevisa.com.cn/"><img class="windowsimg" src="" onclick="onurl('','')"/></a>
	<div class="closewind"></div>
</div>
<div class="post" style="display: none"><input type="text" value="1"></div>
<!-- 左侧飘窗-->
<!-- 底部弹窗 -->
<!-- 底部弹窗 -->

<div class="feiyong_zong dibulunbo augus--">
	<div class="feiyong_zhong">
		<div class="feiyong_zhong_1">
			<img src="https://www.globevisa.com.cn/static/index/images/feiyong_titlenew2.png" class="feiyong_tanchu">
			<img src="https://www.globevisa.com.cn/static/index/images/feiyong_closenew2.png" class="feiyong_close first_close" title="关闭">
		</div>
		 <section class="g_footer_calculation">
			<span>我们不止为您规划方向，而且为您分析每一笔花费</span>
			<a href = "javascript:;"><img src="https://www.globevisa.com.cn/static/index/images/tc_04new2.png" class="feiyong_close" style="position: absolute;right: 76px;top: 30px;"></a>
			<div class="g_footer_c_main clearfix">
				<div class="gfc_left">
					<div class="gfc_left_gg gfc_city_project">
						<ul class="clearfix">
							<li><span>选择项目</span></li><li><a href="javascript:;">请选择意向项目</a>	</li>
						</ul>

						<div class="gfc_cp_main_yc">
							<div class="gfc_cp_main">
<div class="gfc_cp_main_nav clearfix">
	<a class="btn_country countryAndProjectChoose" href="javascript:;">国家和地区</a>
	<span class="btn_before">></span>
	<a style="display: none" class="btn_project" href="javascript:;">项目</a>
</div>

<div class="gfc_cp_main_country clearfix">
	<div class="gfc_cp_main_country_zm">
		<a class="btn_zm_up" href="javascript:;"></a><ul></ul>
		<a class="btn_zm_down" href="javascript:;"></a>
	</div>
	<dl>
		<dd name="c_1" class="clearfix"><em></em><span>澳大利亚</span></dd>
		<dd name="c_27" class="clearfix"><em></em><span>美国</span></dd>
		<dd name="c_224" class="clearfix"><em></em>	<span>帕劳</span></dd>
			</dl>
</div>

<div style="display: none" class="gfc_cp_main_project">
			<dl name="c_1">
						<dd id="erp_2711">澳洲杰出人才GTI</dd>
						<dd id="erp_3177">澳洲本地服务项目</dd>
					</dl>
			<dl name="c_27">
						<dd id="erp_118">美国L1A创业工签</dd>
						<dd id="erp_1091">美国银行开户公司账户</dd>
						<dd id="erp_997">美国银行开户个人账户</dd>
						<dd id="erp_2361">美国EB3职业移民</dd>
						<dd id="erp_2938">美国远程结婚</dd>
					</dl>
				
			<dl name="c_224"><dd id="erp_3345">帕劳数字居民身份证</dd></dl>
	</div>
							</div>
						</div>
					</div>
<!--					<span class="gfc_text_tx" hidden="hidden">请添加您希望一起申请移民的家庭成员个数，添加人数不同导致费用产生差异</span>-->
					<span class="gfc_text_tx" hidden="hidden"></span>
					<div class="gfc_left_gg gfc_people_xq" hidden="hidden">
						<ul class="clearfix">
							<li>
<span>申请人数</span>
							</li>

							<li>
<a href="javascript:;" class="tjrs">希望添加人数</a>
							</li>
						</ul>

						<div style="display: none" class="gfc_people_main_yc">
							<div class="gfc_people_main">
<dl>

</dl>
							</div>
						</div>
					</div>
					<div class="gfc_left_gg gfc_left_fjx">
						<ul class="clearfix">
							<li>
<span class="moneyName">投资金额</span>
							</li>

							<li class="fjx_tzje clearfix">
<input type="text" value="0" class="minMoney" id ="">
<em>币种</em>
							</li>

							<li style="display: none">
<input type="text" value="3">
							</li>
						</ul>
					</div>
					<div class="gfc_left_gg gfc_left_sqfs">
						<ul class="clearfix">
							<li>
<span>申请方式</span>
							</li>

							<li>
<a href="javascript:;">请选择申请方式，不同方式会导致收费产生差异</a>
							</li>
						</ul>

						<div style="display: none" class="gfc_sqfs_main_yc">
							<div style="border: 1px solid #D2D2D2;box-sizing: border-box;height: 100%;">
<div class="gfc_sqfs_main">	<ul></ul></div>
<img src="https://www.globevisa.com.cn/static/index/images/fy_033new2.png" style="margin: 0 auto;cursor:pointer;"  class="ok_btn">
							</div>
						</div>
					</div>
<form >
	<div class="gfc_left_phone">
		<ul class="clearfix">
<li class="PopupHidUserName">	<span>姓名</span></li>
<li class="xq_phone PopupHidUserName" style="width: 410px;margin-bottom: 20px;">
	<input type="text" placeholder="怎么称呼您？" name="userName"  value=""></li>
<li class="PopupHidTel2">	<span>手机号</span></li>
<li class="xq_phone PopupHidTel2" style="margin-bottom: 20px">
	<!-- <select  class="porject " name="countrycode"  id="countrycode" >
		<option value="0086">中国 +86</option>
	</select> -->

	<dl class="flex_window">
		<dd class="flex_window">
			<div class="select-i-window">
				<p class="input-txt-window" id="">国编</p>
				<i class="jt_window"><img
						src="https://www.globevisa.com.cn/static/index/images/form_flag_select_pull.png"
						alt=""></i>
				<ul class="ul-select-window un-fold-window" id="countryCodeWindow"></ul>
			</div>
		</dd>
	</dl>
	<input type="text" placeholder="请输入您的手机号" name="tel"  value="">

</li>
<li class="PopupHidTel2">
	<span>验证码</span>
</li>
<li class="xq_phone PopupHidTel2" style="margin-bottom: 20px">
	<div class="form_group clearfix">
		<input type="text" name="pwd" class="pwd" placeholder="输入验证码">
		<input type="button" style="background-color: #dab371;color: #ffffff;padding-left:0px" class="submit get_sms" window_action="video_list_sms" value="获取验证码">
	</div>
</li>
<li class="tjBtn" style="width: 410px">
	<input type="hidden" name="countrycode" value="">
	<input type="hidden" name="action" value="fytc" />
	<input type="hidden" name="p_num" value="1" class="p_num"/>
	<input type="hidden" name="fee" value="" class="fee" />
	<input type="hidden" name="check_a" value="" class="check_a"/>
	<input type="hidden" name="check_h" value="" class="check_h"/>
	<input type="hidden" name="include" value="" class="include"/>
	<input type="hidden" name="p_total" value="" class="p_total"/>
	<input type="hidden" name="ymProject" value="" class="ymProject"/>
	<input type="hidden" name="erpid" value="" class="erpid"/>
	<a href="javascript:;" class="ajaxBtn fytc2">开始计算</a>
</li>
							</ul>
						</div>
					</form>
				</div>

				<div class="gfc_right">
					<ul>
						<li>
							<span class="zhf">预计投资额：<a class="tz_money">?</a>元</span>
							<a href="javascript:;">
<span>什么是投资额？</span>
<p><em>投资额是指办理该项目初始需投入的资金，并非实际花费，因为部分项目的投资款项到期可返还。最终计算结果仅供参考。</em></p>
							</a>
						</li>

						<li>
							<span class="jtr">预计净花费：<a class="tz_money">?</a>元</span>
							<a href="javascript:;">
<span>什么是净花费？</span>
<p><em>净花费是指办理该项目预计实际花费的金额，因为部分项目的投资款可收回，如购房移民项目中，购买的房产为个人财产等则未计入净花费中，此金额供参考。</em></p>
							</a>
						</li>
					</ul>

					<div class="gfc_right_tips">
						<div class="gfc_right_tips_w" style="display: none">
							<span>我们将根据您选择的项目计算费用明细</span>
							<span>让您算清每一笔账，心里更有谱</span>
						</div>

						<div class="gfc_right_tips_y">
							<span>根据您的选择为您计算出每项具体花费，计算结果仅供参考</span>
							<span>您可随时联系专家解析每一笔花费，不花冤枉钱</span>
						</div>
					</div>

					<div class='dlTitle'><span>费用名称</span><span>金额</span><span>收费时间</span></div>
					<dl class="allDetail">
						<dd class="clearfix"><span>服务费</span>	<span>？</span>	<span>？</span>	</dd>
						<dd class="clearfix"><span>律师费</span>	<span>？</span>	<span>？</span>	</dd>
						<dd class="clearfix"><span>翻译费</span>	<span>？</span><span>？</span></dd>
						<dd class="clearfix"><span>公证费</span>	<span>？</span><span>？</span></dd>
						<dd class="clearfix"><span>体检费</span>	<span>？</span><span>？</span></dd>
					</dl>
				</div>
			</div>
		</section>
	</div>
</div>

<!-- 公共隐藏域 -->
<input type="hidden" id="G_IP" value="">
<input type="hidden" id="G_LOGIN_STATUS" value="">
<input type="hidden" id="G_LOGIN_PERSON" value="">
<input type="hidden" id="G_LOGIN_USERNAME" value="">
<input type="hidden" id="G_LOGIN_COUNTRY_CODE" value="">
<input type="hidden" id="G_YMGJ" value="">
<input type="hidden" id="G_YMMD" value="">
<!-- 公共隐藏域 -->
<!-- 尾部 -->

<script>
	var signature = "1726455250,kHp7PiOha,6da312684f60010ec459048cfebd582e";
</script>
<input type="hidden" id="F_M" value="">
<input type="hidden" id="F_C" value="">
<input type="hidden" id="F_A" value="">
<input type="hidden" id="F_PARAM" value='a:0:{}'>
<input type="hidden" id="F_CLIENT_ID" value=''>
<input type="hidden" id="F_CLIENT_IP" value=''>
<input type="hidden" id="DEPTH_Y" value='0'>
<input type="hidden" id="DEPTH_T" value='0'>
<input type="hidden" id="RETRY_T" value='0'>
<!--_footer 作为公共模版分离出去-->

<script>
	(function (w, d, s, i, v, j, b) {
		w[i] = w[i] || function () {
			(w[i].v = w[i].v || []).push(arguments)
		};
		j = d.createElement(s),	b = d.getElementsByTagName(s)[0];
		j.async = true;
		j.charset = "UTF-8";
		j.src = "//main.globevisa.com.cn/main/bigdata.js?1683710040225";
		b.parentNode.insertBefore(j, b);
	})(window, document, "script", "_VISIT");
	_VISIT();
</script>



<!-- 国编数据 -->
<script>
$(function(){

		//TODO:接口站异常临时处理
	var _url = ApiUrl + "/Web/GetSheets";
	var gwurl = BaseUrl+"/api/api/GetSheets";
	$.ajax({
		type: "GET",
		url:_url,
		dataType:'json',
		success: function(msg) {
			if (msg.ret == 200) { loadCountryWindow(msg.data)	}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			$.getJSON(gwurl,function(msg) {
				if (msg.ret == 200) {	loadCountryWindow(msg.data)	}
			})
		}
	})


	/**模拟下拉框点击事件*/
	$(".select-i-window .input-txt-window,.select-i-window i").on('click', function (event) {
		var $this = $(this);
		$(".select-i-window .input-txt-window").each(function () {
			if($this.attr("id") != $(this).attr("id")){
				console.log('点击了下拉框1');
				hideULWindow($(this));
			}
		})
		var jt = $this.next(".jt_window").andSelf('.jt_window');
		if (jt.hasClass('up')){
			jt.removeClass('up');
			$('#countryCodeWindow').slideUp().addClass("un-fold-window");
		}else{
			jt.addClass('up');
			$('#countryCodeWindow').slideDown().removeClass("un-fold-window");
		}
		/*阻止冒泡*/
		event.stopPropagation();
	});
	/**当下拉框失去焦点时收起下拉框*/
	$("body").on("click",function () {	hideULWindow($('#countryCodeWindow'));	});
	/**下拉列表展开时点击li的事件  项目页只显示编码不显示国家名称*/
	$(".select-i-window").on("click","ul li",function(){
		var is_only_show_code = $('input[name="is_only_show_code"]').val()
		var cnumber = $(this).find('strong').text()
		if(is_only_show_code == 1 ){	cnumber = '+'+$(this).attr('data-value');}
		$(this).parent("ul").siblings(".input-txt-window").text(cnumber);
		var countryCodeWindow = '00'+$(this).attr("data-value")
		$(this).parent("ul").siblings(".input-txt-window").attr("data-value",countryCodeWindow);
		$('input[name="countrycode"]').val(countryCodeWindow)
		//已选元素添加选中样式
		var selectTxt = $('.select-i-window .input-txt-window').text();
		if (selectTxt && selectTxt !='请选择国编') {
			$('.select-i-window .ul-select-window strong.selected').removeClass('selected');
			$('.select-i-window .ul-select-window strong:contains("' + selectTxt + '")').addClass('selected');
			$("[name = 'countrycode']").children('option').removeAttr('selected');
			$("[name = 'countrycode']").children('option:contains("' + selectTxt + '")').attr('selected',true);
		}
		hideULWindow($(this).parent());
	});

	/**加载国家*/
	// 精灵图的国旗 <div class="flag-box"><div class="iti-flag ${data[i].abbreviation}"></div></div>

	function loadCountryWindow(data){
		var html = "";
		for (var i = 0; i < data.length; i++) {
			html +=
			`<li data-value="${data[i].InternationalTel}">
			<div style="display:inline-block; vertical-align: middle;">
				<img src="${data[i].img}" width="20" alt="">
			</div>
			<strong>${data[i].country}+${data[i].InternationalTel}</strong>
			</li>`;
		}
		$("#countryCodeWindow").html(html);

		if (!isNaN(S_Query.type)){
			var qn=S_Query.type；
			if (qn == 0 || qn == 1 || qn== 2 || qn == 10) {
				$('li[data-value="86"]').click();
			} else if (qn == 5 || qn == 6 || qn == 7 || qn == 8){
				$('li[data-value="65"]').click();
			}
		}
	}
});
/**隐藏ul*/
function hideULWindow(obj) {
	if(obj.siblings(".jt_window").hasClass('up')){
		$('.jt_window').removeClass("up");
		$('#countryCodeWindow').slideUp().addClass("un-fold-window");
		// obj.siblings(".jt").removeClass('up').siblings("ul").addClass("un-fold");
	}
}
</script>
<!-- 导航错位 -->
<script>
	var add_s_time="";
	/*左侧加入三个标签 nav_column 用来控制纵向*/
	var nav_column="<div class='nav_column'></div>";
	var nav_kj="<div class='nav_kj_column'></div>";
	$(".nav_loop").each(function () {
		for(var i=0;i<5;i++){	$(this).append(nav_column);	}
	});
	$(".nav_kj_item").each(function () {
		for(var i=0;i<2;i++){
			$(this).find(".nav_kj_loop").append(nav_kj);
		}
	});
</script>

<script>
	//懒加载方法（目前有一个很大的问题，就是时间循环，此方法问题很大，但是没有什么好的办法解决）
	$(function() {

		$("img").lazyload({	effect: "fadeIn",failure_limit : 10, });
		var time=0;
		$("body li").mouseover(function(){

			//$("img").trigger("sporty");

			if($(this).closest("ul").hasClass("fhm-ul-t")){
				//if(time==0){
				//time=30;
				var index= $(this).attr("name");
				console.log(index);
				$("section[name='"+index+"']").find(".fhm-cl-li").each(function(){
					var gg_org = $(this).find(".fhm-cl-t").find("a").find("img").attr("data-original");
					var gg_src = $(this).find(".fhm-cl-t").find("a").find("img").attr("src");
					var wx_org = $(this).find(".fhm-cl-p").find("img").attr("data-original");
					if(gg_src ==""){
						$(this).find(".fhm-cl-t").find("a").find("img").attr("src",gg_org);
						$(this).find(".fhm-cl-p").find("img").attr("src",wx_org);
					}
				});

			}else{	$(this).trigger("scroll");}
	});



		var id=0;
		var idArr =new Array();
		//timer();
		function timer(){
			if(time>0){
				console.log(time);
//				$("img").lazyload();
				id = window.setTimeout(timer,1000);
				time--;
				idArr[time]=id;

			}
			if(time==0){
				for(var i=0;i<idArr.length;i++){
    				clearTimeout(idArr[i]);
				}
				idArr =[];
			}
		}
		$(".search_type").click(function(){	$(".g-hd-search").find("ul").show();});
		$(".g-hd-search").find("ul").find("li").click(function(){
			$(".search_type").html($(this).html());
			$(".g-hd-search").find("ul").hide();
		});

		$(".header_search").click(function(){
			var searchResult = $(".searchResult").val();
			var searchType = $(".search_type").html();

			if(window.location.host=="https://www.huanqiuchuguo.com"){
				var hwzwLink = "/cn";
			}else{
				var hwzwLink = "";
			}


			if(searchType=="国家"){
				if(searchResult){
					getSearchLink(searchResult);
				}else{
					layer.msg("请填写搜索词");
				}

			}else if(searchType=="新闻"){
				window.location.href=hwzwLink+"/category/171.html?keyword="+searchResult;
			}else if(searchType=="活动"){
				window.location.href=hwzwLink+"/event_gather.html?keyword="+searchResult;

			}else{
				window.location.href=hwzwLink+"/news.html?keyword="+searchResult;
			}

		})
		//setInterval(function() {
		//$("img").lazyload();
		// }, 1000);

	});


</script>

	<script  src="https://www.globevisa.com.cn/static/index/js/flash.js"></script>
	<script  src="https://www.globevisa.com.cn/static/index/js/swiper/swiper1.js"></script>
	<script  src="https://www.globevisa.com.cn/static/index/js/company2.js?72429"></script>
	<script type="text/javascript"  src="https://www.globevisa.com.cn/static/index/js/advisers.js"></script>
	<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=0Fe8a1e79a2b773b91b3bcffe67b71b8&s=1"></script>
	<script type="text/javascript">
		$(function() {
			$('.bo_hot_city>ul').addClass('flex flex-w');

			$(".show_btn").click(function() {
				if ($(this).parents('dl').hasClass('on')) {
					$(this).parents('dl').removeClass('on');
					$(this).html('展开评价<i></i>');
					$(this).prev('.content').html($(this).attr('data-h'));

				}else{
					$(this).parents('dl').addClass('on');
					$(this).html('收起评价<i></i>');
					$(this).prev('.content').html($(this).attr('data-s'));
				}
			});
		});

		var map_lon = "120.679203";
		var map_lat = "31.32106";
		if(map_lon && map_lat){
			var map = new BMap.Map("bdMapLoc");
			map.centerAndZoom(new BMap.Point(map_lon, map_lat), 17);  //前边是左边。后边是
			map.enableScrollWheelZoom();
			var marker = new BMap.Marker(new BMap.Point(map_lon, map_lat));
			map.addOverlay(marker);
			var licontent = "<p style='font-size:14px;padding:0;margin:0;height: 24px;font-weight:700'>环球苏州</p>";
			licontent += "<span style='line-height:17px;'><strong>地址:</strong> 苏州市工业园区苏州大道西9号中海财富中心西塔2306-2307室 </span><br>";

			var hiddeninput = "<input type=\"hidden\" value=\"" + '苏州' + "\" name=\"region\" /><input type=\"hidden\" value=\"html\" name=\"output\" /><input type=\"hidden\" value=\"driving\" name=\"mode\" /><input type=\"hidden\" value=\"latlng:" + marker.getPosition().lat + "," + marker.getPosition().lng + "|name:" + "\" name=\"destination\" />";
			var content1 = "<form id=\"gotobaiduform\" action=\"https://api.map.baidu.com/direction\" target=\"_blank\" method=\"get\">" + licontent + hiddeninput + "</form>";
			var opts1 = { width: 400 };

			var infoWindow = new BMap.InfoWindow(content1, opts1);
			marker.openInfoWindow(infoWindow);
			marker.addEventListener('click', function () { marker.openInfoWindow(infoWindow); });

			function gotobaidu(type) {
				if ($.trim($("input[name=origin]").val()) == "") {
					alert("请输入起点！");
					return;
				} else {
					if (type == 1) {
						$("input[name=mode]").val("transit");
						$("#gotobaiduform")[0].submit();
					} else if (type == 2) {
						$("input[name=mode]").val("driving");
						$("#gotobaiduform")[0].submit();
					}
				}
			}
		}else{
			$('.dtxs').hide();
		}
</script>

<!--请在上方写此页面业务相关的脚本-->
</body>
</html>


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
     <p> <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 4; endif;if(is_array($field['children']) || $field['children'] instanceof \think\Collection || $field['children'] instanceof \think\Paginator): $i = 0; $e = 1;$__LIST__ = is_array($field['children']) ? array_slice($field['children'],0,4, true) : $field['children']->slice(0,4, true); if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field2): $field2["typename"] = text_msubstr($field2["typename"], 0, 100, false); $__LIST__[$key] = $_result[$key] = $field2;$i= intval($key) + 1;$mod = ($i % 2 ); ?> <a href="<?php echo $field2['typeurl']; ?>"><?php echo $field2['typename']; ?></a><?php ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field2 = []; ?> </p>
    </div>
    <?php ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?> </div>
 
  <div class="container">
<!--  <div class="container link">
  <div class="col-md-12"> 友情链接： 
    <?php  $tagFlink = new \think\template\taglib\eyou\TagFlink; $_result = $tagFlink->getFlink("text", "0,24", ""); if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $e = 1; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $field["title"] = text_msubstr($field["title"], 0, 100, false); $__LIST__[$key] = $_result[$key] = $field;$i= intval($key) + 1;$mod = ($i % 2 ); ?> <a href="<?php echo $field['url']; ?>" <?php echo $field['target']; ?> <?php echo $field['nofollow']; ?>><?php echo $field['title']; ?></a> <?php ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?> </div>
</div> -->

    <div class="col-md-12 white footer01"> <?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_copyright"); echo $__VALUE__; ?> <br>
      <!--
      <?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attrname_1"); echo $__VALUE__; ?>：<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attr_1"); echo $__VALUE__;  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attrname_2"); echo $__VALUE__; ?>：<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attr_2"); echo $__VALUE__; ?> <br>
 
      <?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attrname_3"); echo $__VALUE__; ?>：<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attr_3"); echo $__VALUE__;  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attrname_4"); echo $__VALUE__; ?>：<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attr_4"); echo $__VALUE__;  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attrname_5"); echo $__VALUE__; ?>：<?php  $tagGlobal = new \think\template\taglib\eyou\TagGlobal; $__VALUE__ = $tagGlobal->getGlobal("web_attr_5"); echo $__VALUE__; ?>
   -->
       </div>
  </div>

</footer>
<?php  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/js/jquery-3.7.0.min.js","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/js/bootstrap.js","","","","",""); echo $__VALUE__;  $tagStatic = new \think\template\taglib\eyou\TagStatic; $__VALUE__ = $tagStatic->getStatic("skin/js/amazeui.min.js","","","","",""); echo $__VALUE__; ?> 
<!-- 应用插件标签 start --> 
 <?php  $tagWeapp = new \think\template\taglib\eyou\TagWeapp; $__VALUE__ = $tagWeapp->getWeapp("default"); echo $__VALUE__; ?> 
<!-- 应用插件标签 end --> 

<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/css/font.css" />
<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/js/jquery.fallr/jquery.fallr.css" />
<link rel="stylesheet" type="text/css" href="/hsytt/static/admin/js/artDialog/skins/default.css" />
<script type="text/javascript" src="/hsytt/assets/fb04db1/jquery.min.js"></script>
<script type="text/javascript" src="/hsytt/static/admin/js/artDialog/jquery.artDialog.js"></script>
<script type="text/javascript" src="/hsytt/static/admin/js/artDialog/plugins/iframeTools.js"></script>
</body>
</html>
