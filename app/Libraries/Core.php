<?php

namespace App\Libraries;

class Core
{
    private $currentController = "HomeController";
    private $currentMethod = "index";
    private $params = [];

    public function __construct()
    {

        $url = explode("/", rtrim($_GET["url"], "/"));

        if (!empty($url[0])) {
            if (file_exists("../app/Controllers/" . ucfirst($url[0]) . "Controller.php")) {
                $this->currentController = ucfirst($url[0]) . "Controller";
                unset($url[0]);
            } else {
                $this->currentController = "ErrorController";
            }
        }
        require_once "../app/Controllers/$this->currentController.php";
        $this->currentController = new $this->currentController();

        if (!empty($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        $this->params = !empty($url) ? array_values($url) : [];
        call_user_func([$this->currentController, $this->currentMethod], $this->params);
    }
}
