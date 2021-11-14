<?php 

    $titleElement = "";

    if(isset($invInfo['invMake']) && isset($invInfo['invModel'])) { 
        $titleElement = "<title>Delete $invInfo[invMake] $invInfo[invModel]</title>";
    } elseif(isset($invMake) && isset($invModel)) { 
        $titleElement = "<title>Delete $invMake $invModel</title>"; 
    }

    require_once '../includes/header.php';
    require_once '../includes/menu.php';
    require_once '../model/main-model.php';

    if ($_SESSION['clientData']['clientLevel'] < 2) {
        header('Location: /phpmotors/');
        exit;
    }

    $classifications = getClassifications();

    $classificationList = "<select name='classificationId' id='vehicle-classification'>";

    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'";

        if(isset($classificationId)){
            if($classification['classificationId'] === $classificationId){
                $classificationList .= ' selected ';
            } elseif(isset($invInfo['classificationId'])){
                if($classification['classificationId'] === $invInfo['classificationId']){
                    $classificationList .= ' selected ';
                }
            }
        }

        $classificationList .= ">$classification[classificationName]</option>";
    }

    $classificationList .= "</select>";

?>

<section class="main">
    <h1>Delete Vehicle</h1>
    <?php 
        if(isset($message)){
            echo $message;
        }
    ?>
    <form action="/phpmotors/vehicles/index.php" method="post">

        <label for="vehicle-make">Make</label>
        <input type="text" readonly id="vehicle-make" name="carMake" required  value="<?php if(isset($invInfo['invMake'])){echo $invInfo['invMake'];} ?>"/>

        <label for="vehicle-model">Model</label>
        <input type="text" readonly id="vehicle-model" name="carModel" required  value="<?php if(isset($invInfo['invModel'])){echo $invInfo['invModel'];} ?>"/>
        
        <label for="vehicle-desc">Description</label>
        <textarea name="carDescription" readonly id="vehicle-desc" cols="60" rows="5" required><?php if(isset($invInfo['invDescription'])){echo $invInfo['invDescription'];}?></textarea>

        <button type="submit">Delete</button>

        <input type="hidden" name="action" value="delete-vehicle"/>

        <input type="hidden" name="carId" value="<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} elseif(isset($invId)){ echo $invId; } ?>">
    </form>
</section>

<?php 
    require_once '../includes/footer.php';
?>