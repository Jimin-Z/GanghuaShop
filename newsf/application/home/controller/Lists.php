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
use think\Verify;

class Lists extends Base
{
    // 模型标识
    public $nid = '';
    // 模型ID
    public $channel = '';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 栏目列表
     */
    public function index($tid = '')
    {
        $param = input('param.');
        /*获取当前栏目ID以及模型ID*/
        $page_tmp = input('param.page/s', 0);
        if (empty($tid) || !is_numeric($page_tmp)) {
            abort(404, '页面不存在');
        }
        /*URL上参数的校验*/
        $s1= (is_numeric($tid)) ? 'a.id' : 'a.dirname';
        $map = array($s1 => $tid);
        $map['a.is_del'] = 0; // 回收站功能
        $map['a.lang']   = $this->home_lang; // 多语言
        $row  = Db::name('arctype')->field('a.id, a.current_channel, b.nid')
            ->alias('a')
            ->join('__CHANNELTYPE__ b', 'a.current_channel = b.id', 'LEFT')
            ->where($map)->find();
        if (empty($row)) {
            abort(404, '页面不存在');
        }
        $this->nid     = $row['nid'];
        $this->channel = $row['current_channel'];
        /*--end*/
        $result = $this->logic( $row['id']); // 模型对应逻辑
        $eyou       = array(  'field' => $result,    );
        $this->eyou = array_merge($this->eyou, $eyou);
        $this->assign('eyou', $this->eyou);

        /*模板文件*/
        $tp=$result['templist'];
        $viewfile =empty($tp) ? 'lists_'.$this->nid : str_replace('.'.$this->view_suffix, '', $tp);
        /*--end*/
        $ps=TEMPLATE_PATH.$this->theme_style_path.DS;
        if (config('city_switch_on') && !empty($this->home_site)) { // 多站点内置模板文件名
            $viewfilepath = $ps.$this->home_site;
            $viewfilepath2 = $ps.'city'.DS.$this->home_site;
            $v1=$this->home_site.'/'.$viewfile;
            if (!empty($this->eyou['global']['site_template'])) {
                if (file_exists($viewfilepath2)) {
                    $viewfile = "city/".$v1;
                } else if (file_exists($viewfilepath)) {
                    $viewfile =$v1;
                }
            }
        } else if (config('lang_switch_on') && !empty($this->home_lang)) { // 多语言内置模板文件名
            $viewfilepath =$ps.$viewfile . "_{$this->home_lang}." . $this->view_suffix;
            if (file_exists($viewfilepath)) {
                $viewfile .= "_{$this->home_lang}";
            }
        }

        $users_id = (int)session('users_id');
        $emptyhtml = $this->check_arcrank($this->eyou['field'],$users_id);
        $view ="./public/html/empty_view.htm";
        if (empty($emptyhtml)) {
            $view = ':'.$viewfile;
            if ($this->channel==51) { // 问答模型
                $Ask = new \app\home\controller\Ask;
                return $Ask->index();
            }
        }
        return $this->fetch($view);

    }

    /*
     * 判断阅读权限
     */
    private function check_arcrank($eyou_field,$users_id){
        $emptyhtml = "";
        $ef=$eyou_field['page_limit'];
        $eyou_field['page_limit'] = empty($ef) ? [] : explode(',', $ef);
        if ($eyou_field['typearcrank'] > 0 && in_array(1,$eyou_field['page_limit']) ) { // 若需要会员权限则执行
            if (empty($users_id)) {
                $url = url('user/Users/login');
                $s0=(stristr($url, '?')) ? '&' : '?';
                $url .= "&referurl=".urlencode($eyou_field['arcurl']);
                $this->redirect($url);
            }
            $msg = action('api/Ajax/get_arcrank', ['tid' => $eyou_field['id'], 'vars' => 1]);
            if (true !== $msg) {
                $this->error($msg);
            }
        }

        return $emptyhtml;
    }

