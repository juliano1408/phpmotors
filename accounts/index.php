<?php 
/** Accounts Controller */
session_start();

require_once '../connection/connection.php';
require_once '../model/main-model.php';
require_once '../library/functions.php';

/** Getting the account model */
require_once '../model/accounts-model.php';

/** Getting the review model */
require_once '../model/reviews-model.php';

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

    case 'loginUser';
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientEmail = checkEmail($clientEmail);

        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
        $checkPassword = checkPassword($clientPassword);

        if(empty($clientEmail) || empty($clientPassword)) {
            $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
            include '../view/login.php';
            exit;
        }

        $clientData = getClient($clientEmail);

        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);

        if(!$hashCheck) {
            $_SESSION['message'] = '<p>Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }

        $_SESSION['loggedin'] = true;

        $clientId = $clientData['clientId'];
        $clientsReview = getReviewsByClient($clientId);
        
        array_pop($clientData);

        $_SESSION['clientData'] = $clientData;

        include '../view/admin.php';
        exit;

        break;
    case 'logout';
        session_unset();
        session_destroy();
        unset($_COOKIE['firstname']); 
        setcookie('firstname', null, -1, '/'); 
        header('Location: /phpmotors/');
        break;
    case 'login';
        include '../view/login.php';
        break;
    case 'register':
        include '../view/register.php';
        break;
    case 'registration';

        $clientFirstName = trim(filter_input(INPUT_POST, 'clientFirstName', FILTER_SANITIZE_STRING));
        $clientLastName = trim(filter_input(INPUT_POST, 'clientLastName', FILTER_SANITIZE_STRING));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        if(empty($clientFirstName) || empty($clientLastName) || empty($clientEmail) || empty($checkPassword) ){
            $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
            include '../view/register.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        $existingEmail = checkExistingEmail($clientEmail);

        if($existingEmail){
            $_SESSION['message'] = '<p>This email address is already registered. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        $regOutcome = regClient($clientFirstName, $clientLastName, $clientEmail, $hashedPassword);

        if($regOutcome === 1){
            setcookie('firstname', $clientFirstName, strtotime('+1year'), '/');
            $_SESSION['message'] = "<p>Thanks for registering $clientFirstName. Please use your email and password to login.</p>";
            header('Location: /phpmotors/accounts/?action=login');
            exit;
        } else {
            $_SESSION['message'] = "<p>Sorry $clientFirstName, but the registration failed. Please try again.</p>";
            include '../view/register.php';
            exit;
        }

        break;

    case 'user-management':
        $_SESSION['message'] = '';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/user-management.php';
        break;

    case 'update-client':

        $clientFirstName = trim(filter_input(INPUT_POST, 'clientFirstName', FILTER_SANITIZE_STRING));
        $clientLastName = trim(filter_input(INPUT_POST, 'clientLastName', FILTER_SANITIZE_STRING));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));

        $clientEmail = checkEmail($clientEmail);

        if (empty($clientFirstName) || empty($clientLastName) || empty($clientEmail)) {
            $_SESSION['message']  = '<p>Please provide information for all empty form fields.</p>';
            include '../view/user-management.php';
            exit;
        }

        $updateClientResult = updateClient($clientFirstName, $clientLastName, $clientEmail);

        if ($updateClientResult === 1) {

            setcookie('firstname', $clientFirstName, strtotime('+1 year'), '/');

            $_SESSION['clientData']['clientFirstname'] = $clientFirstName;
            $_SESSION['clientData']['clientLastname'] = $clientLastName;
            $_SESSION['clientData']['clientEmail'] = $clientEmail;

            $_SESSION['message'] = $clientFirstname .", your information was updated.";
            header('Location: /phpmotors/accounts/');
            exit;

        } else {

            $updateMessage = "<p>Sorry $clientFirstName, but your information couldn't be updated. Please try again.</p>";
            include '../view/user-management.php';
            exit;
        }
    
        case 'update-password':

            $clientEmail = $_SESSION['clientData']['clientEmail'];
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
            $checkPassword = checkPassword($clientPassword);

            if (empty($clientPassword)) {
                $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
                include '../view/user-management.php';
                exit;
            }

            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

            $updateClientPassword = updatePassword($hashedPassword, $clientEmail);

            if ($updateClientPassword === 1) {
    
                $_SESSION['message'] = "password for email: $clientEmail was updated.";
                header('Location: /phpmotors/accounts/');
                exit;

            } else {

                $_SESSION['message'] = "<p>It was not possible to change the password for the email $clientEmail. Please try again later.</p>";
                include '../view/user-management.php';
                exit;

            }

            break;

    default:
        
        if ($_SESSION['loggedin']) {
            $clientId = $_SESSION['clientData']['clientId'];
            $clientsReview = getReviewsByClient($clientId);
        }
            
        include '../view/admin.php';
        break;
}