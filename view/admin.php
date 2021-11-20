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
    ?>
</section>

<?php 
    require_once '../includes/footer.php';
?>