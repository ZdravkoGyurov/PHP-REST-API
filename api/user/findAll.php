<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    function findAll($user) {
        $result = $user->findAllUsers();
        $num = $result->rowCount();

        if(isset($_COOKIE['loginInfo']) && !empty(isset($_COOKIE['loginInfo']))) {
            $errors = array();

            $user->email = $_COOKIE['loginInfo'];
            $user->findUserByEmail();

            if($user->type == 'Admin') {
                if($num > 0) {
                    $usersArr = array();
                    $usersArr['data'] = array();
        
                    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $userItem = array(
                            'email' => $email,
                            'name' => $name,
                            'surname' => $surname,
                            'password' => $password,
                            'roleId' => $roleId,
                            'type' => $type
                        );
        
                        array_push($usersArr['data'], $userItem);
                    }
                    echo json_encode($usersArr, JSON_UNESCAPED_UNICODE);
                } else {
                    $errors['noUserFoundError'] = 'No users found!';
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
            $errors['noAdminError'] = 'You need to be logged in as Admin to see all registered users!';
            echo json_encode(array(
                'errors' => $errors
            ));
            // header('Location: https://www.google.com/', true, 303);
        }
    }
