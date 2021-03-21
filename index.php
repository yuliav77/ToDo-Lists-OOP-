<?php

session_start();

require_once "src/config/connect.php";
use src\models\User;
use src\controllers\LoginController;
use src\controllers\MainController;
use src\controllers\RegisterController;
use src\views\LoginView;
use src\views\MainView;
use src\views\RegisterView;

$user = new User($databaseConnection);
$url = trim($_SERVER['REQUEST_URI'], '/');

if (empty($_SESSION['userId'])) {

    /* User is not authorized */

    $url = !empty($url) ? $url : 'login';
    $controllerName = 'src\controllers\\' . ucfirst($url . 'Controller');
    $viewName =  'src\views\\' . ucfirst($url . 'View');
    $controller = new $controllerName($user);
    $view = new $viewName($controller, $user);

} else {

    /* Authorized user */

    $user->setId($_SESSION['userId']);
    $user->setTitle($_SESSION['userName']);
    $user->setLists();
    $controller = new MainController($user);
    $view = new MainView($controller, $user);

    /* Logout action */

    if (isset($_GET['action'])) {
        $controller->{$_GET['action']}();
    }

}


/* Forms computing */

if (isset($_POST) && !empty($_POST)) {
    $controller->postAction($_POST, $databaseConnection);
}

echo $view->output();