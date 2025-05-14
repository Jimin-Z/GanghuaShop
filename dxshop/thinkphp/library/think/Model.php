<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think;

use InvalidArgumentException;
use think\db\Query;
use think\Pdosql as Pdosql;
use think\Db;
/**
 * Class Model
 * @package think
 * @mixin Query
 * @method Query where(mixed $field, string $op = null, mixed $condition = null) static 查询条件
 * @method Query whereRaw(string $where, array $bind = []) static 表达式查询
 * @method Query whereExp(string $field, string $condition, array $bind = []) static 字段表达式查询
 * @method Query when(mixed $condition, mixed $query, mixed $otherwise = null) static 条件查询
 * @method Query join(mixed $join, mixed $condition = null, string $type = 'INNER') static JOIN查询
 * @method Query view(mixed $join, mixed $field = null, mixed $on = null, string $type = 'INNER') static 视图查询
 * @method Query with(mixed $with) static 关联预载入
 * @method Query count(string $field) static Count统计查询
 * @method Query min(string $field) static Min统计查询
 * @method Query max(string $field) static Max统计查询
 * @method Query sum(string $field) static SUM统计查询
 * @method Query avg(string $field) static Avg统计查询
 * @method Query field(mixed $field, boolean $except = false) static 指定查询字段
 * @method Query fieldRaw(string $field, array $bind = []) static 指定查询字段
 * @method Query union(mixed $union, boolean $all = false) static UNION查询
 * @method Query limit(mixed $offset, integer $length = null) static 查询LIMIT
 * @method Query order(mixed $field, string $order = null) static 查询ORDER
 * @method Query orderRaw(string $field, array $bind = []) static 查询ORDER
 * @method Query cache(mixed $key = null , integer $expire = null) static 设置查询缓存
 * @method mixed value(string $field) static 获取某个字段的值
 * @method array column(string $field, string $key = '') static 获取某个列的值
 * @method mixed find(mixed $data = null) static 查询单个记录
 * @method mixed select(mixed $data = null) static 查询多个记录
 * @method mixed get(mixed $data = null,mixed $with =[],bool $cache= false) static 查询单个记录 支持关联预载入
 * @method mixed getOrFail(mixed $data = null,mixed $with =[],bool $cache= false) static 查询单个记录 不存在则抛出异常
 * @method mixed findOrEmpty(mixed $data = null,mixed $with =[],bool $cache= false) static 查询单个记录  不存在则返回空模型
 * @method mixed all(mixed $data = null,mixed $with =[],bool $cache= false) static 查询多个记录 支持关联预载入
 * @method \think\Model withAttr(array $name,\Closure $closure) 动态定义获取器
 */
abstract class Model implements \JsonSerializable, \ArrayAccess
{
    use model\concern\Attribute;
    use model\concern\RelationShip;
    use model\concern\ModelEvent;
    use model\concern\TimeStamp;
    use model\concern\Conversion;

    /**
     * 是否存在数据
     * @var bool
     */
    private $exists = false;

    /**
     * 是否Replace
     * @var bool
     */
    private $replace = false;

    /**
     * 是否强制更新所有数据
     * @var bool
     */
    private $force = false;

    /**
     * 更新条件
     * @var array
     */
    private $updateWhere;

    /**
     * 数据库配置信息
     * @var array|string
     */
    protected $connection = [];

    /**
     * 数据库查询对象类名
     * @var string
     */
    protected $query;

    /**
     * 模型名称
     * @var string
     */
    protected $name;

    /**
     * 数据表名称
     * @var string
     */
    protected $table;

    /**
     * 写入自动完成定义
     * @var array
     */
    protected $auto = [];

    /**
     * 新增自动完成定义
     * @var array
     */
    protected $insert = [];

    /**
     * 更新自动完成定义
     * @var array
     */
    protected $update = [];

    /**
     * 初始化过的模型.
     * @var array
     */
    protected static $initialized = [];

