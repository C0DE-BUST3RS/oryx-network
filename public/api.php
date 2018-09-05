<?php
//Require the functions and start the session
require 'includes/functions.inc.php';
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
    <title>API - Oryx Network</title>
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
                    <h1 class="title is-1">Oryx Network</h1>
                </div>

                <div class="column is-one-third">
                    <h1 class="title is-1">API</h1>
                </div>

                <div class="column is-one-third">
                    <h1 class="title is-1">Request key</h1>
                    <?php
                    if (!CheckIfLoggedIn()) { ?>
                        <div class='notification is-warning is-rounded'>
                            You are not logged-in <br> Login to request a API key
                        </div>
                    <?php } else { ?>
                        <form action="includes/keyrequest.inc.php" method="post">

                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input is-primary is-info is-rounded" name="requestEmail" type="email"
                                           placeholder="Email" value="<?php EmailFillIn(); ?>" required/>
                                    <span class="icon is-small is-left">
									    <i class="fas fa-address-card"></i>
    							    </span>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <textarea class="textarea is-info" placeholder="Why you need access to our api?"
                                              name="requestReason" rows="2" required></textarea>
                                </div>
                            </div>

                            <button type="submit" id="submit" name="submit"
                                    class="button is-info is-outlined is-rounded">
                                <i class="fas fa-envelope"></i>&nbsp;Request key
                            </button>

                        </form>
                    <?php } ?>

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