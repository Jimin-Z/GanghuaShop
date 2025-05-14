<?php
namespace wstmart\common\model;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 快递业务处理类
 */
use think\Db;
class Express extends Base{
	protected $pk = 'expressId';
    /**
	 * 获取快递列表
	 */
    public function listQuery(){
         return $this->where(['dataFlag'=>1,'isShow'=>1])->select();
    }
	/**
	 * 商家启用的快递
	 */
    public function shopExpressList($sId=0){
		$shopId = $sId==0?(int)session('WST_USER.shopId'):$sId;
		$where = [];
		$where[] = ["shopId","=",$shopId];
		$where[] = ["isEnable","=",1];
		$where[] = ["se.dataFlag","=",1];
		$where[] = ["e.dataFlag","=",1];
		$rs = Db::name("shop_express se")
				->join("express e","se.expressId=e.expressId","inner")
				->field("se.id,e.expressId,e.expressName")
				->where($where)
				->select();
		return $rs;
	}
	/**
	 * 供货商启用的快递
	 */
    public function supplierExpressList($sId=0){
		$supplierId = $sId==0?(int)session('WST_SUPPLIER.supplierId'):$sId;
		$where = [];
		$where[] = ["supplierId","=",$supplierId];
		$where[] = ["isEnable","=",1];
		$where[] = ["se.dataFlag","=",1];
		$where[] = ["e.dataFlag","=",1];
		$rs = Db::name("supplier_express se")
				->join("express e","se.expressId=e.expressId","inner")
				->field("se.id,e.expressId,e.expressName")
				->where($where)
				->select();
		return $rs;
	}

    /**
     * 快递列表
     */
    public function pageQuery($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $ename = input("expressName");
        $where = [];
        $where[] = ["e.dataFlag","=",1];
        $where[] = ["e.isShow","=",1];
        if($ename!="")$where[] = ["e.expressName","like",'%'.$ename.'%'];
        $page = Db::name("express e")
            ->join("shop_express se","e.expressId=se.expressId and se.dataFlag=1 and se.shopId=$shopId","left")
            ->field("e.expressId,e.expressName,e.expressCode,se.id,se.isEnable,se.isDefault")
            ->where($where)
            ->paginate(input('limit/d'))->toArray();
        return $page;
    }

    /**
     * 启用快递
     */
    public function enableExpress($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $expressId = (int)input("expressId");
        $spExpress = Db::name("shop_express")->where(["shopId"=>$shopId,"expressId"=>$expressId,"dataFlag"=>1])->find();
        Db::startTrans();
        try{
            if(empty($spExpress)){
                $cnt = Db::name("shop_express")->where(["shopId"=>$shopId,"dataFlag"=>1])->count();
                $isDefault = ($cnt==0)?1:0;
                $data = [];
                $data["expressId"] = $expressId;
                $data["isEnable"] = 1;
                $data["isDefault"] = $isDefault;
                $data["dataFlag"] = 1;
                $data["shopId"] = $shopId;
                $id = Db::name("shop_express")->insertGetId($data);

                $data = [];
                $data["shopExpressId"] = $id;
                $data["tempName"] = "默认模板(全国)";
                $data["tempType"] = 0;
                $data["provinceIds"] = '';
                $data["cityIds"] = '';
                $data["weightStart"] = 0;
                $data["weightStartPrice"] = 0;
                $data["weightContinue"] = 0;
                $data["weightContinuePrice"] = 0;
                $data["shopId"] = $shopId;
                $data["createTime"] = date("Y-m-d H:i:s");
                Db::name("shop_freight_template")->insert($data);
            }else{
                $id = $spExpress["id"];
                Db::name("shop_express")->where(["id"=>$id])->update(["isEnable"=>1]);
            }
            Db::commit();
        }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn("",1);
    }

    /**
     * 停用快递
     */
    public function disableExpress($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $id = (int)input("id");
        Db::name("shop_express")->where(["id"=>$id,"shopId"=>$shopId])->update(["isEnable"=>0]);
        return WSTReturn("",1);
    }

    public function getShopExpressInfo($shopExpressId,$sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $rs = Db::name("shop_express se")
            ->join("express e","e.expressId=se.expressId and e.isShow=1 and e.dataFlag=1","inner")
            ->field("e.expressId,e.expressName")
            ->where(["se.id"=>$shopExpressId,"shopId"=>$shopId])
            ->find();
        return $rs;
    }

    /**
     * 快递列表
     */
    public function listQuery2(){
        $tname = input("tempName");
        $shopExpressId = (int)input("shopExpressId");
        $where = [];
        $where[] = ["dataFlag","=",1];
        $where[] = ["shopExpressId","=",$shopExpressId];
        if($tname!="")$where[] = ["tempName","like",'%'.$tname.'%'];
        $list = Db::name("shop_freight_template")
            ->where($where)
            ->paginate(input('limit/d'))->toArray();
        return $list;
    }

    /**
     * 删除运费模板
     */
    public function del($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $id = (int)input('post.id');
        $data = [];
        $data['dataFlag'] = -1;
        Db::startTrans();
        try{
            $where = [];
            $where[] = ["shopId",'=',$shopId];
            $where[] = ["id",'=',$id];
            $where[] = ["tempType",'=',1];
            Db::name("shop_freight_template")
                ->where(["shopId"=>$shopId,"id"=>$id])
                ->update(['dataFlag'=>-1]);
            Db::commit();
            return WSTReturn("删除成功", 1);
        }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('删除失败',-1);
    }

    public function getFreightById($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $id = (int)input("id");
        $rs = Db::name("shop_freight_template")->where(["id"=>$id,"shopId"=>$shopId])->find();
        return $rs;
    }

