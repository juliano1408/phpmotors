<?php 
    require_once '../includes/header.php';
    require_once '../includes/menu.php';

    if (!isset($_SESSION['loggedin'])) {
        header('Location: /phpmotors');
    }
?>

<section class="main">
    <h1>Management Account</h1>
    <?php 
        if(isset($_SESSION['message'])) {
            echo "<p>" . $_SESSION['message'] ."</p>";
        }
    ?>

    <form method="post">

        <label for="firstName-input">First Name:</label>
        <input type="text" name="clientFirstName" placeholder="First Name" required value="<?php if (isset($_SESSION['clientData']['clientFirstname'])) {  echo $_SESSION['clientData']['clientFirstname']; }  ?>" />

        <label for="lastName-input">Last Name:</label>
        <input type="text" name="clientLastName" placeholder="lastName" required value="<?php if (isset($_SESSION['clientData']['clientLastname'])) { echo $_SESSION['clientData']['clientLastname'];}  ?>" />

        <label for="email-input">Email Address:</label>
        <input type="email" name="clientEmail" placeholder="email address" required value="<?php if (isset($_SESSION['clientData']['clientEmail'])) { echo $_SESSION['clientData']['clientEmail'];} ?>" />

        <button type="submit">Update Client</button>
        <input type="hidden" name="action" value="update-client">

    </form>


    <form method="post">
        <label for="password-input">Password:</label>
        <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span>
        <input type="password" id="password-input" name="clientPassword" placeholder="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required />

        <button type="submit">Update Password</button>
        <input type="hidden" name="action" value="update-password">
    </form>

</section>

<?php 
    require_once '../includes/footer.php';
?>