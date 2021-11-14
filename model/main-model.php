<?php 

/** Main PHP Motors Model  */
function getClassifications() {

    $db = createConnection();

    $sql = 'SELECT classificationId, classificationName 
            FROM carclassification 
            ORDER BY classificationName ASC'; 

    $stmt = $db->prepare($sql);
    $stmt->execute(); 
    $classifications = $stmt->fetchAll(); 

    $stmt->closeCursor(); 

    return $classifications;
    
}