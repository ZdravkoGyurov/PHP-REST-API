<?php
    class Validator {
        public static function validateEmail($email, &$errors) {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['emailError'] = 'Email is invalid';
            } else if(strlen($email) > 255) {
                $errors['emailError'] = 'Email is too long';
            }
        }

        public static function validateName($name, &$errors) {
            $pattern  = '/^[\p{Cyrillic}0-9\s\-]+$/u';
            if(!preg_match($pattern, $name)) {
                $errors['nameError'] = 'Name can contain only cyrillic letters';
            } else if(mb_strlen($name) > 100) {
                $errors['nameError'] = 'Name is too long';
            }
        }
        
        public static function validateSurname($surname, &$errors) {
            $pattern  = '/^[\p{Cyrillic}0-9\s\-]+$/u';
            if(!preg_match($pattern, $surname)) {
                $errors['surnameError'] = 'Surname can contain only cyrillic letters';
            } else if(mb_strlen($surname) > 100) {
                $errors['surnameError'] = 'Surname is too long';
            }
        }

        public static function validatePassword($password, &$errors) {
            if(strlen($password) <= 0) {
                $errors['passwordError'] = 'Password is invalid';
            }
        }
    }