<?php
namespace wstmart\common\model;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 插件类
 */
class Addons extends Base{
   
	public function getAddonsMaps(){
		$addons = WSTCache('WST_ADDONS_MAPS');
		if(!$addons){
			$list = $this->where(["dataFlag"=>1])->field("name,title")->select();
			$addons = array();
			for($i=0,$j=count($list);$i<$j;$i++){
				$addon = $list[$i];
				$addons[strtolower($addon["name"])] = $addon["title"];
			}
			WSTCache('WST_ADDONS_MAPS',$addons,86400);
		}
		return $addons;
	}

}
