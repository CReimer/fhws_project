<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 19.12.16
 * Time: 22:22
 */
class Project {
    private $dummy_data;

    /**
     * Project constructor.
     */
    public function __construct() {
        $this->dummy_data[0] = ["name" => 'Test1', "owner" => "User1"];
        $this->dummy_data[1] = ["name" => 'Test2', "owner" => "User2"];
        $this->dummy_data[2] = ["name" => 'Test3', "owner" => "User3"];
    }

    public function returnJson($minimized = false) {
        $temp = array();
        foreach ($this->dummy_data as $single) {
            if ($minimized) {
                array_push($temp, $single["name"]);
            } else {
                array_push($temp, $single);
            }
        }
    }
}