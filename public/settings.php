<?php
//Require the functions and start the session
require 'includes/functions.inc.php';

//Check if the user is logged in
If (!CheckIfLoggedIn()) {
    header("Location: ../index.php");
}

//Load the latest profile data
LoadProfileData($_SESSION['user']['id']);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Oryx Network">
    <meta name="keywords" content="Oryx Network, Oryx, Network">
    <meta name="author" content="C0DE-BUST3RS">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/bulma.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <title>My settings - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    require 'includes/nav-login.php';
    ?>
    <div class="hero-body">
        <div class="container has-text-centered">

            <h1 class="title is-1">Settings</h1>

            <div class="columns is-vcentered">

                <div class="column is-one-third">
                </div>

                <div class="column is-one-third">
                </div>

                <div class="column is-one-third">
                </div>

            </div>
        </div>
    </div>


    <?php
    require 'includes/footer.php';
    ?>
</section>

<script src="js/main.js"></script>
<script src="js/navbarMenu.js"></script>
</body>

</html>