<?php 
/** Vehicles model */

function regCarClassification($carClassification) {

    $db = createConnection();

    $sql = "INSERT INTO carclassification (classificationName)
            VALUES (:carClassification)";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(":carClassification", $carClassification, PDO::PARAM_STR);

    $stmt->execute();

    $rowChanged = $stmt->rowCount();

    $stmt->closeCursor();

    return $rowChanged;

}

function addVehicle($vehicleMake, $vehicleModel, $vehicleDescription, $vehicleImage, $vehicleThumbnail, $vehiclePrice, $vehicleStock, $vehicleColor, $classificationId) {

    $db = createConnection();

    $sql = "INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId) 
            VALUES (:vehicleMake, :vehicleModel, :vehicleDescription, :vehicleImage, :vehicleThumbnail, :vehiclePrice, :vehicleStock, :vehicleColor, :classificationId)";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':vehicleMake', $vehicleMake, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleModel', $vehicleModel, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleDescription', $vehicleDescription, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleImage', $vehicleImage, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleThumbnail', $vehicleThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':vehiclePrice', $vehiclePrice, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleStock', $vehicleStock, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleColor', $vehicleColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    
    $stmt->closeCursor();

    return $rowsChanged;
}

function updateVehicle($vehicleId, $vehicleMake, $vehicleModel, $vehicleDescription, $vehicleImage, $vehicleThumbnail, $vehiclePrice, $vehicleStock, $vehicleColor, $classificationId) {

    $db = createConnection();

    $sql = "UPDATE inventory 
            SET invMake = :vehicleMake, invModel = :vehicleModel, invDescription = :vehicleDescription, invImage = :vehicleImage, invThumbnail = :vehicleThumbnail, invPrice = :vehiclePrice, invStock = :vehicleStock, invColor = :vehicleColor, classificationId = :classificationId
            WHERE invId = :vehicleId";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':vehicleId', $vehicleId, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleMake', $vehicleMake, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleModel', $vehicleModel, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleDescription', $vehicleDescription, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleImage', $vehicleImage, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleThumbnail', $vehicleThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':vehiclePrice', $vehiclePrice, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleStock', $vehicleStock, PDO::PARAM_STR);
    $stmt->bindValue(':vehicleColor', $vehicleColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    
    $stmt->closeCursor();

    return $rowsChanged;
}

function deleteVehicle($vehicleId) {

    $db = createConnection();

    $sql = "DELETE FROM inventory
            WHERE invId = :vehicleId";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':vehicleId', $vehicleId, PDO::PARAM_STR);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    
    $stmt->closeCursor();

    return $rowsChanged;
}

function getInventoryByClassification($classificationId) { 

    $db = createConnection(); 

    $sql = "SELECT * 
            FROM inventory 
            WHERE classificationId = :classificationId";

    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    $stmt->execute(); 

    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 

    return $inventory; 
}

function getInvItemInfo($invId) {

    $db = createConnection();

    $sql = "SELECT * 
            FROM images ima
            JOIN inventory inv
            ON ima.invId = inv.invId
            WHERE ima.invId = :invId
            AND ima.imgPrimary = 1
            GROUP BY ima.invId";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();

    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $invInfo;
}

function getThumbnailsInv($invId) {

    $db = createConnection();

    $sql = "SELECT * 
            FROM images ima
            JOIN inventory inv
            ON ima.invId = inv.invId
            WHERE ima.invId = :invId
            AND ima.imgPrimary = 0
            AND MOD(ima.imgId, 2) <> 0";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();

    $thumbnails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $thumbnails;
}

function getVehiclesByClassification($classificationName){

    $db = createConnection();

    $sql = "SELECT * 
            FROM images ima
            JOIN inventory inv 
            ON ima.invId = inv.invId
            WHERE inv.classificationId IN (
                SELECT classificationId 
                FROM carclassification 
                WHERE classificationName = :classificationName
            ) GROUP BY ima.invId";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();

    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $vehicles;

}

function getVehicles(){

	$db = createConnection();

	$sql = "SELECT invId, invMake, invModel 
            FROM inventory";

	$stmt = $db->prepare($sql);
	$stmt->execute();

	$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();

	return $invInfo;
}
