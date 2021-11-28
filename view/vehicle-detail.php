<?php 

    if (isset($vehicle['invMake']) && isset($vehicle['invModel'])){
        $vehicleName = $vehicle['invMake'] . " " .$vehicle['invModel'];
        $titleElement = "<title>" . $vehicleName . "</title>";
    }

    require_once '../includes/header.php';
    require_once '../includes/menu.php';
?>

<section class="main">
    <h1>Vehicle Details</h1>

    <?php 
        if(!empty($vehicleDetailsDisplay)) {
            echo $vehicleDetailsDisplay;
        }
    ?>

</section>

<?php 
    require_once '../includes/footer.php';
?>