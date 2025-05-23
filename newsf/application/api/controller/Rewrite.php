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

namespace app\api\controller;

class Rewrite extends Base
{
    /*
     * 初始化操作
     */
    
    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 检测服务器是否支持URL重写隐藏应用的入口文件index.php
     */
    public function testing()
    {
        ob_clean();
        exit('Congratulations on passing');
    }

    /**
     * 设置隐藏index.php
     */
    public function setInlet()
    {
        $seo_inlet = input('param.seo_inlet/d', 1);
        /*多语言*/
        if (is_language()) {
            $langRow = \think\Db::name('language')->order('id asc')->select();
            foreach ($langRow as $key => $val) {
                tpCache('seo', ['seo_inlet'=>$seo_inlet], $val['mark']);
            }
        } else { // 单语言
            tpCache('seo', ['seo_inlet'=>$seo_inlet]);
        }
        /*--end*/
        ob_clean();
        exit('Congratulations on passing');
    }

    /**
     * 关闭父弹框
     */
    public function close_parent_layer()
    {
        $version = getCmsVersion();
        $str = <<<EOF
    <script type="text/javascript" src="{$this->root_dir}/public/static/common/js/jquery.min.js?v={$version}"></script>
    <script type="text/javascript" src="{$this->root_dir}/public/plugins/layer-v3.1.0/layer.js?v={$version}"></script>
    <script type="text/javascript">
        $(function(){
            parent.layer.closeAll();
        });
    </script>
EOF;
        echo $str;
        exit;
    }
}