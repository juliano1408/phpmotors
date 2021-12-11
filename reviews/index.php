<?php 
/** Reviews Controller */
session_start();

require_once '../connection/connection.php';
require_once '../model/main-model.php';
require_once '../library/functions.php';

/** Getting the reviews model */
require_once '../model/reviews-model.php';

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

    case 'add-review':

        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        if (empty($reviewText)) {
            $_SESSION['reviewsMessage'] = "<p class='message-error'>Please add some review text.</p>";
            header("Location: /phpmotors/vehicles/?action=vehicle-view&invId=$invId");
            exit;
        }

        $result = insertReview($clientId, $invId, $reviewText);

        if ($result === 1) {

            $_SESSION['reviewsMessage'] = "<p class='message-success'>Your review was registered successfully.</p>";
            header("Location: /phpmotors/vehicles/?action=vehicle-view&invId=$invId");
            exit;

        } else {

            $_SESSION['reviewsMessage'] = "<p class='message-error'>Couldn't save the review. Please try again later.</p>";
            header("Location: /phpmotors/vehicles/?action=vehicleDetailView&invId=$invId");
            exit;

        }

        break;

    case 'edit-review':

        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_STRING);
        $reviewInfo = getReviewById($reviewId);

        include '../view/review-edit.php';

        break;

    case 'update-review':

        $reviewText = trim(filter_input(INPUT_POST, 'review-text', FILTER_SANITIZE_STRING));
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_STRING));

        $resultUpdate = updateReview($reviewId, $reviewText);

        if ($resultUpdate === 1) {
            $_SESSION['messageData']['review'] = "Your review was updated.";
        } else {
            $_SESSION['messageData']['review'] = "It was not possible to update the review.";
        }

        header('Location:/phpmotors/accounts/');
        exit;

        break;

    case 'delete-view':

        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_STRING);

        $reviewInfo = getReviewById($reviewId);

        include '../view/review-delete.php';

        break;

    case 'delete-review':

        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT)); 

        $resultDelete = deleteReview($reviewId);

        if ($resultDelete === 1) {
            $_SESSION['messageData']['review'] = "Your review was deleted."; 
        } else {
            $_SESSION['messageData']['review'] = "The review couldn't be deleted."; 
        }

        header('Location:/phpmotors/accounts/');
        exit;

        break;

    default:
        header('Location: /phpmotors/accounts');
        break;
}