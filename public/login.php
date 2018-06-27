<?php
//Require the functions also start the session automaticly.
require_once 'includes/functions.inc.php';

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
    <title>Login - Oryx Network</title>
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

                    <h2 class="title is-2">Login</h2>

                    <?php
                    if (isset($_SESSION['loginfailed'])) { ?>
                        <div class="notification is-danger is-rounded">
                            Login failed, check your credentials!
                        </div>
                        <?php
                        unset($_SESSION['loginfailed']);
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['success'])) { ?>
                        <div class="notification is-success is-rounded">
                            <?php echo $_SESSION['success']; ?>
                        </div>
                        <?php
                        unset($_SESSION['success']);
                    }
                    ?>
					<?php
					if (isset($_SESSION['activated'])) { ?>
						<div class="notification is-success is-rounded">
							<?php echo $_SESSION['activated']; ?>
						</div>
						<?php
						unset($_SESSION['activated']);
					}
					?>

                    <form action="includes/login.inc.php" method="POST" enctype="multipart/form-data">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="loginEmail"
                                       name="loginEmail" type="email" placeholder="Email"/>
                                <span class="icon is-small is-left">
									<i class="fa fa-envelope"></i>
    							</span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="loginPassword"
                                       name="loginPassword" type="password" placeholder="Password"/>
                                <span class="icon is-small is-left">
									<i class="fa fa-lock"></i>
    							</span>
                            </div>
                        </div>

                        <button type="submit" id="submit" name="submit" class="button is-danger is-outlined is-rounded"><i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp;Login</button>
                        <a class="button is-danger is-outlined is-rounded" href="#"><i class="fa fa-question-circle" aria-hidden="true"></i> &nbsp;Forgot password?</a>

                        <br>
                        <br>


                        <a class="button is-danger is-outlined is-rounded" href="index.php"><i class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;Signup</a>

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

