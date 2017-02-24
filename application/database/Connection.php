<?php

/**
 * Created by PhpStorm.
 * User: kezi
 * Date: 18.2.2017.
 * Time: 23:02
 */
class Connection
{
    private $host;
    private $db;
    private $username;
    private $password;
    private $charset;
    private $dsn;

    public function __construct($config)
    {
        $this->host =$config['host'];
        $this->db = $config['databaseName'];
        $this->charset = $config['charset'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
    }

    public  function getPDO()
    {

            return new PDO($this->dsn,$this->username,$this->password);

    }

}