<?php
require 'includes/functions.inc.php';

if (CheckIfLoggedIn() == true) {
    header("Location: feed.php");
    exit();
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
    <title>Home - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    require 'includes/nav-nologin.php';
    ?>
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns is-vcentered">

                <div class="column is-one-third is-hidden-mobile">
                    <figure class="image">
                        <img src="img/logos/mockup2.png" alt="" style="width: 50%; margin: 0 auto;"/>
                    </figure>
                </div>

                <div class="column is-one-third">
                    <h1 class="title is-1">
                        Oryx Network
                    </h1>
                    <h2 class="subtitle is-4">
                        The best place to make new friends
                    </h2>
                    <a class="button is-danger is-outlined is-rounded" href="login.php">
                        <i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp;Login
                    </a>
                </div>

                <div class="column is-one-third">
                    <h4 class="title is-4">
                        Don't have an account?
                    </h4>
                    <h5 class="subtitle is-5">
                        Register Now!
                    </h5>

                    <?php
                    if (isset($_SESSION['status'])) { ?>
                        <div class="notification is-danger is-rounded">
                            <?php echo $_SESSION['status']; ?>
                        </div>
                        <?php
                        unset($_SESSION['status']);
                    } elseif (isset($_SESSION['success'])) { ?>
                        <div class="notification is-success is-rounded">
                            <?php echo $_SESSION['success']; ?>
                        </div>
                        <?php
                        unset($_SESSION['success']);
                    }
                    ?>

                    <form action="includes/signup.inc.php" method="POST" enctype="multipart/form-data">

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="registerFirstname"
                                       name="registerFirstname" type="text" placeholder="Firstname" required/>
                                <span class="icon is-small is-left">
									<i class="fa fa-address-card"></i>
    							</span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="registerLastname"
                                       name="registerLastname" type="text" placeholder="Lastname" required/>
                                <span class="icon is-small is-left">
									<i class="fa fa-address-card"></i>
    							</span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="registerEmail"
                                       name="registerEmail" type="email" placeholder="Email" required/>
                                <span class="icon is-small is-left">
									<i class="fa fa-envelope"></i>
    							</span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="registerPassword"
                                       name="registerPassword" type="password" placeholder="Password (min 8 characters)"
                                       required/>
                                <span class="icon is-small is-left">
									<i class="fa fa-lock"></i>
    							</span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" name="registerTOF" id="registerTOF" value="accepted"
                                           required/>
                                    I agree to the <a href="#">terms and conditions</a>
                                </label>
                            </div>
                        </div>

                        <button type="submit" id="submit" name="submit" class="button is-danger is-outlined is-rounded">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;Register
                        </button>

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
</body>

</html>