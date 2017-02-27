<?php
// Routes
require_once 'classes/class.Projects.php';
require_once 'classes/class.Login.php';
require_once 'classes/class.User.php';

$app->get('/projects', function () {
    $projectsObj = new Projects();
    echo json_encode($projectsObj->getProjects());
});
$app->post('/projects', function ($request, $response, $args) {
    $jwtToken = $request->getHeaderLine('authorization');
    if (!$jwtToken) {
        exit;
    }
    $userObj = new User($jwtToken);

    if (!$userObj->getUserInfo()) {
        $response
            ->withStatus(550)
            ->withHeader('Content-Type', 'text/html')
            ->write('User not logged in');
        exit;
    }


    $projectsObj = new Projects();
    echo $projectsObj->newProject($request->getParsedBody());
});


$app->get('/projects/status', function ($request, $response, $args) {
    $projectsObj = new Projects();
    echo $projectsObj->getPossibleStatuses();
});
$app->get('/projects/{id}/status', function ($request, $response, $args) {
    $projectsObj = new Projects();
    echo $projectsObj->getProjectStatusById($args['id']);
});

$app->get('/projects/[{id}]', function ($request, $response, $args) {
    $projectsObj = new Projects();
    echo json_encode($projectsObj->getProjectById($args['id']));
});

$app->delete('/projects/[{id}]', function ($request, $response, $args) {
    $projectsObj = new Projects();
    echo $projectsObj->delProjectById($args['id']);
});
$app->post('/projects/[{id}]', function ($request, $response, $args) {
    $projectsObj = new Projects();
    echo json_encode($projectsObj->patchProjectById($args['id'], $request->getParsedBody()));
});


$app->get('/login', function ($request, $response, $args) {
    $loginObj = new Login($request, $response);
    header("x-fhws-jwt-token: " . $loginObj->getJwtToken());
    echo $loginObj->getData();
});

$app->get('/user/projects', function ($request, $response, $args) {
    $jwtToken = $request->getHeaderLine('authorization');
    $userObj = new User($jwtToken);
    echo json_encode($userObj->getProjects());
});

$app->get('/user', function ($request, $response, $args) {
    $jwtToken = $request->getHeaderLine('authorization');
    $userObj = new User($jwtToken);
    echo json_encode($userObj->getUserInfo());
});

$app->get('/user/{id}', function ($request, $response, $args) {
    $jwtToken = $request->getHeaderLine('authorization');
    $userObj = new User($jwtToken);
    $userObj->getUserInfoById($args['id']);
});

$app->get('/search/projects', function ($request, $response, $args) {
    $projectsObj = new Projects();
    echo json_encode($projectsObj->searchProject($_GET));
});
