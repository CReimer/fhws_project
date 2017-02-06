<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 18.01.17
 * Time: 11:49
 */
class User {

    /**
     * User constructor.
     */
    public function __construct($jwtToken) {
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
        return json_encode($this->data);
    }

    public function getUserInfoById($id) {
        $sql = <<<SQL
SELECT * FROM users
WHERE id = :id
SQL;
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
    }
}