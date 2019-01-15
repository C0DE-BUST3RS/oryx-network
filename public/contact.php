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
    <title>Contact - Oryx Network</title>
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

                    <h1 class="title is-1">Contact us</h1>
                    <p>For any questions please don't hasitate to contact us. (Abuse of the service will result in a IP-ban)</p>

                    <br>

                    <?php
                    if (isset($_SESSION['success'])) { ?>
                        <div class="notification is-success is-rounded">
                            <?php echo $_SESSION['success']?>
                        </div>
                        <?php
                        unset($_SESSION['success']);
                        $_SESSION['hide'] = '';
                    }

                    if (isset($_SESSION['failed'])) { ?>
                        <div class="notification is-danger is-rounded">
                            <?php echo $_SESSION['failed']?>
                        </div>
                        <?php
                        unset($_SESSION['failed']);
                        $_SESSION['hide'] = '';
                    }

                    if (!isset($_SESSION['hide'])) { ?>

                        <form action="includes/contact.inc.php" method="POST" enctype="multipart/form-data">

                            <?php

                            if (!CheckIfLoggedIn()) { ?>

                                <div class="field">
                                    <div class="control has-icons-left">
                                        <input class="input is-primary is-info is-rounded" id="contactFirstname"
                                               name="contactFirstname" type="text" placeholder="Firstname" required/>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-address-card"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control has-icons-left">
                                        <input class="input is-primary is-info is-rounded" id="contactLastname"
                                               name="contactLastname" type="text" placeholder="Lastname" required/>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-address-card"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control has-icons-left">
                                        <input class="input is-primary is-info is-rounded" id="contactEmail"
                                               name="contactEmail" type="email" placeholder="Email" required/>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-address-card"></i>
                                        </span>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <input name="contactFirstname" type="hidden" value="<?php FirstnameFillIn(); ?>"/>
                                <input name="contactLastname" type="hidden" value="<?php LastnameFillIn(); ?>"/>
                                <input name="contactEmail" type="hidden" value="<?php EmailFillIn(); ?>"/>
                            <?php } ?>

                            <div class="field">
                                <div class="control">
                                    <textarea class="textarea is-info" placeholder="Your message" name="contactMessage" rows="6" required></textarea>
                                </div>
                            </div>

                            <button type="submit" id="submit" name="submit" class="button is-info is-outlined is-rounded">
                                <i class="fas fa-envelope"></i>&nbsp;Send message
                            </button>

                        </form>
                    <?php } ?>

                </div>

                <div class="column is-one-third">
                </div>

            </div>
        </div>
    </div>


    <?php
    require 'includes/footer.php';
    unset($_SESSION['hide']);
    ?>
</section>

<script src="js/main.js"></script>
<script src="js/navbarMenu.js"></script>
</body>

</html>