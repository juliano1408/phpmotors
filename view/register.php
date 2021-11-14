<?php 
    require_once '../includes/header.php';
    require_once '../includes/menu.php';
?>

<section class="main">
    <h1>Register</h1>
    <?php 
        if (isset($message)) {
            echo $message;
        }
    ?>
    <form action="/phpmotors/accounts/index.php" method="post" autocomplete="off">
        <label for="firstName">First Name</label>
        <input type="text" id="firstName" name="clientFirstName" placeholder="Type your first name here" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?>required>

        <label for="lastName">Last Name</label>
        <input type="text" id="lastName" name="clientLastName" placeholder="Type your last name here" <?php if(isset($clientLastName)){echo "value='$clientLastName'";} ?>required>

        <label for="email">Email</label>
        <input type="email" id="email" name="clientEmail" placeholder="Type your email here" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?>required>

        <label for="password">Password</label>
        <span class="reminder">There must be 8 characters, any of which may be numbers, any may be non-alphanumeric characters, they may be in any order and can include any number of capital and lower case letters.</span>
        <input type="password" id="password" name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Type your password here" required>

        <div>
            <a class="show-password" href="#">Show Password</a>
        </div>
        <button type="submit">Register</button>
        <input type="hidden" name="action" value="registration">
    </form>
</section>

<?php 
    require_once '../includes/footer.php';
?>