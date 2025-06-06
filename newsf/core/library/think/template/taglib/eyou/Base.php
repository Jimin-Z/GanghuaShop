<?php
/**
 * 新闻通
 * ============================================================================
 * 版权所有 新闻通 同一科技有限公司，并保留所有权利。
 * 
 * ----------------------------------------------------------------------------
，
 * ============================================================================
 * Author: 新闻通  4035172988@qq.com
 * Date: 2024-06-18
 */

namespace think\template\taglib\eyou;

use think\Db;
use think\Request;

/**
 * 基类
 */
class Base
{
    /**
     * 子目录
     */
    public $root_dir = '';

    static $request = null;

    /**
     * 当前栏目ID
     */
    public $tid = 0;

    /**
     * 当前文档aid
     */
    public $aid = 0;

    /**
     * 是否开启多语言
     */
    static $lang_switch_on = null;

    /**
     * 前台当前语言
     */
    public $lang = null;

    /**
     * 主体语言（语言列表中最早一条）
     */
    static $main_lang = null;

    /**
     * 前台当前语言
     */
    static $home_lang = null;

    /**
     * 是否开启多城市站点
     */
    static $city_switch_on = null;

    /**
     * 前台当前城市站点
     */
    static $home_site = '';

    /**
     * 当前城市站点ID
     */
    static $siteid = null;

    /**
     * 当前城市站点信息
     */
    static $site_info = null;
    
    public $php_sessid = '';

    /**
     * 多语言分离
     */
    static $language_split = null;

    /**
     * 全部文档的数据
     * @var array
     */
    static $archivesData = null;

    //构造函数
    function __construct()
    {
        // 控制器初始化
        $this->_initialize();
    }

    // 初始化
    protected function _initialize()
    {
        $this->php_sessid = !empty($_COOKIE['PHPSESSID']) ? $_COOKIE['PHPSESSID'] : '';
        if (null == self::$request) {
            self::$request = Request::instance();
        }

        $this->root_dir = ROOT_DIR; // 子目录安装路径
        // 多语言
        if (null === self::$main_lang) {
            self::$main_lang = get_main_lang();
            self::$home_lang = get_home_lang();
        }
        $this->lang = self::$home_lang;
        // 多语言分离
        if (null === self::$language_split) self::$language_split = tpCache('language.language_split');

        /*多城市*/
        self::$home_site = get_home_site();
        null === self::$city_switch_on && self::$city_switch_on = config('city_switch_on');
        if (self::$city_switch_on && null === self::$site_info) {
            if (!empty(self::$home_site)) {
                self::$site_info = Db::name('citysite')->where('domain', self::$home_site)->cache(true, EYOUCMS_CACHE_TIME, 'citysite')->find();
            } else {
                $site_info = cookie('site_info');
                self::$site_info = empty($site_info) ? [] : (array)json_decode($site_info);
            }
        }
        if (!empty(self::$site_info)) {
            self::$siteid = self::$site_info['id'];
        }
        self::$siteid = intval(self::$siteid);

        $this->tid = input("param.tid/s", '');
        $this->tid = getTrueTypeid($this->tid); // tid为目录名称的情况下

        $this->aid = input("param.aid/s", '');
        $this->aid = getTrueAid($this->aid); // 在aid传值为自定义文件名的情况下

        if (null === self::$archivesData) {
            if ('Buildhtml' == CONTROLLER_NAME) {
                self::$archivesData = $this->get_archivesData($this->aid);
            }
        }
        self::$archivesData = !empty(self::$archivesData) ? self::$archivesData : [];
    }

    //查询虎皮椒支付有没有配置相应的(微信or支付宝)支付
    public function findHupijiaoIsExis($type = '')
    {
        $hupijiaoInfo = Db::name('weapp')->where(['code'=>'Hupijiaopay','status'=>1])->find();
        $HupijiaoPay = Db::name('pay_api_config')->where(['pay_mark'=>'Hupijiaopay'])->find();
        if (empty($HupijiaoPay) || empty($hupijiaoInfo)) return true;
        if (empty($HupijiaoPay['pay_info'])) return true;
        $PayInfo = unserialize($HupijiaoPay['pay_info']);
        if (empty($PayInfo)) return true;
        if (!isset($PayInfo['is_open_pay']) || $PayInfo['is_open_pay'] == 1) return true;
        $type .= '_appid';
        if (!isset($PayInfo[$type]) || empty($PayInfo[$type])) return true;

        return false;
    }

