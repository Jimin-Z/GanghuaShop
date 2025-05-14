<?php

namespace think;
use think\Pdosql as Pdosql;
/*
 * Created on 2014-12-10
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Pepdo
 {
 	public $sql;
 	private $queryid = 0;
	private $linkid = 0;
	private $log = 1;

    public function __construct($G='')
    {
    	$this->sql = new Pdosql();
    }

    public function _log($sql,$query)
    {
    	if($this->log)
    	{
    	//	$fp = fopen('data/error.log','a');
	//		fputs($fp,print_r($sql,true).print_r($query->errorInfo(),true));
	//	   	fclose($fp);
    	}
    }

    public function _error($str)
    {
   
    		if (is_array($str)) $str=json_encode($str);
    		//$fp = fopen('data/error.log','a');
			//fputs($fp,$str);
		  	//fclose($fp);
  
    } 

	//增加科目
	//参数：科目ID，修改的信息数组
	//返回值：true
	public function aaput_msg($pmsg,$er=0)
	{
		 if (is_array($pmsg)){
            $pmsg=json_encode($pmsg,JSON_UNESCAPED_UNICODE);
           }
		$er=1;
		if($er) {
			$this->_error($pmsg);	
			$this->_error(chr(13).chr(10));
		
		 }
	  	   return $this->insert('test_err',
			array('f_msg'=>$pmsg,'f_callname'=>'',
				'f_time'=> date('Y-m-d H:i:s',time())));
     
	}
    public function connect($host = DH,$dbuser = DU,$password = DP,$dbname = DB,$dbcode = HE)
    {
    	$dsn="mysql:host={$host};dbname={$dbname};";
    	$this->linkid = new PDO($dsn,$dbuser,$password);
    	$this->linkid->query("set names ".((HE == 'utf-8') ? "utf8" : "gbk"));
    }

    public function commit()
    {
    	if(!$this->linkid)$this->connect();
    	$this->linkid->commit();
    }

    public function beginTransaction()
    {
    	if(!$this->linkid)$this->connect();
    	$this->linkid->beginTransaction();
    }

    public function rollback()
    {
    	if(!$this->linkid)$this->connect();
    	$this->linkid->rollback();
    }

    public function fetchAll($sql,$index = false,$unserialize = false)
    {
    	if(!is_array($sql))return false;
		
    	if(!$this->linkid) $this->connect();
    	$query = $this->linkid->prepare($sql['sql']);
    	if(isset($sql['v'])){
    		$rs = $query->execute($sql['v']);
    	} else{
    	   $rs = $query->execute();
    	}
        
    	//$this->_log($sql,$query);
		if ($rs) {			
			$query->setFetchMode(PDO::FETCH_ASSOC);
			//return $query->fetchAll();
			$r = array();
			while($tmp = $query->fetch())
			{
				if($unserialize)
				{
					if(!is_array($unserialize)){
							$tmp[$unserialize] = unserialize($tmp[$unserialize]);
						} else
					{
						foreach($unserialize as $value)
						{  
							if (isset($tmp[$value])){
									if(!is_array($tmp[$value]))
								
									 if(strlen($tmp[$value])>2)
										 	{
												 	$data=$tmp[$value];
											 		$data=$this->mb_unserializea($data);
													$tmp[$value] = $data;
											//	$tmp[$value] = unserialize($tmp[$value]);
										  	}
										}
						}
					}
				}
				if($index)
				{   if(isset($tmp[$index]))
					$r[$tmp[$index]] = $tmp;
				}
				else
				$r[] = $tmp;
			}
			return $r;
		}
		else
		return false;
    }


function mb_unserialize($str) {
    return preg_replace_callback('#s:(\d+):"(.*?)";#s',function($match){return 's:'.strlen($match[2]).':"'.$match[2].'";';},$str);
}

function to_unserialize_array($unserialize) {
	if (!is_array($unserialize)){
    	$unserialize=str_replace('[','',$unserialize);
		$unserialize=str_replace(']','',$unserialize);
		$unserialize=explode(',',$unserialize);//explode(" ",$str)
	}

	
	return $unserialize;
}

public function fetch($sql,$unserialize = false)
    {
    
    if(!is_array($sql))return false;
    if($unserialize)
		$unserialize=$this->to_unserialize_array($unserialize);//explode(" ",$str)
    	if(!$this->linkid)$this->connect();
    	$query = $this->linkid->prepare($sql['sql']);
    	$rs = $query->execute($sql['v']);
    	//$this->_log($sql,$query);
    	if ($rs) {
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$tmp = $query->fetch();
			if($tmp)
	    	{
		    	if($unserialize)
				{
					if(is_array($unserialize))
					{
						foreach($unserialize as $value)
						{
							if(isset($tmp[$value])){
							     $tmp[$value] = $this->mb_unserializea($tmp[$value]);}
							else{
                              $tmp[$value]="";
							}
						}
					} else
					 if(isset($tmp[$unserialize]))	
					 $tmp[$unserialize] = $this->mb_unserializea($tmp[$unserialize]);
				//	else $tmp[$unserialize] = unserialize($tmp[$unserialize]);
				}
	    	}
			return $tmp;
		}
		return false;
    }


function mb_unserializea($str) {
	if(!is_array($str))
	if  ((strpos($str,"s:")>0)||empty($str)){
	 // $this->_error('=a1='.$str.'=a1=');
//       $str= preg_replace_callback('#s:(\d+):"(.*?)";#s',function($match){return 's:'.strlen($match[2]).':"'.$match[2].'";';},$str);
       $data=$str;
       $str=@unserialize($str);
      	if (!$str) {
    		$$str =$this->mb_unserializeb($data);
		}
     }
   return $str;
}

function mb_unserializebk($serial_str) {
//    $out = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
    $out = preg_replace_callback('|s\:(\d+)\:"(.*?)"|',
        function ($matches){
            return "s:".strlen($matches[2]).":\"$matches[2]\"";
        },
        $serial_str);
    return unserialize($out);
}
 

function mb_unserializeb($serial_str) { 
        $serial_str = preg_replace_callback('/s:(\d+):"([\s\S]*?)";/', function($matches) {
            return 's:'.strlen($matches[2]).':"'.$matches[2].'";';
        }, $serial_str);
      //   $this->_error($serial_str);
        return unserialize($serial_str);  
}

    public function query($sql)
    {
    	if(!$sql) return false;
    	if(!$this->linkid) $this->connect();
    	return $this->linkid->query($sql);
    }

    public function exec($sql)
    {
    	$this->affectedRows = 0;
    	if(!is_array($sql))return false;
    	if(!$this->linkid)$this->connect();
    	if(isset($sql['dim'])){
    		if($sql['dim'])
    	    return $this->dimexec($sql);
        }
    	$query = $this->linkid->prepare($sql['sql']);
    	$rs = $query->execute($sql['v']);
		$this->_log($sql,$query);
		$this->affectedRows = $rs;
    	return $rs;
    }

    public function dimexec($sql)
    {
    	//if(!is_array($sql))return false;
    	//if(!$this->linkid)$this->connect();
    	$query = $this->linkid->prepare($sql['sql']);
    	foreach($sql['v'] as $p)
    	$rs = $query->execute($p);
    	return $rs;
    }

    public function lastInsertId()
    {
    	return $this->linkid->lastInsertId();
    }

    public function insertElement($args)
	{
		return $this->insert($args['table'],$args['query']);
	}

	public function insert($table,$args)
	{
	  	  $data = array($table,$args);
		  $sql = $this->sql->makeInsert($data);
		  $this->exec($sql);
		  return $this->lastInsertId();
	}



    public function listElements($page,$number = 20,$args,$tablepre = DTH)
	{
		if(!is_array($args))return false;
		$pg = $this->G->make('pg');
		$page = $page > 0?$page:1;
		$r = array();
		if(!isset($args['groupby'])) $args['groupby']=false;
		if(!isset($args['orderby'])) $args['orderby']=false;
		$data = array($args['select'],$args['table'],$args['query'],$args['groupby'],$args['orderby'],array(intval($page-1)*$number,$number));
		$sql = $this->sql->makeSelect($data,$tablepre);
		if(!isset($args['index'])) $args['index']=false;
		if(!isset($args['serial'])) $args['serial']=false;
		$r['data'] = $this->fetchAll($sql,$args['index'],$args['serial']);
		$data = array('count(*) AS number',$args['table'],$args['query']);
		$sql = $this->sql->makeSelect($data,$tablepre);
		$t = $this->fetch($sql);
		$pages = $pg->outPage($pg->getPagesNumber($t['number'],$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}

	public function delElement($args)
	{
		$data = array($args['table'],$args['query'],$args['orderby'],$args['limit']);
		$sql = $this->sql->makeDelete($data);
		return $this->exec($sql);
		//return $this->affectedRows();
	}

	public function updateElement($args)
	{
		$data = array($args['table'],$args['value'],$args['query'],$args['limit']);
		$sql = $this->sql->makeUpdate($data);
		return $this->exec($sql);
		//$this->affectedRows();
	}

	public function affectedRows()
	{
		return $this->affectedRows;
	}
 }
?>
