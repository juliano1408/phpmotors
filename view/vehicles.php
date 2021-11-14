<?php 

    require_once '../includes/header.php';
    require_once '../includes/menu.php';

    if ($_SESSION['clientData']['clientLevel'] < 2) {
        header('Location: /phpmotors/');
        exit;
    }

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
    }

?>

<section class="main">

    <h1>Vehicles</h1>
    <div class="vehicle-links">
        <a href="/phpmotors/vehicles?action=add-classification-page">Add Car Classification</a>
        <a href="/phpmotors/vehicles?action=add-vehicle-page">Add Vehicle</a>
    </div>
    
    <?php 
        if (isset($message)) { 
            echo $message; 
        } 
        
        if (isset($classificationList)) { 
            echo '<h2>Vehicles By Classification</h2>'; 
            echo '<p>Choose a classification to see those vehicles</p>'; 
            echo $classificationList; 
        }
    ?>
    <noscript>
    <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
    </noscript>

    <table id="inventoryRecords" cellspacing="0" cellpadding="0"></table>

</section>

<script src="../js/inventory.js"></script>

<?php 
    require_once '../includes/footer.php';
?>