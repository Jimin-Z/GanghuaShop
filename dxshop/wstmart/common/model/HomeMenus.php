<?php
namespace wstmart\common\model;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 菜单业务处理
 */
class HomeMenus extends Base{
	/**
	 * 获取菜单树
	 */
	public function getMarray($v){
		return ['menuId'=>$v['menuId'],'parentId'=>$v['parentId'],'menuName'=>$v['menuName'],'menuUrl'=>$v['menuUrl']];
	}
	public function bbbbgetMenus(){
		//$data = WSTCache('WST_HOME_MENUS');
		//if(!$data){
			$rs = $this->where(['isShow'=>1,'dataFlag'=>1,'f_type'=>'01'])
			        ->field('menuId,parentId,menuName,menuUrl,menuType,f_code,menu')->order('f_code')->select();
			$m1 = ['0'=>[],'1'=>[]];
			$tmp = [];
			
			//获取第一级
			foreach ($rs as $key => $v){
				if($v['menu']==0){
					$m1[$v['menuType']][$v['menuId']] =$this->getMarray($v);
					$s1=substr($v['f_code'], 0,3);
					$rs2=array();//获取第二级
					foreach ($rs as $key2 => $v2){
						if(($v2['menu']==1)&&($s1==substr($v2['f_code'], 0,3))){
							$rs0=$this->getMarray($v2);
							$rs0['list']=$this->getMenu3($rs,$v2,2);
							$rs2[]=$rs0;
						}

					}
					$m1[$v['menuType']][$v['menuId']]['list'] =$rs2; //获取第二级
				}
			}
			//获取第二级
		
			put_msg($m1);
			//WSTCache('WST_HOME_MENUS',$m1,31536000);
			return $m1;
	//	}
		put_msg($data);
		return $data;
	}
	
function getMenu3($rs,$v3,$l){
      $rs2=array();//获取第二级
      $ln=3*$l;
      $s1=substr($v3,0,$ln);
	 foreach ($rs as $key2 => $v2){
		if(($v2['menu']==$l)&&($s1==substr($v2['f_code'], 0,$ln))){
			$rs2[]=$this->getMarray($v2);
		}
    }
    return $rs2;
}
	public function getMenus(){
		//$data = WSTCache('WST_HOME_MENUS');
		//if(!$data){
			$rs = $this->where(['isShow'=>1,'dataFlag'=>1])
			        ->field('menuId,parentId,menuName,menuUrl,menuType')->order('menuSort asc,menuId asc')->select();
			$m1 = ['0'=>[],'1'=>[]];
			$tmp = [];
			
			//获取第一级
			foreach ($rs as $key => $v){
				if($v['parentId']==0){
					$m1[$v['menuType']][$v['menuId']] = ['menuId'=>$v['menuId'],'parentId'=>$v['parentId'],'menuName'=>$v['menuName'],'menuUrl'=>$v['menuUrl']];
				}else{
					$tmp[$v['parentId']][] = ['menuId'=>$v['menuId'],'parentId'=>$v['parentId'],'menuName'=>$v['menuName'],'menuUrl'=>$v['menuUrl']];
				}
			}
			//获取第二级
			foreach ($m1 as $key => $v){
				foreach ($v as $key1 => $v1){
				    if(isset($tmp[$v1['menuId']]))$m1[$key][$key1]['list'] = $tmp[$v1['menuId']];
				}
			}
			//获取第三级
		    foreach ($m1 as $key => $v){
		    	foreach ($v as $key1 => $v1){
			    	if(isset($v1['list'])){
				    	foreach ($v1['list'] as $key2 => $v2){
						    if(isset($tmp[$v2['menuId']]))$m1[$key][$key1]['list'][$key2]['list'] = $tmp[$v2['menuId']];
				    	}
			    	}
		    	}
			}
		//	put_msg($m1);
			//WSTCache('WST_HOME_MENUS',$m1,31536000);
			return $m1;
	//	}
		put_msg($data);
		return $data;
	}
	/**
	 * 获取菜单URL
	 */
	public function getMenusUrl(){
		$data = WSTCache('WST_PRO_MENUS');
		if(!$data){
			$list = $this->where('dataFlag',1)->order('menuType asc')->select();
			$menus = [];
			foreach($list as $key => $v){
				$menus[strtolower($v['menuUrl'])] = $v['menuType'];
				if($v['menuOtherUrl']!=''){
					$str = explode(',',$v['menuOtherUrl']);
					foreach ($str as $vkey => $vv){
						if($vv=='')continue;
						$menus[strtolower($vv)] = $v['menuType'];
					}
				}
			}
			WSTCache('WST_PRO_MENUS',$menus,31536000);
			return $menus;
		}
		return $data;
	}

	/**
	 * 角色可访问url
	 */
	public function getShopMenuUrls(){
		$wst_user = session('WST_USER');
		$shopUrls = [];
		if(!empty($wst_user)){
			$roleId = isset($wst_user["roleId"])?(int)$wst_user["roleId"]:0;
			if($roleId>0){
				$role = model("shop/ShopRoles")->getById($roleId);
				$menuUrls = $role["menuUrls"];
				$shopUrls = array_merge($menuUrls,$shopUrls);
			}
		}
		return $shopUrls;
	}

	/**
	 * 获取菜单父ID
	 */
	public function getParentId($menuId){
		$data = WSTCache('WST_HOME_MENUS_PARENT');
		if(!$data){
			$rs = $this->where(['isShow'=>1,'dataFlag'=>1])
			        ->field('menuId,parentId,menuType')->order('menuSort asc,menuId asc')->select();
			$tmp = [];
			foreach ($rs as $key => $v) {
			    $tmp[$v['menuId']] = $v;
			}
			$data = [];
            foreach ($tmp as $key => $v) {
            	if($v['parentId']==0){
                    $data[$v['menuId']] = $v;
            	}else{
                    $data[$v['menuId']] = $tmp[$v['parentId']];
            	}
			} 
            WSTCache('WST_HOME_MENUS_PARENT',$data,31536000);
		}
		return $data[$menuId];	
	}
	
}
