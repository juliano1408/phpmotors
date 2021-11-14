<?php 
/** Main Controller */
session_start();

require_once 'connection/connection.php';
require_once 'model/main-model.php';

$classifications = getClassifications();

$navigationList = "<ul>";
$navigationList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";

foreach ($classifications as $classification) {
    $navigationList .= "<li><a href='/phpmotors/index.php?action=" .urlencode($classification['classificationName']). "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";

}

$navigationList .= "</ul>";

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