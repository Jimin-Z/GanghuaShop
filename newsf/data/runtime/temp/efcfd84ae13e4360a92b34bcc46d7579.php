<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:25:"./template/pc/newHome.htm";i:1732686656;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/hkshop/newsf/template/pc/newHome.css">
    <title>home</title>
</head>
<body>
    <div class="home-container">

        <header class="home-header">

            <nav class="home-main-tabs flex">
                <ul class="tab-items flex">
                    <li class="tab-item tab-item-active">
                        <a href="/hkshop/hk-Index/index.html" class="tab-link">首页</a>
                    </li>
                    <li class="tab-item">
                        <a href="" class="tab-link">香港移民</a>
                    </li>
                    <li class="tab-item">
                        <a href="/hkshop/newsf/?m=home&c=Lists&a=index&tid=1" class="tab-link">香港生活机构</a>
                    </li>
                    <li class="tab-item">
                        <a href="/hkshop/newsf/?m=home&c=Lists&a=index&tid=2" class="tab-link">亚非移民</a>
                    </li>
                    <li class="tab-item">
                        <a href="/hkshop/newsf/?m=home&c=Lists&a=index&tid=3" class="tab-link">欧洲移民</a>
                    </li>
                    <li class="tab-item">
                        <a href="/hkshop/newsf/?m=home&c=Lists&a=index&tid=4" class="tab-link">活动图片</a>
                    </li>
                    <li class="tab-item">
                        <a href="/hkshop/newsf/?m=home&c=Lists&a=index&tid=5" class="tab-link">大洋洲移民</a>
                    </li>
                    <li class="tab-item">
                        <a href="/hkshop/newsf/?m=home&c=Lists&a=index&tid=6" class="tab-link">香港城信息</a>
                    </li>
                    <li class="tab-item">
                        <a href="/hkshop/newsf/?m=home&c=Lists&a=index&tid=7" class="tab-link">跨境服务</a>
                    </li>
                </ul>
            </nav>

            <div class="flex flex--header">
                <div class="header__left">
                    <h1 class="header__logo-wrapper">
                        <img src="/newHome/images/hkLogo.png" alt="logo" class="header__logo">
                    </h1>

                    <div class="header__search flex">
                        <img src="/newHome/images/search.png" alt="搜索图标" class="header__search-icon">
                        <input type="text" class="header__search-input">
                        <button class="header__search-btn">搜索</button>
                    </div>

                    <div class="header__links flex">
                        <a href="#" class="header__link">
                            免费评估
                            <br>
                            <span class="header__link--en">Free<br>Evaluation</span>
                            
                        </a>
                        <a href="#" class="header__link">
                            热门推荐
                            <br>
                            <span class="header__link--en">Popular<br>Recommondations</span>
                        </a>
                        <a href="/hkshop/shop/viplogin.php" class="header__link">
                            会员中心
                            <br>
                            <span class="header__link--en">Member<br>Center</span>
                        </a>
                    </div>
                </div>

                

                <div class="swiper-wrapper">
                    <div class="swiper__bgc"></div>

                    <div class="swiper">
                        <div class="swiper__items">
                            <div class="swiper__item">
                                <img class="swiper__img" src="/newHome/images/swiper01.jpg" alt="swiper__img">
                            </div>
                            <div class="swiper__item">
                                <img class="swiper__img" src="/newHome/images/swiper02.jpg" alt="swiper__img">
                            </div>
                            <div class="swiper__item">
                                <img class="swiper__img" src="/newHome/images/swiper03.jpg" alt="swiper__img">
                            </div>
                            <div class="swiper__item">
                                <img class="swiper__img" src="/newHome/images/swiper04.jpg" alt="swiper__img">
                            </div>
                        </div>
        

                    </div>

                    <ul class="dot__items flex--column">
                        <li class="dot__item dot__item--active"></li>
                        <li class="dot__item"></li>
                        <li class="dot__item"></li>
                        <li class="dot__item"></li>
                    </ul>
                </div>

            </div>
        </header>

        <aside class="home-aside">
            <nav class="home-aside__nav">
                <ul class="aside-nav__items flex--column">
                    <li class="aside-nav__item"  href="https://qmdd.net/welive/kefu.php?a=6168">
                              <a
                href="https://qmdd.net/welive/kefu.php?a=6168"
                target="_blank" style="color: white;"
                >在线咨询</a
              >
                    </li>
                    <li class="aside-nav__item">
                               <a
                href=""
                target="_blank" style="color: white;"
                >项目合作</a
              >
                    </li>
                    <li class="aside-nav__item">
                               <a
                href=""
                target="_blank" style="color: white;"
                >关注微信</a
              >
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- 信息中心 -->
        <section class="info-center wrapper--gobal">

            <!-- 顶部部分，有移民和视频中心的盒子 -->
            <div class="info-center__items flex">

                <section class="info-center__item flex--column info-center__item--left info-center__item--migrant">

                    <h2 class="info-center__item-title">
                        香港移民中心
                    </h2>

                    <!-- 内容部分 -->
                    <div class="info-center__item-content--small info-center__item-content flex--column">

                        <!-- 内容可视化 -->
                        <?php  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = "2"; endif; if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 10; endif; $tagChannelartlist = new \think\template\taglib\eyou\TagChannelartlist; $_result = $tagChannelartlist->getChannelartlist($typeid, "self",""); if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $e = 1;$__LIST__ = is_array($_result) ? array_slice($_result,0, $row, true) : $_result->slice(0, $row, true); if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$channelartlist): $channelartlist["typename"] = text_msubstr($channelartlist["typename"], 0, 100, false); $__LIST__[$key] = $_result[$key] = $channelartlist;$i= intval($key) + 1;$mod = ($i % 2 );  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 1; endif; $modelid = ""; $param = array(      "typeid"=> $typeid,      "notypeid"=> "",      "flag"=> "",      "noflag"=> "",      "channel"=> $modelid,      "joinaid"=> "",      "keyword"=> "",      "release"=> "off",      "idlist"=> "",      "idrange"=> "",      "aid"=> "", ); $tag = array (
  'limit' => '0,1',
  'titlelen' => '20',
  'r' => 'eyou:artlist',
); $tagArclist = new \think\template\taglib\eyou\TagArclist; $_result = $tagArclist->getArclist($param, $row, "", "","desc","",$tag,"0","on","off","","");if(!empty($_result["list"]) && (is_array($_result["list"]) || $_result["list"] instanceof \think\Collection || $_result["list"] instanceof \think\Paginator)): $i = 0; $e = 1; $__LIST__ = is_array($_result["list"]) ? array_slice($_result["list"],0, $row, true) : $_result["list"]->slice(0, $row, true);  $__TAG__ = $_result["tag"];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $aid = $field["aid"];$users_id = $field["users_id"];$field["title"] = text_msubstr($field["title"], 0, 20, false);if($field["is_b"] == 1) : $field["title"] = "<strong>".$field["title"]."</strong>";endif;$field["seo_description"] = text_msubstr($field["seo_description"], 0, 160, true);$i= intval($key) + 1;$mod = ($i % 2 ); ?>
                        <div class="info-center__item-img-link--hover">

                            <div class="info-center__item-img-link flex info-center__item-img-link--visible info-center__item-img-link--active">
                                <img src="/newHome/images/info-center01.png" alt="info-center--pic" class="info-center__item-img info-center__item-img--visible info-center__item-img--active">
                                <a href="<?php echo $field['arcurl']; ?>" class="info-center__item-link info-center__item-link--active">
                                    <?php echo $field['title']; ?>
                                </a>
                            </div>

                            <a href="<?php echo $field['arcurl']; ?>" class="info-center__item-link">
                                <?php echo $field['title']; ?>
                            </a>
                        </div>   
                        <?php ++$e; $aid = 0; $users_id = 0; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = [];  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 4; endif; $modelid = ""; $param = array(      "typeid"=> $typeid,      "notypeid"=> "",      "flag"=> "",      "noflag"=> "",      "channel"=> $modelid,      "joinaid"=> "",      "keyword"=> "",      "release"=> "off",      "idlist"=> "",      "idrange"=> "",      "aid"=> "", ); $tag = array (
  'limit' => '1,4',
  'titlelen' => '20',
  'r' => 'eyou:artlist',
); $tagArclist = new \think\template\taglib\eyou\TagArclist; $_result = $tagArclist->getArclist($param, $row, "", "","desc","",$tag,"0","on","off","","");if(!empty($_result["list"]) && (is_array($_result["list"]) || $_result["list"] instanceof \think\Collection || $_result["list"] instanceof \think\Paginator)): $i = 0; $e = 1; $__LIST__ = is_array($_result["list"]) ? array_slice($_result["list"],1, $row, true) : $_result["list"]->slice(1, $row, true);  $__TAG__ = $_result["tag"];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $aid = $field["aid"];$users_id = $field["users_id"];$field["title"] = text_msubstr($field["title"], 0, 20, false);if($field["is_b"] == 1) : $field["title"] = "<strong>".$field["title"]."</strong>";endif;$field["seo_description"] = text_msubstr($field["seo_description"], 0, 160, true);$i= intval($key) + 1;$mod = ($i % 2 ); ?>
                  <div class="info-center__item-img-link--hover">

                            <div class="info-center__item-img-link flex info-center__item-img-link--visible">
                                <img src="/newHome/images/info-center01.png" alt="info-center--pic" class="info-center__item-img ">
                  <a
                    href="<?php echo $field['arcurl']; ?>"
                    class="info-center__item-link info-center__item-link--active"
                  >
                    <?php echo $field['title']; ?>
                  </a>
                </div>

                <a href="<?php echo $field['arcurl']; ?>" class="info-center__item-link">
                  <?php echo $field['title']; ?>
                </a>
              </div>      
               <?php ++$e; $aid = 0; $users_id = 0; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = [];  if(isset($ui_typeid) && !empty($ui_typeid)) : $typeid = $ui_typeid; else: $typeid = ""; endif; if(empty($typeid) && isset($channelartlist["id"]) && !empty($channelartlist["id"])) : $typeid = intval($channelartlist["id"]); endif;  if(isset($ui_row) && !empty($ui_row)) : $row = $ui_row; else: $row = 5; endif; $modelid = ""; $param = array(      "typeid"=> $typeid,      "notypeid"=> "",      "flag"=> "",      "noflag"=> "",      "channel"=> $modelid,      "joinaid"=> "",      "keyword"=> "",      "release"=> "off",      "idlist"=> "",      "idrange"=> "",      "aid"=> "", ); $tag = array (
  'limit' => '4,5',
  'titlelen' => '20',
  'r' => 'eyou:artlist',
); $tagArclist = new \think\template\taglib\eyou\TagArclist; $_result = $tagArclist->getArclist($param, $row, "", "","desc","",$tag,"0","on","off","","");if(!empty($_result["list"]) && (is_array($_result["list"]) || $_result["list"] instanceof \think\Collection || $_result["list"] instanceof \think\Paginator)): $i = 0; $e = 1; $__LIST__ = is_array($_result["list"]) ? array_slice($_result["list"],4, $row, true) : $_result["list"]->slice(4, $row, true);  $__TAG__ = $_result["tag"];if( count($__LIST__)==0 ) : echo htmlspecialchars_decode("");else: foreach($__LIST__ as $key=>$field): $aid = $field["aid"];$users_id = $field["users_id"];$field["title"] = text_msubstr($field["title"], 0, 20, false);if($field["is_b"] == 1) : $field["title"] = "<strong>".$field["title"]."</strong>";endif;$field["seo_description"] = text_msubstr($field["seo_description"], 0, 160, true);$i= intval($key) + 1;$mod = ($i % 2 ); ?>
                  <div class="info-center__item-img-link--hover">
                         <div class="info-center__item-img-link flex info-center__item-img-link--visible">
                           <img src="/newHome/images/info-center01.png" alt="info-center--pic" class="info-center__item-img info-center__item-img--visible">
                  <a
                    href="<?php echo $field['arcurl']; ?>"
                    class="info-center__item-link info-center__item-link--active"
                  >
                    <?php echo $field['title']; ?>
                  </a>
                </div>

                <a href="<?php echo $field['arcurl']; ?>" class="info-center__item-link">
                  <?php echo $field['title']; ?>
                </a>
              </div>   
               <?php ++$e; $aid = 0; $users_id = 0; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $field = []; ?>      
                        <a href="<?php  $__VALUE__ = isset($channelartlist["typeurl"]) ? $channelartlist["typeurl"] : "变量名不存在"; echo $__VALUE__; ?>" class="info-center__item-more-btn flex">
                            查看更多
                            <img src="/newHome/images/right-arrow.png" alt="right-row" class="info-center__item-arrow">
                        </a>
                    </div>
                     <?php ++$e; endforeach; endif; else: echo htmlspecialchars_decode("");endif; $typeid = $row = ""; unset($channelartlist); ?>
    
    
                </section>

          