    public function get_aid_typeid($aid = 0)
    {
        if (!empty(self::$archivesData[$aid])) {
            $typeid = self::$archivesData[$aid];
        } else {
            $cacheKey = 'table-archives-aid-'.$aid;
            $archivesInfo = cache($cacheKey);
            if (empty($archivesInfo)) {
                $archivesInfo = Db::name('archives')->field('typeid')->where('aid', $aid)->find();
                cache($cacheKey, $archivesInfo, null, 'archives');
            }
            $typeid = !empty($archivesInfo['typeid']) ? intval($archivesInfo['typeid']) : 0;
        }

        return $typeid;
    }

    /**
     * 根据aid获取对应所在的缓存文件
     * @return [type] [description]
     */
    private function get_archivesData($aid = 0)
    {
        if (empty($aid)) {
            return [];
        }

        $pagesize = 15000;
        $start = intval($aid / $pagesize) * $pagesize;
        $end = $start + $pagesize;
        $cacheKey = "table_archives_{$start}_{$end}";
        $result = cache($cacheKey);

        return $result;
    }

    /*
     *  会员组相关文档查询条件补充
     */
    protected function diy_get_users_group_archives_query_builder($alias = '')
    {
        $where_str = "";
        if (is_dir('./weapp/UsersGroup/')) {
            try {        //注册会员设置初始化
                $usersGroupLogic = new \weapp\UsersGroup\logic\UsersGroupLogic();
                $where_str = $usersGroupLogic->get_archives_query_builder($alias);
            } catch (\Exception $e) {
            }
        }

        return $where_str;
    }

    /*
     *  会员组相关栏目查询条件补充
     */
    protected function diy_get_users_group_arctype_query_builder($alias = '')
    {
        $where_str = "";
        if (is_dir('./weapp/UsersGroup/')) {
            try {        //注册会员设置初始化
                $usersGroupLogic = new \weapp\UsersGroup\logic\UsersGroupLogic();
                $where_str = $usersGroupLogic->get_arctype_query_builder($alias);
            } catch (\Exception $e) {
            }
        }

        return $where_str;
    }

    /**
     * 城市分站的特殊标签替换
     * @param  string $value [description]
     * @return [type]        [description]
     */
    protected function citysite_replace_string($value = '')
    {
        if (!self::$city_switch_on || empty(self::$siteid)) {
            $value = str_ireplace(['{region}','{regionAll}','{parent}','{top}'], '', $value);
        }
        return $value;
    }

