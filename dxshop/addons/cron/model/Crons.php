<?php
namespace addons\cron\model;
use think\addons\BaseModel as Base;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 计划任务业务处理
 */
class Crons extends Base{
	/***
     * 安装插件
     */
    public function install(){
    	Db::startTrans();
		try{
			$hooks = ['initCronHook'];
			$this->bindHoods("Cron", $hooks);
			//管理员后台
			$rs = Db::name('menus')->insert(["parentId"=>2,"menuName"=>"计划任务","menuSort"=>11,"dataFlag"=>1,"isShow"=>1,"menuMark"=>"cron"]);
			if($rs!==false){
				$datas = [];
				$parentId = Db::name('menus')->getLastInsID();
				$datas[] = ["menuId"=>$parentId,"privilegeCode"=>"CRON_JHRW_00","privilegeName"=>"查看计划任务","isMenuPrivilege"=>1,"privilegeUrl"=>"/addon/cron-cron-index","otherPrivilegeUrl"=>"/addon/cron-cron-pageQuery","dataFlag"=>1,"isEnable"=>1];
				$datas[] = ["menuId"=>$parentId,"privilegeCode"=>"CRON_JHRW_04","privilegeName"=>"操作计划任务","isMenuPrivilege"=>0,"privilegeUrl"=>"/addon/cron-cron-toEdit","otherPrivilegeUrl"=>"/addon/cron-cron-edit,/addon/cron-cron-changeEnableStatus,/addon/cron-cron-runCron,/addon/cron-cron-del","dataFlag"=>1,"isEnable"=>1];
				Db::name('privileges')->insertAll($datas);
			}
			installSql("cron");
			Db::commit();
			return true;
		}catch (\Exception $e) {
	 		Db::rollback();

	  		return false;
	   	}
    }

	/**
	 * 删除菜单
	 */
	public function uninstall(){
		Db::startTrans();
		try{
			$hooks = ['initCronHook'];
			$this->unbindHoods("Cron", $hooks);
			Db::name('menus')->where("menuMark",'=',"cron")->delete();
			Db::name('privileges')->where("privilegeCode","like","CRON_%")->delete();
            uninstallSql("cron");//传入插件名
			Db::commit();
			return true;
		}catch (\Exception $e) {
	 		Db::rollback();
	  		return false;
	   	}
	}
	/**
	 * 分页
	 */
	public function pageQuery(){
		return $this->order('id desc')->paginate(input('limit/d'));
	}
	/**
	 * 列表
	 */
    public function listQuery(){
		return $this->order('id desc')->select();
	}
	public function getById($id){
		$rs = $this->get($id);
		if($rs['cronJson']!='')$rs['cronJson'] = unserialize($rs['cronJson']);
		return $rs;
	}
	/**
	 * 新增
	 */
	public function add(){
		$data = input('post.');
		unset($data['id']);
		$data['isRunSuccess'] = 0;
		$data['cronMinute'] = str_replace('，',',',$data['cronMinute']);
		if($data['cronMinute']=='')$data['cronMinute'] = '0';
		Db::startTrans();
		try{
			if($data['cronName']=='')return WSTReturn('请输入计划任务名称');
			if($data['cronDesc']=='')return WSTReturn('请输入计划任务描述');
			if($data['cronUrl']=='')return WSTReturn('请输入定时任务网址');
			$data['cronCycle'] = (int)$data['cronCycle'];
			if(!in_array($data['cronCycle'],[0,1,2]))return WSTReturn('无效的计划时间');
			if($data['cronDay']<=0 || $data['cronDay']>=32)return WSTReturn('无效的计划日期');
			if($data['cronWeek']<0 || $data['cronWeek']>6)return WSTReturn('无效的计划星期');
			$data['cronMinute'] = str_replace('，',',',$data['cronMinute']);
			if(stripos($data['cronMinute'],',')!==false){
                $mins = WSTFormatIn(',',$data['cronMinute'],false);
                foreach ($mins as $key => $vm) {
                	if($vm<0 || $vm>59)return WSTReturn('无效的计划时间');
                }
			}else{
				if((int)$data['cronMinute']<0 || (int)$data['cronMinute']>59)return WSTReturn('无效的计划时间');
			}
			
			$json = [];
			foreach ($json as $key => $v) {
				$json[$key]['fieldVal'] = input('post.'.$v['fieldCode']);
			}
			$data['cronJson'] = serialize($json);
			$data['isEnable'] = (int)$data['isEnable'];
			$data['nextTime'] = $this->getNextRunTime($data);
			$result = $this->save($data);
	        if(false !== $result){
	        	cache('WST_CRONS',null);
	        	Db::commit();
	        	return WSTReturn("新增成功", 1);
	        }
	    }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('新增失败',-1);  
	}
    /**
	 * 编辑
	 */
	public function edit(){
		$data = input('post.');
		$data['cronMinute'] = str_replace('，',',',$data['cronMinute']);
		if($data['cronMinute']=='')$data['cronMinute'] = '0';
		Db::startTrans();
		try{
			$corn = $this->get((int)$data['id']);
			if($data['cronName']=='')return WSTReturn('请输入计划任务名称');
			if($data['cronDesc']=='')return WSTReturn('请输入计划任务描述');
			if($data['cronUrl']=='')return WSTReturn('请输入定时任务网址');
			$data['cronCycle'] = (int)$data['cronCycle'];
			if(!in_array($data['cronCycle'],[0,1,2]))return WSTReturn('无效的计划时间');
			if($data['cronDay']<=0 || $data['cronDay']>=32)return WSTReturn('无效的计划日期');
			if($data['cronWeek']<0 || $data['cronWeek']>6)return WSTReturn('无效的计划星期');
			$data['cronMinute'] = str_replace('，',',',$data['cronMinute']);
			if(stripos($data['cronMinute'],',')!==false){
                $mins = WSTFormatIn(',',$data['cronMinute'],false);
                foreach ($mins as $key => $vm) {
                	if($vm<0 || $vm>59)return WSTReturn('无效的计划时间');
                }
			}else{
				if((int)$data['cronMinute']<0 || (int)$data['cronMinute']>59)return WSTReturn('无效的计划时间');
			}
			$json = [];
			foreach ($json as $key => $v) {
				$json[$key]['fieldVal'] = input('post.'.$v['fieldCode']);
			}
			$data['cronJson'] = serialize($json);
			$data['isEnable'] = (int)$data['isEnable'];
			$data['nextTime'] = $this->getNextRunTime($data);
			$result = $corn->where('id',(int)$data['id'])->update($data);
	        if(false !== $result){
	        	cache('WST_CRONS',null);
	        	Db::commit();
	        	return WSTReturn("编辑成功", 1);
	        }
	    }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('编辑失败',-1);  
	}
	/**
	 * 删除
	 */
    public function changeEnableStatus(){
	    $id = (int)input('post.id/d');
	    $status = ((int)input('post.status/d')==1)?1:0;
	    Db::startTrans();
		try{
		    $result = $this->setField(['isEnable'=>$status,'id'=>$id]);
	        if(false !== $result){
	        	cache('WST_CRONS',null);
	        	Db::commit();
	        	return WSTReturn("操作成功", 1);
	        }
		}catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('操作失败',-1); 
	}

