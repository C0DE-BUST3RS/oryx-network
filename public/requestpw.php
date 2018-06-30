<?php
require 'includes/functions.inc.php';

If (CheckIfLoggedIn() == true) {
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
    <link rel="stylesheet" href="css/font-awesome.min.css">
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

                    <form action="includes/requestpw.inc.php" method="POST" enctype="multipart/form-data">

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="resetEmail" name="resetEmail" type="email" placeholder="Email"/>
                                <span class="icon is-small is-left">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" id="submit" name="submit" class="button is-danger is-outlined is-rounded">
                            <i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp;Reset password
                        </button>

                        <a class="button is-danger is-outlined is-rounded" href="login.php.php"><i class="fa fa-envelope"></i>&nbsp;Login</a>

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