<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: '.
    'Access-Control-Allow-Headers, Content-Type, '.
    'Access-Control-Allow-Methods, Authorization, X-Requested-With');

    function create($user) { 
        $data = json_decode(file_get_contents('php://input'));

        if($data->email != '' && $data->name != '' && $data->surname != '' && $data->password != '') {
            $errors = array();
            
            Validator::validateEmail($data->email, $errors);
            Validator::validateName($data->name, $errors);
            Validator::validateSurname($data->surname, $errors);
            Validator::validatePassword($data->password, $errors);

            if(empty($errors)) {
                $user->email = $data->email;
                $user->name = $data->name;
                $user->surname = $data->surname;
                $user->password = password_hash($data->password, PASSWORD_DEFAULT) ;
                $user->roleId = '2';
                $user->type = 'User';

                if($user->createUser()) {
                    echo json_encode($user, JSON_UNESCAPED_UNICODE);
                } else {
                    $errors['userExistsError'] = 'User already exists!';
                    echo json_encode(array(
                        'errors' => $errors
                    ));
                }
            } else {
                echo json_encode(array(
                    'errors' => $errors
                ));
            }
        } else {
            $errors['dataIncompleteError'] = 'User could not be created! Data is incomplete!';
            echo json_encode(array(
                'errors' => $errors
            ));
        }
    }