<?php
// Routes
require_once 'classes/class.Projects.php';

$app->get('/projects', function () {
    $projectsObj = new Projects();
    return $projectsObj->getProjects();
});
$app->get('/projects/:uid', function ($uid) {
    $projectsObj = new Projects();
    return $projectsObj->getProjectById($uid);
});
