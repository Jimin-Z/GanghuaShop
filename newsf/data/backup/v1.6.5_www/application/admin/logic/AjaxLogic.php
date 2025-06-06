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

namespace app\admin\logic;

use think\Config;
use think\Model;
use think\Db;

/**
 * 逻辑定义
 * Class CatsLogic
 * @package admin\Logic
 */
class AjaxLogic extends Model
{
    private $request = null;
    private $admin_lang = 'cn';
    private $main_lang = 'cn';

    /**
     * 析构函数
     */
    function  __construct() {
        $this->request = request();
        $this->admin_lang = get_admin_lang();
        $this->main_lang = get_main_lang();
    }

    /**
     * 进入登录页面需要异步处理的业务
     */
    public function login_handle()
    {
        // $this->repairAdmin(); // 修复管理员ID为0的问题
        $this->saveBaseFile(); // 存储后台入口文件路径，比如：/login.php
        clear_session_file(); // 清理过期的data/session文件
    }

    /**
     * 修复管理员
     * @return [type] [description]
     */
    private function repairAdmin()
    {
        $row = [];
        $result = Db::name('admin')->field('admin_id,user_name')->order('add_time asc')->select();
        $total = count($result);
        foreach ($result as $key => $val) {
            $pre_admin_id = $next_admin_id = 0;
            if (empty($val['admin_id'])) {
                if (1 == $total) {
                    Db::name('admin')->where(['user_name'=>$val['user_name']])->update(['admin_id'=>1, 'update_time'=>getTime()]);
                } else {
                    $pre_admin_id = empty($key) ? 0 : $result[$key - 1]['admin_id'];
                    if ($key < ($total - 1)) {
                        $next_admin_id = $result[$key + 1]['admin_id'];
                    } else {
                        $next_admin_id = $pre_admin_id + 2;
                    }

                    if (($next_admin_id - $pre_admin_id) >= 2) {
                        $admin_id = $pre_admin_id + 1;
                        Db::name('admin')->where(['user_name'=>$val['user_name']])->update(['admin_id'=>$admin_id, 'update_time'=>getTime()]);
                    }
                }
            }
        }
    }

    /**
     * 清理未存在的左侧菜单
     * @return [type] [description]
     */
    public function admin_menu_clear()
    {
        $del_ids = [];
        $codeArr = Db::name('weapp')->column('code');
        $list = Db::name('admin_menu')->where(['controller_name'=>'Weapp','action_name'=>'execute'])->select();
        foreach ($list as $key => $val) {
            $code = preg_replace('/^(.*)\|sm\|([^\|]+)\|sc\|(.*)$/i', '${2}', $val['param']);
            if (!in_array($code, $codeArr)) {
                $del_ids[] = $val['id'];
            }
        }
        if (!empty($del_ids)) {
            Db::name('admin_menu')->where(['id'=>['IN', $del_ids]])->delete();
        }
    }

    /**
     * 进入欢迎页面需要异步处理的业务
     */
    public function welcome_handle()
    {
        getVersion('version_themeusers', 'v1.0.1', true);
        getVersion('version_themeshop', 'v1.0.1', true);
        $this->addChannelFile(); // 自动补充自定义模型的文件
        $this->saveBaseFile(); // 存储后台入口文件路径，比如：/login.php
        $this->renameInstall(); // 重命名安装目录，提高网站安全性
        $this->renameSqldatapath(); // 重命名数据库备份目录，提高网站安全性
        $this->del_adminlog(); // 只保留最近一个月的操作日志
        model('Member')->batch_update_userslevel(); // 批量更新会员过期等级
        // tpversion(); // 统计装载量，请勿删除，谢谢支持！
    }
    
    /**
     * 自动补充自定义模型的文件
     */
    public function addChannelFile()
    {
        try {
            $list = Db::name('channeltype')->where([
                'ifsystem'  => 0,
                ])->select();
            if (!empty($list)) {
                $cmodSrc = "data/model/application/common/model/CustomModel.php";
                $cmodContent = @file_get_contents($cmodSrc);
                $hctlSrc = "data/model/application/home/controller/CustomModel.php";
                $hctlContent = @file_get_contents($hctlSrc);
                $hmodSrc = "data/model/application/home/model/CustomModel.php";
                $hmodContent = @file_get_contents($hmodSrc);
                foreach ($list as $key => $val) {
                    $file = "application/common/model/{$val['ctl_name']}.php";
                    if (!file_exists($file)) {
                        $cmodContent = str_replace('CustomModel', $val['ctl_name'], $cmodContent);
                        $cmodContent = str_replace('custommodel', strtolower($val['nid']), $cmodContent);
                        $cmodContent = str_replace('CUSTOMMODEL', strtoupper($val['nid']), $cmodContent);
                        @file_put_contents($file, $cmodContent);
                    }
                    $file = "application/home/controller/{$val['ctl_name']}.php";
                    if (!file_exists($file)) {
                        $hctlContent = str_replace('CustomModel', $val['ctl_name'], $hctlContent);
                        $hctlContent = str_replace('custommodel', strtolower($val['nid']), $hctlContent);
                        $hctlContent = str_replace('CUSTOMMODEL', strtoupper($val['nid']), $hctlContent);
                        @file_put_contents($file, $hctlContent);
                    }
                    $file = "application/home/model/{$val['ctl_name']}.php";
                    if (!file_exists($file)) {
                        $hmodContent = str_replace('CustomModel', $val['ctl_name'], $hmodContent);
                        $hmodContent = str_replace('custommodel', strtolower($val['nid']), $hmodContent);
                        $hmodContent = str_replace('CUSTOMMODEL', strtoupper($val['nid']), $hmodContent);
                        @file_put_contents($file, $hmodContent);
                    }
                }
            }
        } catch (\Exception $e) {}
    }
    
    /**
     * 只保留最近一个月的操作日志
     */
    public function del_adminlog()
    {
        try {
            $is_system = true;
            if (file_exists(ROOT_PATH.'weapp/Systemdoctor/logic/SystemdoctorLogic.php')) {
                $systemdoctorLogic = new \weapp\Systemdoctor\logic\SystemdoctorLogic;
                if (method_exists($systemdoctorLogic, 'del_adminlog')) {
                    $is_system = false;
                    $systemdoctorLogic->del_adminlog();
                }
            }
            if ($is_system) {
                $mtime = strtotime("-1 month");
                Db::name('admin_log')->where([
                    'log_time'  => ['lt', $mtime],
                    ])->delete();
            }
        } catch (\Exception $e) {}
    }

    /*
     * 修改备份数据库目录
     */
    private function renameSqldatapath() {
        $default_sqldatapath = config('DATA_BACKUP_PATH');
        if (is_dir('.'.$default_sqldatapath)) { // 还是符合初始默认的规则的链接方式
            $dirname = get_rand_str(20, 0, 1);
            $new_path = '/data/sqldata_'.$dirname;
            if (@rename(ROOT_PATH.ltrim($default_sqldatapath, '/'), ROOT_PATH.ltrim($new_path, '/'))) {
                /*多语言*/
                if (is_language()) {
                    $langRow = \think\Db::name('language')->order('id asc')->select();
                    foreach ($langRow as $key => $val) {
                        tpCache('web', ['web_sqldatapath'=>$new_path], $val['mark']);
                    }
                } else { // 单语言
                    tpCache('web', ['web_sqldatapath'=>$new_path]);
                }
                /*--end*/
            }
        }
    }

    /**
     * 重命名安装目录，提高网站安全性
     * 在 Admin@login 和 Index@index 操作下
     */
    private function renameInstall()
    {
        if (stristr($this->request->host(), 'eycms.hk')) {
            return true;
        }
        $install_path = ROOT_PATH.'install';
        if (is_dir($install_path) && file_exists($install_path)) {
            $install_time = get_rand_str(20, 0, 1);
            $new_path = ROOT_PATH.'install_'.$install_time;
            @rename($install_path, $new_path);
        }
        else {
            $dirlist = glob('install_*');
            $install_dirname = current($dirlist);
            if (!empty($install_dirname)) {
                /*---修补v1.1.6版本删除的安装文件 install.lock start----*/
                if (!empty($_SESSION['isset_install_lock'])) {
                    return true;
                }
                $_SESSION['isset_install_lock'] = 1;
                /*---修补v1.1.6版本删除的安装文件 install.lock end----*/

                $install_path = ROOT_PATH.$install_dirname;
                if (preg_match('/^install_[0-9]{10}$/i', $install_dirname)) {
                    $install_time = get_rand_str(20, 0, 1);
                    $install_dirname = 'install_'.$install_time;
                    $new_path = ROOT_PATH.$install_dirname;
                    if (@rename($install_path, $new_path)) {
                        $install_path = $new_path;
                        /*多语言*/
                        if (is_language()) {
                            $langRow = \think\Db::name('language')->order('id asc')->select();
                            foreach ($langRow as $key => $val) {
                                tpSetting('install', ['install_dirname'=>$install_time], $val['mark']);
                            }
                        } else { // 单语言
                            tpSetting('install', ['install_dirname'=>$install_time]);
                        }
                        /*--end*/
                    }
                }

                $filename = $install_path.DS.'install.lock';
                if (!file_exists($filename)) {
                    @file_put_contents($filename, '');
                }
            }
        }
    }

