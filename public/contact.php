<?php
//Require the functions and start the session
require 'includes/functions.inc.php';

//Check if the user is logged in
if (CheckIfLoggedIn() == true) {
    $firstname = $_SESSION['user']['firstname'];
    $lastname = $_SESSION['user']['lastname'];
    $email = $_SESSION['user']['email'];
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
    <title>Contact - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    if (CheckIfLoggedIn() == true) {
        require 'includes/nav-login.php';
    } else {
        require 'includes/nav-nologin.php';
    }
    ?>
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns is-vcentered">

                <div class="column is-one-third">
                </div>

                <div class="column is-one-third">

                    <h1 class="title is-1">Contact us</h1>

                    <form action="includes/contact.inc.php" method="POST" enctype="multipart/form-data">

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="contactFirstname"
                                       name="contactFirstname" type="text" placeholder="Firstname" value="<?php if (isset($firstname)) {echo $firstname;}?>" required/>
                                <span class="icon is-small is-left">
									<i class="fa fa-address-card"></i>
    							</span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="contactLastname"
                                       name="contactLastname" type="text" placeholder="Lastname" value="<?php if (isset($firstname)) {echo $lastname;}?>" required/>
                                <span class="icon is-small is-left">
									<i class="fa fa-address-card"></i>
    							</span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input is-primary is-info is-rounded" id="contactEmail"
                                       name="contactEmail" type="email" placeholder="Email" value="<?php if (isset($firstname)) {echo $email;}?>" required/>
                                <span class="icon is-small is-left">
									<i class="fa fa-envelope"></i>
    							</span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <textarea class="textarea is-info" placeholder="Your message" name="contactMessage" rows="6"></textarea>
                            </div>
                        </div>

                        <button type="submit" id="submit" name="submit" class="button is-info is-outlined is-rounded">
                            <i class="fa fa-envelope"></i> &nbsp;Send email
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