<?php
//Require the functions and start the session
require 'includes/functions.inc.php';

//Check if the user is logged in
If (CheckIfLoggedIn() == false) {
    header("Location: ../index.php");
}

//Change intro
if (isset($_POST['changeintro'])) {
    if (ChangeIntro($_SESSION['user']['id'], $_POST['newIntro']) == true) {
        $_SESSION['success'] = "Your intro has been changed!";
    } else {
        $_SESSION['error'] = "Your intro has not been changed!";
    }
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

                <div class="column is-one-third">
                </div>


                <div class="column is-one-third">
                    <h3 class="subtitle is-4">Change introduction</h3>
                    <?php
                    if (isset($_SESSION['success'])) { ?>
                        <div class="notification is-success is-rounded">
                            <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div> <?php
                    }

                    if (isset($_SESSION['error'])) { ?>
                        <div class="notification is-danger is-rounded">
                            <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div> <?php
                    }
                    ?>
                    <form action="settings.php" method="post">
                        <div class="field">
                            <div class="control">
                                <textarea class="textarea is-info" placeholder="Introduction" name="newIntro"><?php echo $_SESSION['user']['introduction']; ?></textarea>
                            </div>
                        </div>
                        <button type="submit" id="submit" name="changeintro" class="button is-info is-outlined is-rounded">Change introduction
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
</body>

</html>