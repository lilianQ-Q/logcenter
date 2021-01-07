<?php
    define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
    define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
    define('MODEL', ROOT . 'kernel/model/');
    define('CORE', ROOT . 'kernel/lib/core/');
    define('MODUL', ROOT. 'kernel/lib/modul/');
    define('LIB', ROOT . 'kernel/lib/');
    define('VIEW', ROOT . 'kernel/view/');
    define('CSS', WEBROOT . 'css/');
    define('IMG', WEBROOT . 'img/');
    define('JS', WEBROOT . 'js/');
    define('DATA', ROOT . 'data/');
    define('CONTROLLER', ROOT . 'kernel/controller/');
    define('LANGAGE', parse_ini_file('app.conf')['langage']);
    define('IP', parse_ini_file('app.conf')['address']);
    $forbidden_actions = array("loadModel","render","set","checkRequest");

    if(!isset($_SERVER['HTTPS']) && parse_ini_file('app.conf')['mod'] != "development"){
        header("Location: https://".IP);
    }

    if (!empty($_GET['p'])) {
        $param = explode('/', $_GET['p']);
        $controller = $param[0];
    } else {
        $controller = 'main';
        $param = array();
    }

    if (!empty($param[1])) {
        if(in_array($param[1], $forbidden_actions)){
            header("Location: //".IP."/main/error");
        }
        else{
            $action = $param[1];
        }
    } else {
        $action = 'index';
    }

    $path = CONTROLLER . $controller . '.php';
    if (file_exists($path)) {
        require($path);
        $controller = 'CTRL' . $controller;
        $controller = new $controller();
        if (method_exists($controller, $action)) {
            unset($param[0]);
            unset($param[1]);
            call_user_func_array(array($controller, $action), $param);
        }
        else {
            header("Location: //".IP."/main/error");
        }
    }
    else{
        $path = CONTROLLER . 'main.php';
        require($path);
        $controller = 'CTRLmain';
        $controller = new $controller();
        $action = 'error';
        call_user_func_array(array($controller, $action), $param);
    }
?>