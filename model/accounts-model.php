<?php 
/** Accounts model */


/**
* Handle site registrations
*/

function regClient($firstName, $lastName, $email, $password) {

    $db = createConnection();

    $sql = "INSERT INTO clients (clientFirstName, clientLastName, clientEmail, clientPassword)
            VALUES (:clientFirstName, :clientLastName, :clientEmail, :clientPassword)";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(":clientFirstName", $firstName, PDO::PARAM_STR);
    $stmt->bindValue(":clientLastName", $lastName, PDO::PARAM_STR);
    $stmt->bindValue(":clientEmail", $email, PDO::PARAM_STR);
    $stmt->bindValue(":clientPassword", $password, PDO::PARAM_STR);

    $stmt->execute();

    $rowChanged = $stmt->rowCount();

    $stmt->closeCursor();

    return $rowChanged;

}

/** Check if email exists */
function checkExistingEmail($email) {

    $db = createConnection();

    $sql = "SELECT clientEmail  
            FROM clients 
            WHERE clientEmail  = :email";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $emailFound = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();

    if(empty($emailFound)) {
        return 0;
    } else {
        return 1;
    }
}

// Get client data based on an email address
function getClient($email) {

    $db = createConnection();

    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword 
            FROM clients 
            WHERE clientEmail = :clientEmail';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientEmail', $email, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $clientData;
}


function updateClient($clientFirstName, $clientLastName, $clientEmail) {
    
    $db = createConnection();

    $sql = "UPDATE clients 
            SET clientFirstName = :clientFirstName, clientLastName = :clientLastName, clientEmail = :clientEmail 
            WHERE clientEmail = :clientEmail";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bindValue(':clientFirstName', $clientFirstName, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastName', $clientLastName, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    
    $stmt->execute();
    
    $rowsChanged = $stmt->rowCount();
    
    $stmt->closeCursor();
    
    return $rowsChanged;
}

function updatePassword($hashedPassword, $clientEmail) {
    
    $db = createConnection();

    $sql = "UPDATE clients 
            SET clientPassword = :clientPassword 
            WHERE clientEmail = :clientEmail";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':clientPassword', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    
    $stmt->execute();
    
    $rowsChanged = $stmt->rowCount();
    
    $stmt->closeCursor();
    
    return $rowsChanged;
}