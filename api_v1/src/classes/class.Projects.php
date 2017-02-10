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
SELECT * FROM projects
WHERE deleted IS NOT TRUE 
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
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
        return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * @param $form
     * @return mixed
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

        return $this->dbh->lastInsertId();
    }

    public function delProjectById($id) {
        $sql = <<<SQL
UPDATE projects SET `deleted` = '1' WHERE `projects`.`id` = :id
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        return true;
    }

    public function patchProjectById($id, $data) {
        foreach ($data as $single => $value) {
            $sql = <<<SQL
UPDATE projects SET :single = :value WHERE `projects`.`id` = :id
SQL;
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $id);
            $sth->bindParam(':single', $single);
            $sth->bindParam(':value', $value);
            $sth->execute();
        }
        return true;
        // Todo: May want to return complete object after patching
    }

    public function searchProject($phrase) {
        $sql = <<<SQL
SELECT name FROM projects
WHERE deleted = 0
AND name LIKE '%:phrase%'
OR projects.description LIKE '%:phrase%'
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':phrase', $phrase);
        return json_encode($sth->fetchAll());

    }

    public function getPossibleStatuses() {
        $sql = <<<SQL
SELECT * FROM project_status
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getProjectStatusById($id) {
        $sql = <<<SQL
SELECT project_status.name as status, project_status.id as id FROM `projects`
INNER JOIN project_status
ON projects.status=project_status.id
WHERE projects.id = :id
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
    }
}