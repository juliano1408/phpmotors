<?php 
    require_once '../includes/header.php';
    require_once '../includes/menu.php';
?>

<section class="main">
    <h1>Edit Review</h1>

    <?php 

        if(!empty($reviewInfo)) {

            $html = "<section class='review-edit-form'>";
            $html .= "<form action='/phpmotors/reviews/?action=update-review' method='POST'>";
            $html .= "<label for='review-text'>Review</label>";
            $html .= "<textarea rows='5' cols='60' type='text' id='review-text' name='review-text'>" .$reviewInfo['reviewText']. "</textarea>";
            $html .= "<button type='submit'>Update</button>";
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

