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

// 模板错误提示
switch_exception();

if (!function_exists('is_adminlogin')) 
{
    /**
     * 检验登陆
     * @param
     * @return bool
     */
    function is_adminlogin(){
        $admin_id = session('admin_id');
        return (isset($admin_id) && $admin_id > 0) ? $admin_id : false;
    }
}

if (!function_exists('apiAdminLog'))
{
    /**
     * 管理员操作记录
     * @param $log_url 操作URL
     * @param $log_info 记录信息
     */
    function apiAdminLog($log_info = ''){
        $admin_id = session('admin_id');
        $admin_id = !empty($admin_id) ? $admin_id : -2;
        $add['log_time'] = getTime();
        $add['admin_id'] = $admin_id;
        $add['log_info'] = $log_info;
        $add['log_ip'] = clientIP();
        $add['log_url'] = request()->baseUrl() ;
        M('admin_log')->add($add);
    }
}

if (!function_exists('push_bdminiproapi'))
{
    /**
     * 将新链接推送给百度
     * 将小程序资源 path 路径，提交到 API 接口中
     */
    function push_bdminiproapi($access_token = '',$type = '1', $aid = '', $typeid = '')
    {
        $aid = intval($aid);
        $typeid = intval($typeid);

        $urls = '';
        if (!empty($aid)){
            $nid = \think\Db::name('archives')->alias('a')->join('channeltype b','a.channel = b.id')->where('a.aid',$aid)->value('b.nid');
            if ('single' == $nid){
                $urls = 'pages/article/single?typeid='.$typeid;
            }else{
                $urls = 'pages/article/view?aid='.$aid;
            }
        }elseif (!empty($typeid)){
            $urls = 'pages/article/list?typeid='.$typeid;
        }

        $data['type'] = $type;
        $data['url_list'] = $urls;
        $url         = 'https://openapi.baidu.com/rest/2.0/smartapp/access/submitsitemap/api?access_token='.$access_token;
        $response   = httpRequest($url, 'POST', $data);
        $result    = json_decode($response, true);

        return $result;
    }
}