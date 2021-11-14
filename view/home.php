<?php
    require_once 'includes/header.php';
    require_once 'includes/menu.php';
?>

<main>
    <section class="main">
        <h1>Welcome to PHP Motors!</h1>
        <div class="info-car">
            <h3>DMC Delorean</h3>
            <p>3 Cup holders</p>
            <p>Superman doors</p>
            <p>Fuzzy dice!</p>
        </div>
        <figure>
            <img class="img-own" src="images/own_today.png" alt="Own Today!">
        </figure>
        <figure>
            <img class="img-car" src="images/delorean.jpg" alt="delorean">
        </figure>
    </section>
</main>

<section class="secondary">

    <div class="upgrades">

        <h3>DMC Delorean Upgrades</h3>

        <div class="upgrade">
            <div class="img-upgrade">
                <img src="images/flux-cap.png" alt="Flux Capacitor">
            </div>
            <a href="#">Flux Capacitor</a>
        </div>

        <div class="upgrade">
            <div class="img-upgrade">
                <figure>
                    <img src="images/flame.jpg" alt="Flame Decals">
                </figure>
            </div>
            <a href="#">Flame Decals</a>
        </div>

        <div class="upgrade">
            <div class="img-upgrade">
                <figure>
                    <img src="images/bumper_sticker.jpg" alt="Bumper Stickers">
                </figure>
            </div>
            <a href="#">Bumper Stickers</a>
        </div>

        <div class="upgrade">
            <div class="img-upgrade">
                <figure>
                    <img src="images/hub-cap.jpg" alt="Hub Caps">
                </figure>
            </div>
            <a href="#">Hub Caps</a>
        </div>

    </div>

    <div class="reviews">
        <h3>DMC Delorean Reviews</h3>
        <ul>
            <li>"So fast its almost like traveling in time" (4/5)</li>
            <li>"Coolest ride on the road" (4/5)</li>
            <li>"I'm feeling Marty McFly" (5/5)</li>
            <li>"The most futuristic ride of our day" (5/5)</li>
            <li>"So fast its almost like traveling in time" (4/5)</li>
        </ul>
    </div>

</section>

<?php 
    require_once 'includes/footer.php';
?>