    /**
     * 存储后台入口文件路径，比如：/login.php
     * 在 Admin@login 和 Index@index 操作下
     */
    private function saveBaseFile()
    {
        $data = [];
        $data['web_adminbasefile'] = $this->request->baseFile();
        $data['web_cmspath'] = ROOT_DIR; // EyouCMS安装目录
        /*多语言*/
        if (is_language()) {
            $langRow = \think\Db::name('language')->field('mark')->order('id asc')->select();
            foreach ($langRow as $key => $val) {
                tpCache('web', $data, $val['mark']);
            }
        } else { // 单语言
            tpCache('web', $data);
        }
        /*--end*/
    }

    /**
     * 升级前台会员中心的模板文件
     */
    public function update_template($type = '')
    {
        if (!empty($type)) {
            if ('users' == $type) {
                if (file_exists(ROOT_PATH.'template/'.TPL_THEME.'pc/users') || file_exists(ROOT_PATH.'template/'.TPL_THEME.'mobile/users')) {
                    $upgrade = getDirFile(DATA_PATH.'backup'.DS.'tpl');
                    if (!empty($upgrade) && is_array($upgrade)) {
                        delFile(DATA_PATH.'backup'.DS.'template_www');
                        // 升级之前，备份涉及的源文件
                        foreach ($upgrade as $key => $val) {
                            $val_tmp = str_replace("template/", "template/".TPL_THEME, $val);
                            $source_file = ROOT_PATH.$val_tmp;
                            if (file_exists($source_file)) {
                                $destination_file = DATA_PATH.'backup'.DS.'template_www'.DS.$val_tmp;
                                tp_mkdir(dirname($destination_file));
                                @copy($source_file, $destination_file);
                            }
                        }

                        // 递归复制文件夹
                        $this->recurse_copy(DATA_PATH.'backup'.DS.'tpl', rtrim(ROOT_PATH, DS));
                    }
                    /*--end*/
                }
            }
        }
    }

