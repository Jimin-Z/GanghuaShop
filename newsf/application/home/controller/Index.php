<?php

/**
 * 新闻通
 * ============================================================================
 * 版权所有 2016-2028 智讯通 同一科技有限公司。。
 * 
 * ----------------------------------------------------------------------------
，
 * ============================================================================
 * Author: 新闻通  4035172988@qq.com
 * Date: 2024-06-18
 */ 

namespace app\home\controller;

use think\Db;
use app\user\logic\PayLogic;

class Index extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->wechat_return();
        $this->alipay_return();
        $this->Express100();
        $this->ey_agent();
        $this->tikTok_return();
        $this->baiduPay_return();
    }

    public function index()
    {
        $preview_templet = input('param.templet/s');
        /*处理多语言首页链接最后带斜杆，进行301跳转*/
        $lang = input('param.lang/s');
        $url = $this->request->url(true);
        if (preg_match("/\?lang=" . $this->home_lang . "\/$/i", $url) && $lang == $this->home_lang . '/') {
            $langurl = rtrim($url, '/');
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $langurl);
            exit;
        }
        /*end*/
        /*首页焦点*/
        $m = input('param.m/s');
        if (empty($m)) {
            $this->request->get(['m' => 'Index']);
        }
        /*end*/
        $filename = 'index.html';
        $seo_pseudo = config('ey_config.seo_pseudo');
        $global0 = $this->eyou['global'];
        $sg0 = $global0['seo_html_position'];
        if (!isset($_GET['clear']) && file_exists($filename) && 2 == $seo_pseudo) {
            if ((isMobile() && !file_exists('./template/' . TPL_THEME . 'mobile')) || !isMobile()) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location:' . $filename);
                exit;
            }
        } else if (!isset($_GET['clear']) && 2 == $seo_pseudo && !empty($global0['seo_showmod']) && !empty($sg0)) {
            $html = explode('/', $sg0);
            $filename = end($html);
            if (file_exists($filename)) {
                $html = @file_get_contents($filename);
                if (!empty($html)) {
                    echo $html;
                    exit;
                }
            } 
        }
        $result['pageurl'] = $url; // 获取当前页面URL
        $result['pageurl_m'] = pc_to_mobile_url($url); // 获取当前页面对应的移动端URL
        if (!config('city_switch_on')) {
            if (3 != $seo_pseudo && stristr($url, '/Index/index')) {
                abort(404, '页面不存在');
            } else if (3 == $seo_pseudo && preg_match('/m=([^&]+)&c=([^&]+)&a=([^&]+)/i', $url)) {
                abort(404, '页面不存在');
            }
        }
        // 移动端域名 
        $result['mobile_domain'] = '';
        $s0 = $global0['web_mobile_domain'];
        if (!empty($global0['web_mobile_domain_open']) && !empty($s0)) {
            $result['mobile_domain'] = $s0 . '.' . $this->request->rootDomain();
        }
        $eyou = array( 'field' => $result,
                       'showman' => $this->getShowMan(),
                       'succcase' => $this->getSuccCase(),
                       'review' => $this->getReview(),
                       'topannouncements'=>$this->getTopAnnouncements(),
                        'videocenter'=>$this->getVideoCenter(),
                       // 'ImmigrationCentre'=>$this->getImmigrationCentre(),
                   );
        $eyou['slideads'] = $this->getSlideAds();
        $eyou['hkcase'] = $this->getCaseAnalysis();
        $eyou['hkproject'] = $this->chinaHk();
        $eyou['mainmenu'] = $this->getMainUrl();
        $this->eyou = array_merge($this->eyou, $eyou);
        $this->assign('eyou', $this->eyou);
        /*模板文件*/
        $viewfile = $this->getTempFile();
        $viewfile = ':newHome'; //测试使用 

        return $this->fetch($viewfile);
    }

    function bgetSideData()
    {
        $tmp = tablefindAll('ey_ad', ' 1 order by id');
        $rs0 = '';
        $rs1 = '';
        $rs2 = '<li data-target="#carousel-example-generic" data-slide-to="';
        $at = 'class="active"';
        $at1 = ' active';
        $p1 = '/hkshop/newsf/';

        foreach ($tmp as $k => $v) {
            $pic = $p1 . $v['litpic'];
            $rs0 .= $rs2 . $k . '" ' . $at . ' ></li>';
            $rs1 .= '<div class="item' . $at1 . '"> <img src="' . $pic . '" alt="" onClick="location.href=' . "''" . '"> </div>';
            $at = '';
            $at1 = '';
        }
        return array($rs0, $rs1);
    }

    function getSideData()
    {
        $tmp = tablefindAll('ey_ad', ' 1 order by id');
        $rs0 = '';
        $rs1 = '';
        $rs2 = '<li data-target="#carousel-example-generic" data-slide-to="';
        $at = 'class="active"';
        $at1 = ' active';
        $p1 = '/hkshop/newsf/';

        foreach ($tmp as $k => $v) {
            $pic = $p1 . $v['litpic'];
            $rs0 .= $rs2 . $k . '" ' . $at . ' ></li>';
            $rs1 .= '<div class="item' . $at1 . '"> <img src="' . $pic . '" alt="" onClick="location.href=' . "''" . '"> </div>';
            $at = '';
            $at1 = '';
        }
        return array($rs0, $rs1);
    }
    //前端获得广告
    public function getSlideAds()
    {
        $rs = $this->getSideData();
        $rs0 = ' <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">';
        $rs0 .= '<ol class="carousel-indicators">' . $rs[0] . '</ol>';
        $rs0 .= '<div class="carousel-inner" role="listbox">' . $rs[1] . '</div>';
        $rs0 .= '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> 
  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> 
  <span class="sr-only">Previous</span> </a> 
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>';
        return $rs0;
    }

    public function getMainUrl()
    {
        $w1 = 'parent_id=0 order by f_code limit 8';
        $tmp = tablefindAll('ey_arctype', $w1);
        $rs = '';
        $at = 'class="active"';
        $url = '/hkshop/newsf/?m=home&c=Lists&a=index&tid=';
        foreach ($tmp as $k => $v) {
            $rs .= '<li ' . $at . ' >';
            $at = 'class=""';
            $rs .= '<a href="' . $url . $v['id'] . '">' . $v['typename'] . '</a>';
            // if($v->f_ishot>0){
            //   $rs.=($v->f_ishot==1) ? $this->showMainUrl2($thisv,$v->f_code) : $this->showMainUrlh1($thisv,$v->f_code);
            // }
            $rs .= '</li>';
        }

        return $rs;
    }


    public function showMainUrlh1($thisv, $fcode)
    {
        $rs = '<div class="nav_about_hq clearfix"><div class="nav_about_hq_main">';
        $tmp = $this->findAll('f_type=2 AND  f_show=1 and f_level=2 and f_ishot=1 order by f_code');
        foreach ($tmp as $k => $v) {
            $rs .= '<div class="abhq_item"><h3>' . $v->f_name . '</h3>';
            $rs .= $this->showMainUrlh3($thisv, $v->f_code) . '</div>';
        }
        return $rs . '</div>';
    }

    public function showMainUrlh3($thisv, $fcode)
    {
        $rs = '';
        $rs0 = '  <a href="';
        $w0 = 'f_type=2 AND f_show=1 AND f_ishot=1 and f_level=3 ';
        $tmp = $this->findAll($w1 . ' and left(f_code,5)="' . $fcode . '" order by f_code');
        foreach ($tmp as $k => $v) {
            $rs .= $rs0 . $thisv->createUrl($v->f_url) . '" target="_blank">' . $v->f_name . '</a>';
        }
        return '<div>' . $rs . '</div>';
    }


    public function showMainUrl2($thisv, $fcode)
    {
        $rs = '<div class="nav_about_hq clearfix"><div class="nav_about_hq_main">';
        $tmp = $this->findAll('f_type=2 AND  f_show=1 and f_level=2 and left(f_code,3)="' . $fcode . '" order by f_code');
        foreach ($tmp as $k => $v) {
            $rs .= '<div class="abhq_item"><h3>' . $v->f_name . '</h3>';
            $rs .= $this->showMainUrl3($thisv, $v->f_code) . '</div>';
        }
        return $rs . '</div>';
    }

    public function showMainUrl3($thisv, $fcode)
    {
        $rs = '';
        $rs0 = '  <a href="';
        $tmp = $this->findAll('f_type=2 AND f_show=1 and f_level=3 and left(f_code,5)="' . $fcode . '" order by f_code');
        foreach ($tmp as $k => $v) {
            $rs .= $rs0 . $thisv->createUrl($v->f_url) . '" target="_blank">' . $v->f_name . '</a>';
        }
        return '<div>' . $rs . '</div>';
    }

    public function getTempFile()
    {
        /*模板文件*/
        $viewfile = 'index';
        $p0 = $this->home_site;
        $p1 = TEMPLATE_PATH . $this->theme_style_path . DS;
        $l1 = $this->home_lang;
        if (config('city_switch_on') && !empty($p0)) { // 多站点内置模板文件名
            $fin = file_exists($p1 . $p0);
            $fin2 = $p1 . 'city' . DS . $p0;
            if (!empty($global0['site_template'])) {
                $f1 = $p0 . '/' . $viewfile;
                $viewfile = ($fin2) ? "city/" . $f1 : (($fin) ? $f1 : $viewfile);
            }
        } else if (config('lang_switch_on') && !empty($l1)) { // 多语言内置模板文件名
            $fin = file_exists($p1 . $viewfile . "_{$l1}." . $this->view_suffix);
            $viewfile .= ($fin) ? "_" . $l1 : '';
        }
        // 招聘插件内置代码 end
        // 预览主页
        if (!empty($preview_templet)) {
            $viewfile = preg_replace('/\.(.*)$/i', '', $preview_templet);
        }
        $viewfile = ":" . $viewfile;
        // 招聘插件内置代码 start 
        if (file_exists('./weapp/Recruits/model/RecruitsModel.php')) {
            $recruitsModel = new \weapp\Recruits\model\RecruitsModel;
            $recruitsViewfile = $recruitsModel->setHome($this->eyou);
            if (!empty($recruitsViewfile)) {
                $this->assign('eyou', $this->eyou);
                $viewfile = $recruitsViewfile;
            }
        }
        return $viewfile;
    }

    public  function chinaHk()
    {
        $s1 = '';
        $tmp1 = $this->getProjdata('f_level=2 and left(f_code,3)="C01"');
        foreach ($tmp1 as $k1 => $v1) {
            $s1 .= '<div class="sub_title">';
            $s1 .= '<h2 style="color:blue;">' . $v1['f_adtitle'] . '' . $v1['f_adtext'] . '</h2></div>';
            $s00 = ($v1['f_code'] == 'C0130') ? 'fw' : 'ym';
            $s1 .= '<div class="cp_panel_' . $s00 . '"><ul class="cpy_list">';
            $tmp2 = $this->getProjdata('f_level=3 and left(f_code,5)="' . $v1['f_code'] . '" ');
            $s2 = '';
            foreach ($tmp2 as $k2 => $v2) {
                $s2 .= '<li><dl><dt>' . $v2['f_adtitle'] . '</dt>';
                $s2 .= '<dd>' . $v2['f_adtext'] . '';
                $s2 .= '<a class="btn" href="' . $v2['f_url'] . '" target="_blank" >查看更多</a> ';
                //    $s2.='<h3 style="color:blue;"><a href="'.$v2['f_url'].'" target="_blank" >查看詳情</a></h3>';
                $s2 .= '</dd></dl></li>';
            }
            $s1 .= $s2 . '</ul></div>';
        }
        return $s1;
    }

    public  function getProjdata($w1)
    {
        return tablefindAll('ws_sys_configs_home', $w1 . ' and f_type=3 order by f_code');
    }

    public  function getCaseAnalysis()
    {
        $rs = $this->getData('f_typecode="Y01"', '<li>', '</li>');
        $s1 = $this->getSite() . 'index.php';
        $rs = str_replace('https://www.globevisa.com.cn/zhongguoxianggang/news/64261.html', $s1, $rs);
        return $rs;
    }

    public function getShowMan()
    {
        return $this->getman();
    }
    function getman()
    {
        $tmp = tablefindAll('customer_service', '1=1');
        $rs = '';
        $p1 = $this->getSite() . 'uploads/';
        foreach ($tmp as $key => $v) {
            $v['f_pic'] = $p1 . $v['f_pic'];
            $v['f_wxcode'] = $p1 . $v['f_wxcode'];

            $rs .= $this->getOneMan($v);
        }

        return '' . $rs . $rs . $rs . '';
    }

    public function getTopAnnouncements()
    {
        return $this->topannouncements();
    }
    function topannouncements(){
        $tmp = tablefindAll('ey_archives','typeid=5 ORDER BY aid DESC');
        $rs = '';
        $rs .= $this->getOneTop();
        foreach ($tmp as $k => $v) {
            if($k<=7) $rs.= $this->getTweTop($v['aid'],$v['title']);
            if($k==3) $rs.=' </div>
                <div class="info-center__item-links flex--column">';
        }
         $rs .= $this->getEndTop();
        return '' . $rs;
    }

     function getOneTop()
    {   $s1='';
        $s1.=' </div>
            <div class="info-center__items info-center__items--hot">
        <section class="info-center__item flex--column info-center__item--hot">
               <h2 class="info-center__item-title">
                        热门公告地区
                    </h2>
            <div class="info-center__item-content--hot info-center__item-content flex--column">

                        <div class="info-center__item-link-container  flex">

                            <div class="info-center__item-links flex--column">';
        return $s1;
    }
     function getTweTop($aid,$title)
    {   
        $url='/hkshop/newsf/?m=home&c=View&a=index&aid=';
        return '<a href="'.$url.$aid.'" class="info-center__item-link--hot"> '.$title.' </a>';
    }

    function getEndTop()
    {   
        $url='/hkshop/newsf/?m=home&c=Lists&a=index&tid=5';
        return '</div></div>
              <a  href="'. $url.'" class="info-center__item-more-btn flex" >
                查看更多
              <img src="/newHome/images/right-arrow.png" alt="right-row" class="info-center__item-arrow"/>
              </a>
              </div>
              </section>
              </div>

              ';
    }

      public function getVideoCenter()
    {
        return $this->VideoCenter();
    }
    function VideoCenter(){
        $tmp = tablefindAll('ey_archives','typeid=26 ORDER BY aid DESC');
        $rs = '';
        $rs .= $this->getOneVideoCenter();
        foreach ($tmp as $k => $v) {
            if($k<=2) $rs.= $this->getTweVideoCenter($v);
        }
         $rs .= $this->getEndVideoCenter();
        return '' . $rs;
    }

     function getOneVideoCenter()
    {   
        $s1='
        <section class="info-center__item flex--column ">
                    <h2 class="info-center__item-title">
                        视频中心
                    </h2>
                    <div class="info-center__item-content--right info-center__item-content">';
        return $s1;
    }
