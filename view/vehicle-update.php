<?php 

    $titleElement = "";

    if(isset($invInfo['invMake']) && isset($invInfo['invModel'])) { 
        $titleElement = "<title>Modify $invInfo[invMake] $invInfo[invModel]</title>";
    } elseif(isset($invMake) && isset($invModel)) { 
        $titleElement = "<title>Modify $invMake $invModel</title>"; 
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
    <h1>Update Vehicle</h1>
    <?php 
        if(isset($message)){
            echo $message;
        }
    ?>
    <form action="/phpmotors/vehicles/index.php" method="post">

        <label for="vehicle-color">Car Classification</label>
        <?php 
            echo $classificationList;
        ?>
        <label for="vehicle-make">Make</label>
        <input type="text" id="vehicle-make" name="carMake" required <?php if(isset($carMake)){echo "value='$carMake'";} elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>/>

        <label for="vehicle-model">Model</label>
        <input type="text" id="vehicle-model" name="carModel" required <?php if(isset($carModel)){echo "value='$carModel'";} elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>/>
        
        <label for="vehicle-desc">Description</label>
        <textarea name="carDescription" id="vehicle-desc" cols="60" rows="5" required><?php if(isset($carDescription)){echo $carDescription;} elseif(isset($invInfo['invDescription'])) {echo "$invInfo[invDescription]";}?></textarea>
        
        <label for="vehicle-image-path">Image Path</label>
        <input type="text" id="vehicle-image-path" name="carImage" required <?php if(isset($carImage)){echo "value='$carImage'";} elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'";}?>/>

        <label for="vehicle-thumb-path">Thumbnail Path</label>
        <input type="text" id="vehicle-thumb-path" name="carThumbnail" <?php if(isset($carThumbnail)){echo "value='$carThumbnail'";} elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'";}?>/>

        <label for="vehicle-price">Price</label>
        <input type="number" step="0.01" id="vehicle-price" name="carPrice" required <?php if(isset($carPrice)){echo "value='$carPrice'";} elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'";}?>/>

        <label for="vehicle-stock">Stock</label>
        <input type="number" id="vehicle-stock" name="carStock" required <?php if(isset($carStock)){echo "value='$carStock'";} elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'";}?>/>

        <label for="vehicle-color">Color</label>
        <input type="text" id="vehicle-color" name="carColor" required <?php if(isset($carColor)){echo "value='$carColor'";} elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'";}?>/>

        <button type="submit">Update</button>

        <input type="hidden" name="action" value="update-vehicle"/>

        <input type="hidden" name="carId" value="<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} elseif(isset($invId)){ echo $invId; } ?>">
    </form>
</section>

<?php 
    require_once '../includes/footer.php';
?>