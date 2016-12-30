<?php


function preventXSS($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isUsernameValid($data){
    if(strlen($data) == 0 || !preg_match("~^[a-zA-Z0-9_ ]+$~", strval($data))){
        return false;
    }
    return true;
}

function isNameValid($data){
    if(strlen($data) == 0 || !preg_match("~^[a-zA-Z ]+$~", strval($data))){
        return false;
    }
    return true;
}

function isPasswordValid($data){
    if(strlen($data) < 5){
        return false;
    }
    return true;
}
function isEmailValid($data){

    if(strlen($data) == 0){
       return false;
    }
    return filter_var(strval($data), FILTER_VALIDATE_EMAIL) != false;
}
function isDateTimeValid($data){
    if(strlen($data) == 0 || !preg_match("~~", strval(strval($data)))){
        return false;
    }
    return true;
}

function isCityNameValid($data){
    if(strlen($data) == 0 || !preg_match("~^[a-zA-Z ]+$~", strval($data))){
        return false;
    }
    return true;
}

function isPositiveNumber($data){
    $num=intval($data);
    if($num<=0){
        return false;
    }

    return true;
}

