<?php
/**
 * Created by PhpStorm.
 * User: CoolCats
 * Date: 2019/3/27
 * Time: 17:28
 */

class PgSQL
{
    private $_host;
    private $_port;
    private $_dbuser;
    private $_dbpass;
    private $_dbname;

    private $_result;
    private $_querycount;

    private $_linkid;

    /**
     * PgSQL constructor.
     * @param $host
     * @param $port
     * @param $dbname
     * @param $dbuser
     * @param $dbpass
     */
    public function __construct($host = "127.0.0.1", $port = "5432", $dbname = "webqq", $dbuser = "postgres", $dbpass = "zhugepost")
    {
        $this->_host = $host;
        $this->_port = $port;
        $this->_dbuser = $dbuser;
        $this->_dbpass = $dbpass;
        $this->_dbname = $dbname;
    }

    /**
     * 数据库连接
     */
    public function connect()
    {
        try {
            $this->_linkid = pg_connect("host=$this->_host port=$this->_port dbname=$this->_dbname
user=$this->_dbuser password=$this->_dbpass");//@
            if (!$this->_linkid){
                throw new Exception("Could not connect to PostgreSQL server.");
            }else{
//                echo "Connect Success";
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * 执行语句
     * @param $query ：SQL语句
     * @return resource ：资源变量
     */
    public function query($query)
    {
        try {
            $this->_result = pg_query($this->_linkid, $query);
            if (!$this->_result){
                throw new Exception("The database query failed.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $this->_querycount++;
        return $this->_result;
    }
    public function queryParams($query,$params)
    {
        try {
            $this->_result = pg_query_params($this->_linkid, $query,$params);
            if (!$this->_result){
                throw new Exception("The database query failed.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $this->_querycount++;
        return $this->_result;
    }
    /**
     * 将查询结果作为索引数组返回
     * @return array
     */
    public function fetchRow(){
        $row = pg_fetch_row($this->_result);
        return $row;
    }
    public function  getLinkID(){
//        echo $this->_linkid;
        return $this->_linkid;
    }
}