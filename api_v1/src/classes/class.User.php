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
                'header' => "Authorization: $jwtToken"
            )
        );
        $context = stream_context_create($opts);

        $this->data = file_get_contents('https://apistaging.fiw.fhws.de/auth/api/users/me', false, $context);

        echo $this->data;

    }
}