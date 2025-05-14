<?php
namespace think;
//本类主要用于生成各种SQL语句
use think\Db;

class Pdosql
{
	public $G;
	public $tablepre ='ws_';// DTH;
	private $_mostlimits = 512;

    public function __construct()
    {
    	//$this->G = $G;
    }

    public function get_table_stru($table)
    {
      return Db::query("SHOW FULL COLUMNS FROM  `".$this->tablepre.$table."`");
    }

	public function _makeDefaultInsertArgs($tables,$args)
	{
		$newargs = array();
		if(!is_array($tables))
		{
			$tables = array($tables);
		}
 		foreach($tables as $table)
		{
			$r = $this->get_table_stru($table);
			if (is_array($r))
			foreach($r as $p)
			{
				if($p['Extra'] != 'auto_increment')
				{  
					$pf=$p['Field'];
					if(isset($args[$pf])){
						if($args[$pf]){
							$newargs[$pf] = $args[$pf];
						 }
						else
						{
							if(array_key_exists($pf,$args))
							{
								$newargs[$pf] = $this->_setDefaultInsetValue($p['Type']);
							}
							else
							$newargs[$pf] = $this->_setDefaultInsetValue($p['Type'],$p['Default']);
						}
				    }
			  }
			}
		}
		return $newargs;
	}

	public function _makeDefaultUpdateArgs($tables,$args)
	{
		$newargs = array();
		if(!is_array($tables))
		{
			$tables = array($tables);
		}
		foreach($tables as $table)
		{
			$r=$this->get_table_stru($table);
			if (is_array($r))
			foreach($r as $p)
			{
				if($p['Extra'] != 'auto_increment')
				{
					if(array_key_exists($p['Field'],$args))
					{
						if($args[$p['Field']])$newargs[$p['Field']] = $args[$p['Field']];
						else
						$newargs[$p['Field']] = $this->_setDefaultInsetValue($p['Type']);
					}
				}
			}
		}
		return $newargs;
	}

	public function _setDefaultInsetValue($type,$def = false)
	{
		$type = explode('(',$type);
		$type = $type[0];
		switch($type)
		{
			case 'char':
			case 'varchar':
			case 'tinytext':
			case 'longtext':
			case 'mediumtext':
			case 'text':
			if($def)return (string)$def;
			else
			return '';
			break;

			case 'int':
			if($def)return intval($def);
			else
			return 0;
			break;

			default:
			if($def)return floatval($def);
			else
			return 0;
			break;
		}
	}

	//生成select sql
	//$args = array('*',array('user','user_group'),array(array('AND','user.usergroupid = user_group.groupid'),array('AND','userid >= :userid','userid',$userid),array('OR','usergroupid >= :usergroupid','usergroupid',$usergroupid)));
	//$data = $this->makeSelect($args,$dbh);
	//array('0:*','1:TABLES','2:WHERE','3:group','4:order','5:limit')
	public function makeSelect($args,$tablepre = NULL)
	{   
	  $this->sql_key($args,$tablepre,$db_fields,$db_tables,$db_query,$db_groups,$db_orders,$db_limits,$v);
	  $sql = 'SELECT '.$db_fields.' FROM '.$db_tables.' WHERE '.$db_query.$db_groups.$db_orders;		
		if($db_limits === false);
		else $sql .=' LIMIT '.$db_limits;
		return array('sql' => $sql, 'v' => $v);
	}

	//生成update sql 
	public function makeUpdate($args,$tablepre = NULL)
	{
		if(!is_array($args))return false;
		if($tablepre === NULL)$tb_pre = $this->tablepre;
		else $tb_pre = $tablepre;

		$tables = $args[0];
		$args[1] = $this->_makeDefaultUpdateArgs($tables,$args[1]);
		if(is_array($tables))
		{
			$db_tables = array();
			foreach($tables as $p)
			{
				$db_tables[] = "{$tb_pre}{$p} AS $p";
			}
			$db_tables = implode(',',$db_tables);
		}
		else
		$db_tables = $tb_pre.$tables;
		$v = array();
		$pars = $args[1];
		if(!is_array($pars))return false;
		
		$parsql = array();
		foreach($pars as $key => $value)
		{
			$parsql[] = $key.' = '.':'.$key;
			if(is_array($value))$value = serialize($value);
			$v[$key] = $value;
		}
		$parsql = implode(',',$parsql);

		$query = $args[2];
		if(!is_array($query)){
			$db_query =(empty($query)) ? 1 : $query;
		}else
		 {
			$q = array();
			foreach($query as $p)
			{
				$q[] = $p[0].' '.$p[1].' ';
				if(isset($p[2]))
				$v[$p[2]] = $p[3];
			}
			$db_query = '1 '.implode(' ',$q);
		}
		$db_groups = $this->get_para($args,3);
		$db_orders = $this->get_para($args,4);
		$db_limits =$this->get_para($args,5);
		
		if($db_limits == false && $db_limits !== false) $db_limits = $this->_mostlimits;
		$db_groups = $db_groups?' GROUP BY '.$db_groups:'';
		$db_orders = $db_orders?' ORDER BY '.$db_orders:'';
		$sql = 'UPDATE '.$db_tables.' SET '.$parsql.' WHERE '.$db_query.$db_groups.$db_orders.' LIMIT '.$db_limits;
		return array('sql' => $sql, 'v' => $v);
	}