    /**
     * 是否从主库读取（主从分布式有效）
     * @var array
     */
    protected static $readMaster;

    /**
     * 查询对象实例
     * @var Query
     */
    protected $queryInstance;

    /**
     * 错误信息
     * @var mixed
     */
    protected $error;

    /**
     * 软删除字段默认值
     * @var mixed
     */
    protected $defaultSoftDelete;

    /**
     * 全局查询范围
     * @var array
     */
    protected $globalScope = [];

    public  $sql='',$new_config,$linkid,$nQuery;
    private $lastId =0;
    /**
     * 架构函数
     * @access public
     * @param  array|object $data 数据
     */
    public function __construct($data = [])
    {
        if (is_object($data)) {
            $this->data = get_object_vars($data);
        } else {
            $this->data = $data;
        }

        if ($this->disuse) {
            // 废弃字段
            foreach ((array) $this->disuse as $key) {
                if (array_key_exists($key, $this->data)) {
                    unset($this->data[$key]);
                }
            }
        }

        // 记录原始数据
        $this->origin = $this->data;

        $config = Db::getConfig();

        if (empty($this->name)) {
            // 当前模型名
            $name       = str_replace('\\', '/', static::class);
            $this->name = basename($name);
            if (Container::get('config')->get('class_suffix')) {
                $suffix     = basename(dirname($name));
                $this->name = substr($this->name, 0, -strlen($suffix));
            }
        }

        if (is_null($this->autoWriteTimestamp)) {
            // 自动写入时间戳
            $this->autoWriteTimestamp = $config['auto_timestamp'];
        }

        if (is_null($this->dateFormat)) {
            // 设置时间戳格式
            $this->dateFormat = $config['datetime_format'];
        }

        if (is_null($this->resultSetType)) {
            $this->resultSetType = $config['resultset_type'];
        }

        if (!empty($this->connection) && is_array($this->connection)) {
            // 设置模型的数据库连接
            $this->connection = array_merge($config, $this->connection);
        }

        if ($this->observerClass) {
            // 注册模型观察者
            static::observe($this->observerClass);
        }

        // 执行初始化操作
        $this->initialize();

        $this->sql = new Pdosql();
        $this->nQuery= new Query();
      //  $cnid=Db::connect();
        $this->new_config=$config;
        $this->linkid=0;
        //$this->_initb();
     // echo  json_encode( $this->new_config);
      //{"type":"mysql","dsn":"","hostname":"127.0.0.1","database":"wsshop","username":"root","password":"","hostport":"3306",
      //  echo  $this->new_config['hostname'] ;
      if(isset($this->p_mark)){
        if(empty($this->model))
          $this->_init();
       }
    }

    /**
     * 获取当前模型名称
     * @access public
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 是否从主库读取数据（主从分布有效）
     * @access public
     * @param  bool     $all 是否所有模型有效
     * @return $this
     */
    public function readMaster($all = false)
    {
        $model = $all ? '*' : static::class;

        static::$readMaster[$model] = true;

        return $this;
    }

    /**
     * 创建新的模型实例
     * @access public
     * @param  array|object $data 数据
     * @param  bool         $isUpdate 是否为更新
     * @param  mixed        $where 更新条件
     * @return Model
     */
    public function newInstance($data = [], $isUpdate = false, $where = null)
    {
        return (new static($data))->isUpdate($isUpdate, $where);
    }

    /**
     * 创建模型的查询对象
     * @access protected
     * @return Query
     */
    protected function buildQuery()
    {
        // 设置当前模型 确保查询返回模型对象
        $query = Db::connect($this->connection, false, $this->query);
        $query->model($this)
            ->name($this->name)
            ->json($this->json, $this->jsonAssoc)
            ->setJsonFieldType($this->jsonType);

        if (isset(static::$readMaster['*']) || isset(static::$readMaster[static::class])) {
            $query->master(true);
        }

        // 设置当前数据表和模型名
        if (!empty($this->table)) {
            $query->table($this->table);
        }

        if (!empty($this->pk)) {
            $query->pk($this->pk);
        }

        return $query;
    }

