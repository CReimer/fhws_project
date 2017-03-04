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
        $this->getProjectBaseSql = <<<SQL
SELECT
  projects.id                                                         AS id,
  projects.name                                                       AS name,
  projects.description                                                AS description,
  projects.creation_date                                              AS creation_date,
  GROUP_CONCAT(DISTINCT degreeProgram.short_name)                     AS degreeName,
  GROUP_CONCAT(DISTINCT types.selector)                               AS type,
  GROUP_CONCAT(DISTINCT users.cn)                                     AS cn,
  GROUP_CONCAT(DISTINCT CONCAT(users.firstName, ' ', users.lastName)) AS contributor,
  CONCAT(supervisor.firstName, ' ', supervisor.lastName)              AS supervisor,
  status.name                                                         AS status

FROM projects
  LEFT JOIN projects_degreeProgram
    ON projects_degreeProgram.project_id = projects.id
  LEFT JOIN degreeProgram
    ON degreeProgram.id = projects_degreeProgram.program_id
  LEFT JOIN projects_type
    ON projects_type.project_id = projects.id
  LEFT JOIN types
    ON types.id = projects_type.type_id
  LEFT JOIN users_projects
    ON projects.id = users_projects.project_id
  LEFT JOIN users
    ON users_projects.user_cn = users.cn
  LEFT JOIN users AS supervisor
    ON projects.supervisor = supervisor.id
  LEFT JOIN status
    ON projects.status = status.id
WHERE deleted <> 1

