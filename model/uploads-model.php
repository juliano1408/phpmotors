<?php 

/** Uploads model */

function storeImages($imgPath, $invId, $imgName, $imgPrimary) {

    $db = createConnection();

    $sql = "INSERT INTO images (invId, imgPath, imgName, imgPrimary) 
            VALUES (:invId, :imgPath, :imgName, :imgPrimary)";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_INT);
    $stmt->execute();
        
    $imgPath = makeThumbnailName($imgPath);

    $imgName = makeThumbnailName($imgName);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_INT);
    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    
    return $rowsChanged;

}

function getImages() {

    $db = createConnection();

    $sql = "SELECT imgId, imgPath, imgName, imgDate, inventory.invId, invMake, invModel 
            FROM images 
            JOIN inventory 
            ON images.invId = inventory.invId";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $imageArray;
}

function deleteImage($imgId) {

    $db = createConnection();

    $sql = "DELETE FROM images 
            WHERE imgId = :imgId";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imgId', $imgId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();

    return $result;
}

function checkExistingImage($imgName){

    $db = createConnection();

    $sql = "SELECT imgName 
            FROM images 
            WHERE imgName = :name";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $imgName, PDO::PARAM_STR);
    $stmt->execute();
    $imageMatch = $stmt->fetch();
    $stmt->closeCursor();
    
    return $imageMatch;
}