    /**
     * 自定义函数递归的复制带有多级子目录的目录
     * 递归复制文件夹
     *
     * @param string $src 原目录
     * @param string $dst 复制到的目录
     * @return string
     */                        
    //参数说明：            
    //自定义函数递归的复制带有多级子目录的目录
    private function recurse_copy($src, $dst)
    {
        $planPath_pc = "template/".TPL_THEME."pc/";
        $planPath_m = "template/".TPL_THEME."mobile/";
        $dir = opendir($src);

        /*pc和mobile目录存在的情况下，才拷贝会员模板到相应的pc或mobile里*/
        $dst_tmp = str_replace('\\', '/', $dst);
        $dst_tmp = rtrim($dst_tmp, '/').'/';
        if (stristr($dst_tmp, $planPath_pc) && file_exists($planPath_pc)) {
            tp_mkdir($dst);
        } else if (stristr($dst_tmp, $planPath_m) && file_exists($planPath_m)) {
            tp_mkdir($dst);
        }
        /*--end*/

        while (false !== $file = readdir($dir)) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $needle = '/template/'.TPL_THEME;
                    $needle = rtrim($needle, '/');
                    $dstfile = $dst . '/' . $file;
                    if (!stristr($dstfile, $needle)) {
                        $dstfile = str_replace('/template', $needle, $dstfile);
                    }
                    $this->recurse_copy($src . '/' . $file, $dstfile);
                }
                else {
                    if (file_exists($src . DIRECTORY_SEPARATOR . $file)) {
                        /*pc和mobile目录存在的情况下，才拷贝会员模板到相应的pc或mobile里*/
                        $rs = true;
                        $src_tmp = str_replace('\\', '/', $src . DIRECTORY_SEPARATOR . $file);
                        if (stristr($src_tmp, $planPath_pc) && !file_exists($planPath_pc)) {
                            continue;
                        } else if (stristr($src_tmp, $planPath_m) && !file_exists($planPath_m)) {
                            continue;
                        }
                        /*--end*/
                        $rs = @copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
                        if($rs) {
                            @unlink($src . DIRECTORY_SEPARATOR . $file);
                        }
                    }
                }
            }
        }
        closedir($dir);
    }
    
    // 记录当前是多语言还是单语言到文件里
    public function system_langnum_file()
    {
        model('Language')->setLangNum();
    }
    
    // 记录当前是否多站点到文件里
    public function system_citysite_file()
    {
        $key = base64_decode('cGhwLnBocF9zZXJ2aWNlbWVhbA==');
        $value = tpCache($key);
        if (2 > $value) {
            /*多语言*/
            if (is_language()) {
                $langRow = Db::name('language')->order('id asc')->select();
                foreach ($langRow as $key => $val) {
                    tpCache('web', ['web_citysite_open'=>0], $val['mark']);
                }
            } else { // 单语言
                tpCache('web', ['web_citysite_open'=>0]);
            }
            /*--end*/
            model('Citysite')->setCitysiteOpen();
        }
    }

    public function admin_logic_1609900642()
    {
        // 更新自定义的样式表文件
        $version = getVersion();
        $syn_admin_logic_1697156935 = tpSetting('syn.admin_logic_1697156935', [], 'cn');
        if ($version != $syn_admin_logic_1697156935) {
            $r = $this->admin_update_theme_css();
            if ($r !== false) {
                tpSetting('syn', ['admin_logic_1697156935'=>$version], 'cn');
            }
        }

        $vars1 = 'cGhwLnBo'.'cF9zZXJ2aW'.'NlaW5mbw==';
        $vars1 = base64_decode($vars1);
        $data = tpCache($vars1);
        $data = mchStrCode($data, 'DECODE');
        $data = json_decode($data, true);
        if (empty($data['pid']) || 2 > $data['pid']) return true;
        $file = "./data/conf/{$data['code']}.txt";
        $vars2 = 'cGhwX3Nl'.'cnZpY2V'.'tZWFs';
        $vars2 = base64_decode($vars2);
        if (!file_exists($file)) {
            /*多语言*/
            if (is_language()) {
                $langRow = \think\Db::name('language')->order('id asc')->select();
                foreach ($langRow as $key => $val) {
                    tpCache('php', [$vars2=>1], $val['mark']);
                }
            } else { // 单语言
                tpCache('php', [$vars2=>1]);
            }
            /*--end*/
        } else {
            /*多语言*/
            if (is_language()) {
                $langRow = \think\Db::name('language')->order('id asc')->select();
                foreach ($langRow as $key => $val) {
                    tpCache('php', [$vars2=>$data['pid']], $val['mark']);
                }
            } else { // 单语言
                tpCache('php', [$vars2=>$data['pid']]);
            }
            /*--end*/
        }
    }

    /**
     * 更新后台自定义的样式表文件
     * @return [type] [description]
     */
    public function admin_update_theme_css()
    {
        $r = false;
        $file = APP_PATH.'admin/template/public/theme_css.htm';
        if (file_exists($file)) {
            $view = \think\View::instance(\think\Config::get('template'), \think\Config::get('view_replace_str'));
            $view->assign('global', tpCache('global'));
            $css = $view->fetch($file);
            $css = str_replace(['<style type="text/css">','</style>'], '', $css);
            @chmod($file, 0755);
            $r = @file_put_contents(ROOT_PATH.'public/static/admin/css/theme_style.css', $css);
        }

        return $r;
    }

    /**
     * 更新会员中心自定义的样式表文件
     * @return [type] [description]
     */
    public function users_update_theme_css()
    {
        
    }

    // 评价主表评分由原先的(好评、中评、差评)转至实际星评数(1、2、3、4、5)(v1.6.1节点去掉)
    public function admin_logic_1651114275()
    {
        $Prefix = config('database.prefix');
        $isTable = Db::query('SHOW TABLES LIKE \''.$Prefix.'shop_order_comment\'');
        if (!empty($isTable)) {
            $orderCommentTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}shop_order_comment");
            $orderCommentTableInfo = get_arr_column($orderCommentTableInfo, 'Field');
            if (!empty($orderCommentTableInfo) && !in_array('is_new_comment', $orderCommentTableInfo)){
                $sql = "ALTER TABLE `{$Prefix}shop_order_comment` ADD COLUMN `is_new_comment`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否新版评价：0否，1是' AFTER `is_anonymous`;";
                @Db::execute($sql);
                schemaTable('shop_order_comment');
            }
        }
    }

    public function admin_logic_1623036205()
    {
        $getTableInfo = [];
        $Prefix = config('database.prefix');

        $arr = [
            ROOT_PATH."application/admin/model/UsersLevel.php",
            ROOT_PATH."core/library/think/verify/bgs/3e.jpg",
            ROOT_PATH."public/plugins/Ueditor/lang/en/images/imglabel1.png",
            ROOT_PATH."public/plugins/Ueditor/lang/zh-cn/images/mfusisc.png",
            ROOT_PATH."public/plugins/Ueditor/dialogs/template/images/prel2.png",
            ROOT_PATH."public/html/article_pay.htm",
            ROOT_PATH."public/html/download_pay.htm",
            ROOT_PATH."public/html/comment",
            ROOT_PATH."public/static/common/js/jquery.tools.min.js",
        ];
        foreach ($arr as $key => $val) {
            if (is_dir($val)) {
                try {
                    delFile($val, true);
                } catch (\Exception $e) {}
            } else if (file_exists($val)) {
                @unlink($val);
            }
        }

        Db::name("admin_menu")->where(['menu_id'=>2004006])->update(['param'=>'|mt20|1|menu|1']);
    }
    
    /*
    * 初始化原来的菜单栏目
    */
    public function initialize_admin_menu(){
        $total = Db::name("admin_menu")->count();
        if (empty($total)){
            $menuArr = getAllMenu();
            $insert_data = [];
            foreach ($menuArr as $key => $val){
                foreach ($val['child'] as $nk=>$nrr) {
                    $sort_order = 100;
                    $is_switch = 1;
                    if ($nrr['id'] == 2004){
                        $sort_order = 10000;
                        $is_switch = 0;
                    }
                    $insert_data[] = [
                        'menu_id' => $nrr['id'],
                        'title' => $nrr['name'],
                        'controller_name' => $nrr['controller'],
                        'action_name' => $nrr['action'],
                        'param' => !empty($nrr['param']) ? $nrr['param'] : '',
                        'is_menu' => $nrr['is_menu'],
                        'is_switch' => $is_switch,
                        'icon' =>  $nrr['icon'],
                        'sort_order' => $sort_order,
                        'add_time' => getTime(),
                        'update_time' => getTime()
                    ];
                }
            }
            Db::name("admin_menu")->insertAll($insert_data);
        }
    }
    
    //1.5.9相关
    public function admin_logic_1658220528(){
        $Prefix = config('database.prefix');
        $archivesTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}archives");
        $archivesTableInfo = get_arr_column($archivesTableInfo, 'Field');
        if (!empty($archivesTableInfo) && !in_array('virtual_sales', $archivesTableInfo)){
            $sql = "ALTER TABLE `{$Prefix}archives` ADD COLUMN `virtual_sales`  int(10) NULL DEFAULT 0 COMMENT '商品虚拟销售量' AFTER `sales_num`;";
            @Db::execute($sql);
        }
        if (!empty($archivesTableInfo) && !in_array('sales_all', $archivesTableInfo)){
            $sql = "ALTER TABLE `{$Prefix}archives` ADD COLUMN `sales_all`  int(10) NULL DEFAULT 0 COMMENT '虚拟总销量' AFTER `virtual_sales`;";
            @Db::execute($sql);
        }
        schemaTable('archives');

        $guestbookTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}guestbook");
        $guestbookTableInfo = get_arr_column($guestbookTableInfo, 'Field');
        if (!empty($guestbookTableInfo) && !in_array('users_id', $guestbookTableInfo)){
            $sql = "ALTER TABLE `{$Prefix}guestbook` ADD COLUMN `users_id`  int(11) NULL DEFAULT 0 COMMENT '用户id' AFTER `channel`;";
            @Db::execute($sql);
            schemaTable('guestbook');
        }

        try {
            $specTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}product_spec_data_handle");
            $specTableInfo = convert_arr_key($specTableInfo, 'Field');
            if (!empty($specTableInfo['spec_id']['Key'])) {
                $sql = "ALTER TABLE `{$Prefix}product_spec_data_handle` DROP PRIMARY KEY;";
                @Db::execute($sql);
                $sql = "ALTER TABLE `{$Prefix}product_spec_data_handle` MODIFY COLUMN `spec_id`  int(10) NULL DEFAULT 0 COMMENT '对应 product_spec_data 数据表' FIRST ;";
                @Db::execute($sql);
                schemaTable('product_spec_data_handle');
            }
        } catch (\Exception $e) {
            
        }
        
        $searchTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}search_word");
        $searchTableInfo = get_arr_column($searchTableInfo, 'Field');
        if (!empty($searchTableInfo) && !in_array('users_id', $searchTableInfo)){
            $sql = "ALTER TABLE `{$Prefix}search_word` ADD COLUMN `users_id`  int(11) NULL DEFAULT 0 COMMENT '用户id' AFTER `sort_order`;";
            @Db::execute($sql);
        }
        if (!empty($searchTableInfo) && !in_array('ip', $searchTableInfo)){
            $sql = "ALTER TABLE `{$Prefix}search_word` ADD COLUMN `ip`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'ip' AFTER `users_id`;";
            @Db::execute($sql);
            schemaTable('search_word');
        }
        if (!empty($searchTableInfo) && !in_array('is_hot', $searchTableInfo)){
            $sql = "ALTER TABLE `{$Prefix}search_word` ADD COLUMN `is_hot`  tinyint(1) NULL DEFAULT 0 COMMENT '是否热搜' AFTER `ip`;";
            @Db::execute($sql);
            schemaTable('search_word');
        }

        $isTable = Db::query('SHOW TABLES LIKE \''.$Prefix.'search_locking\'');
        if (empty($isTable)) {
            $tableSql = <<<EOF
CREATE TABLE IF NOT EXISTS `{$Prefix}search_locking` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) DEFAULT '0' COMMENT '用户ID',
  `ip` varchar(20) DEFAULT '' COMMENT 'ip',
  `locking_time` int(11) DEFAULT '0' COMMENT '锁定时间',
  `add_time` int(11) DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='搜索记录锁定表';
