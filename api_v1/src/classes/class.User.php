<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 18.01.17
 * Time: 11:49
 */
require_once "class.Projects.php";

class User {

    /**
     * User constructor.
     */
    public function __construct($jwtToken) {
        $databaseObj = new Database();
        $this->dbh = $databaseObj->getPdo();

        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => "Authorization: " . $jwtToken
            )
        );
        $context = stream_context_create($opts);

        $this->data = file_get_contents('https://apistaging.fiw.fhws.de/auth/api/users/me', false, $context);
    }

    public function getUserInfo() {
        return $this->data;
    }

    public function getUserInfoById($id) {
        $sql = <<<SQL
SELECT * FROM users
WHERE id = :id
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
    }

    // TODO Test
    public function areRightsElevated() {
        $sql = <<<SQL
SELECT * FROM users
WHERE cn = :cn
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':cn', $this->data['cn']);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result['role'] > 0) {
            return true;
        }
        return false;
    }

    public function getProjects() {
        $projectsObj = new Projects();
        return $projectsObj->getProjectsBySupervisorId($this->data['cn']);
    }
}