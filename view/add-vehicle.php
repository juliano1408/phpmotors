<?php 
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
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
    }

    $classificationList .= "</select>";

?>

<section class="main">
    <h1>Add Vehicle</h1>
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
        <input type="text" id="vehicle-make" name="carMake" required <?php if(isset($carMake)){echo "value='$carMake'";} ?>/>

        <label for="vehicle-model">Model</label>
        <input type="text" id="vehicle-model" name="carModel" required <?php if(isset($carModel)){echo "value='$carModel'";} ?>/>
        
        <label for="vehicle-desc">Description</label>
        <textarea name="carDescription" id="vehicle-desc" cols="60" rows="5" required>
            <?php if(isset($carDescription)){echo $carDescription;} ?>
        </textarea>
        
        <label for="vehicle-image-path">Image Path</label>
        <input type="text" id="vehicle-image-path" name="carImage" required <?php if(isset($carImage)){echo "value='$carImage'";} ?>/>

        <label for="vehicle-thumb-path">Thumbnail Path</label>
        <input type="text" id="vehicle-thumb-path" name="carThumbnail" <?php if(isset($carThumbnail)){echo "value='$carThumbnail'";} ?>/>

        <label for="vehicle-price">Price</label>
        <input type="number" step="0.01" id="vehicle-price" name="carPrice" required <?php if(isset($carPrice)){echo "value='$carPrice'";} ?>/>

        <label for="vehicle-stock">Stock</label>
        <input type="number" id="vehicle-stock" name="carStock" required <?php if(isset($carStock)){echo "value='$carStock'";} ?>/>

        <label for="vehicle-color">Color</label>
        <input type="text" id="vehicle-color" name="carColor" required <?php if(isset($carColor)){echo "value='$carColor'";} ?>/>

        <button type="submit">Add</button>

        <input type="hidden" name="action" value="add-vehicle"/>
    </form>
</section>

<?php 
    require_once '../includes/footer.php';
?>