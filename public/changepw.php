<?php
//Require the functions and start the session
require 'includes/functions.inc.php';

//Check if the user is logged in
if (CheckIfLoggedIn()) {
    header("Location: feed.php");
    exit();
}

//If the token and email are filled in the url set the variables
if (isset($_GET['email']) && isset($_GET['token'])) {
    //Get all the data
    $getEmail = htmlspecialchars($_GET['email']);
    $getToken = htmlspecialchars($_GET['token']);
}

//If the user pressed the button change the password
if (isset($_POST['submit'])) {
    $resetToken = $_POST['resetToken'];
    $resetEmail = strtolower($_POST['resetEmail']);
    $resetNewPasswordUnhashed = $conn->real_escape_string($_POST['resetNewPassword']);

    if (!empty($resetToken) && !empty($resetEmail) && !empty($resetNewPasswordUnhashed)) {

        if (CheckBeforeReset($resetEmail, $resetToken)) {

            $newPassword = HashPassword($resetNewPasswordUnhashed);
            $query = $conn->query("UPDATE user SET password = '$newPassword' WHERE email = '$resetEmail';");
            $query = $conn->query("UPDATE resettoken SET used = 1 WHERE email = '$resetEmail' AND value = '$resetToken';");

            $_SESSION['reset'] = "The password has been changed!";
            header("Location: login.php?reset=successful");

        } else {
            header("Location: changepw.php");
            exit();
        }

    } else {
        header("Location: changepw.php");
        exit();
    }

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
    <title>Reset password - Oryx Network</title>
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

                    <form action="changepw.php" method="POST" enctype="multipart/form-data">

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="resetToken" name="resetToken"
                                       type="text" value="<?php PWResetTokenFillIn(); ?>" placeholder="Your token"/>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-key"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="resetEmail" name="resetEmail"
                                       type="email" value="<?php PWResetEmailFillIn(); ?>" placeholder="Your email"/>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
    							</span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="resetNewPassword"
                                       name="resetNewPassword" type="password" placeholder="Your new password"/>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-key"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" id="submit" name="submit" class="button is-info is-outlined is-rounded">
                            <i class="fas fa-sign-in-alt">&nbsp;Change password
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
