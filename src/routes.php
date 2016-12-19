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

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.html', $args);
});