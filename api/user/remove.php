<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: '.
    'Access-Control-Allow-Headers, Content-Type, '.
    'Access-Control-Allow-Methods, Authorization, X-Requested-With');

    function remove($user, $email) {
        define('ADMIN_EMAIL', 'zdravko.gyurov97@gmail.com');
        if(isset($_COOKIE['loginInfo']) && !empty(isset($_COOKIE['loginInfo']))) {
            $errors = array();

            $user->email = $_COOKIE['loginInfo'];
            $user->findUserByEmail();

            if($user->type == 'Admin') {
                Validator::validateEmail($email, $errors);

                if(empty($errors)) {
                    if($email == ADMIN_EMAIL) {
                        $errors['adminError'] = 'Cannot delete admin user!';
                        echo json_encode(array(
                            'errors' => $errors
                        ));
                    } else {
                        $user->email = $email;
                        $user->findUserByEmail();
        
                        if(!isset($user->name)) {
                            $errors['noSuchUserFoundError'] = 'No user with given email found!';
                            echo json_encode(array(
                                'errors' => $errors
                            ));
                        } else if($user->removeUser()) {
                            echo json_encode($user, JSON_UNESCAPED_UNICODE);
                        } else {
                            $errors['unableToDeleteUserError'] = 'User could not be deleted!';
                            echo json_encode(array(
                                'errors' => $errors
                            ));
                        }
                    }
                } else {                
                    echo json_encode(array(
                        'errors' => $errors
                    ));
                }
            } else {
                $errors['unauthorizedUserError'] = 'User is unauthorized!';
                echo json_encode(array(
                    'errors' => $errors
                ));
            }
        } else {
            $errors['noAdminError'] = 'You need to be logged in as Admin to delete users!';
            echo json_encode(array(
                'errors' => $errors
            ));
        }
    }