<?php  echo $eyou['videocenter'];  echo $eyou['topannouncements']; ?>
    
        </section>

        <main class="home-main wrapper--gobal">
 
            <div class="service-card--flex">

                <section class="service-card">

                    <h2 class="service-card__main-title service-card__main-title--flex">
                        移居項目
                        <span class="service-card__sub-title">投資、創業、技術——拿身份，享醫療教育福利</span>
                    </h2>
    
                    <div class="swiper-card__wrapper flex">
    
                        <div class="swiper-card__left-arrow">
                            <img src="/newHome/images/swiper-left-arrow.png" alt="swiper-left-arrow" class="swiper-card__left-arrow--img">
                        </div>
    
                        <div class="swiper-card">
    
                            <div class="swiper-card__items flex">
    
                                <div class="swiper-card__item">
                                    <h3 class="swiper-card__title swiper-card__title--left">香港專才工簽</h3>
                                    <p class="swiper-card__details flex--column">
                                        <span class="swiper-card__text">獲得身份</span>
                                        <span class="swiper-card__text">居留簽證</span>
                                        <span class="swiper-card__text">資産要求</span>
                                        <span class="swiper-card__text">20萬人民币</span>
                                    </p>
                                </div>
        
                                <div class="swiper-card__item">
                                    <h3 class="swiper-card__title">香港優才計劃</h3>
                                    <p class="swiper-card__details flex--column">
                                        <span class="swiper-card__text">獲得身份</span>
                                        <span class="swiper-card__text">居留簽證</span>
                                        <span class="swiper-card__text">資産要求</span>
                                        <span class="swiper-card__text">20萬人民币</span>
                                    </p>
                                </div>
        
                                <div class="swiper-card__item">
                                    <h3 class="swiper-card__title swiper-card__title--right">香港高端人才 <br>- 高薪人士</h3>
                                    <p class="swiper-card__details flex--column">
                                        <span class="swiper-card__text">獲得身份</span>
                                        <span class="swiper-card__text">居留簽證</span>
                                        <span class="swiper-card__text">資産要求</span>
                                        <span class="swiper-card__text">20萬人民币</span>
                                    </p>
                                </div>
    
                                <div class="swiper-card__item">
                                    <h3 class="swiper-card__title swiper-card__title--right">香港高端人才 <br>- 高薪人士</h3>
                                    <p class="swiper-card__details flex--column">
                                        <span class="swiper-card__text">獲得身份</span>
                                        <span class="swiper-card__text">居留簽證</span>
                                        <span class="swiper-card__text">資産要求</span>
                                        <span class="swiper-card__text">20萬人民币</span>
                                    </p>
                                </div>
    
                                <div class="swiper-card__item">
                                    <h3 class="swiper-card__title swiper-card__title--right">香港高端人才 <br>- 高薪人士</h3>
                                    <p class="swiper-card__details flex--column">
                                        <span class="swiper-card__text">獲得身份</span>
                                        <span class="swiper-card__text">居留簽證</span>
                                        <span class="swiper-card__text">資産要求</span>
                                        <span class="swiper-card__text">20萬人民币</span>
                                    </p>
                                </div>
    
                                <div class="swiper-card__item">
                                    <h3 class="swiper-card__title swiper-card__title--right">香港高端人才 <br>- 高薪人士</h3>
                                    <p class="swiper-card__details flex--column">
                                        <span class="swiper-card__text">獲得身份</span>
                                        <span class="swiper-card__text">居留簽證</span>
                                        <span class="swiper-card__text">資産要求</span>
                                        <span class="swiper-card__text">20萬人民币</span>
                                    </p>
                                </div>
    
                                <div class="swiper-card__item">
                                    <h3 class="swiper-card__title swiper-card__title--right">香港高端人才 <br>- 高薪人士</h3>
                                    <p class="swiper-card__details flex--column">
                                        <span class="swiper-card__text">獲得身份</span>
                                        <span class="swiper-card__text">居留簽證</span>
                                        <span class="swiper-card__text">資産要求</span>
                                        <span class="swiper-card__text">20萬人民币</span>
                                    </p>
                                </div>
    
                                <div class="swiper-card__item">
                                    <h3 class="swiper-card__title swiper-card__title--right">香港高端人才 <br>- 高薪人士</h3>
                                    <p class="swiper-card__details flex--column">
                                        <span class="swiper-card__text">獲得身份</span>
                                        <span class="swiper-card__text">居留簽證</span>
                                        <span class="swiper-card__text">資産要求</span>
                                        <span class="swiper-card__text">20萬人民币</span>
                                    </p>
                                </div>
        
                            </div>
                        </div>
    
                        <div class="swiper-card__right-arrow">
                            <img src="/newHome/images/swiper-right-arrow.png" alt="swiper-right-arrow" class="swiper-card__right-arrow--img">
                        </div>
    
                    </div>
    
                </section>

                <section class="service-card">
                    <h2 class="service-card__main-title flex edu-card__main-title">
                        留學教育
                        <span class="service-card__sub-title">——省錢+便捷的移居捷徑</span>
                    </h2>
    
                    <div class="service-items flex">
                        
                        <section class="service-item service-item--left">
                            <h3 class="service-item__title">低门槛</h3>
                            <p class="service-item__details flex--column service-item__details--left">
                                <span class="item-detais__text">香港研究生</span>
                                <span class="item-detais__text">獲得香港身份</span>
                                <span class="item-detais__text">獲得身份</span>
                                <span class="item-detais__text">學生簽證</span>
                                <span class="item-detais__text">資産要求</span>
                                <span class="item-detais__text">20萬人民币</span>      
                            </p>
                        </section>
    
                        <section class="service-item service-item--right flex--column">
                            <h3 class="service-item__title service-item__title--right">高性價比</h3>
                            <p class="service-item__details flex--column service-item__details--right">
                                <span class="item-detais__text">職專畢業</span>
                                <span class="item-detais__text">留港計劃(VPAS)</span>
                                <span class="item-detais__text">獲得身份</span>
                                <span class="item-detais__text">學生簽證</span>
                                <span class="item-detais__text">資産要求</span>
                                <span class="item-detais__text">25萬人民币</span>
                            </p>
                        </section>
    
                    </div>
    
                </section>
            </div>

            

            

            <section class="service-card">
                <h2 class="service-card__main-title flex">
                    金融類
                    <span class="service-card__sub-title">開戶，註冊公司，報稅</span>
                </h2>

                <div class="finance-items flex">

                    <div class="finance-item">

                        <section class="finance-item__main">
                            <h3 class="finance-item__title">
                                香港資本投資者入境計劃
                            </h3>
                            <!-- 文字有空格就行  就是内容要有空格就会将空格给留着-->
                            <p class="finance-item__details">     环球出国立足于新加坡，以国际化理念服务于中国、东南亚、非洲、大洋洲、欧洲和北美等国家和地区三十余城市的精英阶层。遍布中国北京、上海、广州、深圳、香港等二十一座城市，以及马来西亚吉隆坡、葡萄牙里斯本、英国伦敦、加拿大温哥华、土耳其、阿联酋迪拜等全球金融中心。</p>
                        </section>

                        <div class="finance-item__img-box flex">
                            <img src="/newHome/images/finance01.png" alt="finance--pic" class="finance-item__img">
                        </div>
                    </div>

                    <div class="finance-item">

                        <div class="finance-item__img-box flex">
                            <img src="/newHome/images/finance02.png" alt="finance--pic" class="finance-item__img">
                        </div>

                        <section class="finance-item__main">
                            <h3 class="finance-item__title">
                                香港資本投資者入境計劃
                            </h3>
                            <p class="finance-item__details">     环球出国立足于新加坡，以国际化理念服务于中国、东南亚、非洲、大洋洲、欧洲和北美等国家和地区三十余城市的精英阶层。遍布中国北京、上海、广州、深圳、香港等二十一座城市，以及马来西亚吉隆坡、葡萄牙里斯本、英国伦敦、加拿大温哥华、土耳其、阿联酋迪拜等全球金融中心。</p>
                        </section>


                    </div>

                    <div class="finance-item">

                        <section class="finance-item__main">
                            <h3 class="finance-item__title">
                                香港資本投資者入境計劃
                            </h3>
                            <p class="finance-item__details">     环球出国立足于新加坡，以国际化理念服务于中国、东南亚、非洲、大洋洲、欧洲和北美等国家和地区三十余城市的精英阶层。遍布中国北京、上海、广州、深圳、香港等二十一座城市，以及马来西亚吉隆坡、葡萄牙里斯本、英国伦敦、加拿大温哥华、土耳其、阿联酋迪拜等全球金融中心。</p>
                        </section>

                        <div class="finance-item__img-box flex">
                            <img src="/newHome/images/finance03.png" alt="finance--pic" class="finance-item__img">
                        </div>
                    </div>

                

                </div>

            </section>


            <section class="service-card">
                <h2 class="service-card__main-title">
                    成功案例
                </h2>

                    <div class="success-items flex">

                        <section class="success-item">
                            <a href="#" class="success-item-top">
                                <img src="/hkshop/newsf/uploads/ca56712903ffd55e256648c36ad2c97.png" alt="案例图片" class="success-item-img">
                                <span class="success-item-span">「案例分享」</span>
                                <h3 class="success-item-h3">客戶說｜爲兩個兒子未來發展鋪路，我還</h3>
                                <p class="success-item-p"> 環球出國邀請香港高才通客戶趙女士講述自己爲兩個兒子未來教育、職業規劃從而成功獲得香港身份的故事，趙女士講述了自己在辦理香..</p>
                            </a>
                            <!-- 根据内容选择合适的语义化标签 -->
                            <aside class="expert-card flex">
                                <!-- 例如专家信息：头像、姓名、头衔等 -->
                                <img class="expert-card-img" src="/newHome/images/expert.png" alt="专家头像">
                                <p class="expert-card-p flex--column">
                                    <span class="expert-card-span">广州-Alice曹</span>
                                    <span>16676779478</span>
                                </p>
                                <a href="#" class="connect-btn">专家连线</a>
                            </aside>
                        </section>

                        <section class="success-item">
                            <a href="#" class="success-item-top">
                                <img src="/hkshop/newsf/uploads/c640a7f96462306159b38ca821f1695.png" alt="案例图片" class="success-item-img">
                                <span class="success-item-span">「案例分享」</span>
                                <h3 class="success-item-h3">客戶說｜爲兩個兒子未來發展鋪路，我還</h3>
                                <p class="success-item-p">環球出國邀請香港高才通客戶趙女士講述自己爲兩個兒子未來教育、職業規劃從而成功獲得香港身份的故事，趙女士講述了自己在辦理香..</p>
                            </a>
                            <!-- 根据内容选择合适的语义化标签 -->
                            <aside class="expert-card flex">
                                <!-- 例如专家信息：头像、姓名、头衔等 -->
                                <img class="expert-card-img" src="/newHome/images/expert.png" alt="专家头像">
                                <p class="expert-card-p flex--column">
                                    <span class="expert-card-span">广州-Alice曹</span>
                                    <span>16676779478</span>
                                </p>
                                <a href="#" class="connect-btn">专家连线</a>
                            </aside>
                        </section>

                        <form action="" class="success-form flex--column">
                            <span class="form-name">GLOBEVISA</span>
                            <p class="flex-column form-desc">
                                <span class="form-h3">马上预约</span>
                                <span class="form-h2">免费定制方案吧</span>
                                <span class="form-h4">貼心服務減少後顧之憂</span>
                            </p>
                            <div class="form-item flex">
                                <label for="name" class="form-label">姓名：</label>
                                <input type="text" name="" id="name" placeholder="请输入姓名" class="form-input">
                            </div>

                            <div class="form-item flex">
                                <label for="name" class="form-label">國編：</label>
                                <input type="text" name="" id="name" placeholder="请输入姓名" class="form-input">
                            </div>

                            <div class="form-item flex">
                                <label for="name" class="form-label">手機号：</label>
                                <input type="text" name="" id="name" placeholder="请输入您的手机号" class="form-input">
                            </div>

                            <div class="form-item flex">
                                <label for="name" class="form-label">選擇公司：</label>
                                <input type="text" name="" id="name" placeholder="选择公司" class="form-input">
                            </div>

                            <button class="form-btn">立即预约获取方案</button>
                        </form>
    
                    </div>
    
            </section>
           <section class="service-card">
                <h2 class="service-card__main-title flex">
                    專業團隊是申請成功的關鍵
                    <span class="service-card__sub-title">——24小時爲您提供諮詢服務，根據您的實際需求制定專屬方案</span>
                </h2>

                <div class="swiper--profess">

                    <div class="swiper__items--profess flex">

                        <img src="/newHome/images/swiper-left-arrow.png" alt="left-arrow" class="swiper__left-arrow--profess">

    <?php  echo $eyou['review']; ?>
                        <img src="/newHome/images/swiper-right-arrow.png" alt="right-arrow" class="swiper__right-arrow--profess">
                    </div>

                </div>

                <div class="slider">
                    <ul class="slider-items flex">
     <?php  echo $eyou['showman']; ?>
                        </ul>
                </div>
                

            </section>
        </main>

        <footer class="home-footer">
            <nav class="footer-nav footer-wrapper">
                <ul class="footer-nav-items flex">
                    <li class="footer-nav-item flex--column">
                        <a href="#" class="footer-nav-link">案例分析</a>
                    </li>

                    <li class="footer-nav-item flex--column">
                        <a href="#" class="footer-nav-link">成功案例</a>
                    </li>

                    <li class="footer-nav-item flex--column">
                        <a href="#" class="footer-nav-link">专员信息</a>
                    </li>

                    <li class="footer-nav-item flex--column">
                        <a href="#" class="footer-nav-link">香港生活机构</a>
                        <a href="#" class="footer-nav-link">组织架构</a>
                        <a href="#" class="footer-nav-link">组织架构</a>
                        <a href="#" class="footer-nav-link">组织架构</a>
                    </li>

                    <li class="footer-nav-item flex--column">
                        <a href="#" class="footer-nav-link">亚非移民</a>
                        <a href="#" class="footer-nav-link">组织架构</a>
                        <a href="#" class="footer-nav-link">组织架构</a>
                        <a href="#" class="footer-nav-link">组织架构</a>
                    </li>

                    <li class="footer-nav-item flex--column">
                        <a href="#" class="footer-nav-link">案例分析</a>
                        <a href="#" class="footer-nav-link">组织架构</a>
                        <a href="#" class="footer-nav-link">组织架构</a>
                        <a href="#" class="footer-nav-link">组织架构</a>
                    </li>
                </ul>
            </nav>

            <div class="copyRight footer-wrapper">
                <span>Copyright © 2012-2024 港华网络 版权所有 非商用版本</span>
            </div>
        </footer>

    </div>

    <script src="/hkshop/newsf/template/pc/newHome.js"></script>
</body>
</html>