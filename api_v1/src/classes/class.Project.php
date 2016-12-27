<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 19.12.16
 * Time: 22:22
 */
class Project {
    private $dummy_data = [];

    /**
     * Project constructor.
     */
    public function __construct($val1, $val2) {
        $this->dummy_data['name'] = $val1;
        $this->dummy_data['whatever'] = $val2;
    }

    public function returnJson($minimized = false) {
        if ($minimized) {
            return json_encode($this->dummy_data['name']);
        }
        else {
            return json_encode($this->dummy_data);
        }
    }
}