    /**
     * 多城市分站与全国的显示逻辑
     * @param  array  &$condition   [description]
     * @param  [type] $site_showall [description]
     * @param  [type] $siteall      [description]
     * @return [type]               [description]
     */
    protected function site_show_archives(&$condition = [], $logic_type = 'archives', $site_showall = null, $siteall = null)
    {
        // 多城市站点
        if (self::$city_switch_on) {
            static $site_config = null;
            if (null === $site_config) {
                $site_config = tpCache('site');
            }
            if (!empty(self::$site_info)) {
                if (self::$site_info['level'] == 1) { // 省份
                    // 包含全国、当前省份
                    if ($siteall != null){  //标签属性控制
                        $province_where = [self::$siteid];
                        if(!empty($siteall)){  //显示主站
                            $province_where[] = 0;
                        }
                        if (!empty($site_config['site_showsuball'])) {
                            $condition[] = Db::raw(" a.province_id IN (".implode(',', $province_where).") ");
                        } else {
                            $condition[] = Db::raw(" (a.province_id IN (".implode(',', $province_where).") AND a.city_id = 0) ");
                        }
                    }
                    else if(empty(self::$site_info['showall'])){   //分站点配置信息不显示主站信息
                        if (!empty($site_config['site_showsuball'])) {
                            $condition[] = Db::raw(" a.province_id = ".self::$siteid." ");
                        } else {
                            $condition[] = Db::raw(" (a.province_id = ".self::$siteid." AND a.city_id = 0) ");
                        }
                    }
                    else{
                        $province_where = [self::$siteid,0];
                        if (!empty($site_config['site_showsuball'])) {
                            $condition[] = Db::raw(" a.province_id IN (".implode(',', $province_where).") ");
                        } else {
                            $condition[] = Db::raw(" (a.province_id IN (".implode(',', $province_where).") AND a.city_id = 0) ");
                        }
                    }
                } else if (self::$site_info['level'] == 2) { // 城市
                    // 包含全国、当前城市
                    if ($siteall != null){  //标签属性控制
                        $province_where = '';
                        if(!empty($siteall)){  //显示主站
                            $province_where = ' OR a.province_id = 0 ';
                        }
                        if (!empty($site_config['site_showsuball'])) {
                            $condition[] = Db::raw(" (a.city_id = ".self::$siteid." {$province_where} ) ");
                        } else {
                            $condition[] = Db::raw(" ((a.city_id = ".self::$siteid." AND a.area_id = 0) {$province_where} ) ");
                        }
                    }
                    else if(empty(self::$site_info['showall'])){   //分站点配置信息,不显示主站信息
                        if (!empty($site_config['site_showsuball'])) {
                            $condition[] = Db::raw(" a.city_id = ".self::$siteid." ");
                        } else {
                            $condition[] = Db::raw(" (a.city_id = ".self::$siteid." AND a.area_id = 0) ");
                        }
                    }
                    else{  //分站点配置信息,显示主站信息
                        if (!empty($site_config['site_showsuball'])) {
                            $condition[] = Db::raw(" (a.city_id = ".self::$siteid." OR a.province_id = 0) ");
                        } else {
                            $condition[] = Db::raw(" ((a.city_id = ".self::$siteid." AND a.area_id = 0) OR a.province_id = 0 ) ");
                        }
                    }
                    // 包含全国、全省、当前城市
                    // $citysiteInfo = Db::name('citysite')->where(['id'=>self::$siteid])->cache(true, EYOUCMS_CACHE_TIME, 'citysite')->find();
                    // $condition[] = Db::raw(" ((a.city_id IN (".self::$siteid.",0) AND a.province_id = ".$citysiteInfo['parent_id'].") OR (a.province_id = 0)) ");
                } else { // 区域
                    // 包含全国、当前区域
                    if ($siteall != null){  //标签属性控制
                        $province_where = '';
                        if(!empty($siteall)){  //显示主站
                            $province_where = ' OR a.province_id = 0 ';
                        }
                        $condition[] = Db::raw(" (a.area_id = ".self::$siteid." {$province_where} ) ");
                    }
                    else if(empty(self::$site_info['showall'])){   //分站点配置信息,不显示主站信息
                        $condition[] = Db::raw("a.area_id = ".self::$siteid);
                    }
                    else{  //分站点配置信息,显示主站信息
                        $condition[] = Db::raw(" (a.area_id = ".self::$siteid." OR a.province_id = 0 ) ");
                    }
                    // 包含全国、全省、全城市
                    // $citysiteInfo = Db::name('citysite')->where(['id'=>self::$siteid])->cache(true, EYOUCMS_CACHE_TIME, 'citysite')->find();
                    // $condition[] = Db::raw(" ((a.area_id IN (".self::$siteid.",0) AND a.city_id = ".$citysiteInfo['parent_id'].") OR (a.province_id = ".$citysiteInfo['topid']." AND a.city_id = 0) OR (a.province_id = 0)) ");
                }
            }
            else { //以下为主站内容展示
                if (null === $site_showall) {
                    $site_showall = !empty($site_config['site_showall']) ? intval($site_config['site_showall']) : 0; // 多城市站点 - 全国是否显示分站的文档
                }
                if ($siteall != null){    //标签属性控制
                    if (empty($siteall)){      //不显示分站文档
                        $condition[] = Db::raw("a.province_id = 0");
                    }else{    //显示分站文档

                    }
                }
                else if (empty($site_showall)) {    //主页不显示分站文档
                    $condition[] = Db::raw("a.province_id = 0");
                }
            }
        }
        return $condition;
    }
}