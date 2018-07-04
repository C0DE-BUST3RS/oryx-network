<?php
// Require DB file for feed.
require 'includes/functions.inc.php';

If (CheckIfLoggedIn() == false) {
    header("Location: ../index.php");
}
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
    <link rel="stylesheet" href="css/font-awesome.min.css">
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

                <div class="column is-half">
                    <h3 class="title is-3">Change introduction</h3>
                    <form action="">
                        <div class="field">
                            <div class="control">
                                <textarea class="textarea is-large is-info" placeholder="Introduction" rows="1"></textarea>
                            </div>
                        </div>
                        <button type="submit" id="submit" name="submit" class="button is-info is-outlined is-rounded">Change introduction</button>
                    </form>
                </div>

                <div class="column is-half">
                    <h3 class="title is-3">Change Description</h3>
                    <form action="">
                        <div class="field">
                            <div class="control">
                                <textarea class="textarea is-large is-info" placeholder="Description" rows="1"></textarea>
                            </div>
                        </div>
                        <button type="submit" id="submit" name="submit" class="button is-info is-outlined is-rounded">Change description</button>
                    </form>
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