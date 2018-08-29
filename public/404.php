<?php
require 'includes/functions.inc.php';
header('HTTP/1.1 404 Not Found');
header('Status: 404 Not Found');
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
    <title>Page not found - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    CheckIfLoggedIn() ? require 'includes/nav-login.php' : require 'includes/nav-nologin.php';
    ?>
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns is-vcentered">

                <div class="column is-one-third">
                </div>

                <div class="column is-one-third">
                    <h1 class="title is-1">404 error</h1>
                    <h1 class="subtitle is-4">The page you are looking for doesn't exist or another error occured.</h1>
                    <?php

                    if (CheckIfLoggedIn() == true) { ?>
                        <a class="button is-info is-outlined is-rounded" href="feed.php">Feed page</a>
                    <?php } else { ?>
                        <a class="button is-info is-outlined is-rounded" href="index.php">Home page</a>
                    <?php }
                    ?>
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