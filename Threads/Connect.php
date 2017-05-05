<?php
namespace Threads;

class Connect extends \Worker
{
    protected $dsn;
    protected $username;
    protected $password;
    protected $options;
    public static $data ;
    protected static $link;
    public function __construct($db)
    {
        $this->dsn ='mysql:'.$db['host'].'=localhost;dbname='.$db['database'].';unix_socket='.$db['unix_socket'];
        $this->username=$db['username'];
        $this->password=$db['password'];
    }
    public function createConnection()
    {
        if (!self::$link) {
            self::$link = new \PDO($this->dsn,$this->username,$this->password);
        }
        /* do some exception/error stuff here maybe */
        return self::$link;
    }
    public function start(int $options = PTHREADS_INHERIT_ALL ^ PTHREADS_INHERIT_CLASSES) { return parent::start(PTHREADS_INHERIT_ALL ^ PTHREADS_INHERIT_CLASSES); }
}