    /**
     * 获取当前模型的数据库查询对象
     * @access public
     * @param  Query $query 查询对象实例
     * @return $this
     */
    public function setQuery($query)
    {
        $this->queryInstance = $query;
        return $this;
    }

    /**
     * 获取当前模型的数据库查询对象
     * @access public
     * @param  bool|array $useBaseQuery 是否调用全局查询范围（或者指定查询范围名称）
     * @return Query
     */
    public function db($useBaseQuery = true)
    {
        if ($this->queryInstance) {
            return $this->queryInstance;
        }

        $query = $this->buildQuery();

        // 软删除
        if (property_exists($this, 'withTrashed') && !$this->withTrashed) {
            $this->withNoTrashed($query);
        }

        // 全局作用域
        if (true === $useBaseQuery && method_exists($this, 'base')) {
            call_user_func_array([$this, 'base'], [ & $query]);
        }

        $globalScope = is_array($useBaseQuery) && $useBaseQuery ? $useBaseQuery : $this->globalScope;

        if ($globalScope && false !== $useBaseQuery) {
            $query->scope($globalScope);
        }

        // 返回当前模型的数据库查询对象
        return $query;
    }

    /**
     *  初始化模型
     * @access protected
     * @return void
     */
    protected function initialize()
    {
        if (!isset(static::$initialized[static::class])) {
            static::$initialized[static::class] = true;
            static::init();
        }
    }

    /**
     * 初始化处理
     * @access protected
     * @return void
     */
    protected static function init()
    {}

    /**
     * 数据自动完成
     * @access protected
     * @param  array $auto 要自动更新的字段列表
     * @return void
     */
    protected function autoCompleteData($auto = [])
    {
        foreach ($auto as $field => $value) {
            if (is_integer($field)) {
                $field = $value;
                $value = null;
            }

            if (!isset($this->data[$field])) {
                $default = null;
            } else {
                $default = $this->data[$field];
            }

            $this->setAttr($field, !is_null($value) ? $value : $default);
        }
    }

    /**
     * 更新是否强制写入数据 而不做比较
     * @access public
     * @param  bool $force
     * @return $this
     */
    public function force($force = true)
    {
        $this->force = $force;
        return $this;
    }

    /**
     * 判断force
     * @access public
     * @return bool
     */
    public function isForce()
    {
        return $this->force;
    }

    /**
     * 新增数据是否使用Replace
     * @access public
     * @param  bool $replace
     * @return $this
     */
    public function replace($replace = true)
    {
        $this->replace = $replace;
        return $this;
    }

    /**
     * 设置数据是否存在
     * @access public
     * @param  bool $exists
     * @return $this
     */
    public function exists($exists)
    {
        $this->exists = $exists;
        return $this;
    }

    /**
     * 判断数据是否存在数据库
     * @access public
     * @return bool
     */
    public function isExists()
    {
        return $this->exists;
    }

    /**
     * 保存当前数据对象
     * @access public
     * @param  array  $data     数据
     * @param  array  $where    更新条件
     * @param  string $sequence 自增序列名
     * @return bool
     */
    public function save($data = [], $where = [], $sequence = null)
    {
        if (is_string($data)) {
            $sequence = $data;
            $data     = [];
        }

        if (!$this->checkBeforeSave($data, $where)) {
            return false;
        }

        $result = $this->exists ? $this->updateData($where) : $this->insertData($sequence);

        if (false === $result) {
            return false;
        }

        // 写入回调
        $this->trigger('after_write');

        // 重新记录原始数据
        $this->origin = $this->data;
        $this->set    = [];

        return true;
    }