EOF;
            $r = @Db::execute($tableSql);
            if ($r !== false) {
                schemaTable('search_locking');
            }
        }

        // 优化主表字段的长度
        $admin_logic_1673941712 = tpSetting('syn.admin_logic_1673941712', [], 'cn');
        if (empty($admin_logic_1673941712)) {
            @Db::execute("ALTER TABLE `{$Prefix}archives` MODIFY COLUMN `htmlfilename`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '自定义文件名' AFTER `collection`");
            tpSetting('syn', ['admin_logic_1673941712'=>1], 'cn');
        }
        
        // 积分字段优化
        $admin_logic_1676854942 = tpSetting('syn.admin_logic_1676854942', [], 'cn');
        if (empty($admin_logic_1676854942)) {
            @Db::execute("ALTER TABLE `{$Prefix}users_score` MODIFY COLUMN `score`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '积分' AFTER `reply_id`");
            tpSetting('syn', ['admin_logic_1676854942'=>1], 'cn');
        }

        // 更新旧的商品虚拟总销量
        $this->handleProductSalesAll();

        // 同步模板的付费选择支付文件到前台模板指定位置
        $this->copy_tplpayfile();

        // 新增海外地区
        $this->add_haiwai_region();
        // 新增河南济源市地区
        $this->add_henan_jiyuan_region();

        // 默认收货后可维权时间
        $admin_logic_1678762367 = tpSetting('syn.admin_logic_1678762367', [], 'cn');
        if (empty($admin_logic_1678762367)) {
            getUsersConfigData('order', ['order_right_protect_time' => 7]);
            tpSetting('syn', ['admin_logic_1678762367'=>1], 'cn');
        }

        Db::name("admin_menu")->where(['menu_id'=>2004018])->update(['title'=>'留言中心']);
        Db::name("region")->where(['id'=>10961])->update(['name'=>'新吴区', 'initial'=>'X']);
        Db::name("region")->where(['id'=>10962])->update(['name'=>'梁溪区', 'initial'=>'L']);
        Db::name("region")->where(['id'=>['IN',['10969','10976']]])->delete();

        // 升级v1.6.3版本要处理的数据
        $this->eyou_v163_handle_data();
        // 升级v1.6.4版本要处理的数据
        $this->eyou_v164_handle_data();
        // 升级v1.6.5版本要处理的数据
        $this->eyou_v165_handle_data();
    }

    // 升级v1.6.3版本要处理的数据
    private function eyou_v163_handle_data()
    {
        // 主题风格同步兼容旧版本数据
        $this->theme_syn_olddata();

        // 处理站点状态的模板页面
        $admin_logic_1687676445 = tpSetting('syn.admin_logic_1687676445', [], 'cn');
        if (empty($admin_logic_1687676445)) {
            $webConfig = tpCache('web');
            if (empty($webConfig['web_status_tpl'])) {
                /*多语言*/
                $web_basehost = empty($webConfig['web_basehost']) ? request()->domain() : $webConfig['web_basehost'];
                $web_basehost = preg_replace('/^(([^\:\.]+):)?(\/\/)?([^\/\:]*)(\:\d+)?(.*)$/i', '${1}${3}${4}${5}', $web_basehost);
                $web_status_tpl = $web_basehost.ROOT_DIR.'/public/close.html';
                if (is_language()) {
                    $langRow = \think\Db::name('language')->order('id asc')
                        ->cache(true, EYOUCMS_CACHE_TIME, 'language')
                        ->select();
                    foreach ($langRow as $key => $val) {
                        tpCache('web', ['web_status_tpl'=>$web_status_tpl], $val['mark']);
                    }
                } else {
                    tpCache('web', ['web_status_tpl'=>$web_status_tpl]);
                }
                /*--end*/
            }
            tpSetting('syn', ['admin_logic_1687676445'=>1], 'cn');
        }
        
        // 处理编辑器常用配置
        $admin_logic_1687767523 = tpSetting('syn.admin_logic_1687767523', [], 'cn');
        if (empty($admin_logic_1687767523)) {
            $editor = tpSetting('editor', [], get_default_lang());
            if (!empty($editor['editor_select']) || !empty($editor['editor_remote_img_local']) || !empty($editor['editor_img_clear_link'])) {
                /*多语言*/
                if (is_language()) {
                    $langRow = \think\Db::name('language')->order('id asc')
                        ->cache(true, EYOUCMS_CACHE_TIME, 'language')
                        ->select();
                    foreach ($langRow as $key => $val) {
                        tpSetting('editor', $editor, $val['mark']);
                    }
                } else {
                    tpSetting('editor',$editor);
                }
                /*--end*/
            }
            tpSetting('syn', ['admin_logic_1687767523'=>1], 'cn');
        }

        // 搜索敏感词默认值
        $admin_logic_1685584104 = tpSetting('syn.admin_logic_1685584104', [], 'cn');
        if (empty($admin_logic_1685584104)) {
            $searchConf = tpCache('search');
            if (!isset($searchConf['search_tabu_words'])) {
                $search_tabu_words = ['<','>','"',';',',','@','&','#','\\','*'];
                $searchConf['search_tabu_words'] = implode(PHP_EOL, $search_tabu_words);
            }
            /*多语言*/
            if (is_language()) {
                $langRow = \think\Db::name('language')->order('id asc')
                    ->cache(true, EYOUCMS_CACHE_TIME, 'language')
                    ->select();
                foreach ($langRow as $key => $val) {
                    tpCache('search', $searchConf, $val['mark']);
                }
            } else {
                tpCache('search', $searchConf);
            }
            /*--end*/
            tpSetting('syn', ['admin_logic_1685584104'=>1], 'cn');
        }

        // 处理网站防止被刷的默认开关值
        $admin_logic_1682580429 = tpSetting('syn.admin_logic_1682580429', [], 'cn');
        if (empty($admin_logic_1682580429)) {
            /*多语言*/
            if (is_language()) {
                $langRow = \think\Db::name('language')->order('id asc')
                    ->cache(true, EYOUCMS_CACHE_TIME, 'language')
                    ->select();
                foreach ($langRow as $key => $val) {
                    tpCache('web', ['web_anti_brushing'=>'0'], $val['mark']);
                }
            } else {
                tpCache('web', ['web_anti_brushing'=>'0']);
            }
            /*--end*/
            tpSetting('syn', ['admin_logic_1682580429'=>1], 'cn');
        }
    }

    // 升级v1.6.4版本要处理的数据
    private function eyou_v164_handle_data()
    {
        $Prefix = config('database.prefix');

        // 删除大数据影响的索引
        $admin_logic_1689071584 = tpSetting('syn.admin_logic_1689071584', [], 'cn');
        if (empty($admin_logic_1689071584)) {
            try {
                @Db::execute("ALTER TABLE `{$Prefix}archives` DROP INDEX `aid`;");
            } catch (\Exception $e) {
                
            }
            tpSetting('syn', ['admin_logic_1689071584'=>1], 'cn');
        }
    }

    // 升级v1.6.5版本要处理的数据
    private function eyou_v165_handle_data()
    {
        // $this->eyou_v165_del_func();
        $this->syn_handle_table_data();
        $this->syn_handle_formdata();
        $this->syn_handle_linksgroupdata();
        $this->syn_handle_recycle_switch();
        // $this->syn_handle_foreign_pack();
        $this->syn_handle_tougao_tpl();
        $this->syn_handle_update_archives();
        $this->syn_handle_create_index();
    }

    private function syn_handle_table_data()
    {
        $Prefix = config('database.prefix');

        $admin_logic_1701050542 = tpSetting('syn.admin_logic_1701050542', [], 'cn');
        if (empty($admin_logic_1701050542)) {
            $data = [
                'seo_uphtml_after_home13' => 1,
                'seo_uphtml_after_channel13' => 1,
                'seo_uphtml_after_pernext13' => 1,
            ];
            /*多语言*/
            if (is_language()) {
                $langRow = \think\Db::name('language')->order('id asc')
                    ->cache(true, EYOUCMS_CACHE_TIME, 'language')
                    ->select();
                foreach ($langRow as $key => $val) {
                    tpCache('seo', $data, $val['mark']);
                }
            } else {
                tpCache('seo', $data);
            }
            /*--end*/
            tpSetting('syn', ['admin_logic_1701050542'=>1], 'cn');
        }

        $admin_logic_1700638990 = tpSetting('syn.admin_logic_1700638990', [], 'cn');
        if (empty($admin_logic_1700638990)) {
            $pay_open = (int) Db::name('users_config')->where(['name'=>'pay_open'])->value('value');
            //同步会员中心手机端底部菜单开关
            Db::name('users_bottom_menu')->where([
                    'mca'   => ['IN',['user/Pay/pay_account_recharge']]
                ])->update([
                    'status'    => $pay_open,
                    'update_time'   => getTime(),
                ]);
            tpSetting('syn', ['admin_logic_1700638990'=>1], 'cn');
        }

        $admin_logic_1700789211 = tpSetting('syn.admin_logic_1700789211', [], 'cn');
        if (empty($admin_logic_1700789211)) {
            try {
                $count = Db::name('foreign_pack')->where(['name'=>'page6','type'=>1,'lang'=>'cn'])->count();
                if (empty($count)) {
                    @Db::execute("INSERT INTO `{$Prefix}foreign_pack` (`type`, `name`, `value`, `lang`, `sort_order`, `add_time`, `update_time`) VALUES ('1', 'page6', '第%s页', 'cn', '100', '1543890216', '1543890216');");
                }
            } catch (\Exception $e) {}
            try {
                $count = Db::name('foreign_pack')->where(['name'=>'page6','type'=>1,'lang'=>'en'])->count();
                if (empty($count)) {
                    @Db::execute("INSERT INTO `{$Prefix}foreign_pack` (`type`, `name`, `value`, `lang`, `sort_order`, `add_time`, `update_time`) VALUES ('1', 'page6', '%s', 'en', '100', '1543890216', '1543890216');");
                }
            } catch (\Exception $e) {}
            tpSetting('syn', ['admin_logic_1700789211'=>1], 'cn');
        }

        try {
            $tableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}users_recharge_pack");
            $tableInfo = get_arr_column($tableInfo, 'Field');
            if (!empty($tableInfo) && !in_array('pack_pay_prices', $tableInfo)){
                $sql = "ALTER TABLE `{$Prefix}users_recharge_pack` ADD COLUMN `pack_pay_prices`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '会员充值套餐购买价格' AFTER `pack_face_value`;";
                @Db::execute($sql);
                if (in_array('pack_pay_prices', $tableInfo) && in_array('pack_buy_prices', $tableInfo)){
                    @Db::execute("UPDATE `{$Prefix}users_recharge_pack` SET `pack_pay_prices`=`pack_buy_prices`;");
                }
                schemaTable('users_recharge_pack');
            }
            if (!empty($tableInfo) && in_array('pack_buy_prices', $tableInfo)){
                $sql = "ALTER TABLE `{$Prefix}users_recharge_pack` DROP COLUMN `pack_buy_prices`;";
                @Db::execute($sql);
                schemaTable('users_recharge_pack');
            }
        } catch (\Exception $e) {}
    }

    /**
     * 创建索引
     * @return [type] [description]
     */
    private function syn_handle_create_index()
    {
        $admin_logic_1700621159 = tpSetting('syn.admin_logic_1700621159', [], 'cn');
        if (empty($admin_logic_1700621159)) {
            $Prefix = config('database.prefix');
            try {
                @Db::execute("CREATE INDEX `add_time` ON `{$Prefix}archives`(`add_time`) USING BTREE ;");
            } catch (\Exception $e) {}
            try {
                @Db::execute("CREATE INDEX `union_id` ON `{$Prefix}users`(`union_id`) USING BTREE ;");
            } catch (\Exception $e) {}
            try {
                @Db::execute("CREATE INDEX `username` ON `{$Prefix}users`(`username`) USING BTREE ;");
            } catch (\Exception $e) {}
            try {
                @Db::execute("CREATE INDEX `mobile` ON `{$Prefix}users`(`mobile`) USING BTREE ;");
            } catch (\Exception $e) {}
            try {
                @Db::execute("CREATE INDEX `open_id` ON `{$Prefix}users`(`open_id`) USING BTREE ;");
            } catch (\Exception $e) {}
            try {
                @Db::execute("CREATE INDEX `users_id` ON `{$Prefix}users_list`(`users_id`) USING BTREE ;");
            } catch (\Exception $e) {}
            tpSetting('syn', ['admin_logic_1700621159'=>1], 'cn');
        }
    }

    /**
     * 更新 远程图片本地化/清除非本站链接
     * @return [type] [description]
     */
    private function syn_handle_update_archives()
    {
        $syn_admin_logic_1700106425 = tpSetting('syn.syn_admin_logic_1700106425', [], 'cn');
        if (empty($syn_admin_logic_1700106425)) {
            try{
                $Prefix = config('database.prefix');
                $editor = tpSetting('editor');
                $editor_remote_img_local = !isset($editor['editor_remote_img_local']) ? 1 : intval($editor['editor_remote_img_local']);
                $editor_img_clear_link = !isset($editor['editor_img_clear_link']) ? 1 : intval($editor['editor_img_clear_link']);
                @Db::execute("UPDATE `{$Prefix}archives` SET `editor_remote_img_local`={$editor_remote_img_local};");
                @Db::execute("UPDATE `{$Prefix}archives` SET `editor_img_clear_link`={$editor_img_clear_link};");
                tpSetting('syn', ['syn_admin_logic_1700106425'=>1], 'cn');
            }catch(\Exception $e){}
        }
    }

    /**
     * 同步投稿提醒的模板
     * @return [type] [description]
     */
    private function syn_handle_tougao_tpl()
    {
        $syn_admin_logic_1700016487 = tpSetting('syn.syn_admin_logic_1700016487', [], 'cn');
        if (empty($syn_admin_logic_1700016487)) {
            try{
                $r = true;
                Db::name('sms_template')->where(['send_scene'=>20])->delete();
                $saveData = Db::name('sms_template')->field('tpl_id', true)->where(['send_scene'=>0])->select();
                if (!empty($saveData)) {
                    $addData = [];
                    foreach ($saveData as $key => $val) {
                        $val['tpl_title'] = '投稿提醒';
                        $val['send_scene'] = 20;
                        $val['sms_sign'] = '';
                        $val['sms_tpl_code'] = '';
                        $val['tpl_content'] = '您有新的会员投稿，请查看！';
                        $val['is_open'] = 0;
                        $addData[] = $val;
                    }
                    $r = Db::name('sms_template')->insertAll($addData);
                }
                if ($r !== false) {
                    tpSetting('syn', ['syn_admin_logic_1700016487'=>1], 'cn');
                }
            }catch(\Exception $e){}
        }

        $syn_admin_logic_1700016488 = tpSetting('syn.syn_admin_logic_1700016488', [], 'cn');
        if (empty($syn_admin_logic_1700016488)) {
            try{
                $r = true;
                Db::name('smtp_tpl')->where(['send_scene'=>20])->delete();
                $saveData = Db::name('smtp_tpl')->field('tpl_id', true)->where(['send_scene'=>2])->select();
                if (!empty($saveData)) {
                    $addData = [];
                    foreach ($saveData as $key => $val) {
                        $val['tpl_name'] = '投稿提醒';
                        $val['tpl_title'] = '您有新的投稿文档，请及时查看！';
                        $val['send_scene'] = 20;
                        $val['is_open'] = 0;
                        $addData[] = $val;
                    }
                    $r = Db::name('smtp_tpl')->insertAll($addData);
                }
                if ($r !== false) {
                    tpSetting('syn', ['syn_admin_logic_1700016488'=>1], 'cn');
                }
            }catch(\Exception $e){}
        }

        $syn_admin_logic_1700016489 = tpSetting('syn.syn_admin_logic_1700016489', [], 'cn');
        if (empty($syn_admin_logic_1700016489)) {
            try{
                $r = true;
                Db::name('users_notice_tpl')->where(['send_scene'=>20])->delete();
                $saveData = Db::name('users_notice_tpl')->field('tpl_id', true)->where(['send_scene'=>1])->select();
                if (!empty($saveData)) {
                    $addData = [];
                    foreach ($saveData as $key => $val) {
                        $val['tpl_name'] = '投稿提醒';
                        $val['tpl_title'] = '您有新的投稿文档，请及时查看！';
                        $val['send_scene'] = 20;
                        $val['is_open'] = 0;
                        $addData[] = $val;
                    }
                    $r = Db::name('users_notice_tpl')->insertAll($addData);
                }
                if ($r !== false) {
                    tpSetting('syn', ['syn_admin_logic_1700016489'=>1], 'cn');
                }
            }catch(\Exception $e){}
        }
    }

    /**
     * 处理外贸助手功能数据表
     * @return [type] [description]
     */
    private function syn_handle_foreign_pack()
    {
        $admin_logic_1699261141 = tpSetting('syn.admin_logic_1699261141', [], 'cn');
        if (empty($admin_logic_1699261141)) {
            $Prefix = config('database.prefix');
            $isTable = Db::query('SHOW TABLES LIKE \''.$Prefix.'foreign_pack\'');
            if (empty($isTable)) {
                $tableSql = <<<EOF
CREATE TABLE IF NOT EXISTS `{$Prefix}foreign_pack` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `type` int(4) DEFAULT '0' COMMENT '分类：1=列表，2=留言',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '变量名',
  `value` text NOT NULL COMMENT '变量值',
  `lang` varchar(50) DEFAULT 'cn' COMMENT '语言标识',
  `sort_order` int(10) DEFAULT '0' COMMENT '排序号',
  `add_time` int(11) DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='外贸助手语言包变量';
EOF;
                $r = @Db::execute($tableSql);
                if ($r !== false) {
                    schemaTable('foreign_pack');
                    try {
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('1', '1', 'page1', '首页', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('2', '1', 'page2', '上一页', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('3', '1', 'page3', '下一页', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('4', '1', 'page4', '末页', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('5', '1', 'page5', '共<strong>%s</strong>页 <strong>%s</strong>条', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('6', '1', 'page1', 'Home', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('7', '1', 'page2', 'Pre', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('8', '1', 'page3', 'Next', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('9', '1', 'page4', 'Last', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('10', '1', 'page5', 'Road <strong>%s</strong> page <strong>%s</strong> strip', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('11', '2', 'gbook1', '操作成功', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('12', '2', 'gbook1', 'success', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('14', '2', 'gbook2', 'The same IP cannot be submitted repeatedly within %s seconds!', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('13', '2', 'gbook2', '同一个IP在%s秒之内不能重复提交！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('15', '2', 'gbook3', '%s不能为空！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('16', '2', 'gbook3', '%s Cannot be empty!', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('17', '2', 'gbook4', '%s格式不正确！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('18', '2', 'gbook4', '%s Incorrect format!', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('19', '2', 'gbook5', '图片验证码不能为空！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('20', '2', 'gbook5', 'Picture verification code cannot be empty!', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('21', '2', 'gbook6', '图片验证码不正确！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('22', '2', 'gbook6', 'The picture verification code is incorrect!', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('23', '2', 'gbook7', '请输入手机号码！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('24', '2', 'gbook7', 'Please enter your mobile number!', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('25', '2', 'gbook8', '手机号码和手机验证码不一致，请重新输入！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('26', '2', 'gbook8', 'Mobile phone number and mobile phone verification code are inconsistent, please re-enter!', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('27', '2', 'gbook9', '手机验证码已被使用或超时，请重新发送！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('28', '2', 'gbook9', 'The mobile phone verification code has been used or timed out. Please resend it!', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('29', '2', 'gbook10', '请输入手机验证码！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('30', '2', 'gbook10', 'Please enter the mobile phone verification code!', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('31', '2', 'gbook11', '表单缺少标签属性{\$field.hidden}', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('32', '2', 'gbook11', 'The form is missing label attribute {\$field.hidden}', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('33', '2', 'gbook12', '页面自动 %s跳转%s 等待时间：', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('34', '2', 'gbook12', 'Page automatic %sjump%s waiting time：', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('35', '2', 'gbook13', '%s至少选择一项！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('36', '2', 'gbook13', 'Select at least one item to %s', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('37', '2', 'gbook14', '请选择%s', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('38', '2', 'gbook14', 'Please select %s', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('39', '2', 'gbook15', '请输入正确的手机号码！', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('40', '2', 'gbook15', 'Please enter the correct mobile number！', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('41', '2', 'gbook16', '图片验证码', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('42', '2', 'gbook16', 'Picture verification code', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('43', '2', 'gbook17', '手机验证码', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('44', '2', 'gbook17', 'Mobile verification code', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('45', '2', 'gbook18', '获取验证码', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('46', '2', 'gbook18', 'Get verification code', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('47', '2', 'gbook19', '看不清？点击更换验证码', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('48', '2', 'gbook19', 'Can\'t see clearly? Click to change the verification code', 'en', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('49', '2', 'gbook20', '看不清？%s点击更换%s', 'cn', '100', '1543890216', '1543890216');");
                        @Db::execute("INSERT INTO `{$Prefix}foreign_pack` VALUES ('50', '2', 'gbook20', 'Can\'t see clearly? %sClick to replace%s', 'en', '100', '1543890216', '1543890216');");
                    } catch (\Exception $e) {
                        
                    }
                }
                tpSetting('syn', ['admin_logic_1699261141'=>1], 'cn');
            }
        }
    }

    /**
     * 处理回收站开关，多语言情况下同步
     * @return [type] [description]
     */
    private function syn_handle_recycle_switch()
    {
        $admin_logic_1698799687 = tpSetting('syn.admin_logic_1698799687', [], 'cn');
        if (empty($admin_logic_1698799687)) {
            $web_recycle_switch = Db::name('setting')->where(['name'=>'recycle_switch', 'inc_type'=>'recycle'])->value('value');
            $web_recycle_switch = intval($web_recycle_switch);
            /*多语言*/
            if (is_language()) {
                $langRow = \think\Db::name('language')->order('id asc')
                    ->cache(true, EYOUCMS_CACHE_TIME, 'language')
                    ->select();
                foreach ($langRow as $key => $val) {
                    tpCache('web', ['web_recycle_switch'=>$web_recycle_switch], $val['mark']);
                }
            } else {
                tpCache('web', ['web_recycle_switch'=>$web_recycle_switch]);
            }
            /*--end*/
            tpSetting('syn', ['admin_logic_1698799687'=>1], 'cn');
        }
    }

    /**
     * 同步处理在添加多语言时，友情链接分组没有同步到其他语言里
     * @return [type] [description]
     */
    private function syn_handle_linksgroupdata()
    {
        $admin_logic_1698733259 = tpSetting('syn.admin_logic_1698733259', [], 'cn');
        if (empty($admin_logic_1698733259)) {
            $r = true;
            $main_lang = get_main_lang();
            $linksGroupList = Db::name('links_group')->order('lang asc, id asc')->select();

            $languageAttributeList = Db::name('language_attribute')->where(['attr_group'=>'links_group'])->order('attr_name asc')->getAllWithIndex('attr_name');
            $addData = [];
            foreach ($linksGroupList as $key => $val) {
                if ($main_lang == $val['lang']) {
                    if (!isset($languageAttributeList['linksgroup'.$val['id']])) {
                        $addData[] = [
                            'attr_title' => $val['group_name'],
                            'attr_name' => "linksgroup{$val['id']}",
                            'attr_group' => 'links_group',
                            'add_time' => getTime(),
                            'update_time' => getTime(),
                        ];
                    }
                }
            }
            if (!empty($addData)) {
                $r = Db::name('language_attribute')->insertAll($addData);
            }

            if ($r !== false) {
                $languageAttrList = Db::name('language_attr')->where(['attr_group'=>'links_group'])->order('lang asc, attr_name asc')->getAllWithIndex('attr_value');
                $addData = [];
                foreach ($linksGroupList as $key => $val) {
                    if (!isset($languageAttrList[$val['id']])) {
                        $addData[] = [
                            'attr_name' => "linksgroup{$val['id']}",
                            'attr_value' => $val['id'],
                            'attr_group' => 'links_group',
                            'lang' => $val['lang'],
                            'add_time' => getTime(),
                            'update_time' => getTime(),
                        ];
                    }
                }
                if (!empty($addData)) {
                    $r = Db::name('language_attr')->insertAll($addData);
                }
                if ($r !== false) {
                    tpSetting('syn', ['admin_logic_1698733259'=>1], 'cn');
                }
            }
        }
    }

    /**
     * 同步处理在添加多语言时，表单属性没有同步到其他语言里
     * @return [type] [description]
     */
    private function syn_handle_formdata()
    {
        $admin_logic_1698716726 = tpSetting('syn.admin_logic_1698716726', [], 'cn');
        if (empty($admin_logic_1698716726)) {
            $r = true;
            $formAttributeList = Db::name('guestbook_attribute')->where(['form_type'=>1])->order('typeid asc, attr_id asc')->select();
            $languageAttrList = Db::name('language_attr')->where(['attr_group'=>'form_attribute'])->order('lang asc, attr_name asc')->getAllWithIndex('attr_value');
            $addData = [];
            foreach ($formAttributeList as $key => $val) {
                if (!isset($languageAttrList[$val['attr_id']])) {
                    $addData[] = [
                        'attr_name' => "attr_{$val['attr_id']}",
                        'attr_value' => $val['attr_id'],
                        'attr_group' => 'form_attribute',
                        'lang' => $val['lang'],
                        'add_time' => getTime(),
                        'update_time' => getTime(),
                    ];
                }
            }
            if (!empty($addData)) {
                $r = Db::name('language_attr')->insertAll($addData);
            }
            if ($r !== false) {
                tpSetting('syn', ['admin_logic_1698716726'=>1], 'cn');
            }
        }
    }

    // 移除没有使用的功能模块，在index控制器也在用，要一起去掉
    public function eyou_v165_del_func()
    {
        // $admin_logic_1694048251 = tpSetting('syn.admin_logic_1694048251', [], 'cn');
        // if (empty($admin_logic_1694048251)) {
        //     $shopLogic = new \app\admin\logic\ShopLogic;
        //     // 列出营销功能里已使用的模块
        //     $marketFunc = $shopLogic->marketLogic();
        //     if (empty($marketFunc)) {
        //         Db::name('admin_menu')->where(['menu_id'=>2008005])->update(['is_menu'=>0, 'update_time'=>getTime()]);
        //     }
        //     // 列出功能地图里已使用的模块
        //     $useFunc = $shopLogic->useFuncLogic();
        //     if (!in_array('memgift', $useFunc)) {
        //         Db::name('admin_menu')->where(['menu_id'=>2004023])->update(['is_menu'=>0, 'update_time'=>getTime()]);
        //     }

        //     tpSetting('syn', ['admin_logic_1694048251'=>1], 'cn');
        // }
    }

    private function add_haiwai_region()
    {
        $admin_logic_1677555001 = tpSetting('syn.admin_logic_1677555001', [], 'cn');
        if (empty($admin_logic_1677555001)) {
            $count = Db::name('region')->where(['name'=>'海外','level'=>1])->count();
            if (empty($count)) {
                $insertid1 = Db::name('region')->insertGetId([
                        'name' => '海外',
                        'level' => 1,
                        'parent_id' => 0,
                        'initial' => 'H',
                    ]);
                if (!empty($insertid1)) {
                    $insertid2 = Db::name('region')->insertGetId([
                            'name' => '海外',
                            'level' => 2,
                            'parent_id' => $insertid1,
                            'initial' => 'H',
                        ]);
                    if (!empty($insertid2)) {
                        Db::name('region')->insertGetId([
                                'name' => '海外',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'H',
                            ]);
                    }
                    tpSetting('syn', ['admin_logic_1677555001'=>1], 'cn');
                }
            }
        }
    }

    private function add_henan_jiyuan_region()
    {
        $admin_logic_1698388181 = tpSetting('syn.admin_logic_1698388181', [], 'cn');
        if (empty($admin_logic_1698388181)) {
            $count = Db::name('region')->where(['name'=>'济源市','parent_id'=>21387])->count();
            if (empty($count)) {
                $insertid2 = Db::name('region')->insertGetId([
                        'name' => '济源市',
                        'level' => 2,
                        'parent_id' => 21387,
                        'initial' => 'J',
                    ]);
                if (!empty($insertid2)) {
                    Db::name('region')->insertAll([
                            [
                                'name' => '沁园街道',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'Q',
                            ],
                            [
                                'name' => '济水街道',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'J',
                            ],
                            [
                                'name' => '北海街道',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'B',
                            ],
                            [
                                'name' => '天坛街道',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'T',
                            ],
                            [
                                'name' => '玉泉街道',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'Y',
                            ],
                            [
                                'name' => '克井镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'K',
                            ],
                            [
                                'name' => '五龙口镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'W',
                            ],
                            [
                                'name' => '轵城镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'Z',
                            ],
                            [
                                'name' => '承留镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'C',
                            ],
                            [
                                'name' => '邵原镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'S',
                            ],
                            [
                                'name' => '坡头镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'P',
                            ],
                            [
                                'name' => '梨林镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'L',
                            ],
                            [
                                'name' => '大峪镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'D',
                            ],
                            [
                                'name' => '思礼镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'S',
                            ],
                            [
                                'name' => '王屋镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'W',
                            ],
                            [
                                'name' => '下冶镇',
                                'level' => 3,
                                'parent_id' => $insertid2,
                                'initial' => 'X',
                            ],
                        ]);
                    tpSetting('syn', ['admin_logic_1698388181'=>1], 'cn');
                }
            }
        }
    }

    // 添加商城订单主表字段(消费获得积分数(obtain_scores)；订单是否已赠送积分(is_obtain_scores))
    public function admin_logic_1677653220()
    {
        $Prefix = config('database.prefix');
        // 订单表字段查询
        $shopOrderTableInfo = Db::query("SHOW COLUMNS FROM {$Prefix}shop_order");
        $shopOrderTableInfo = get_arr_column($shopOrderTableInfo, 'Field');

        // 订单是否允许申请售后维权
        if (!empty($shopOrderTableInfo) && !in_array('allow_service', $shopOrderTableInfo)) {
            $sql0 = "ALTER TABLE `{$Prefix}shop_order` ADD COLUMN `allow_service`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单是否允许申请售后维权，0=允许申请维权，1=不允许申请维权' AFTER `confirm_time`";
            @Db::execute($sql0);
            schemaTable('shop_order');
        }

        // 消费获得积分数
        if (!empty($shopOrderTableInfo) && !in_array('obtain_scores', $shopOrderTableInfo)) {
            $sql1 = "ALTER TABLE `{$Prefix}shop_order` ADD COLUMN `obtain_scores`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '消费获得积分数' AFTER `allow_service`;";
            @Db::execute($sql1);
            schemaTable('shop_order');
        }

        // 该订单是否已赠送积分
        if (!empty($shopOrderTableInfo) && !in_array('is_obtain_scores', $shopOrderTableInfo)) {
            $sql2 = "ALTER TABLE `{$Prefix}shop_order` ADD COLUMN `is_obtain_scores`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '该订单是否已赠送积分，0=未赠送，1=已赠送' AFTER `obtain_scores`;";
            @Db::execute($sql2);
            schemaTable('shop_order');
        }
    }

    // 更新会员积分数据表，积分类型字段 type
    public function admin_logic_1680749290()
    {
        $admin_logic_1680749290 = tpSetting('syn.admin_logic_1680749290', [], 'cn');
        if (empty($admin_logic_1680749290)) {
            // 表前缀
            $Prefix = config('database.prefix');
            // 会员积分表更新
            $sql = "ALTER TABLE `{$Prefix}users_score` MODIFY COLUMN `type`  tinyint(2) NULL DEFAULT 1 COMMENT '类型:1-提问,2-回答,3-最佳答案4-悬赏退回,5-每日签到,6-管理员编辑,7-问题悬赏/获得悬赏,8-消费赠送积分,9-积分兑换/退回,10-登录赠送积分' AFTER `id`;";
            @Db::execute($sql);
            schemaTable('users_score');
            // 增加会员登录日志表
            $isTable = Db::query('SHOW TABLES LIKE \''.$Prefix.'users_login_log\'');
            if (empty($isTable)) {
                $tableSql = <<<EOF
CREATE TABLE IF NOT EXISTS `{$Prefix}users_login_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员日志自增ID',
  `users_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `log_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '日志时间，年月日(例:20230406)',
  `log_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '日志次数',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`log_id`),
  UNIQUE KEY `users_id` (`users_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员登录日志';
EOF;
                $result = @Db::execute($tableSql);
                if ($result !== false) schemaTable('users_login_log');
            }
            // 设置已完成执行
            tpSetting('syn', ['admin_logic_1680749290'=>1], 'cn');
        }
    }

    /**
     * 更新旧的商品虚拟总销量
     * @return [type] [description]
     */
    private function handleProductSalesAll()
    {
        $admin_logic_1675243579 = tpSetting('syn.admin_logic_1675243579', [], 'cn');
        if (empty($admin_logic_1675243579)) {
            $productList = Db::name('archives')->field('aid,sales_num,virtual_sales,sales_all')
                ->where(['channel'=>2])
                ->select();
            if (!empty($productList)) {
                $specList = Db::name('product_spec_data')->field('aid,count(aid) as total')
                    ->group('aid')
                    ->getAllWithIndex('aid');
                $salesList = Db::name('product_spec_value')->field('aid,sum(spec_sales_num) as spec_sales_num,count(aid) as spec_counts')
                    ->group('aid')
                    ->getAllWithIndex('aid');
                $saveData = [];
                foreach ($productList as $key => $val) {
                    if (!empty($specList[$val['aid']]['total'])) { // 多规格
                        $spec_counts = empty($salesList[$val['aid']]['spec_counts']) ? 0 : $salesList[$val['aid']]['spec_counts'];
                        $spec_sales_num = empty($salesList[$val['aid']]['spec_sales_num']) ? 0 : $salesList[$val['aid']]['spec_sales_num'];
                        $saveData[] = [
                            'aid' => $val['aid'],
                            'sales_all' => $spec_sales_num, // + ($spec_counts * $val['virtual_sales']),
                        ];
                    } else {
                        $saveData[] = [
                            'aid' => $val['aid'],
                            'sales_all' => $val['sales_num'] + $val['virtual_sales'],
                        ];
                    }
                }
                if (!empty($saveData)) {
                    model('Archives')->saveAll($saveData);
                }
            }
            tpSetting('syn', ['admin_logic_1675243579'=>1], 'cn');
        }
    }

    /**
     * 同步模板的付费选择支付文件到前台模板指定位置
     * @return [type] [description]
     */
    public function copy_tplpayfile($channel = 0)
    {
        $shop_open_comment = getUsersConfigData('shop.shop_open_comment');
        $channelRow = Db::name('channeltype')->where(['status'=>1])->getAllWithIndex('id');
        foreach ($channelRow as $key => $val) {
            $data = json_decode($val['data'], true);
            $val['data'] = empty($data) ? [] : $data;
            $channelRow[$key] = $val;
        }
        $source_path = ROOT_PATH.'public/html/template/';
        $dest_path = ROOT_PATH.'template/'.THEME_STYLE_PATH.'/system/';
        if (stristr($dest_path, '/pc/system/')) {
            tp_mkdir($dest_path);
            if (!empty($channelRow[1]['data']['is_article_pay'])) {
                if (in_array($channel, [0,1]) && !file_exists($dest_path.'article_pay.htm') && file_exists($source_path.'pc/system/article_pay.htm')) {
                    @copy($source_path.'pc/system/article_pay.htm', $dest_path.'article_pay.htm');
                }
            }
            if (!empty($channelRow[4]['data']['is_download_pay'])) {
                if (in_array($channel, [0,4]) && !file_exists($dest_path.'download_pay.htm') && file_exists($source_path.'pc/system/download_pay.htm')) {
                    @copy($source_path.'pc/system/download_pay.htm', $dest_path.'download_pay.htm');
                }
            }
            if (!empty($shop_open_comment)) {
                if (in_array($channel, [0,2]) && !file_exists($dest_path.'product_comment.htm') && file_exists($source_path.'pc/system/product_comment.htm')) {
                    @copy($source_path.'pc/system/product_comment.htm', $dest_path.'product_comment.htm');
                }
            }
        }

        $dest_path = ROOT_PATH.'template/'.THEME_STYLE_PATH;
        $dest_path = preg_replace('/\/pc$/i', '/mobile', $dest_path);
        if (file_exists($dest_path)) {
            $dest_path .= '/system/';
            tp_mkdir($dest_path);
            if (!empty($channelRow[1]['data']['is_article_pay'])) {
                if (in_array($channel, [0,1]) && !file_exists($dest_path.'article_pay.htm') && file_exists($source_path.'mobile/system/article_pay.htm')) {
                    @copy($source_path.'mobile/system/article_pay.htm', $dest_path.'article_pay.htm');
                }
            }
            if (!empty($channelRow[4]['data']['is_download_pay'])) {
                if (in_array($channel, [0,4]) && !file_exists($dest_path.'download_pay.htm') && file_exists($source_path.'mobile/system/download_pay.htm')) {
                    @copy($source_path.'mobile/system/download_pay.htm', $dest_path.'download_pay.htm');
                }
            }
            if (!empty($shop_open_comment)) {
                if (in_array($channel, [0,2]) && !file_exists($dest_path.'product_comment.htm') && file_exists($source_path.'mobile/system/product_comment.htm')) {
                    @copy($source_path.'mobile/system/product_comment.htm', $dest_path.'product_comment.htm');
                }
                if (in_array($channel, [0,2]) && !file_exists($dest_path.'comment_list.htm') && file_exists($source_path.'mobile/system/comment_list.htm')) {
                    @copy($source_path.'mobile/system/comment_list.htm', $dest_path.'comment_list.htm');
                }
            }
        }
    }

    public function admin_logic_1685094852()
    {
        $syn_admin_logic_1685094852 = tpSetting('syn.admin_logic_1685094852', [], 'cn');
        if (empty($syn_admin_logic_1685094852)) {
            $articlePay = Db::name('article_pay')->field('id, size, update_time')->select();
            if (!empty($articlePay)) {
                foreach ($articlePay as $key => $value) {
                    $value['size'] = intval(floatval($value['size']) * floatval(1024));
                    $value['update_time'] = getTime();
                    Db::name('article_pay')->where('id', $value['id'])->update($value);
                }
            }
            tpSetting('syn', ['admin_logic_1685094852'=>1], 'cn');
        }
    }

    // 运费模板数据同步
    public function admin_logic_1687687709()
    {
        $syn_admin_logic_1687687709 = tpSetting('syn.admin_logic_1687687709', [], 'cn');
        if (empty($syn_admin_logic_1687687709)) {
            // 查询地址表是否存在海外区域
            $where = [
                'level' => 1,
                'name' => '海外',
                'parent_id' => 0,
            ];
            $region = Db::name('region')->where($where)->find();

            // 查询运费模板表是否已添加海外区域
            $where = [
                'province_id' => $region['id'],
                'template_region' => $region['name'],
            ];
            $template = Db::name('shop_shipping_template')->where($where)->find();

            // 判断是否需要添加运费模板数据
            if (!empty($region) && empty($template)) {
                // 添加运费模板数据
                $insert = [
                    'update_time' => getTime(),
                    'province_id' => $region['id'],
                    'template_region' => $region['name'],
                ];
                Db::name('shop_shipping_template')->insert($insert);
            }

            tpSetting('syn', ['admin_logic_1687687709'=>1], 'cn');
        }
    }

    /**
     * 主题风格同步兼容旧版本数据
     * @return [type] [description]
     */
    private function theme_syn_olddata()
    {
        $admin_logic_1681199467 = tpSetting('syn.admin_logic_1681199467', [], 'cn');
        if (empty($admin_logic_1681199467)) {
            $count = Db::name('admin_theme')->where(['is_system'=>0,'theme_type'=>1])->count();
            if (empty($count)) {
                $globalConfig = tpCache('global');
                // 后台logo/登录logo
                if (-1 == $globalConfig['web_is_authortoken']) {
                    if (empty($globalConfig['web_adminlogo'])) {
                        $globalConfig['web_adminlogo'] = ROOT_DIR.'/public/static/admin/images/logo_ey.png';
                    }
                    if (empty($globalConfig['web_loginlogo'])) {
                        $globalConfig['web_loginlogo'] = ROOT_DIR.'/public/static/admin/images/login-logo_ey.png';
                    }
                } else {
                    if (empty($globalConfig['web_adminlogo'])) {
                        $globalConfig['web_adminlogo'] = ROOT_DIR.'/public/static/admin/images/logo.png';
                    }
                    if (empty($globalConfig['web_loginlogo'])) {
                        if ($globalConfig['php_servicemeal'] >= 2) {
                            $globalConfig['web_loginlogo'] = ROOT_DIR.'/public/static/admin/images/login-logo_zy.png';
                        } else {
                            $globalConfig['web_loginlogo'] = ROOT_DIR.'/public/static/admin/images/login-logo.png';
                        }
                    }
                }
                $addData = [
                    'theme_type' => 1,
                    'theme_title' => '默认主题',
                    'theme_pic' => ROOT_DIR.'/public/static/admin/images/theme/theme_pic_default.png',
                    'theme_color_model' => empty($globalConfig['web_theme_color_model']) ? 1 : $globalConfig['web_theme_color_model'],
                    'theme_main_color' => empty($globalConfig['web_theme_color']) ? '#3398cc' : $globalConfig['web_theme_color'],
                    'theme_assist_color' => empty($globalConfig['web_assist_color']) ? '#2189be' : $globalConfig['web_assist_color'],
                    'login_logo' => empty($globalConfig['web_loginlogo']) ? ROOT_DIR.'/public/static/admin/login/login-logo.png' : $globalConfig['web_loginlogo'],
                    'login_bgimg_model' => empty($globalConfig['web_loginbgimg_model']) ? 1 : $globalConfig['web_loginbgimg_model'],
                    'login_bgimg' => empty($globalConfig['web_loginbgimg']) ? ROOT_DIR.'/public/static/admin/loginbg/login-bg-1.png' : $globalConfig['web_loginbgimg'],
                    'login_tplname' => '',
                    'admin_logo' => empty($globalConfig['web_adminlogo']) ? ROOT_DIR.'/public/static/admin/logo/logo.png' : $globalConfig['web_adminlogo'],
                    'welcome_tplname' => '',
                    'is_system' => 0,
                    'sort_order' => 100,
                    'lang' => get_admin_lang(),
                    'add_time' => getTime(),
                    'update_time' => getTime(),
                ];
                $theme_id = Db::name('admin_theme')->insertGetId($addData);
                if (!empty($theme_id)) {
                    /*多语言*/
                    if (is_language()) {
                        $langRow = \think\Db::name('language')->order('id asc')
                            ->cache(true, EYOUCMS_CACHE_TIME, 'language')
                            ->select();
                        foreach ($langRow as $key => $val) {
                            tpCache('web', ['web_theme_styleid'=>$theme_id], $val['mark']);
                        }
                    } else {
                        tpCache('web', ['web_theme_styleid'=>$theme_id]);
                    }
                    /*--end*/
                    tpSetting('syn', ['admin_logic_1681199467'=>1], 'cn');
                }
            }
        }
    }
}
