<?php

declare(strict_types=1);

function is_input_empty(string $username, string $email, string $regNo, string $phone, string $password, string $password2){
    if(empty($username) || empty($email) || empty($regNo) || empty($phone) || empty($password) || empty($password2)){
        return true;
    }else{
        return false;
    }
}

function is_email_valid(string $email){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
}

function is_password_match(string $password, string $password2){
    if($password !== $password2){
        return true;
    }else{
        return false;
    }
}

function is_username_taken(object $pdo, string $username){
 if(get_username($pdo, $username)){
     return true;
    }else{
        return false;
    }

}

function is_email_registered(object $pdo, string $email){
    if(get_email($pdo, $email)){
        return true;
    }else{
        return false;
    }
}

