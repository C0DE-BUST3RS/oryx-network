<?php
// Require DB file for feed.
require 'includes/functions.inc.php';

If (CheckIfLoggedIn() == false) {
    header("Location: ../index.php");
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
    <title>Profile - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    require 'includes/nav-login.php';
    ?>
    <div class="hero-body">
        <div class="container has-text-centered">
            <nav class="level">
                <div class="level-item has-text-centered is-hidden-mobile">
                    <div>
                        <p class="heading">Posts</p>
                        <p class="title">3,456</p>
                    </div>
                </div>
                <h1 class="title is-1"><?php echo ucwords($_SESSION['user']['firstname']). " " . ucwords($_SESSION['user']['lastname']);?></h1>
                <div class="level-item has-text-centered">
                    <div>
                        <p class="heading">Friends</p>
                        <p class="title">456K</p>
                    </div>
                </div>
                <div class="level-item has-text-centered is-hidden-desktop">
                    <div>
                        <p class="heading">Posts</p>
                        <p class="title">3,456</p>
                    </div>
                </div>
            </nav>

            <div class="tile is-ancestor">
                <div class="tile is-vertical is-8">
                    <div class="tile">
                        <div class="tile is-parent">
                            <article class="tile is-child notification is-info">
                                <p class="title"><?php echo ucwords($_SESSION['user']['firstname']). " " . ucwords($_SESSION['user']['lastname']);?></p>
                                <figure class="image">
                                    <img src="img/profilepictures/default.jpg" style="border-radius: 5%">
                                </figure>
                                <br>
                                <a href="settings.php" class="button is-info is-outlined is-inverted">My Settings</a>
                            </article>
                        </div>
                        <div class="tile is-parent is-vertical">
                            <article class="tile is-child notification is-primary">
                                <p class="title">Introduction</p>
                                <p class="subtitle">Introduction goes here</p>
                            </article>
                            <article class="tile is-child notification is-warning">
                                <p class="title">Friends</p>
                                <p class="subtitle">Friends go here</p>
                            </article>
                        </div>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child notification is-danger">
                            <p class="title">Description</p>
                            <div class="content is-hidden-mobile">
                                <?php
                                if ($_SESSION['user']['admin'] == 1) { ?>
                                    <div class="field is-grouped is-grouped-centered">
                                        <div class="control">
                                            <div class="tags has-addons">
                                                <span class="tag is-dark">Oryx Network</span>
                                                <span class="tag is-success">Admin</span>
                                            </div>
                                        </div>
                                        <div class="control">
                                            <div class="tags has-addons">
                                                <span class="tag is-dark">Oryx Network</span>
                                                <span class="tag is-primary">Developer</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="tile is-parent">
                    <article class="tile is-child notification is-success">
                        <div class="content">
                            <p class="title">Posts</p>
                            <p class="subtitle">Posts go here</p>
                            <div class="content">
                                <!-- Content -->
                            </div>
                        </div>
                    </article>
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