	//参数转换 
	public function get_para($args,$r)
	{
		$rs="";
		if(isset($args[$r])) $rs = is_array($args[$r]) ?implode(',',$args[$r]):$args[$r];
		return $rs;
	}

	//生成delete sql
	public function makeDelete($args,$tablepre = NULL)
	{
	 array_unshift($args,''); 
	 $this->sql_key($args,$tablepre,$db_fields,$db_tables,$db_query,$db_groups,$db_orders,$db_limits,$v);
	  $sql = 'DELETE FROM '.$db_tables.' WHERE '.$db_query;
	  return array('sql' => $sql, 'v' => $v);
	}

	/**
	 * 生成insert sql
	 * $args = array('user',array('username' => 'ttt1','useremail' => 'ttt11@166.com','userpassword' => '122s5a1s4sdfs5as5ax4a5sd5s','usergroupid' => '8'));
	 * $data = $this->makeInsert($args);
	 */

	public function makeInsert($args,$dim = 0,$tb_pre = NULL)
	{
		if($tb_pre === NULL)$tb_pre = $this->tablepre;
		else $tb_pre = '';
		$tables = $args[0];
		$args[1] = $this->_makeDefaultInsertArgs($tables,$args[1]);
	
		if(is_array($tables))
		{
			$db_tables = array();
			foreach($tables as $p)
			{
				$db_tables[] = "{$tb_pre}{$p} AS $p";
			}
			$db_tables = implode(',',$db_tables);
		}
		else
		$db_tables = $tb_pre.$tables;
		$v = array();
		if($dim == 0)
		{
			$query = $args[1];

			foreach($args[1] as $key => $value)
			{
				if(is_array($value))
				$value = serialize($value);
				$v[$key] = $value;
			}
		}
		else
		{
			$query = current($args[1]);
			foreach($args[1] as $pkey => $p)
			{
				$tn = array();
				foreach($p as $key => $value)
				{
					if(is_array($value))
					$value = serialize($value);
					$tn[$key] = $value;
				}
				$v[] = $tn;
			}
		}
		if(!is_array($query)) return false;
		$db_field = array();
		$db_value = array();
		foreach($query as $key => $value)
		{
			$db_field[] = $key;
			$db_value[] = ':'.$key;
		}
		$sql = 'INSERT INTO '.$db_tables.' ('.implode(',',$db_field).') VALUES ('.implode(',',$db_value).')';
		return array('sql' => $sql, 'v' => $v,'dim' => $dim);
	}
  //$argss数组说明 0 = $db_fields，1 =$tables， 2 =$query
  // 3=$db_groups，4=$db_orders，5=$db_limits，6=，
	public function sql_key($args,$tb_pre,&$db_fields,&$db_tables,&$db_query,&$db_groups,&$db_orders,&$db_limits,&$v)
	{
		if($tb_pre === NULL) $tb_pre = $this->tablepre;
		else $tb_pre = '';
		if(empty($tb_pre)) $tb_pre ="ws_";
	    
        if(!$args[0]) $args[0] = '*';
		$db_fields = is_array($args[0]) ? implode(',',$args[0]) : $args[0];
		$tables = $args[1];
		if(is_array($tables))
		{
			$db_tables = array();
			foreach($tables as $p)
			{
				$db_tables[] = "{$tb_pre}{$p} AS $p";
			}
			$db_tables = implode(',',$db_tables);
		}
		else
		$db_tables = $tb_pre.$tables;
		$db_query =$this-> get_sql_where($args[2]);
		$db_groups = $this->get_para($args,3);
		$db_orders = $this->get_para($args,4);
		$db_limits =$this->get_para($args,5);
	
		if($db_limits == false && $db_limits !== false) $db_limits = $this->_mostlimits;
		
		$db_groups = $db_groups?' GROUP BY '.$db_groups:'';
		$db_orders = $db_orders?' ORDER BY '.$db_orders:'';
	
	}

	public function get_sql_where($query)
	{	
		if(!is_array($query) || empty($query)){
			$db_query =(empty($query)) ? 1 : $query;
		}
		else
		{
			$q = array();
			$v = array();
			if(isset($query[0][0])){
				foreach($query as $key => $p)
				{
					$q[] =(($key) ? $p[0] : ' ').' '.$p[1].' ';//不要第一个AND
					if(isset($p[2]))
					$v[$p[2]] = $p[3];
				}
				$db_query = ' '.implode(' ',$q);
			} else{
				$b='';$db_query='';
				foreach($query as $key => $p)
				{
					$db_query .=$b.$key."='".$p."'";//不要第一个AND
					$b=' and ';
				}
			}
		}
	  return $db_query; 
	}
	
}

?>
