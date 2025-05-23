<?php
namespace wstmart\mobile\controller;
use wstmart\common\model\Informs as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商品举报控制器
 */
class Informs extends Base{
    protected $beforeActionList = [
        'checkAuth'  =>  ['except'=>'tips'],
    ];
    /**
     * 举报详情页
     */
    public function detail(){
        $userId = (int)session('WST_USER.userId');
        $data = model('Informs')->getUserInformDetail(0, $userId);
        $step = 2;
        if(isset($data['informStatus']) && $data['informStatus']>0){
            $step = 3;
        }
        return $this->fetch('users/informs/detail', ['step'=>$step, 'data'=>$data]);
    }

    /**
     * 商品举报页
     */
    public function index(){
        return $this->fetch('users/informs/index', ['goodsId'=>(int)input('goodsId'), 'step'=>1,]);
    }

    /**
     * 商品举报页
     */
    public function listQuery(){
        $informType = (new M())->informStatus();
        $this->assign("informType",$informType['data']);
        return $this->fetch('users/informs/list');
    }

    /**
     * 获取举报处理结果
     */
    public function informStatus(){
        $rs = (new M())->informStatus();
        return $rs;
    }

    /**
    * 获取用户举报列表
    */
    public function pageQuery(){
        $m = model('Informs');
        $userId = (int)session('WST_USER.userId');
        $rs = $m->queryUserInformByPage($userId);
        return $rs;

    }
    /**
     * 举报须知
     */
    public function tips(){
        $m = new M();
        $tips = $m->tips();
        return $this->fetch('users/informs/tips', ['tips'=>$tips]);
    }

    /**
     * 商品举报页面
     */
    public function inform(){
        $userId = (int)session('WST_USER.userId');
    	$m = new M();
        $data = $m->inform($userId);
        return $data;
    }
    /**
     * 保存举报信息
     */
    public function saveInform(){
        $userId = (int)session('WST_USER.userId');
        $rs = model('Informs')->saveInform($userId);
        return $rs;
    }


}
