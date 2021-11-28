<?php 

    if (isset($classificationName)){
        $titleElement = "<title>Classification:" . $classificationName . "</title>";
    }

    require_once '../includes/header.php';
    require_once '../includes/menu.php';
?>

<section class="main">
    <h1>Classification Page</h1>

    <?php 
    if (isset($message)) {
        echo $message; 
    }

    if (isset($vehiclesDisplay)) {
        echo $vehiclesDisplay;
    } 
?>
</section>

<?php 
    require_once '../includes/footer.php';
?>