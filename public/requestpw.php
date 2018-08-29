<?php
//Require the functions and start the session
require 'includes/functions.inc.php';

//Check if the user is logged in
If (CheckIfLoggedIn()) {
    header("Location: feed.php");
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <title>Request password - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    require 'includes/nav-nologin.php';
    ?>
    <div class="hero-body">

        <div class="container has-text-centered">

            <div class="columns is-vcentered">

                <div class="column is-one-third">

                </div>

                <div class="column is-one-third">
                    <img src="img/logos/oryx-trans.png" alt="" width="80%">

                    <h2 class="title is-2">Reset password</h2>

                    <?php
                    if (isset($_SESSION['tokensend'])) { ?>
                    <div class="notification is-success is-rounded">
                        <?php echo $_SESSION['tokensend']; ?>
                    </div>
                    <?php
                        unset($_SESSION['tokensend']);
                    }
                    ?>

                    <form action="includes/requestpw.inc.php" method="POST" enctype="multipart/form-data">

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="resetEmail" name="resetEmail" type="email" placeholder="Email"/>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" id="submit" name="submit" class="button is-info is-outlined is-rounded">
                            <i class="fas fa-sign-in-alt"></i>&nbsp;Reset password
                        </button>

                    </form>
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
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>

</html>