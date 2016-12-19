<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 19.12.16
 * Time: 22:21
 */
require_once 'class.Project.php';

class Projects
{
    private $dummy_data;

    /**
     * Projects constructor.
     */
    public function __construct()
    {
        $this->dummy_data[0] = new Project();
        $this->dummy_data[1] = new Project();
        $this->dummy_data[2] = new Project();
    }

    public function getProjects() {
        $temp = array();
        foreach ($this->dummy_data as $single) {
            array_push($temp,$single->returnJson(true));

        }
        return $temp;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProjectById($id) {
        return $this->dummy_data[$id]->returnJson();
    }
}