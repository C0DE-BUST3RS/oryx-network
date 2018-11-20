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

                <div class="column is-one-quarter">
                </div>

                <div class="column is-one-quarter">
                    <h4 class="title is-4">Change email:</h4>
                    <p>
                       Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad at delectus fugiat laborum minus, officiis quaerat quis repudiandae voluptatem. Consectetur deleniti eligendi enim et ipsa iusto, laboriosam nisi nulla quia?
                    </p>
                    <br>
                    <form action="includes/change-email.inc.php" method="POST">
                        <div class="field">
                            <div class="control">
                                <input name="currentEmail" type="hidden" value="<?php echo $_SESSION['user']['email']; ?>"/>
                            </div>
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info"
                                       name="newEmail" type="text" placeholder="New Email" required/>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-address-card"></i>
                                </span>
                            </div>
                            <br>
                            <button type="submit" id="submit" name="submit" class="button is-info is-outlined is-rounded">
                                <i class="fas fa-envelope"></i>&nbsp;Change email
                            </button>
                        </div>
                    </form>
                </div>

                <div class="column is-one-quarter">
                    <h4 class="title is-4">Change password:</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad at delectus fugiat laborum minus, officiis quaerat quis repudiandae voluptatem. Consectetur deleniti eligendi enim et ipsa iusto, laboriosam nisi nulla quia?
                    </p>
                    <br>
                    <form action="includes/change-password.inc.php" method="POST">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info"
                                       name="newPassword" type="password" placeholder="New Password" required/>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-address-card"></i>
                                </span>
                            </div>
                            <br>
                            <button type="submit" id="submit" name="submit" class="button is-info is-outlined is-rounded">
                                <i class="fas fa-envelope"></i>&nbsp;Change password
                            </button>
                        </div>
                    </form>
                </div>

                <div class="column is-one-quarter">

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