<?php
    include_once '../config/Database.php';
    include_once '../models/User.php';
    include_once '../validate/Validator.php';
    include_once 'user/create.php';
    include_once 'user/findAll.php';
    include_once 'user/remove.php';
    include_once 'user/login.php';
    include_once 'user/logout.php';

    $database = new Database();
    $connection = $database->getConnection();

    $user = new User($connection); 

    $uriSegments = explode('.php/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    if($uriSegments[1] == 'register') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            create($user);
        }
    } else if($uriSegments[1] == 'users') {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            findAll($user);
        }
    } else if($uriSegments[1] == 'login') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            login($user);
        }
    } else if($uriSegments[1] == 'logout') {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            logout($user);
        }
    } else if(strpos($uriSegments[1], '/')) {
        $segments = explode('/', $uriSegments[1]);
        if($segments[0] == 'user') {
            if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                remove($user, $segments[1]);
            }
        }
    } else {
        echo 'Page not found.';
    }
