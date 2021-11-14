<?php 
    require_once '../includes/header.php';
    require_once '../includes/menu.php';
?>

<section class="main">
    <h1>Sign in</h1>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
    ?>
    <form action="/phpmotors/accounts/" method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="clientEmail" placeholder="Type your email here" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required>

        <label for="password">Password</label>
        <input type="password" id="password" name="clientPassword" placeholder="Type your password here" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
        
        <input type="hidden" name="action" value="loginUser">

        <button type="submit">Sign-in</button>
    </form>
    <a class="not-a-member" href="?action=register">Not a member yet?</a>
</section>

<?php 
    require_once '../includes/footer.php';
?>