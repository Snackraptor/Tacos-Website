<?php

function validate_registration($user, $conn) {
    $errors = [];

    if(empty(trim($user['email']))) {
        $errors['email'] = "Email cannot be blank";
    }

    $email_regex = "/.+\@.+\..+/";
    if (!preg_match($email_regex, $user['email'])) {
        $errors['email'] = "Username must be a valid email address";
    }

    if(empty(trim($user['new-password']))) {
        $errors['password'] = "Password cannot be blank";
    }

    if(empty(trim($user['confirm-password']))) {
        $errors['confirm'] = "Confirmation Password cannot be blank";
    }

    $sql = "SELECT * FROM taco_users WHERE username='" . $user['email'] . "'";
    $cmd = $conn -> prepare($sql);
    $cmd -> execute();
    $found_username = $cmd -> fetch();

    if($found_username){
        $errors['email'] = "Username already taken";
    }
        
    return $errors;
}