      // 外部链接跳转
    function setTypeLink($is_part,$s1){
        if ($is_part == 1) {
            $s1= htmlspecialchars_decode($s1);
            if (!is_http_url($s1)) {
                $typeurl = '//'.$this->request->host();
                if (!preg_match('#^'.ROOT_DIR.'(.*)$#i', $s1)) {
                    $typeurl .= ROOT_DIR;
                }
                $s1=$typeurl .='/'.trim($s1, '/');
            }
            $this->redirect($s1);
            exit;
        }
    }
    /**
     * 模型对应逻辑
     * @param intval $tid 栏目ID
     * @return array
     */
    private function logic($tid = '')
    {
        $result = array();
        if (empty($tid)) { return $result;}
        switch ($this->channel) {
            case '6': // 单页模型
            {
                $arctype_info = model('Arctype')->getInfo($tid);
                if ($arctype_info) {
                    // 读取当前栏目的内容，否则读取每一级第一个子栏目的内容，直到有内容或者最后一级栏目为止。
                    $archivesModel = new \app\home\model\Archives;
                    $result_new = $archivesModel->readContentFirst($tid);
                    // 阅读权限
                    if ($result_new['arcrank'] == -1) {
                        $this->success('待审核稿件，你没有权限阅读！');
                        exit;
                    }
                    // 外部链接跳转
                    $this->setTypeLink($result_new['is_part'],$result_new['typelink']);
                    /*自定义字段的数据格式处理*/
                    $result_new = $this->fieldLogic->getChannelFieldList($result_new, $this->channel);
                    /*--end*/
                    $result = array_merge($arctype_info, $result_new);
                    $s1=$arctype_info['templist'];
                    $result['templist'] = !empty($s1) ? $s1 : 'lists_'. $arctype_info['nid'];
                    $result['dirpath'] = $arctype_info['dirpath'];
                    $result['diy_dirpath'] = $arctype_info['diy_dirpath'];
                    $result['typeid'] = $arctype_info['typeid'];
                    $result['rulelist']  = $arctype_info['rulelist'];
                }
                break;
            }

            default:
            {
                $result = model('Arctype')->getInfo($tid);
                /*外部链接跳转*/
                $this->setTypeLink($result_new['is_part'],$result_new['typelink']);
                /*end*/
                break;
            }
        }

        if (!empty($result)) {
            /*自定义字段的数据格式处理*/
            $result = $this->fieldLogic->getTableFieldList($result, config('global.arctype_channel_id'));
            /*--end*/
        }

        /*是否有子栏目，用于标记【全部】选中状态*/
        $result['has_children'] = model('Arctype')->hasChildren($tid);
        /*--end*/

        // seo
        $result['seo_title'] = set_typeseotitle($result['typename'], $result['seo_title'], $this->eyou['site']);

        $result['pageurl'] = typeurl('home/'.$result['ctl_name'].'/lists', $result, true, true);
        $result['pageurl'] = get_list_only_pageurl($result['pageurl'], $result['typeid'], $result['rulelist']);
        $result['pageurl_m'] = pc_to_mobile_url($result['pageurl'], $result['typeid']); // 获取当前页面对应的移动端URL
        // 移动端域名
        $result['mobile_domain'] = '';
        if (!empty($this->eyou['global']['web_mobile_domain_open']) && !empty($this->eyou['global']['web_mobile_domain'])) {
            $result['mobile_domain'] = $this->eyou['global']['web_mobile_domain'] . '.' . $this->request->rootDomain(); 
        }

        /*给没有type前缀的字段新增一个带前缀的字段，并赋予相同的值*/
        foreach ($result as $key => $val) {
            if (!preg_match('/^type/i', $key)) {
                $key_new = 'type' . $key;
                !array_key_exists($key_new, $result) && $result[$key_new] = $val;
            }
        }
        /*--end*/

        return $result;
    }

