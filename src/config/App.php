<?php

namespace src\config;

use src\models\User;
use src\controllers\LoginController;
use src\controllers\MainController;
use src\controllers\RegisterController;
use src\views\LoginView;
use src\views\MainView;
use src\views\RegisterView;

class App
{
    private $conn;

    public function init():void
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function run()
    {
        $user = new User($this->conn);
        $path = trim($_SERVER['REQUEST_URI'], '/');

        if (empty($_SESSION['userId'])) {

            /** User is not authorized */

            $path = !empty($path) ? $path : 'login';

        } else {

            /** Authorized user */

            $path = 'main';
            $user->setId($_SESSION['userId']);
            $user->setTitle($_SESSION['userName']);
            $user->setLists();
        }

        $controllerName = 'src\controllers\\' . ucfirst($path . 'Controller');
        $controllerFile = $controllerName . '.php';
        if (!file_exists($controllerFile)) {
            $controllerName = 'src\controllers\ErrorController';
        }
        $controller = new $controllerName($user);

        /** Logout action */

        if (isset($_GET['action'])) {
            $controller->{$_GET['action']}();
        }

        /** Forms computing */

        if (isset($_POST) && !empty($_POST)) {
            $controller->postAction($_POST, $this->conn);
        }

        $controller->render();
    }
}