    /**
     * 写入之前检查数据
     * @access protected
     * @param  array   $data  数据
     * @param  array   $where 保存条件
     * @return bool
     */
    protected function checkBeforeSave($data, $where)
    {
        if (!empty($data)) {
            // 数据对象赋值
            foreach ($data as $key => $value) {
                $this->setAttr($key, $value, $data);
            }

            if (!empty($where)) {
                $this->exists      = true;
                $this->updateWhere = $where;
            }
        }

        // 数据自动完成
        $this->autoCompleteData($this->auto);

        // 事件回调
        if (false === $this->trigger('before_write')) {
            return false;
        }

        return true;
    }

    /**
     * 检查数据是否允许写入
     * @access protected
     * @param  array   $append 自动完成的字段列表
     * @return array
     */
    protected function checkAllowFields(array $append = [])
    {
        // 检测字段
        if (empty($this->field) || true === $this->field) {
            $query = $this->db(false);
            $table = $this->table  ? $this->table : $query->getTable();

            $this->field = $query->getConnection()->getTableFields($table);

            $field = $this->field;
        } else {
            $field = array_merge($this->field, $append);

            if ($this->autoWriteTimestamp) {
                array_push($field, $this->createTime, $this->updateTime);
            }
        }

        if ($this->disuse) {
            // 废弃字段
            $field = array_diff($field, (array) $this->disuse);
        }

        return $field;
    }

    /**
     * 更新写入数据
     * @access protected
     * @param  mixed   $where 更新条件
     * @return bool
     */
    protected function updateData($where)
    {
        // 自动更新
        $this->autoCompleteData($this->update);

        // 事件回调
        if (false === $this->trigger('before_update')) {
            return false;
        }

        // 获取有更新的数据
        $data = $this->getChangedData();

        if (empty($data)) {
            // 关联更新
            if (!empty($this->relationWrite)) {
                $this->autoRelationUpdate();
            }

            return false;
        } elseif ($this->autoWriteTimestamp && $this->updateTime && !isset($data[$this->updateTime])) {
            // 自动写入更新时间
            $data[$this->updateTime] = $this->autoWriteTimestamp($this->updateTime);

            $this->data[$this->updateTime] = $data[$this->updateTime];
        }

        if (empty($where) && !empty($this->updateWhere)) {
            $where = $this->updateWhere;
        }

        // 检查允许字段
        $allowFields = $this->checkAllowFields(array_merge($this->auto, $this->update));

        // 保留主键数据
        foreach ($this->data as $key => $val) {
            if ($this->isPk($key)) {
                $data[$key] = $val;
            }
        }

        $pk    = $this->getPk();
        $array = [];

        foreach ((array) $pk as $key) {
            if (isset($data[$key])) {
                $array[] = [$key, '=', $data[$key]];
                unset($data[$key]);
            }
        }

        if (!empty($array)) {
            $where = $array;
        }

        foreach ((array) $this->relationWrite as $name => $val) {
            if (is_array($val)) {
                foreach ($val as $key) {
                    if (isset($data[$key])) {
                        unset($data[$key]);
                    }
                }
            }
        }

        // 模型更新
        $db = $this->db(false);
        $db->startTrans();

        try {
            $db->where($where)
                ->strict(false)
                ->field($allowFields)
                ->update($data);

            // 关联更新
            if (!empty($this->relationWrite)) {
                $this->autoRelationUpdate();
            }

            $db->commit();

            // 更新回调
            $this->trigger('after_update');

            return true;
        } catch (\Exception $e) {
            $db->rollback();
            throw $e;
        }
    }

