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
    <title><?php echo $_SESSION['user']['firstname'] . "'s Feed"; ?> - Oryx Network</title>
</head>
<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    require 'includes/nav-login.php';
    ?>
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns is-vcentered">

                <div class="column is-one-third">

                </div>

                <div class="column is-one-third">
                    <?php
                    foreach ($_SESSION['user'] as $key => $item) {
                        echo "<b>" . $key . ":</b> " . $item . "<br>";
                    }
                    ?>
                    <a href="includes/logout.inc.php" class="button is-danger is-rounded">Logout</a>
                </div>

                <div class="column is-one-third">

                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>