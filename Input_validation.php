<?php

function validateName($name) {
    // Name should contain only letters, spaces, and must be between 2 and 50 characters long
    if (preg_match('/^[a-zA-Z\s]{2,50}$/', $name)) {
        return true;
    } else {
        return false;
    }
}

function validateEmail($email) {
    if (preg_match('/^[A-Za-z0-9]+@(gmail|yahoo|it-marvel)\.com$/', $email)) {
        return true;
    } else {
        return false;
    }
}


function validatePassword($password) {
    // Check if password meets certain criteria
    if (strlen($password) >= 8 && preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)) {
        return true;
    } else {
        return false;
    }
}
?>