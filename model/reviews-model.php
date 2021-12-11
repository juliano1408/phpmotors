<?php 

/** Reviews model */

function insertReview($clientId, $invId, $reviewText) {

    $db = createConnection();

    $sql = "INSERT INTO reviews (reviewText, invId, clientId)
            VALUES (:reviewText, :invId, :clientId)";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    return $rowsChanged;

}

function updateReview($reviewId, $reviewText) {

    $db = createConnection();

    $sql = "UPDATE reviews 
            SET reviewText = :reviewText
            WHERE reviewId = :reviewId";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    return $rowsChanged;
}

function deleteReview($reviewId) {

    $db = createConnection();

    $sql = "DELETE FROM reviews 
            WHERE reviewId = :reviewId";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    return $rowsChanged;

}

function getReviewById($reviewId) {

    $db = createConnection();

    $sql = "SELECT * FROM reviews 
            WHERE reviewId = :reviewId";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();

    $review = $stmt->fetch(PDO::FETCH_ASSOC); 
    $stmt->closeCursor();

    return $review;
}

function getReviewsByInvId($invId) {

    $db = createConnection();

    $sql = "SELECT reviews.reviewText, reviews.reviewDate, 
                CONCAT(SUBSTRING(clients.clientFirstname, 1, 1), clients.clientLastname) AS screenName 
            FROM reviews  
            JOIN clients ON reviews.clientId = clients.clientId
            WHERE invId = :invId
            ORDER BY reviews.reviewDate DESC";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();

    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $reviews;

}

function getReviewsByClient($clientId) {

    $db = createConnection();

    $sql = "SELECT r.reviewId, r.reviewText, r.reviewDate, r.invId, c.clientFirstName, c.clientLastName, i.invMake, i.invModel
            FROM reviews r
            JOIN clients c
            ON r.clientId = c.clientId
            JOIN inventory i
            ON r.invId = i.invId
            WHERE r.clientId = :clientId";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();

    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $reviews;
}