// <video src="'.$model[0]['shipin'].'" alt="info-center--pic" class="info-center__item-img info-center__item-img--hover" controls></video>

       function getTweVideoCenter($v)
    {   $url='/hkshop/newsf/?m=home&c=View&a=index&aid=';
        $model = tablefindAll('ey_article_content','aid='.$v['aid']);
        $s1=' <div class="info-center__item-img-link info-center__item-img-link--right flex">
                            <video class="info-center__item-video" controls controlslist="nodownload noplaybackrate" disablepictureinpicture>
                                <!-- <source src="'.$model[0]['shipin'].'" type="video/mp4"> -->
                                <source src="'.$model[0]['shipin'].'" type="video/webm">
                            </video>
                            <section class="info-center__item-desc">
                                <h3 class="info-center__item-desc-title">'.$v['title'].'</h3>
                                <p class="info-center__item-desc-summary">'.$model[0]['content'].'
                                </p>
                            </section> 

                        </div>';
        return $s1;
    }
      function getEndVideoCenter()
    {   $url='/hkshop/newsf/?m=home&c=Lists&a=index&tid=26';
        $s1=' <a href="'.$url.'" class="info-center__item-more-btn flex">
                            查看更多
                            <img src="/newHome/images/right-arrow.png" alt="right-row" class="info-center__item-arrow">
                        </a>       
                    </div>
                </section>
              
                ';
        return $s1;
    }

     public function getImmigrationCentre()
    {
        return $this->ImmigrationCentre();
    }
    function ImmigrationCentre(){
        $tmp = tablefindAll('ey_archives','typeid=15 ORDER BY aid DESC');
        $rs = '';
        $rs .= $this->getOneImmigrationCentre();
        foreach ($tmp as $k => $v) {
            if($k<=5) $rs.= $this->getTweImmigrationCentre($v);
        }
         $rs .= $this->getEndImmigrationCentre();
        return '' . $rs;
    }
       function getOneImmigrationCentre()
    {   
        $s1='<section class="info-center__item flex--column info-center__item--left info-center__item--migrant">

                    <h2 class="info-center__item-title">
                        香港移民中心
                    </h2>
                    <div class="info-center__item-content--small info-center__item-content flex--column">';
        return $s1;
    }
        function getTweImmigrationCentre($v)
    {   $url='/hkshop/newsf/?m=home&c=View&a=index&aid=';
        $model= tablefindAll('ey_article_content','aid='.$v['aid']);
        $s1=' <div class="info-center__item-img-link--hover">

                            <div class="info-center__item-img-link flex info-center__item-img-link--visible info-center__item-img-link--active">
                                <img src="/newHome/images/info-center01.png" alt="info-center--pic" class="info-center__item-img info-center__item-img--visible info-center__item-img--active">
                                <a href="'.$url.$v['aid'].'" class="info-center__item-link info-center__item-link--active">
                                    '.$v['title'].'
                                </a>
                            </div>

                            <a href="'.$url.$v['aid'].'"  class="info-center__item-link">
                                '.$model[0]['content'].'
                            </a>
                        </div>';
        return $s1;
    }
       function getEndImmigrationCentre()
    {   $url='/hkshop/newsf/?m=home&c=Lists&a=index&tid=2';
        $s1='       <a href="'.$url.'" class="info-center__item-more-btn flex">
                            查看更多
                            <img src="/newHome/images/right-arrow.png" alt="right-row" class="info-center__item-arrow">
                        </a>
                    </div>
    
                </section>';
        return $s1;
    }


    function getSite()
    {
        return 'https://qmdd.net/hkshop/newsf/';
    }

    function getOneManold($v)
    {
        $ph = $v['phone'];
        $kf = 'https://qmdd.net/welive/kefu.php?a=6168';
        $mc = $ph . '8565ddd53707dd25b52b08929567c0e3';
        $s0 = " onclick='Meiqia(" . '"' . $mc . '","3",3)' . "'";
        $s1 = '<span class="fhm-cl-t"><a target="_blank" href="' . $kf . '">
        <img  src="https://qmdd.net/hkshop/newsf/' . $v['f_pic'] . '" style="margin-left: 4px"/></a></span>';
        $s1 .= '<span class="fhm-cl-b">
        <p class="tac"  attr-token="' . $mc . '">' . $v['name'] . '</p>
        <ul><li class="cur"><a class="cur" href="javascript:;" ' . $s0 . '>留言给我</a></li>
            <li><a href="javascript:;">拨打电话</a></li></ul></span>';
        $s1 .= '<span class="fhm-cl-p pa"><table><tr><td>
        <img src="' . $v['f_wxcode'] . '" class="fl" /></td><td>
        <div class="info right-div"  style="color:#555">
            <em style="color:#a67e3d;font-weight:bold;">' . $v['name'] . '</em><br />
            <em style="color:#555">邮箱：</em>appleliu@globevisa.com<br />
            <em> WhatsApp：<a class="WhatsAppClick" target="_blank" style="display: inline-block;color: #00f" href="https://api.whatsapp.com/send?phone=' . $ph . '&text=&source=&data=&app_absent=">' . $ph . '</a></em><br />
            <em style="color:#555">手机：</em>' . $ph . '<br />
        </div>
        </td></tr><tr><td colspan="2">
        <p class="fl" style="color:#555"><em style="color:#555">' . $v['f_memo'] . '</p>
        </td></tr></table></span>';
        return '<li class="pr fhm-cl-li">' . $s1 . '</li>';
    }

    function getOneMan($v)
    {
        $ph = $v['phone'];
        $wxqr = $v['f_wxcode'];
        $emall = 'appleliu@globevisa.com';
        $wx = '17724109343';
        $kf = 'https://qmdd.net/welive/kefu.php?a=6168';
        $mc = $ph . '8565ddd53707dd25b52b08929567c0e3';
        $s0 = " onclick='Meiqia(" . '"' . $mc . '","3",3)' . "'";
        $rs1 .= '<li class="slider-item flex--column">
        <img src="' . $v['f_pic'] . '" alt="" class="slider-item-img">
        <span class="slider-item-name">' . $v['name'] . '</span>
        <button class="msg-btn">留言给我</button>
        <button class="call-btn">拨打电话</button>

        <article class="profile-card">
            <header class="profile-card-header flex">
              <img src="' . $wxqr . '" alt="" class="profile-img">
              <section class="profile-details">
                <span class="profile-name">' . $v['name'] . '</span>
                <ul class="profile-contact-list">
                  <li class="profile-contact-item">邮箱：' . $emall . '</li>
                  <li class="profile-contact-item">WhatsApp：' . $wx . '</li>
                  <li class="profile-contact-item">手机：' . $ph . '</li>
                </ul>
              </section>
            </header>
            <footer class="profile-card-footer">
              <p class="profile-info">' . $v['f_memo'] . '</p>
            </footer>
        </article>
    </li>';
        return $rs1;
    }

    function getSuccCase()
    {
        $rs = '';
        return $rs . $rs . $rs;
    }

    function getReview()
    {
        $rs = ' <section class="swiper__item--profess">
                            <h3 class="swiper__item-title--profess">她们每个都很敬业，责任心强，态度积极主动。<br><span class="swiper__text--end">——Y女士1</span></h3>
                            <p class="swiper__item-details--profess">
                                今天已经在你们环球出国的Summer陈盈颖，Rachel陈婷婷，Sharon李璇等所有成员的帮助下办好了所有菲律宾SRRV项目
                            </p >
                            <a href="#" class="swiper__link--profess flex">
                                详情
                                <img src="/newHome/images/right-arrow.png" alt="right-arrow" class="swiper__arrow--profess">
                            </a >
                        </section>';
        return $rs . $rs . $rs;
    }

    function getData($w1, $start, $end)
    {
        $tmp = tablefindAll('ey_archives', $w1);
        $rs = '';
        foreach ($tmp as $key => $v) {
            $rs .= $start . $v['reason'] . $end . chr(13) . chr(10);
        }

        return $rs;
    }

    public function getUrls($ac = '')
    {
        $s0 = 'index:首页,job:找工作,resume:找人才,part:兼职,company:公司,article:新闻公告,hr:工具箱,zph:招聘会,';
        $s0 .= 'ask:问答,evaluate:测评,once:店铺,tiny:普工,redeem:商城,map:地图,special:专题,login:登录注册,other:其它';
        if (indexof($s0, $ac) < 0) $ac = 'index';
        $ac = (empty($ac)) ? 'index' : $ac;
        $s1 = '';
        $d = explode(',', $s0);
        foreach ($d as $key => $value) {
            $d1 = explode(':', $value);
            $s1 .= $this->getSpanUrls($ac, $d1[0], $d1[1]);
        }
        return '<div class="seo_sx">' . $s1 . '</div>';
    }

    public function getSpanUrls($ac, $acname, $title)
    {
        $s0 = ($ac == $acname) ? ' seo_sx_cur' : '';
        $s1 = '<a href="index.php?r=seourl/proc&action=' . $acname . '">' . $title . '</a>';
        return '<span class="seo_sx_a ' . $s0 . '">' . $s1 . '</span>';
    }

    /**
     * 微信支付回调
     */
    private function wechat_return()
    {
        // 获取回调的参数
        $inputXml = file_get_contents("php://input");
        if (!empty($inputXml)) {
            // 解析参数
            $jsonXml = json_encode(simplexml_load_string($inputXml, 'SimpleXMLElement', LIBXML_NOCDATA));
            // 转换数组
            $jsonArr = json_decode($jsonXml, true);
            // 是否与支付成功
            if (!empty($jsonArr) && 'SUCCESS' == $jsonArr['result_code'] && 'SUCCESS' == $jsonArr['return_code']) {
                // 解析判断参数是否为微信支付
                $attach = explode('|,|', $jsonArr['attach']);
                if (!empty($attach) && 'wechat' == $attach[0] && 'is_notify' == $attach[1] && !empty($attach[2])) {
                    if (!empty($attach[4]) && !empty($attach[5]) && 'applets' == $attach[5]) {
                        $config = model('ShopPublicHandle')->getSpecifyAppletsConfig($attach[4], 'weixin');
                    } else if (empty($attach[4]) && !empty($attach[5]) && 'applets' == $attach[5] && !empty($attach[6])) {
                        $config = model('ShopPublicHandle')->getSpecifyAppletsConfig(0, '', $attach[6]);
                    } else {
                        $config = Db::name('pay_api_config')->where('pay_mark', $attach[0])->value('pay_info');
                        $config = !empty($config) ? unserialize($config) : [];
                    }
                    if (!empty($config) && !empty($config['appid']) || stristr($inputXml, "[{$config['appid']}]")) {
                        model('ShopPublicHandle')->getWeChatPayResult($attach[3], $jsonArr, $attach[2], $config, true, true);
                    }
                }
            }
        }
    }

    /**
     * 抖音支付回调
     */
    private function tikTok_return()
    {
        $inputData = file_get_contents("php://input");
        if (!empty($inputData)) {
            $inputData = json_decode($inputData, true);
            $s1 = $inputData['msg'];
            $inputData['msg'] = !empty($s1) ? json_decode($s1, true) : [];
            if (!empty($s1)) model('TikTok')->tikTokAppletsPayDealWith($inputData, true);
        }
    }

    /**
     * 支付宝支付回调
     */
    private function alipay_return()
    {
        $param = input('param.');
        if (isset($param['transaction_type']) && isset($param['is_notify']) && isset($param['person_pay']) && isset($param['users_id'])) {
            // 跳转处理回调信息
            $personPayWeapp = model('ShopPublicHandle')->getWeappInfo('PersonPay');
            if (!empty($personPayWeapp['status'])) {
                $personPayLogic = new \weapp\PersonPay\logic\PersonPayLogic($personPayWeapp['config']);
                $personPayLogic->asyncNotifyHandle($param);
            }
        } else if (isset($param['transaction_type']) && isset($param['is_notify'])) {
            // 跳转处理回调信息
            $pay_logic = new PayLogic();
            $pay_logic->alipay_return();
        }
    }

    /**
     * 百度支付回调
     */
    private function baiduPay_return()
    {
        $param = input('param.');
        $pd1 = $param['returnData'];
        if (!empty($pd1)) {
            $pd1 = json_decode(htmlspecialchars_decode($pd1), true);
            $ps1 = $param['status'];
            $param['returnData'] = $pd1;

            if (empty($param['tpOrderId']) || empty($ps1) || 2 !== intval($ps1)) return false;
            if (empty($pd1['payType']) || 'baiduPay' !== trim($pd1['payType'])) return false;
            if (empty($pd1['usersID']) || empty($pd1['orderCode']) || empty($pd1['table'])) return false;
            // 查询配置信息
            $config = model('ShopPublicHandle')->getSpecifyAppletsConfig($pd1['appletsID'], 'baidu');
            $baiduPayModel = new \app\common\model\BaiduPay($config);
            $baiduPayModel->baiDuAppletsPayDealWith($param, true, $pd1['table']);
        }
    }

    /**
     * 快递100返回时，重定向关闭父级弹框
     */
    private function Express100()
    {
        $coname = input('param.coname/s', '');
        $m = input('param.m/s', '');
        if (!empty($coname) || 'user' == $m) {
            $s1 = (isWeixin()) ? 'user/Shop/shop_centre' : 'api/Rewrite/close_parent_layer';
            $this->redirect(url($s1));
            exit;
        }
    }

    /**
     * 无效链接跳转404
     */
    private function ey_agent()
    {
        $ey_agent = input('param.ey_agent/d', 0);
        if (!IS_AJAX && !empty($ey_agent) && 'home' == MODULE_NAME) {
            abort(404, '页面不存在');
        }
    }

  
}