    /**
     * 新增写入数据
     * @access protected
     * @param  string   $sequence 自增序列名
     * @return bool
     */
    protected function insertData($sequence)
    {
        // 自动写入
        $this->autoCompleteData($this->insert);

        // 时间戳自动写入
        $this->checkTimeStampWrite();

        if (false === $this->trigger('before_insert')) {
            return false;
        }

        // 检查允许字段
        $allowFields = $this->checkAllowFields(array_merge($this->auto, $this->insert));

        $db = $this->db(false);
        $db->startTrans();

        try {
            $result = $db->strict(false)
                ->field($allowFields)
                ->insert($this->data, $this->replace, false, $sequence);

            // 获取自动增长主键
            if ($result && $insertId = $db->getLastInsID($sequence)) {
                $pk = $this->getPk();

                foreach ((array) $pk as $key) {
                    if (!isset($this->data[$key]) || '' == $this->data[$key]) {
                        $this->data[$key] = $insertId;
                    }
                }
            }

            // 关联写入
            if (!empty($this->relationWrite)) {
                $this->autoRelationInsert();
            }

            $db->commit();

            // 标记为更新
            $this->exists = true;

            // 新增回调
            $this->trigger('after_insert');

            return true;
        } catch (\Exception $e) {
            $db->rollback();
            throw $e;
        }
    }

    /**
     * 字段值(延迟)增长
     * @access public
     * @param  string  $field    字段名
     * @param  integer $step     增长值
     * @param  integer $lazyTime 延时时间(s)
     * @return bool
     * @throws Exception
     */
    public function setInc($field, $step = 1, $lazyTime = 0)
    {
        // 读取更新条件
        $where = $this->getWhere();

        // 事件回调
        if (false === $this->trigger('before_update')) {
            return false;
        }

        $result = $this->db(false)
            ->where($where)
            ->setInc($field, $step, $lazyTime);

        if (true !== $result) {
            $this->data[$field] += $step;
        }

        // 更新回调
        $this->trigger('after_update');

        return true;
    }

    /**
     * 字段值(延迟)减少
     * @access public
     * @param  string  $field    字段名
     * @param  integer $step     减少值
     * @param  integer $lazyTime 延时时间(s)
     * @return bool
     * @throws Exception
     */
    public function setDec($field, $step = 1, $lazyTime = 0)
    {
        // 读取更新条件
        $where = $this->getWhere();

        // 事件回调
        if (false === $this->trigger('before_update')) {
            return false;
        }

        $result = $this->db(false)
            ->where($where)
            ->setDec($field, $step, $lazyTime);

        if (true !== $result) {
            $this->data[$field] -= $step;
        }

        // 更新回调
        $this->trigger('after_update');

        return true;
    }

    /**
     * 获取当前的更新条件
     * @access protected
     * @return mixed
     */
    protected function getWhere()
    {
        // 删除条件
        $pk = $this->getPk();

        if (is_string($pk) && isset($this->data[$pk])) {
            $where[] = [$pk, '=', $this->data[$pk]];
        } elseif (!empty($this->updateWhere)) {
            $where = $this->updateWhere;
        } else {
            $where = null;
        }

        return $where;
    }

    /**
     * 保存多个数据到当前数据对象
     * @access public
     * @param  array   $dataSet 数据
     * @param  boolean $replace 是否自动识别更新和写入
     * @return Collection
     * @throws \Exception
     */
    public function saveAll($dataSet, $replace = true)
    {
        $db = $this->db(false);
        $db->startTrans();

        try {
            $pk = $this->getPk();

            if (is_string($pk) && $replace) {
                $auto = true;
            }

            $result = [];

            foreach ($dataSet as $key => $data) {
                if ($this->exists || (!empty($auto) && isset($data[$pk]))) {
                    $result[$key] = self::update($data, [], $this->field);
                } else {
                    $result[$key] = self::create($data, $this->field, $this->replace);
                }
            }

            $db->commit();

            return $this->toCollection($result);
        } catch (\Exception $e) {
            $db->rollback();
            throw $e;
        }
    }

    /**
     * 是否为更新数据
     * @access public
     * @param  mixed  $update
     * @param  mixed  $where
     * @return $this
     */
    public function isUpdate($update = true, $where = null)
    {
        if (is_bool($update)) {
            $this->exists = $update;

            if (!empty($where)) {
                $this->updateWhere = $where;
            }
        } else {
            $this->exists      = true;
            $this->updateWhere = $update;
        }

        return $this;
    }

