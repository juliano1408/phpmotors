<?php 
    require_once '../includes/header.php';
    require_once '../includes/menu.php';

    if ($_SESSION['clientData']['clientLevel'] < 2) {
        header('Location: /phpmotors/');
        exit;
    }

?>

<section class="main">
    <h1>Add Car Classification</h1>
    <?php 
        if(isset($message)){
            echo $message;
        }
    ?>

    <noscript>
    <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
    </noscript>

    <form action="/phpmotors/vehicles/index.php" method="post">
    
        <label for="carClassification">Classification Name</label>
        <input type="text" id="carClassification" name="carClassification" required <?php if(isset($carThumbnail)){echo "value='$carThumbnail'";} ?>/>

        <input type="submit" value="Add Classification" />

        <input type="hidden" name="action" value="add-classification" />
    </form>
</section>

<?php 
    require_once '../includes/footer.php';
?>