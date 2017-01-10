<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 19.12.16
 * Time: 22:21
 */
require_once 'class.Project.php';
require_once 'class.Database.php';

class Projects {
    private $dummy_data;

    /**
     * Projects constructor.
     */
    public function __construct() {
        $this->dummy_data[0] = new Project("Test1", "abcde");
        $this->dummy_data[1] = new Project("Test2", "fghij");
        $this->dummy_data[2] = new Project("Test3", "klmno");
    }

    public function getProjects() {
        $temp = array();
        foreach ($this->dummy_data as $single) {
            array_push($temp, $single->returnJson(true));

        }
        return json_encode($temp);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProjectById($id) {
        return $this->dummy_data[$id]->returnJson();
    }

    /**
     * @param $form
     */
    public function newProject($form) {
        $name = $form['prname'];
        $desc = $form['prdesc'];


        $databaseObj = new Database();
        $dbh = $databaseObj->getPdo();
        $sql = <<<SQL
INSERT INTO projects (`name`, `description`)
VALUES (:name, :desc)
SQL;
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':name', $name);
        $sth->bindParam(':desc', $desc);
        $sth->execute();

        $test = $dbh->lastInsertId();

        echo $test;

        // Name
        // Description
        // User
//        return {'id' => 'ddd'};
    }
}