    /**
     * 删除当前的记录
     * @access public
     * @return bool
     */
    public function delete()
    {
        if (!$this->exists || false === $this->trigger('before_delete')) {
            return false;
        }

        // 读取更新条件
        $where = $this->getWhere();

        $db = $this->db(false);
        $db->startTrans();

        try {
            // 删除当前模型数据
            $db->where($where)->delete();

            // 关联删除
            if (!empty($this->relationWrite)) {
                $this->autoRelationDelete();
            }

            $db->commit();

            $this->trigger('after_delete');

            $this->exists = false;

            return true;
        } catch (\Exception $e) {
            $db->rollback();
            throw $e;
        }
    }

    /**
     * 设置自动完成的字段（ 规则通过修改器定义）
     * @access public
     * @param  array $fields 需要自动完成的字段
     * @return $this
     */
    public function auto($fields)
    {
        $this->auto = $fields;

        return $this;
    }

    /**
     * 写入数据
     * @access public
     * @param  array      $data  数据数组
     * @param  array|true $field 允许字段
     * @param  bool       $replace 使用Replace
     * @return static
     */
    public static function create($data = [], $field = null, $replace = false)
    {
        $model = new static();

        if (!empty($field)) {
            $model->allowField($field);
        }

        $model->isUpdate(false)->replace($replace)->save($data, []);

        return $model;
    }

    /**
     * 更新数据
     * @access public
     * @param  array      $data  数据数组
     * @param  array      $where 更新条件
     * @param  array|true $field 允许字段
     * @return static
     */
    public static function update($data = [], $where = [], $field = null)
    {
        $model = new static();

        if (!empty($field)) {
            $model->allowField($field);
        }

        $model->isUpdate(true)->save($data, $where);

        return $model;
    }

    /**
     * 删除记录
     * @access public
     * @param  mixed $data 主键列表 支持闭包查询条件
     * @return bool
     */
    public static function destroy($data)
    {
        if (empty($data) && 0 !== $data) {
            return false;
        }

        $model = new static();

        $query = $model->db();

        if (is_array($data) && key($data) !== 0) {
            $query->where($data);
            $data = null;
        } elseif ($data instanceof \Closure) {
            $data($query);
            $data = null;
        }

        $resultSet = $query->select($data);

        if ($resultSet) {
            foreach ($resultSet as $data) {
                $data->delete();
            }
        }

        return true;
    }

    /**
     * 获取错误信息
     * @access public
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 解序列化后处理
     */
    public function __wakeup()
    {
        $this->initialize();
    }

    public function __debugInfo()
    {
        return [
            'data'     => $this->data,
            'relation' => $this->relation,
        ];
    }

    /**
     * 修改器 设置数据对象的值
     * @access public
     * @param  string $name  名称
     * @param  mixed  $value 值
     * @return void
     */
    public function __set($name, $value)
    {
        $this->setAttr($name, $value);
    }

