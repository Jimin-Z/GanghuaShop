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

/**
 * 自定义字段
 */
class TagDiyfield extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 自定义字段
     * @author wengxianhu by 2018-4-20
     */
    public function getDiyfield($data = '', $type = 'default')
    {
        if (!empty($data)) {
            switch ($type) {
                case 'imgs': // 多图
                    {
                        $list = [];
                        foreach ($data as $key => $val) {
                            $val['image_url'] = handle_subdir_pic($val['image_url']);
                            $list[$key] = $val;
                        }
                        $data = $list;
                    }
                    break;

                case 'files': // 多文件
                    {
                        $list = [];
                        foreach ($data as $key => $val) {
                            $list[$key]['downurl'] = handle_subdir_pic($val);
                            $list[$key]['title'] = '';
                        }
                        $data = $list;
                    }
                    break;
                
                case 'radio': // 单选项
                case 'select': // 下拉框
                case 'checkbox': // 多选项
                    {
                        $list = [];
                        $row = [];
                        if (is_array($data)) {
                            $row = $data;
                        } else {
                            $row = explode(',', $data);
                        }
                        foreach ($row as $key => $val) {
                            $list[$key]['value'] = $val;
                        }
                        $data = $list;
                    }
                    break;

                default:
                    {
                        $list = [];
                        $row = [];
                        if (is_array($data)) {
                            $row = $data;
                        } else {
                            $row[] = $data;
                        }
                        foreach ($row as $key => $val) {
                            $list[$key]['value'] = $val;
                        }
                        $data = $list;
                    }
                    break;
            }
        }

        return $data;
    }
}