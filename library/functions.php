<?php 

function checkEmail($email) {
    $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $validEmail;
}

function checkPassword($password) {
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $password);
}

function buildNavigation($classifications) {

    $navigationList = "<ul>";
    $navigationList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";

    foreach ($classifications as $classification) {
        $navigationList .= "<li><a href='/phpmotors/index.php?action=" .urlencode($classification['classificationName']). "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }

    $navigationList .= "</ul>";

    return $navigationList;
}

function buildClassificationList($classifications){ 

    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>";

    foreach ($classifications as $classification) { 
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 

    $classificationList .= '</select>'; 

    return $classificationList; 
}