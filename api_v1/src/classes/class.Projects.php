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
  projects.id                            AS id,
  projects.name                          AS name,
  projects.description                   AS description,
  GROUP_CONCAT(degreeProgram.short_name) AS degreeName,
  types.name                             AS type,
  GROUP_CONCAT(DISTINCT users.cn)        AS cn,
  supervisor.firstName                   AS supervisor_firstName,
  supervisor.lastName                    AS supervisor_lastName,
  project_status.name                    AS status
FROM projects
  LEFT JOIN projects_degreeProgram
    ON projects_degreeProgram.project_id = projects.id
  LEFT JOIN degreeProgram
    ON degreeProgram.id = projects_degreeProgram.program_id
  LEFT JOIN types
    ON projects.type_id = types.id
  LEFT JOIN users_projects
    ON projects.id = users_projects.project_id
  LEFT JOIN users
    ON users_projects.user_id = users.id
  LEFT JOIN users AS supervisor
    ON projects.supervisor = users.id
  LEFT JOIN project_status
    ON projects.status = project_status.id
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

        return $this->postProcessGetProjectsResults($data = $sth->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * @param $form
     * @return mixed
     */
    public function newProject($form) {
        if (strlen($form['name']) > 50) {
            exit; // TODO: Send decent error to Client
        }
        if (strlen($form['desc']) > 500) {
            exit; // TODO: Send decent error to Client
        }

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
        $sql .= $this->getProjectBaseSqlFooter;

        $sth = $this->dbh->prepare($sql);
        $phrase = '%' . $params['phrase'] . '%';
        $sth->bindParam(':phrase', $phrase);
        $sth->execute();

        return $this->postProcessGetProjectsResults($data = $sth->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getPossibleStatuses() {
        $sql = <<<SQL
SELECT * FROM project_status
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getProjectStatusById($id) {
        $sql = <<<SQL
SELECT project_status.name AS status, project_status.id AS id FROM `projects`
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