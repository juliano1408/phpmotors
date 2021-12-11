<?php 
    require_once '../includes/header.php';
    require_once '../includes/menu.php';

    if ($_SESSION['clientData']['clientLevel'] < 2) {
        header('Location: /phpmotors/');
        exit;
    }
?>

<section class="main">
    <h1>Delete Review</h1>

    <?php 

    if(!empty($reviewInfo)) {

        $html = "<section class='review-edit-form'>";
        $html .= "<form action='/phpmotors/reviews/?action=delete-review' method='POST'>";
        $html .= "<label for='review-text'>Review</label>";
        $html .= "<textarea disabled rows='5' cols='60' type='text' id='review-text' name='review-text'>" .$reviewInfo['reviewText']. "</textarea>";
        $html .= "<p class='warning-delete'>Are you sure you want to delete this review? This operation can be undone.</p>";
        $html .= "<button type='submit'>Delete</button>";
        $html .= "<input type='hidden' id='reviewId' name='reviewId' value='". $reviewInfo['reviewId']."'>";
        $html .= "</form>";   
        $html .= "</section>";

        echo $html;
    }

    ?>
</section>

<?php 
    require_once '../includes/footer.php';
?>

