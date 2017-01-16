<?php

/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 14.01.17
 * Time: 12:42
 */
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
     */
    public function __construct($request) {
        $auth64 = $request->getHeader('authorization')[0];
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
    }

    function parseHeaders($headers) {
        $header = array();
        foreach ($headers as $k => $v) {
            $t = explode(':', $v, 2);
            if (sizeof($t) > 1) {
                $header[strtolower(trim($t[0]))] = strtolower(trim($t[1]));
            }
        }
        return $header;
    }
}