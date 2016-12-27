<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 25.12.16
 * Time: 19:32
 */
class Database {

    /**
     * Database constructor.
     */
    public function __construct() {
        $config = new Config();
        $this->pdo = new PDO('mysql:host='
            . $config->getValue('database', 'host')
            . ';dbname='
            . $config->getValue('database', 'dbname'),
            $config->getValue('database', 'username'),
            $config->getValue('database', 'password'));
    }
}