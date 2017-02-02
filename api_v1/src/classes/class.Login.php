<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 14.01.17
 * Time: 12:42
 */
require_once 'class.Database.php';

class Login {
    /**
     * @return string
     */
    public function getData(): string {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getJwtToken() {
        return $this->jwt_token;
    }

    /**
     * Login constructor.
     * @param $request
     */
    public function __construct($request) {
        $databaseObj = new Database();
        $this->dbh = $databaseObj->getPdo();


        $auth64 = $request->getHeaderLine('authorization');
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => "Authorization: $auth64"
            )
        );
        $context = stream_context_create($opts);

        $this->data = file_get_contents('https://apistaging.fiw.fhws.de/auth/api/users/me', false, $context);
        $header = $this->parseHeaders($http_response_header);
        $this->jwt_token = $header['x-fhws-jwt-token'];

        $encoded_data = json_decode($this->data);

        $sql = <<<SQL
SELECT COUNT(cn) AS counter FROM users WHERE cn = :cn
SQL;

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':cn', $encoded_data->cn);
        $sth->execute();

        if ($sth->fetchObject()->counter > 0) {
            return;
        }

        $sql = <<<SQL
        INSERT INTO `users` (`cn`) VALUES (:cn);
SQL;

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':cn', $encoded_data->cn);
        $sth->execute();
    }

    function parseHeaders($headers) {
        $header = array();
        foreach ($headers as $k => $v) {
            $t = explode(':', $v, 2);
            if (sizeof($t) > 1) {
                $header[strtolower(trim($t[0]))] = trim($t[1]);
            }
        }
        return $header;
    }
}
