<?php
namespace wstmart\store\behavior;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 记录用户的访问日志
 */
class ListenOperate 
{
    public function run($params){
        if(session("WST_STORE.shopId")>0){

      
            $urls = session("WST_STORE.storeMenuMaps");
            $request = request();
            $visit = strtolower($request->module()."/".$request->controller()."/".$request->action());
            if(array_key_exists($visit,$urls)){
                $privilege = $urls[$visit];
                $data = [];
                $data['menuId'] = $privilege['menuId'];
                $data['operateUrl'] = $_SERVER['REQUEST_URI'];
                $data['operateDesc'] = $privilege['menuName'];
                $data['content'] = !empty($_REQUEST)?json_encode($_REQUEST):'';
                $data['operateIP'] = $request->ip();
                $data['operateSrc'] = 1;
                model('store/LogOperates')->add($data);
            }
        }
    }
}