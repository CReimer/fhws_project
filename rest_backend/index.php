<?php
/**
 * Created by PhpStorm.
 * User: christopher
 * Date: 16.12.16
 * Time: 11:58
 */

// Don't forget to load all neccessary classes!
// Initialize Slim Framework

error_reporting(E_ALL);
ini_set('display_errors','on');

require 'vendor/slim/Slim/App.php';

$app = new \Slim\App();
$app->get('/projects', function () {
// todo
});

$app->get('/projects/:uid', function ($uid) {
// todo
});

$app->run();