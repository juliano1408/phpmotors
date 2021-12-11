<?php 

    if (isset($vehicle['invMake']) && isset($vehicle['invModel'])){
        $vehicleName = $vehicle['invMake'] . " " .$vehicle['invModel'];
        $titleElement = "<title>" . $vehicleName . "</title>";
    }

    require_once '../includes/header.php';
    require_once '../includes/menu.php';

    /*echo "<pre>";
    print_r($reviewsInv);
    echo "</pre>";
    die();*/

?>

<section class="main">
    <h1>Vehicle Details</h1>

    <?php 
        if(!empty($vehicleDetailsDisplay)) {
            echo $vehicleDetailsDisplay;
        }

        if(!empty($vehicleThumbnailsDisplay)){
            echo $vehicleThumbnailsDisplay;
        }
    ?>

    <div class="reviews">
        <h2>Customer Reviews</h2>

        <?php 

            if(isset($reviewsInv)) {

                echo "<div class='reviews-inv'>";

                foreach($reviewsInv as $review){

                    echo "<div class='review-inv'>";
                    echo "<div class='review-screenname'>$review[screenName]</div>";
                    echo "<div class='review-text'>$review[reviewText]</div>";
                    echo "<div class='review-date'>$review[reviewDate]</div>";
                    echo "</div>";

                }

                echo "</div>";

            }

            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1 ) {

                $clientId = $_SESSION['clientData']['clientId'];
                $invId = $vehicle['invId'];

                ?>
                    <div class="form-review">
                        <form action="/phpmotors/reviews/?action=add-review" method="post">
                            <p>Add your review</p>
                            <textarea name="reviewText"></textarea>
                            <input type="hidden" name="clientId" value="<?php echo $clientId; ?>">
                            <input type="hidden" name="invId" value="<?php echo $invId; ?>">
                            <button type="submit">Add</button>
                        </form>
                    </div>
                <?php
            } else {
                ?>
                    <p class="alert-login">To add a review you must be logged in. Login <a href="/phpmotors/accounts/?action=login">here</a></p>
                <?php                 
            }

            if (isset($_SESSION['reviewsMessage'])) {
                echo $_SESSION['reviewsMessage'];
            }
        
        ?>

    </div>

</section>

<?php 
    require_once '../includes/footer.php';
?>