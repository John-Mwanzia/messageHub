<?php

declare(strict_types=1);

function check_signup_errors(){
    if(isset($_SESSION['signup_errors'])){
        $errors = $_SESSION['signup_errors'];
        foreach($errors as $error){
            echo "<p>$error</p>";
        }
        // unset the session variable
        unset($_SESSION['signup_errors']);
    }
}