	/**
	 * 执行计划任务
	 */
	public function runCron(){
		$id = (int)input('post.id');
		$cron = $this->get($id);
		if(!$cron)return WSTReturn('计划任务不存在，跳过此次执行',1);
		if($cron->isEnable==0)return WSTReturn('任务执行未开启中，跳过此次执行',1);
		if($cron->isRunning==1)return WSTReturn('已有任务执行中，跳过此次执行',1);
		$cron->runTime = date('Y-m-d H:i:s');
		$cron->nextTime = $this->getNextRunTime($cron);
		Db::startTrans();
		try{
	        $cron->isRunning = 1;
	        $cron->save();
	        $domain = request()->root(true);
	        $domain = $domain."/".$cron->cronUrl;
	        $data = $this->http($domain);
	        $data = json_decode($data,true);
	        $cron->isRunning = 0;
	        if($data['status']==1){
			    $cron->isRunSuccess = 1;
	        }else{
	            $cron->isRunSuccess = 0;
	        }
	        $cron->save();
	        Db::commit();
	    }catch (\Exception $e) {
            Db::rollback();
            $cron->isRunning = 0;
            $cron->isRunSuccess = 0;
            $cron->save();
            return WSTReturn('执行失败');
        }
        return WSTReturn('执行成功',1);
	}

