<?php 

    if (!isset($_SESSION['loggedin'])) {
        header('Location: /phpmotors');
    }

    if (isset($_SESSION['updateMessage'])) {
        $updateMessage = $_SESSION['updateMessage'];
    }

    $firstName = $_SESSION['clientData']['clientFirstname'];
    $lastName = $_SESSION['clientData']['clientLastname'];
    $fullName = $firstName . ' ' . $lastName;
    $email = $_SESSION['clientData']['clientEmail'];
    $level = $_SESSION['clientData']['clientLevel'];

    require_once '../includes/header.php';
    require_once '../includes/menu.php';
?>

<section class="main">
    <h1>Welcome <span class='name-user'><?php echo $fullName;?></span></h1>
    <h2> You are logged in.</h2>

    <?php 
        if (isset($updateMessage)) {
            echo "<p>" . $updateMessage ."</p>";
        }
    ?>

    <div class='data-user'>
        <ul>
            <li>First name: <?php echo $firstName;?></li>
            <li>Last name: <?php echo $lastName;?></li>
            <li>Email: <?php echo $email;?></li>
        </ul>
    <div>

    <div class='account-management'>
        <h3>Account Management</h3>
        <p>Use this link to update account information</p>
        <a href="/phpmotors/accounts?action=user-management">Update Account Information</a>
    </div>

    <?php 
        if($level == 3) {
    ?>
    <div class='inventory-access'>
        <h3>Inventory Management</h3>
        <p>Access the link below to manage the inventory</p>
        <a href="/phpmotors/vehicles/">Vehicle Management</a>
    </div>
    <?php 
        }

        if(isset($_SESSION['messageData']['review'])){
            $message = $_SESSION['messageData']['review'];
            echo "<p class='message-review'>$message</p>";
        } 

        if(isset($clientsReview)) {

            echo "<div class='clients-review'>";

            echo "<h3>Your reviews</h3>";

            foreach($clientsReview as $review) {

                echo "<div class='client-review'>";
                echo "<div class='inv'>$review[invMake] - $review[invModel]</div>";
                echo "<div class='text'>$review[reviewText]</div>";
                echo "<div class='date'>$review[reviewDate]</div>";
                echo "<div><a href='/phpmotors/reviews/?action=edit-review&reviewId=$review[reviewId]'>Edit</a><a href='/phpmotors/reviews/?action=delete-view&reviewId=$review[reviewId]'>Delete</a></div>";
                echo "</div>";

            }

            echo "</div>";

        }
    ?>


</section>

<?php 
    require_once '../includes/footer.php';
?>