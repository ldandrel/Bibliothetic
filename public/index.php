<?php
require('../vendor/autoload.php');

use \App\System\App;
use \App\System\Router\Router;


session_start();
$app    = new App();
$router = new Router($_GET);


$router->get('/', function() {
    App::secured();
    $controller = new \App\Controllers\BooksController();
    $controller->all();
});

$router->post('/', function() {
    App::secured();
    $controller = new \App\Controllers\BooksController();
    $controller->all();
});

$router->get('/faq', function() {
    App::secured();
    $controller = new \App\Controllers\BooksController();
    $controller->faq();
});

$router->get('/email/:name/:id', function($name, $id) {
    $controller = new \App\Controllers\BooksController();
    $controller->email($name, $id);
});

$router->post('/book/:id', function($id) {
    App::secured();
    $controller = new \App\Controllers\BooksController();
    $controller->book($id);
});

$router->post('/book/:search/:available/:filter', function($search,$available,$filter) {
    App::secured();
    $controller = new \App\Controllers\BooksController();
    $controller->filter($search,$available,$filter);
});

$router->get('/historique', function() {
    $controller = new \App\Controllers\HistoryController();
    $controller->history();
});

$router->get('/connexion', function() {
    $controller = new \App\Controllers\UsersController();
    $controller->login();
});

$router->get('/deconnexion', function() {
    $controller = new \App\Controllers\UsersController();
    $controller->logout();
});

$router->get('/contact', function() {
    App::secured();
    $controller = new \App\Controllers\BooksController();
    $controller->contact();
});

$router->post('/contact', function() {
    App::secured();
    $controller = new \App\Controllers\BooksController();
    $controller->contact();
});

$router->get('/maintenance', function() {
    $controller = new \App\Controllers\BooksController();
    $controller->maintenance();
});


$router->get('/admin', function() {
    if(App::adminAccess()) {
    $controller = new \App\Controllers\AdminController();
    $controller->admin();
    }
});

$router->get('/admin/livre/:id', function($id) {
    if(App::adminAccess()) {
        $controller = new \App\Controllers\AdminController();
        $controller->book($id);
    }
});

$router->post('/admin/livre/:id', function($id) {
    if(App::adminAccess()) {
        $controller = new \App\Controllers\AdminController();
        $controller->book($id);
    }
});



$router->get('/admin/ajouter-un-livre', function() {
    if(App::adminAccess()) {
        $controller = new \App\Controllers\AdminController();
        $controller->add();
    }
});

$router->post('/admin/ajouter-un-livre', function() {
    if(App::adminAccess()) {
        $controller = new \App\Controllers\AdminController();
        $controller->add();
    }
});

$router->get('/admin/utilisateurs', function() {
    if(App::adminAccess()) {
        $controller = new \App\Controllers\AdminController();
        $controller->users();
    }
});

$router->get('/admin/utilisateur/:id', function($id) {
    if(App::adminAccess()) {
        $controller = new \App\Controllers\AdminController();
        $controller->user($id);
    }
});

$router->get('/admin/statistiques', function() {
    if(App::adminAccess()) {
        $controller = new \App\Controllers\AdminController();
        $controller->stats();
    }
});


$router->error(function() {
    App::error();
});

$router->run();