    /**
     * 留言提交
     */
    public function gbook_submit()
    {
        $typeid = input('post.typeid/d');
        if (IS_POST && !empty($typeid)) {
            $form_type = input('post.form_type/d', 0);
             $gourl = tpSetting('channel_guestbook.channel_guestbook_gourl');
            if (empty( $gourl)) {
                $gourl = input('post.gourl/s');
                $gourl = urldecode($gourl);
                $gourl = str_replace(['"',"'",';'], '', $gourl);
            }
            $post = input('post.');
            unset($post['gourl']);

            $token = '__token__';
            foreach ($post as $key => $val) {
                if (preg_match('/^__token__/i', $key)) {
                    $token = $key;
                    continue;
                }
              
            }
            $ip = clientIP();

            /*留言间隔限制*/
            $channel_guestbook_interval = tpSetting('channel_guestbook.channel_guestbook_interval');
            $channel_guestbook_interval = is_numeric($channel_guestbook_interval) ? intval($channel_guestbook_interval) : 60;
            if (0 < $channel_guestbook_interval) {
                $map   = array(
                    'typeid'   => $typeid,
                    'form_type'=> $form_type,
                    'ip'       => $ip,
                    'add_time' => array('gt', getTime() - $channel_guestbook_interval),
                );
                $count = Db::name('guestbook')->where($map)->count('aid');
                if ($count > 0) {
                    $msg = sprintf(foreign_lang('gbook2', $this->home_lang), $channel_guestbook_interval);
                    $this->error($msg);
                }
            }
            /*end*/

            $attrArr = [];
            /*多语言*/
            if (is_language()) {
                foreach ($post as $key => $val) {
                    if (preg_match_all('/^attr_(\d+)$/i', $key, $matchs)) {
                        $attr_value           = intval($matchs[1][0]);
                        $attrArr[$attr_value] = [
                            'attr_id' => $attr_value,
                        ];
                    }
                }
                if (1 == $form_type) {
                    $attrArr = model('LanguageAttr')->getBindValue($attrArr, 'form_attribute'); // 多语言
                } else {
                    $attrArr = model('LanguageAttr')->getBindValue($attrArr, 'guestbook_attribute'); // 多语言
                }
            }
            //判断必填项            
            $ContentArr = []; // 添加站内信所需参数
            foreach ($post as $key => $value) {
                if (stripos($key, "attr_") !== false) {
                    //处理得到自定义属性id
                    $attr_id = substr($key, 5);
                    $attr_id = intval($attr_id);
                    if (!empty($attrArr)) {
                        $attr_id = $attrArr[$attr_id]['attr_id'];
                    }
                    $ga_data = Db::name('guestbook_attribute')->where([
                        'attr_id'   => $attr_id,
                    ])->find();
                    if ($ga_data['required'] == 1) {
                        if (empty($value)) {
                            $msg = sprintf(foreign_lang('gbook3', $this->home_lang), $ga_data['attr_name']);
                            $this->error($msg);
                        } else {
                            if ($ga_data['validate_type'] == 6) {
                                $pattern  = "/^1\d{10}$/";
                                if (!preg_match($pattern, $value)) {
                                    $msg = sprintf(foreign_lang('gbook4', $this->home_lang), $ga_data['attr_name']);
                                    $this->error($msg);
                                }
                            } elseif ($ga_data['validate_type'] == 7) {
                                $pattern  = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
                                if (preg_match($pattern, $value) == false) {
                                    $msg = sprintf(foreign_lang('gbook4', $this->home_lang), $ga_data['attr_name']);
                                    $this->error($msg);
                                }
                            }
                        }
                    }
                    if (is_array($value)){
                        $value = implode('，', $value);
                    }
                    // 添加站内信所需参数
                    array_push($ContentArr, $value);
                }
            }

            /* 处理判断验证码 */
            $is_vertify        = 1; // 默认开启验证码
            $guestbook_captcha = config('captcha.guestbook');
            if (!function_exists('imagettftext') || empty($guestbook_captcha['is_on'])) {
                $is_vertify = 0; // 函数不存在，不符合开启的条件
            }
            if (1 == $is_vertify) {
                if (empty($post['vertify'])) {
                    $msg = foreign_lang('gbook5', $this->home_lang);
                    $this->error($msg);
                }

                $verify = new Verify();
                if (!$verify->check($post['vertify'], $token)) {
                    $msg = foreign_lang('gbook6', $this->home_lang);
                    $this->error($msg);
                }
            }
            /* END */

            if (1 == $form_type) {
                $channel = 0;
            } else {
                $channeltype_list = config('global.channeltype_list');
                $channel = !empty($channeltype_list['guestbook']) ? $channeltype_list['guestbook'] : 8;
            }

            $newData = array(
                'typeid'      => $typeid,
                'form_type'   => $form_type,
                'channel'     => $channel,
                'ip'          => $ip,
                'source'      => isMobile() ? 2 : 1,
                'lang'        => $this->home_lang,
                'add_time'    => getTime(),
                'update_time' => getTime(),
            );
            $data    = array_merge($post, $newData);

            // 查询手机验证码是否正确
            if (!empty($post['real_validate'])) {
                if (!empty($post['real_validate_phone_input']) && !empty($post['real_validate_attr_id'])) {
                    // 匹配手机号码，若为空则返回提示
                    $phone = !empty($post[$post['real_validate_attr_id']]) ? $post[$post['real_validate_attr_id']] : 0;
                    if (empty($phone)) {
                        $msg = foreign_lang('gbook7', $this->home_lang);
                        $this->error($msg);
                    }
                    // 查询手机号码和验证码是否匹配正确
                    $where = [
                        'source' => 7,
                        'mobile' => $phone,
                        'code' => $post['real_validate_phone_input']
                    ];
                    $smsLog = Db::name('sms_log')->where($where)->order('id desc')->find();
                    if (empty($smsLog)) {
                        $msg = foreign_lang('gbook8', $this->home_lang);
                        $this->error($msg);
                    }
                    // 验证码判断
                    $time = getTime();
                    $smsLog['add_time'] += \think\Config::get('global.mobile_default_time_out');
                    // 验证码不可用
                    if (1 === intval($smsLog['is_use']) || $smsLog['add_time'] <= $time) {
                        $msg = foreign_lang('gbook9', $this->home_lang);
                        $this->error($msg);
                    }
                    // 会员所有的未使用留言验证码设为已使用
                    $where = [
                        'source' => 7,
                        'mobile' => $phone,
                        'is_use' => 0,
                        'lang'   => $this->home_lang
                    ];
                    $update = [
                        'is_use' => 1,
                        'update_time' => $time
                    ];
                    Db::name('sms_log')->where($where)->update($update);
                    // 清理短信验证涉及的参数
                    unset($post['real_validate_input'], $post['real_validate_phone_input'], $post['real_validate_attr_id'], $post['real_validate_token']);
                } else {
                    $msg = foreign_lang('gbook10', $this->home_lang);
                    $this->error($msg);
                }
            }

            // 数据验证
            $rule     = [
                'typeid' => 'require|token:' . $token,
            ];
            $message  = [
                'typeid.require' => foreign_lang('gbook11', $this->home_lang),
            ];
            $validate = new \think\Validate($rule, $message);
            if (!$validate->batch()->check($data)) {
                $error     = $validate->getError();
                $error_msg = array_values($error);
                $this->error($error_msg[0]);
            } else {
                $guestbookRow = [];
                /*处理是否重复表单数据的提交*/
                $formdata = $data;
                foreach ($formdata as $key => $val) {
                    if (in_array($key, ['typeid', 'lang']) || preg_match('/^attr_(\d+)$/i', $key)) {
                        continue;
                    }
                    unset($formdata[$key]);
                }
                if (is_array($_FILES)) {
                    $formdata = array_merge($formdata, $_FILES);
                }
                $md5data         = md5(serialize($formdata));
                $data['md5data'] = $md5data;
                $users_id = session('users_id');
                $data['users_id'] = !empty($users_id) ? $users_id : 0;
                $guestbookRow    = Db::name('guestbook')->field('aid')->where(['md5data' => $md5data])->find();
                /*--end*/
                $dataStr = '';
                if (empty($guestbookRow)) { // 非重复表单的才能写入数据库
                    $examine = Db::name('form')->where('form_id',$typeid)->value('open_examine');
                    $data['examine'] = empty($examine) ? 1 : 0;
                    $aid = Db::name('guestbook')->insertGetId($data);
                    if ($aid > 0) {
                        $res = $this->saveGuestbookAttr($aid, $typeid, $post);
                        if ($res){
                            $this->error($res);
                        }
                    }
                    $_POST['aid'] = $aid;
                    /*插件 - 邮箱发送*/
                    $data    = [
                        'gbook_submit',
                        $typeid,
                        $aid,
                        $form_type,
                    ];
                    $dataStr = implode('|', $data);
                    /*--end*/

                    /*发送站内信给后台*/
                    SendNotifyMessage($ContentArr, 1, 1, 0,'',['aid'=>$aid]);
                    /* END */

                    // 留言表单通知
                    $params = [
                        'users_id' => $data['users_id'],
                        'result_id' => $aid,
                    ];
                    eyou_send_notice(1, $params);
                } else {
                    $_POST['aid'] = $guestbookRow['aid'];
                    // 存在重复数据的表单，将在后台显示在最前面
                    Db::name('guestbook')->where('aid', $guestbookRow['aid'])->update([
                        'is_read' => 0,
                        'add_time' => getTime(),
                        'update_time' => getTime(),
                    ]);
                }
                
                $msg = foreign_lang('gbook1', $this->home_lang);
                $channel_guestbook_time = tpSetting('channel_guestbook.channel_guestbook_time');
                $channel_guestbook_time = !empty($channel_guestbook_time) ? intval($channel_guestbook_time) : 5;
                $this->success($msg, $gourl, $dataStr, $channel_guestbook_time);
            }
        }
        $msg = foreign_lang('gbook11', $this->home_lang);
        $this->error($msg);
    }