	public function http($url){
		$ch=curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置否输出到页面
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30 ); //设置连接等待时间
        curl_setopt($ch, CURLOPT_ENCODING, "gzip" );
        $data=curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $data;
	}

    /**
     * 执行所有定时任务
     */
	public function runCrons(){
		$cons = $this->where('isEnable',1)->select();
		$day = date('d');
		$hour = date('H');
		$minute = date('i');
		$week = date('w');
		foreach($cons as $key =>$cron){
			if($cron->isRunning==1)contnie;
			//判断能否执行
			if(strtotime($cron->nextTime)>time())continue;
			Db::startTrans();
			try{
				//fopen(time().'_'.rand(0,10000)."_auctionEnd.txt", "w");
		        $cron->isRunning = 1;
		        $cron->runTime = date('Y-m-d H:i:s');
		        $cron->nextTime = $this->getNextRunTime($cron);
		        $cron->save();
		        $domain = request()->root(true);
		        $domain = $domain."/".$cron->cronUrl;
		        $data = $this->http($domain);
		        $data = json_decode($data,true);
		        $cron->isRunning = 0;
		        if($data['status']==1){
				    $cron->isRunSuccess = 1;
		        }else{
		            $cron->isRunSuccess = 0;
		        }
		        $cron->save();
		        Db::commit();
		    }catch (\Exception $e) {
	            Db::rollback();
	            $cron->isRunning = 0;
	            $cron->isRunSuccess = 0;
	            $cron->save();
	        }
		}
		echo "done";
	}

	public function getNextRunTime($cron){
		$monthDay = date("t");
		$today = date('j');
		$thisWeek = date('w');
		$thisHour = date('H');
		$thisMinute = date('i');
		$nextDay = date('Y-m-d');
		$nextHour = 0;
		$nextMinute = 0;
		$isFurther = false;//标记是否要往前进一位
		$tmpMinute = [];
		if($cron['cronMinute']==-1){
            $nextMinute = date('i',strtotime('+1 Minute'));
            if($nextMinute<$thisMinute)$isFurther = true;
            $tmpMinute[] = $nextMinute;
		}else{
			$tmpMinute = explode(',',$cron['cronMinute']);
			sort($tmpMinute);
            $isFind = false;
            foreach($tmpMinute as $key => $v){
                if((int)$v>59)continue;
                if($thisMinute<(int)$v){
                	$nextMinute = (int)$v;
                	$isFind = true;
                	break;
                }
            }
            if(!$isFind){
            	$nextMinute = (int)$tmpMinute[0];
            	$isFurther = true;
            }
		}
		if($cron['cronHour']==-1){
            $nextHour = date("H",time()+($isFurther?3200:0));
            $isFurther = false;
            if($nextHour<$thisHour)$isFurther = true;
        }else{
            $nextHour = $cron['cronHour'];
            $isFurther = false;
		}
		if(time()>strtotime(date('Y-m-d')." ".$nextHour.":".$nextMinute.":00"))$isFurther = true;
		if($cron['cronCycle']==0){
			if($isFurther){
				$today = date('j',strtotime('+1 day'));
			}
			if($today<$cron['cronDay']){
                 $nextDay = date('Y-m-'.$cron['cronDay']);
			}else{
				 $nextDay = date("Y-m",strtotime(" +1 month"))."-".$cron['cronDay'];
			}
			if(date('j',strtotime($nextDay))!=$today){
            	if($cron['cronHour']==-1){
            		$nextHour = 0;
            	}else{
                    $nextHour = $cron['cronHour'];
            	}
            	if($cron['cronMinute']==-1){
            		$nextMinute = 0;
            	}else{
            		$nextMinute = (int)$tmpMinute[0];
            	}
            }
		}
		if($cron['cronCycle']==1){
			// if($isFurther){
			// 	$thisWeek = date('w',strtotime('+1 day'));
			// }
            $num = 0;
            if($cron['cronWeek']>$thisWeek){
                $num = $cron['cronWeek'] - $thisWeek;
            }else{
            	$num = $cron['cronWeek'] - $thisWeek + 7;
            }
           
            $nextDay = date("Y-m-d",strtotime("+".$num." day"));
            if(date('j',strtotime($nextDay))!=$today){
            	if($cron['cronHour']==-1){
            		$nextHour = 0;
            	}else{
                    $nextHour = $cron['cronHour'];
            	}
            	if($cron['cronMinute']==-1){
            		$nextMinute = 0;
            	}else{
            		$nextMinute = (int)$tmpMinute[0];
            	}
            }
		}
		if($cron['cronCycle']==2){
			if($isFurther){
				$nextDay = date('Y-m-d',strtotime('+1 day'));
			}else{
				$nextDay = date('Y-m-d');
			}
		}
		return date('Y-m-d H:i:s',strtotime($nextDay." ".$nextHour.":".$nextMinute.":00"));
	}

	/**
	 * 删除计划任务
	 */
	public function del(){
		$id = (int)input('id');
		$result = $this->where('id='.$id.' and cronCode is null')->delete();
		if(false !== $result){
            return WSTReturn('操作成功',1);
		}else{
			return WSTReturn('执行失败');
		}
	}
	
}
