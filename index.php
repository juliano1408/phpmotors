<?php 
/** Main Controller */
session_start();

require_once 'connection/connection.php';
require_once 'model/main-model.php';
require_once 'library/functions.php';

$classifications = getClassifications();

$navigationList = buildNavigation($classifications);

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
}

if(isset($_COOKIE['firstname'])){
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

switch ($action){
    case 'template';
        include 'view/template.php';
        break;
    default:
        include 'view/home.php';
}