    /**
     *  给指定留言添加表单值到 guestbook_attr
     * @param int $aid 留言id
     * @param int $typeid 留言栏目id
     */
    private function saveGuestbookAttr($aid, $typeid, $post)
    {
        // post 提交的属性  以 attr_id _ 和值的 组合为键名    
        // $post = input("post.");
        $image_type_list = explode('|', tpCache('global.image_type'));
        /*上传图片或附件*/
        foreach ($_FILES as $fileElementId => $file) {
            try {
                if (is_array($file['name'])) {
                    $files = $this->request->file($fileElementId);
                    foreach ($files as $key => $value) {
                        $ext = pathinfo($value->getInfo('name'), PATHINFO_EXTENSION);
                        if (in_array($ext, $image_type_list)) {
                            $uplaod_data = func_common($fileElementId, 'allimg', '', $value);
                        } else {
                            $uplaod_data = func_common_doc($fileElementId, 'files', '', $value);
                        }
                        if (0 == $uplaod_data['errcode']) {
                            if (empty($post[$fileElementId])) {
                                $post[$fileElementId] = $uplaod_data['img_url'];
                            } else {
                                $post[$fileElementId] .= ',' . $uplaod_data['img_url'];
                            }
                        } else {
                            return $uplaod_data['errmsg'];
                        }
                    }
                } else {
                    if (!empty($file['name']) && !is_array($file['name'])) {
                        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                        if (in_array($ext, $image_type_list)) {
                            $uplaod_data = func_common($fileElementId, 'allimg');
                        } else {
                            $uplaod_data = func_common_doc($fileElementId, 'files');
                        }
                        if (0 == $uplaod_data['errcode']) {
                            $post[$fileElementId] = $uplaod_data['img_url'];
                        } else {
                            return $uplaod_data['errmsg'];
                        }
                    }
                }
            } catch (\Exception $e) {}
        }

        $attrArr = [];

        /*多语言*/
        if (is_language()) {
            foreach ($post as $key => $val) {
                if (preg_match_all('/^attr_(\d+)$/i', $key, $matchs)) {
                    $attr_value           = intval($matchs[1][0]);
                    $attrArr[$attr_value] = [
                        'attr_id' => $attr_value,
                    ];
                }
            }
            if (!empty($post['form_type'])) {
                $attrArr = model('LanguageAttr')->getBindValue($attrArr, 'form_attribute'); // 多语言
            } else {
                $attrArr = model('LanguageAttr')->getBindValue($attrArr, 'guestbook_attribute'); // 多语言
            }
        }
        /*--end*/

        foreach ($post as $k => $v) {
            if (!strstr($k, 'attr_')) continue;
            $attr_id = str_replace('attr_', '', $k);
            if (is_array($v)) {
                $v = implode(PHP_EOL, $v);
            } else {
                $ga_data = Db::name('guestbook_attribute')->where([
                    'attr_id'   => $attr_id,
                ])->find();
                if (!empty($ga_data) && 10 == $ga_data['attr_input_type']){
                    $v = strtotime($v);
                }
            }

            /*多语言*/
            if (!empty($attrArr)) {
                $attr_id = $attrArr[$attr_id]['attr_id'];
            }
            /*--end*/

            //$v = str_replace('_', '', $v); // 替换特殊字符
            //$v = str_replace('@', '', $v); // 替换特殊字符
            $v       = trim($v);
            $adddata = array(
                'aid'         => $aid,
                'form_type'   => empty($post['form_type']) ? 0 : intval($post['form_type']),
                'attr_id'     => $attr_id,
                'attr_value'  => $v,
                'lang'        => $this->home_lang,
                'add_time'    => getTime(),
                'update_time' => getTime(),
            );
            Db::name('guestbook_attr')->add($adddata);
        }
    }
}