    /**
     * 获取器 获取数据对象的值
     * @access public
     * @param  string $name 名称
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getAttr($name);
    }

    /**
     * 检测数据对象的值
     * @access public
     * @param  string $name 名称
     * @return boolean
     */
    public function __isset($name)
    {
        try {
            return !is_null($this->getAttr($name));
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * 销毁数据对象的值
     * @access public
     * @param  string $name 名称
     * @return void
     */
    public function __unset($name)
    {
        unset($this->data[$name], $this->relation[$name]);
    }

    // ArrayAccess
    public function offsetSet($name, $value)
    {
        $this->setAttr($name, $value);
    }

    public function offsetExists($name)
    {
        return $this->__isset($name);
    }

    public function offsetUnset($name)
    {
        $this->__unset($name);
    }

    public function offsetGet($name)
    {
        return $this->getAttr($name);
    }

    /**
     * 设置是否使用全局查询范围
     * @access public
     * @param  bool|array $use 是否启用全局查询范围（或者用数组指定查询范围名称）
     * @return Query
     */
    public static function useGlobalScope($use)
    {
        $model = new static();

        return $model->db($use);
    }

    public function __call($method, $args)
    {
        if ('withattr' == strtolower($method)) {
            return call_user_func_array([$this, 'withAttribute'], $args);
        }

        return call_user_func_array([$this->db(), $method], $args);
    }

    public static function __callStatic($method, $args)
    {
        $model = new static();

        return call_user_func_array([$model->db(), $method], $args);
    }









/*
// 以下代码是曾老师扩充，2020.03.26
// 

// echo  json_encode( $this->new_config);
      //{"type":"mysql","dsn":"","hostname":"127.0.0.1","database":"wsshop","username":"root","password":"","hostport":"3306",
*/





    public function _log($sql,$query)
    {
        if($this->log)
        {
        //  $fp = fopen('data/error.log','a');
    //      fputs($fp,print_r($sql,true).print_r($query->errorInfo(),true));
    //      fclose($fp);
        }
    }




    public function fetchAll($sql,$index = false,$unserialize = false)
    {
        if(!is_array($sql))return false;
        $rs = $this->query($sql);
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
                                            //  $tmp[$value] = unserialize($tmp[$value]);
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
    if(!is_array($sql)) return false;
    if($unserialize)
    $unserialize=$this->to_unserialize_array($unserialize);//explode(" ",$str)
    $rs = $this->query($sql);
    if ($rs) {
          //  $query->setFetchMode(PDO::FETCH_ASSOC);
            $tmp = $rs;//$query->fetch();
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
                //  else $tmp[$unserialize] = unserialize($tmp[$unserialize]);
                }
            }
            return $tmp;
        }
        return false;
    }

public function check_rec($args)
    {   
        $sql = $this->sql->makeSelect(array(false,$this->table_name,$args));
        if(!is_array($sql)) return false;
        return  $this->query($sql);
    }


function mb_unserializea($str) {
    if(!is_array($str))
    if  ((strpos($str,"s:")>0)||empty($str)){
       $data=$str;
       $str=@unserialize($str);
        if (!$str) {
            $$str =$this->mb_unserializeb($data);
        }
     }
   return $str;
}



function mb_unserializeb($serial_str) { 
        $serial_str = preg_replace_callback('/s:(\d+):"([\s\S]*?)";/', function($matches) {
            return 's:'.strlen($matches[2]).':"'.$matches[2].'";';
        }, $serial_str);
        return unserialize($serial_str);  
}

    public function query($sql)
    {
        if(!$sql) return false;
       return Db::query($sql['sql']);
    }

    public function exec($sql)
    {
        $this->affectedRows = 0;
        if(!is_array($sql))return false;
        if($sql['v']){
          $rs = Db::execute($sql['sql'],$sql['v']);
        } else{
            $rs = Db::execute($sql['sql']);
        }
        $this->lastId=0;
        if($rs){
          $tmp=Db::query("select @@identity as recid");
          if($tmp) $this->lastId= $tmp[0]['recid'];
        }
        $this->affectedRows =$rs;
        return $rs;
    }
     public function lastInsertId(){
        return  $this->lastId;
     }

    public function insertElement($args)
    {
        return $this->insert_new($args['table'],$args['query']);
    }

    public function insert_table_new($table,$args)
    {
          $data = array($table,$args);
          return $this->insert_by_data($data);
    }

    public function save_new($args,$where="2=1")
    { 
        return $this->save_key($this->table_name,$args,$where);
    }

    public function save_key($table,$args,$where='2=1')
    {      
        $tmp1=$this->check_rec($where);
        if(empty($tmp1)) {
          return $this->insert_new($args);
        } else{
          return $this->update_by_data(array($table,$args,$where));
        }
    }

  //增加题型
    //参数：题型信息数组
    //返回值：插入的ID
    public function insert_new($args)
    {
        return $this->insert_by_data(array($this->table_name,$args));
    }

 
    public function insert_by_data($data)
    {
          $sql = $this->sql->makeInsert($data);
          $rs=$this->exec($sql);
          return $this->lastInsertId();
    }

