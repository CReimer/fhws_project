<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 25.12.16
 * Time: 19:32
 */

require_once 'class.Config.php';

class Database {
    /**
     * @return PDO
     */
    public function getPdo(): PDO {
        return $this->pdo;
    }

    /**
     * Database constructor.
     */
    public function __construct() {
        $configObj = new Config();
        $this->pdo = new PDO('mysql:host='
            . $configObj->getValue('database', 'host')
            . ';dbname='
            . $configObj->getValue('database', 'dbname'),
            $configObj->getValue('database', 'username'),
            $configObj->getValue('database', 'password'));
    }
}