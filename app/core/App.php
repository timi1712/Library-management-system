<?php

class App 
{
    //Main application class(Router)
    private $controller = 'Home';
    private $method = 'index';

    # split url to array components
    private function splitUrl()
    {
        $Url = $_GET['url'] ?? 'home';
        $Url = explode("/", trim($Url, "/"));
        return $Url;
    }

    public function loadController()
    {
        $URL = $this->splitUrl();
        # convert controller filename to lowercase
        $controllerName = str_replace('-', '', ucfirst(strtolower($URL[0])));
        $baseDir = dirname(__DIR__);  // Store the base directory
        $controllerFile = $baseDir . "/controllers/" . $controllerName .".php";
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->controller = $controllerName;
            unset($URL[0]);
        }else {
            
            # load the 404 controller
            require_once $baseDir."/controllers/_404.php";
            $this->controller = "_404";
            
        }

        $controller = new $this->controller();
        # get the method($URL[1])
        if (!empty($URL[1]) && method_exists($controller, $URL[1])) {
            $this->method = $URL[1];
            unset($URL[1]);
        }

        call_user_func_array([$controller,$this->method],$URL);

    }
}