    public function update_new($args,$id=0)
    {
     return ($id==0) ? $this->insert_new($args) : $this->update_key($args,$this->key_id.'='.$id);
    }
    
    public function update_key($args,$where)
    {
        return $this->save_key($this->table_name,$args,$where);
    }
     public function updateAll($args,$where)
    {
        return $this->save_key($this->table_name,$args,$where);
    }
 
    public function update_by_data($data)
    {
        return $this->exec($this->sql->makeUpdate($data)); 
    }
    
    public function delete_new($id)
    {
        if(is_numeric($id)){
            $id=$this->key_id.'='.$id;
        }
        return $this->delete_key($id);
    }

    public function delete_key($where)
    {   
        return $this->delete_by_data(array($this->table_name,$where));
    }
    
    public function delete_by_data($data)
    {
        return $this->exec($this->sql->makeDelete($data));
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



  public function findbyKey($key=0)
    {   
        if(is_numeric($key)){
            $key=$this->key_id."=".$key;
        }
        return $this->findOne($key);
    }


    public function findOne($args=1,$unserialize = false)
    {
        $rs=$this->findOne_rec($this->table_name,$args);
        if($rs) $rs=$rs[0];
        return $rs;
    }

   public function readValue($args=1,$fieldname)
    {
        $rs='';
        $tmp=$this->findOne_rec($this->table_name,$args);
        if(isset($tmp[$fieldname])){
         $rs=$tmp[$fieldname];
        }
        return $rs;
    }

    public function findOne_rec($table,$args,$unserialize = false,$type = 1,$keytype = 0)
    {
        return $this->findWithFields($table,$args,false,$unserialize,$type,$keytype);
    }

    public function findWithFields($table,$args,$fields=false,$unserialize = false,$type = 1,$keytype = 0)
    {
         //$unserialize=$this->unserialize_strname($unserialize);      
        $sql = $this->sql->makeSelect(array($fields,$table,$args));
        return $this->fetch($sql,$unserialize,$type,$keytype);
    }

    public function getCount($args=1)
    {
        $r = $this->findFields($args,"count(*) as number");
        return $r[0]['number'];
    }
   public function getSum($args=1,$fields)
    {
        $r= $this->findFields($args,"sum(".$fields.") as number");
        return $r[0]['number'];
    }

    public function findFields($args,$fields)
    {
        return $this->findWithFields($this->table_name,$args,$fields);
    }

   public function findList($args = 1,$porder='',$fields=false)
    {   
      $tmp=$this->findAll($args,$porder,$fields);
      return $this->tolist($tmp,$this->key_id);
    }
    
    public function findAll($args = 1,$porder='',$fields=false,$unserialize=false)
    {   
       $porder=($porder=='') ? $this->key_id : $porder;
       $data = array($fields,$this->table_name,$args,false,$porder);
       return $this->getRows($data,$unserialize);
    }

  public function getRows($data,$unserialize=false)
    {
        $sql = $this->sql->makeSelect($data);
//        $unserialize=$this->unserialize_strname($unserialize);
        return $this->query($sql);//,false,$this->unserialize_name());
    }

  public function getRow($data,$unserialize=false)
    {
        $sql = $this->pdosql->makeSelect($data);
   //     $unserialize=$this->unserialize_strname($unserialize);
        return $this->query($sql);//,$unserialize);
    }

public function find_sql($sql,$unserialize = false,$type = 1,$keytype = 0)
    {
        return $this->query($sql);//fetch($sql,$unserialize,$type,$keytype);
    }

public function findALL_sql($sql,$unserialize = false,$type = 1,$keytype = 0)
    {
        return $this->exec($sql);
    }
// Db::name('datas')->where(['dataFlag'=>1])->order('catId asc,dataSort asc,id asc')->select();

public function getALL_base($sql,$unserialize = false,$type = 1,$keytype = 0)
    {
        return $this->db->fetchAll($sql);
    }

/**/
}
