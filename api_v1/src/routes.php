<?php
// Routes
require_once 'classes/class.Projects.php';
$app->get('/projects', function () {
    $projectsObj = new Projects();
    echo $projectsObj->getProjects();
});
$app->post('/projects', function($request, $response, $args) {
    $projectsObj = new Projects();
    echo $projectsObj->newProject($request->getParsedBody());
});


$app->get('/projects/[{id}]', function ($request, $response, $args) {
    $projectsObj = new Projects();
    echo $projectsObj->getProjectById($args['id']);
});
$app->delete('/projects/[{id}]', function ($request, $response, $args) {
    $projectsObj = new Projects();
    echo $projectsObj->delProjectById($args['id']);
});
