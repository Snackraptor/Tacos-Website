<?php

function is_logged_in(){
    return isset($_SESSION['user_id']);
}

function require_login(){
    if(!is_logged_in()) {
        header("Location:taco-login.php");
        exit;
    }
}

function validate_taco($tacos){
    $errors = [];

    if(empty(trim($tacos['title']))){
        $errors['title'] = "Please enter a proper title.";
    }

    if(empty(trim($tacos['filling']))){
        $errors['filling'] = "Please select a proper filling.";
    }
    
    if(empty(trim($tacos['salsa']))){
        $errors['salsa'] = "Please select a proper salsa";
    }
    
    if(empty(trim($tacos['tortilla']))){
        $errors['tortilla']  = "Please select a proper tortilla for your taco.";
    }

    if ($tacos['size'] > 1000000) {
        $errors['photo'] = "Image must be less than 1 MB";
    }
    
    if (!($tacos['type'] == 'image/jpg' || $tacos['type'] == 'image/jpeg' || $tacos['type'] == 'image/png')) {
        $errors['photo'] = "Image format must be .jpg or .png";
    }

    return $errors;
}

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

function display_toast($t, $msg){

    if (!($t && $msg)){
        return;
    }

    $msgs = [];
    $msgs['1'] = "Successfully Added";
    $msgs['2'] = "Successfully Deleted";
    $msgs['3'] = "Successfully Edited";

    echo <<<EOL
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-dark text-light">
                
                <strong class="me-auto">$msgs[$t]</strong>
                <small>11 mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-dark text-light">
                $msg
            </div>
        </div>
    </div>
    <script>
    window.addEventListener('DOMContentLoaded', () => {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
    });
    
    toastList.forEach(toast => toast.show())
    });
    </script>
    EOL;
}