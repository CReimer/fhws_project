<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 19.12.16
 * Time: 22:21
 */
require_once 'class.Database.php';

class Projects {
    /**
     * Projects constructor.
     */
    public function __construct() {
        $databaseObj = new Database();
        $this->dbh = $databaseObj->getPdo();
    }

    public function getProjects() {

        $sql = <<<SQL
SELECT name FROM projects
SQL;
        $sth = $this->dbh->prepare($sql);
        return json_encode($sth->fetchAll());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProjectById($id) {
        $sql = <<<SQL
SELECT * FROM projects
WHERE id = :id
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        return json_encode($sth->fetchAll());
    }

    /**
     * @param $form
     */
    public function newProject($form) {
        $sql = <<<SQL
INSERT INTO projects (`name`, `description`)
VALUES (:name, :desc)
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':name', $form['name']);
        $sth->bindParam(':desc', $form['desc']);
        $sth->execute();

        $test = $this->dbh->lastInsertId();

        echo $test;
    }

    public function delProjectById($id) {
        $sql = <<<SQL
UPDATE projects SET `deleted` = '1' WHERE `projects`.`id` = :id
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();

    }
}