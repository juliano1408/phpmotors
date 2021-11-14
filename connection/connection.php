<?php 

function createConnection() {
    $servername = 'localhost';
    $database = 'phpmotors';
    $username = 'iClient';
    $password = 'DH]RO9kjar0eW*@q';
    $dsn = 'mysql:host=' . $servername . ';dbname=' . $database;

    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        return $connection;
    } catch(PDOException $e) {
        header('location: http://localhost/php-motors/500.php');
        exit;
    }
}

createConnection();

?>