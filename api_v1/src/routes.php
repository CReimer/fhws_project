<?php
// Routes
require_once 'classes/class.Projects.php';
require_once 'classes/class.Login.php';
require_once 'classes/class.User.php';
require_once 'classes/class.Filemanager.php';

$app->get('/projects', function () {
    $projectsObj = new Projects();
    echo $projectsObj->getProjects();
});
$app->post('/projects', function ($request, $response, $args) {
    $jwtToken = $request->getHeaderLine('authorization');
    $userObj = new User($jwtToken);


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
$app->patch('/projects[{id}]', function($request, $response, $args) {
    $projectsObj = new Projects();
    echo $projectsObj->patchProjectById($args['id'], $request->getParsedBody());
});
$app->get('/projects/status', function ($request, $response, $args) {
    $projectsObj = new Projects();
    echo $projectsObj->getPossibleStatuses();
});

$app->get('/login', function ($request, $response, $args) {
    $loginObj = new Login($request);
    header("x-fhws-jwt-token: " . $loginObj->getJwtToken());
    echo $loginObj->getData();
});

$app->post('/files', function ($request, $response, $args) {
    $filesObj = new Filemanager();

});