    /**
     * 新增运费模板
     */
    public function add($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $data = input('post.');
        if($data["tempName"]=="")return WSTReturn('请输入模板名称',-1);
        if($data["provinceIds"]=="")return WSTReturn('请选择地区',-1);
        $shopExpressId = (int)$data['shopExpressId'];
        $otherAreas = $this->getOtherAreas(0,$shopExpressId,$shopId);
        $otherCityIds = $otherAreas["otherCityIds"];
        $cityIds = explode(",",$data['cityIds']);

        foreach ($cityIds as $key => $cityId) {
            if(in_array($cityId,$otherCityIds)){
                return WSTReturn('选择地区已存在于其他运费模板',-1);
            }
        }
        $temp = [];
        $temp["shopExpressId"] = $shopExpressId;
        $temp["shopId"] = $shopId;
        $temp["tempName"] = $data['tempName'];
        $temp["provinceIds"] = $data['provinceIds'];
        $temp["cityIds"] = $data['cityIds'];


        $temp["buyNumStart"] = (float)$data['buyNumStart'];
        $temp["buyNumStartPrice"] = (float)$data['buyNumStartPrice'];
        $temp["buyNumContinue"] = (float)$data['buyNumContinue'];
        $temp["buyNumContinuePrice"] = (float)$data['buyNumContinuePrice'];

        $temp["weightStart"] = (float)$data['weightStart'];
        $temp["weightStartPrice"] = (float)$data['weightStartPrice'];
        $temp["weightContinue"] = (float)$data['weightContinue'];
        $temp["weightContinuePrice"] = (float)$data['weightContinuePrice'];

        $temp["volumeStart"] = (float)$data['volumeStart'];
        $temp["volumeStartPrice"] = (float)$data['volumeStartPrice'];
        $temp["volumeContinue"] = (float)$data['volumeContinue'];
        $temp["volumeContinuePrice"] = (float)$data['volumeContinuePrice'];

        $temp["dataFlag"] = 1;
        $temp["tempType"] = 1;
        $temp["createTime"] = date("Y-m-d H:i:s");
        $result = Db::name("shop_freight_template")->insert($temp);
        if(false !== $result){
            return WSTReturn("新增成功", 1);
        }
        return WSTReturn('新增失败',-1);
    }

    /**
     * 修改运费模板
     */
    public function edit($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        Db::startTrans();
        try{
            $data = input('post.');
            $id = (int)$data["id"];
            $ftemp = Db::name("shop_freight_template")->where(["shopId"=>$shopId,"id"=>$id])->find();
            if($data["tempName"]=="")return WSTReturn('请输入模板名称',-1);
            if($ftemp["tempType"]==1 && $data["provinceIds"]=="")return WSTReturn('请选择省份',-1);

            $temp = [];
            $temp["tempName"] = $data['tempName'];
            if($ftemp["tempType"]==1){
                $temp["provinceIds"] = $data['provinceIds'];
                $temp["cityIds"] = $data['cityIds'];
                $otherAreas = $this->getOtherAreas($id,$ftemp['shopExpressId'],$shopId);
                $otherCityIds = $otherAreas["otherCityIds"];
                $cityIds = explode(",",$data['cityIds']);

                foreach ($cityIds as $key => $cityId) {
                    if(in_array($cityId,$otherCityIds)){
                        return WSTReturn('选择地区已存在于其他运费模板',-1);
                    }
                }
            }
            $temp["buyNumStart"] = (float)$data['buyNumStart'];
            $temp["buyNumStartPrice"] = (float)$data['buyNumStartPrice'];
            $temp["buyNumContinue"] = (float)$data['buyNumContinue'];
            $temp["buyNumContinuePrice"] = (float)$data['buyNumContinuePrice'];

            $temp["weightStart"] = (float)$data['weightStart'];
            $temp["weightStartPrice"] = (float)$data['weightStartPrice'];
            $temp["weightContinue"] = (float)$data['weightContinue'];
            $temp["weightContinuePrice"] = (float)$data['weightContinuePrice'];

            $temp["volumeStart"] = (float)$data['volumeStart'];
            $temp["volumeStartPrice"] = (float)$data['volumeStartPrice'];
            $temp["volumeContinue"] = (float)$data['volumeContinue'];
            $temp["volumeContinuePrice"] = (float)$data['volumeContinuePrice'];
            Db::name("shop_freight_template")
                ->where(["shopId"=>$shopId,"id"=>$id])
                ->update($temp);
            Db::commit();
            return WSTReturn("修改成功", 1);

        }catch (\Exception $e) {
            Db::rollback();
            return WSTReturn("修改失败", -1);
        }
    }

    public function getOtherAreas($id,$shopExpressId,$sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $where = [];
        if($id>0)$where[] = ["id","<>",$id];
        $where[] = ["dataFlag","=",1];
        $where[] = ["tempType","=",1];
        $where[] = ["shopId","=",$shopId];
        $where[] = ["shopExpressId","=",$shopExpressId];
        $list = Db::name("shop_freight_template")->where($where)->field("id,provinceIds,cityIds")->select();

        $otherProvinceIds = [];
        $otherCityIds = [];
        foreach ($list as $key => $vo) {
            $otherProvinceIds = array_merge(explode(",", $vo['provinceIds']),$otherProvinceIds);
            $otherCityIds = array_merge(explode(",", $vo['cityIds']),$otherCityIds);
        }
        $data = [];
        $data['otherProvinceIds'] = array_unique($otherProvinceIds);
        $data['otherCityIds'] = array_unique($otherCityIds);
        return $data;
    }
}
