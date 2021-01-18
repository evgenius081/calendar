<?php

//if ($_SERVER['SERVER_PORT'] === '80') {
//    // header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
//}

spl_autoload_register(static function (string $name): bool {
    $path = __DIR__ . '/' . $name . '.php';
    if (is_readable($path)) {
        include $path;
        return true;
    }
    return false;
});
$requestURI = $_SERVER['REQUEST_URI'];
if ($pos = strpos($requestURI, '?')) {
    $requestURI = substr($requestURI, 0, $pos);
}
if (strpos($requestURI, '.')) {
    $pos = strrpos($requestURI, '/');
    $requestURI = substr($requestURI, 0, $pos);
}
if (substr($requestURI, -1) !== '/') {
    $requestURI .= '/';
}


$routes = include __DIR__ . '/config/routes.php';

if (isset($routes[$requestURI])) {
    $route = $routes[$requestURI];
    if (is_callable($route)) {
        call_user_func($route);
    } else if (is_string($route) && strpos($route, '@')) {
        [$controller, $action] = explode('@', $route);
        $class = 'Controller\\' . $controller;
        if (class_exists($class)) {
            if (method_exists($class, $action)) {
                call_user_func([new $class, $action]);
                exit();
            }header('Location: /404');
        }else {
            trigger_error('');
        }
    }
} else {
    foreach ($routes as $url => $route) {
        if (strpos($url, '{')) {
            $a = preg_replace(['~\{i\}~', '~\{s\}~'], ['([0-9]+)','([a-zA-Z]+)'], $url);
            if (preg_match('~^'.$a.'$~', $requestURI, $matches)) {
                array_shift($matches);
                if($matches[1][0] == 0 && count($matches) > 1){
                    array_pop($matches);
                    $route = 'Calendar@year';
                }
                if (is_callable($route)) {
                    call_user_func($route,$matches);
                } elseif (is_string($route) && strpos($route, '@')) {
                    if($matches[1][0] > 12){
                        header('Location: /404');
                    }
                    [$controller, $action] = explode('@', $route);
                    $class = 'Controller\\' . $controller;
                    if (class_exists($class)) {
                        if (method_exists($class, $action)) {
                            call_user_func([new $class, $action],$matches);
                            exit();
                        }
                    }
                    header('Location: /404');
                } else {
                    trigger_error('');
                }
            }
        }
    }
    //header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    if ($requestURI !== '/404/') {
        header('Location: /404');
    }
    include __DIR__ . '/views/404.php';
}


//https://uiregex.com/ru