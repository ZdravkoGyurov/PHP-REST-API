<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    function logout($user) {
        if(isset($_COOKIE['loginInfo']) && !empty(isset($_COOKIE['loginInfo']))) {
            $errors = array();

            $user->email = $_COOKIE['loginInfo'];
            $user->findUserByEmail();

            if($user->type == 'Admin' || $user->type == 'User') {
                setcookie('loginInfo', '', time() - 3600, '/');
                setcookie('loginInfoToDisplay', '', time() - 3600, '/');
                session_destroy();
                
                echo json_encode($user, JSON_UNESCAPED_UNICODE);
            } else {
                $errors['unauthorizedUserError'] = 'Cannot log out! User is unauthorized!';
                echo json_encode(array(
                    'errors' => $errors
                ));
            }
        } else {
            $errors['loginError'] = 'No user is logged in!';
            echo json_encode(array(
                'errors' => $errors
            ));
        }
    }