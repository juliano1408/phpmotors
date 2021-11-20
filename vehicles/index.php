<?php 
/** Vehicles Controller */
session_start();

require_once '../connection/connection.php';
require_once '../model/main-model.php';
require_once '../library/functions.php';

/** Getting the vehicles model */
require_once '../model/vehicles-model.php';

$classifications = getClassifications();

$navigationList = buildNavigation($classifications);

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

if(isset($_COOKIE['firstname'])){
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

switch ($action) {
    case 'getInventoryItems':
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $inventoryArray = getInventoryByClassification($classificationId); 
        echo json_encode($inventoryArray); 
        break;
    case 'add-vehicle-page':
        include '../view/add-vehicle.php';
        break;

    case 'add-classification-page':
        include '../view/add-classification.php';
        break;

    case 'add-vehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $carMake = filter_input(INPUT_POST, 'carMake', FILTER_SANITIZE_STRING);
        $carModel = filter_input(INPUT_POST, 'carModel', FILTER_SANITIZE_STRING);
        $carDescription = filter_input(INPUT_POST, 'carDescription', FILTER_SANITIZE_STRING);
        $carImage = filter_input(INPUT_POST, 'carImage', FILTER_SANITIZE_STRING);
        $carThumbnail = filter_input(INPUT_POST, 'carThumbnail', FILTER_SANITIZE_STRING);
        $carPrice = filter_input(INPUT_POST, 'carPrice', FILTER_SANITIZE_STRING);
        $carStock = filter_input(INPUT_POST, 'carStock', FILTER_SANITIZE_STRING);
        $carColor = filter_input(INPUT_POST, 'carColor', FILTER_SANITIZE_STRING);
        
        if(empty($classificationId) || empty($carMake) || empty($carModel) || empty($carDescription) || empty($carImage) || empty($carThumbnail) || empty($carPrice) || empty($carStock) || empty($carColor)) {
            $message = "<p class=\"message-error\"> Please complete all empty form fields. </p>";
            include '../view/add-vehicle.php';
            exit;
        }

        $addInventory = addVehicle($carMake, $carModel, $carDescription, $carImage, $carThumbnail, $carPrice, $carStock, $carColor, $classificationId);

        if($addInventory === 1) {
            $message = "<p class=\"message-success\">New vehicle $carMake:$carModel registered. </p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p class=\"message-error\">There was a problem adding the register $carMake:$carModel. Please try again. </p>";
            include '../view/add-vehicle.php';
            exit;
        }
        break;

    case 'add-classification':

        $carClassification = filter_input(INPUT_POST, 'carClassification');

        if (empty($carClassification)) {
            $message = "<p class=\"message-error\">The field for car classification is required! Please provide a classification filling the field.</p>";
            include '../view/add-classification.php';
            exit;
        }

        $newClassification = regCarClassification($carClassification);

        if ($newClassification === 1) {
            $message = "<p class=\"message-success\">New Classification $carClassification registered successfully! </p>";
            include '../view/add-classification.php';
            exit;
        } else {
            $message = "<p class=\"message-error\">Sorry there was an error add $carClassification. Please try again.</p>";
            include '../view/add-classification.php';
            exit;
        }

        break;
    case 'mod':

        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);

        if(count($invInfo)<1){
            $message = 'Sorry, no vehicle information could be found.';
        }

        include '../view/vehicle-update.php';
        exit;

        break;

    case 'del':

        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);

        if(count($invInfo)<1){
            $message = 'Sorry, no vehicle information could be found.';
        }

        include '../view/vehicle-delete.php';
        exit;

        break;

    case 'update-vehicle':

        $carId = filter_input(INPUT_POST, 'carId', FILTER_SANITIZE_NUMBER_INT);
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $carMake = filter_input(INPUT_POST, 'carMake', FILTER_SANITIZE_STRING);
        $carModel = filter_input(INPUT_POST, 'carModel', FILTER_SANITIZE_STRING);
        $carDescription = filter_input(INPUT_POST, 'carDescription', FILTER_SANITIZE_STRING);
        $carImage = filter_input(INPUT_POST, 'carImage', FILTER_SANITIZE_STRING);
        $carThumbnail = filter_input(INPUT_POST, 'carThumbnail', FILTER_SANITIZE_STRING);
        $carPrice = filter_input(INPUT_POST, 'carPrice', FILTER_SANITIZE_STRING);
        $carStock = filter_input(INPUT_POST, 'carStock', FILTER_SANITIZE_STRING);
        $carColor = filter_input(INPUT_POST, 'carColor', FILTER_SANITIZE_STRING);
        
        if(empty($classificationId) || empty($carMake) || empty($carModel) || empty($carDescription) || empty($carImage) || empty($carThumbnail) || empty($carPrice) || empty($carStock) || empty($carColor)) {
            $message = "<p class=\"message-error\"> Please complete all empty form fields. </p>";
            include '../view/vehicle-update.php';
            exit;
        }

        $updateInventory = updateVehicle($carId, $carMake, $carModel, $carDescription, $carImage, $carThumbnail, $carPrice, $carStock, $carColor, $classificationId);

        if ($updateInventory === 1) {

            $message = "<p class=\"message-success\">Vehicle $carMake:$carModel updated. </p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class=\"message-error\">There was a problem updating the register $carMake:$carModel. Please try again. </p>";
            include '../view/vehicle-update.php';
            exit;
        }

        break;

    case 'delete-vehicle':

        $carId = filter_input(INPUT_POST, 'carId', FILTER_SANITIZE_NUMBER_INT);
        $carMake = filter_input(INPUT_POST, 'carMake', FILTER_SANITIZE_STRING);
        $carModel = filter_input(INPUT_POST, 'carModel', FILTER_SANITIZE_STRING);

        $deleteInventory = deleteVehicle($carId);

        if ($deleteInventory === 1) {

            $message = "<p class=\"message-success\">Vehicle $carMake:$carModel deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class=\"message-error\">There was a problem deleting the register $carMake:$carModel. Please try again.</p>";
            include '../view/vehicle-delete.php';
            exit;
        }

        break;

    case 'classification':

        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);

        if(!count($vehicles)) {
            $message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.</p>";
        } else {
            $vehiclesDisplay = buildVehiclesDisplay($vehicles);
        }

        include '../view/classification.php';

        break;

    case 'vehicle-view':

        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $vehicle = getInvItemInfo($invId);

        if (!empty($vehicle)) {
            $vehicleDetailsDisplay = buildVehicleDisplay($vehicle);
            include '../view/vehicle-detail.php';            
        } else {
            $message = "<p>Sorry, $vehicle[invMake] $vehicle[invModel] wasn't found in the registers.";
        }

        break;

    default:
        $classificationList = buildClassificationList($classifications);
        include '../view/vehicles.php';
}