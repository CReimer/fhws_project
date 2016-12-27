<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 27.12.16
 * Time: 19:52
 */
class Config {

    /**
     * Config constructor.
     */
    public function __construct() {
        $string = file_get_contents("../../config.json");
        $this->json = json_decode($string, true);
    }

    public function getValue($category, $val) {
        return $this->json[$category][$val];
    }
}