SQL;
        $this->getProjectBaseSqlFooter = "GROUP BY projects.id";
    }

    private function postProcessGetProjectsResults($data) {
        foreach ($data as &$single) {
            $temp = explode(',', $single['degreeName']);
            $single['degreeName'] = array();
            foreach ($temp as $degree) {
                $single['degreeName'][$degree] = true;
            }
            $single['cn'] = explode(',', $single['cn']);
        }
        return $data;
    }

    public function getProjects() {

        $sql = $this->getProjectBaseSql;
        $sql .= $this->getProjectBaseSqlFooter;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();

        return $this->postProcessGetProjectsResults($data = $sth->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProjectById($id) {
        $sql = $this->getProjectBaseSql;
        $sql .= "AND projects.id = :id\n";
        $sql .= $this->getProjectBaseSqlFooter;

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        $error = $sth->errorInfo();

        return $this->postProcessGetProjectsResults($data = $sth->fetchAll(PDO::FETCH_ASSOC));
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

        $last_id = $this->dbh->lastInsertId();

        $sql_user = <<<SQL
INSERT INTO users_projects (project_id, user_cn)
VALUES (:project_id, :user_id)
SQL;
        foreach (explode(',', $form['contributor']) as $user_id) {
            $sth2 = $this->dbh->prepare($sql_user);
            $sth2->bindParam(':project_id', $last_id);
            $sth2->bindParam(':user_id', $user_id);
            $sth2->execute();
        }

        $sql_type = <<<SQL
INSERT INTO projects_type (project_id, type_id)
VALUES (:project_id, :type_id)
SQL;
        foreach (explode(',', $form['type']) as $type) {
            $type_id = '';
            switch ($type) {
                case 'projekt':
                    $type_id = 1;
                    break;
                case 'bachelor':
                    $type_id = 2;
                    break;
                case 'master':
                    $type_id = 3;
            }
            $sth2 = $this->dbh->prepare($sql_type);
            $sth2->bindParam(':project_id', $last_id);
            $sth2->bindParam(':type_id', $type_id);
            $sth2->execute();
        }

        $sql_program = <<<SQL
INSERT INTO projects_degreeProgram (project_id, program_id)
VALUES (:project_id, :program_id)
SQL;
        foreach (explode(',', $form['program']) as $program) {
            $program_id = '';
            switch ($program) {
                case 'Inf':
                    $program_id = 1;
                    break;
                case 'WInf':
                    $program_id = 2;
                    break;
                case 'EC':
                    $program_id = 3;
            }
            $sth2 = $this->dbh->prepare($sql_program);
            $sth2->bindParam(':project_id', $last_id);
            $sth2->bindParam(':program_id', $program_id);
            $sth2->execute();
        }
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

    public function patchProjectById($id, $form) {
        $sql = <<<SQL
UPDATE projects 
SET `name` = :name,
    `description` = :desc
WHERE projects.id = :id
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':name', $form['name']);
        $sth->bindParam(':desc', $form['desc']);
        $sth->bindParam(':id', $id);
        $sth->execute();
        $error = $sth->errorInfo();

        $last_id = $id;

        $sql_del_user = <<<SQL
        DELETE FROM users_projects
        WHERE project_id = :id
SQL;
        $sth = $this->dbh->prepare($sql_del_user);
        $sth->bindParam(':id', $last_id);
        $sth->execute();
        $error = $sth->errorInfo();

        $sql_user = <<<SQL
INSERT INTO users_projects (project_id, user_cn)
VALUES (:project_id, :user_id)
SQL;
        if ($form['contributor']) {
            foreach (explode(',', $form['contributor']) as $user_id) {
                $sth2 = $this->dbh->prepare($sql_user);
                $sth2->bindParam(':project_id', $last_id);
                $sth2->bindParam(':user_id', $user_id);
                $sth2->execute();
                $error = $sth2->errorInfo();
            }
        }

        $sql_del_type = <<<SQL
        DELETE FROM projects_type
        WHERE project_id = :id
SQL;
        $sth = $this->dbh->prepare($sql_del_type);
        $sth->bindParam(':id', $last_id);
        $sth->execute();
        $error = $sth->errorInfo();

        $sql_type = <<<SQL
INSERT INTO projects_type (project_id, type_id)
VALUES (:project_id, :type_id)
SQL;
        foreach (explode(',', $form['type']) as $type) {
            $type_id = '';
            switch ($type) {
                case 'projekt':
                    $type_id = 1;
                    break;
                case 'bachelor':
                    $type_id = 2;
                    break;
                case 'master':
                    $type_id = 3;
            }
            $sth2 = $this->dbh->prepare($sql_type);
            $sth2->bindParam(':project_id', $last_id);
            $sth2->bindParam(':type_id', $type_id);
            $sth2->execute();
            $error = $sth2->errorInfo();
        }

        $sql_del_program = <<<SQL
        DELETE FROM projects_degreeProgram
        WHERE project_id = :id
SQL;
        $sth = $this->dbh->prepare($sql_del_program);
        $sth->bindParam(':id', $last_id);
        $sth->execute();
        $error = $sth->errorInfo();

        $sql_program = <<<SQL
INSERT INTO projects_degreeProgram (project_id, program_id)
VALUES (:project_id, :program_id)
SQL;
        foreach (explode(',', $form['program']) as $program) {
            $program_id = '';
            switch (strtolower($program)) {
                case 'inf':
                    $program_id = 1;
                    break;
                case 'winf':
                    $program_id = 2;
                    break;
                case 'ec':
                    $program_id = 3;
            }
            $sth2 = $this->dbh->prepare($sql_program);
            $sth2->bindParam(':project_id', $last_id);
            $sth2->bindParam(':program_id', $program_id);
            $sth2->execute();
            $error = $sth2->errorInfo();
        }


//        if (strlen($form['name']) > 50) {
//            exit; // TODO: Send decent error to Client
//        }
//        if (strlen($form['desc']) > 500) {
//            exit; // TODO: Send decent error to Client
//        }
//        $sql = <<<SQL
//UPDATE projects
//SET
//  name        = :name,
//  description = :desc,
//  status      = :status,
//  supervisor  = :supervisor,
//  type_id     = :type
//WHERE projects.id = :`id`
//SQL;
//        $sth = $this->dbh->prepare($sql);
//        $sth->bindParam(':name', $form['name']);
//        $sth->bindParam(':desc', $form['desc']);
//        $sth->bindParam(':id', $id);
//
//        $sth->execute();
//         Todo: May want to return complete object after patching
    }

    public function searchProject($params) {
        $sql = $this->getProjectBaseSql;
        if ($params['projekt'] == 'on') {
            $sql .= "OR types.selector = 'projekt'\n";
        }
        if ($params['bachelor'] == 'on') {
            $sql .= "OR types.selector = 'bachelor'\n";
        }
        if ($params['master'] == 'on') {
            $sql .= "OR types.selector = 'master'\n";
        }

        if ($params['phrase']) {
            $sql .= "AND projects.name LIKE :phrase\n";
            $sql .= "OR projects.description LIKE :phrase\n";
        }

        $sql .= $this->getProjectBaseSqlFooter;

        $sth = $this->dbh->prepare($sql);
        $phrase = '%' . $params['phrase'] . '%';
        $sth->bindParam(':phrase', $phrase);
        $sth->execute();

        return $this->postProcessGetProjectsResults($data = $sth->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getPossibleStatuses() {
        $sql = <<<SQL
SELECT * FROM status
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getProjectStatusById($id) {
        $sql = <<<SQL
SELECT status.name AS status, status.id AS id FROM `projects`
INNER JOIN status
ON projects.status=status.id
WHERE projects.id = :id
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getProjectsBySupervisorId($id) {
        $sql = $this->getProjectBaseSql;
        $sql .= "AND supervisor.cn = :id\n";
        $sql .= $this->getProjectBaseSqlFooter;

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();

        return $this->postProcessGetProjectsResults($data = $sth->fetchAll(PDO::FETCH_ASSOC));
    }
}