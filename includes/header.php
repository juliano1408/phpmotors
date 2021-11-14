<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if(!empty($titleElement)) {
        echo $titleElement;
    } else {
        echo "<title>Home | PHP Motors</title>";
    }
    ?>
    <link rel="stylesheet" href="http://localhost/phpmotors/css/style.css">
</head>
<body>
<div class="container">
    <header class="header">
        <a href="http://localhost/phpmotors/">
            <figure>
                <img src="http://localhost/phpmotors/images/logo.png" alt="PHP Motors">
            </figure>
        </a>
        <?php 
            if(isset($_SESSION['loggedin'])) {
                $firstName = $_SESSION['clientData']['clientFirstname'];

        ?>
            <div>
                <span class="welcome-message"><b><?php echo $firstName; ?></b></span>
                <a href="http://localhost/phpmotors/accounts/?action=logout">Logout</a>
            </div>
        <?php 
            } else { 
        ?>
            <a href="http://localhost/phpmotors/accounts/?action=login">My Account</a>
        <?php 
            } 
        ?>
    </header>