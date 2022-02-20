<?php

namespace App\Db;

use PDO;
use PDOException;

class Db extends PDO
{
    // Instance unique de la classe
    private static $instance;

    // info de connexion
    private const DBHOST =  'localhost';
    private const DBUSER = 'root';
    private const DBPASS = '';
    private const DBNAME = 'demo';

    private function  __construct()
    {
        $_dsn = 'mysql:dbname=' . self::DBNAME . ';host=' . self::DBHOST;

        // on appelle le cosntructeur de la classe PDO
        try {
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
}
