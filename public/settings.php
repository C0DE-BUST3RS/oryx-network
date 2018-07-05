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
        $_SESSION['IntroChanged'] = "Your intro has been changed!";
    } else {
        $_SESSION['IntroNotChanged'] = "Your intro has not been changed!";
    }
}

//Change profile picture
if (isset($_POST['changepicture'])) {

    if (!empty($_FILES['attachment']['name'])) {
        $userID = $_SESSION['user']['id'];

        //Get the path of the users current picture
        $path = GetPathProfilePicture($userID);

        //This statement will check if the users profile picture isn't the default
        if ($path != "img/default/default.jpg") {
            //If its not the default picture delete the file
            unlink($path);
        }

        $path = $_FILES['attachment']['name'];
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $filename = time() . "." . $extension;
        $destination = "img/profilepictures/" . $filename;

        //Upload the file picture to the destination folder
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $destination)) {
            $sql = "UPDATE profiles SET profiles.profile_picture = '$destination' WHERE profiles.user_id = '$userID';";
            $query = $conn->query($sql);

            if ($query) {
                $_SESSION['ImageChanged'] = "Your image has been changed!";
            } else {
                $_SESSION['ImageNotChanged'] = "Your image has not been changed!";
            }
        }
    }
}

//Change profile picture
if (isset($_POST['deletepicture'])) {
    $userID = $_SESSION['user']['id'];

    //Get the path of the users current picture
    $path = GetPathProfilePicture($userID);

    //This statement will check if the users profile picture isn't the default
    if ($path != "img/default/default.jpg") {
        //If its not the default picture delete the file
        unlink($path);
    }

    $sql = "UPDATE profiles SET profiles.profile_picture = 'img/default/default.jpg' WHERE profiles.user_id = '$userID';";
    $query = $conn->query($sql);

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
                    if (isset($_SESSION['IntroChanged'])) { ?>
                        <div class="notification is-success is-rounded">
                            <?php
                            echo $_SESSION['IntroChanged'];
                            unset($_SESSION['IntroChanged']);
                            ?>
                        </div> <?php
                    }

                    if (isset($_SESSION['IntroNotChanged'])) { ?>
                        <div class="notification is-danger is-rounded">
                            <?php
                            echo $_SESSION['IntroNotChanged'];
                            unset($_SESSION['IntroNotChanged']);
                            ?>
                        </div> <?php
                    }
                    ?>
                    <form action="settings.php" method="post">
                        <div class="field">
                            <div class="control">
                                <textarea class="textarea is-info" placeholder="Introduction"
                                          name="newIntro"><?php echo $_SESSION['user']['introduction']; ?></textarea>
                            </div>
                        </div>
                        <button type="submit" id="submit" name="changeintro"
                                class="button is-info is-outlined is-rounded">Change introduction
                        </button>
                    </form>

                    <br>

                    <?php
                    if (isset($_SESSION['ImageChanged'])) { ?>
                        <div class="notification is-success is-rounded">
                            <?php
                            echo $_SESSION['ImageChanged'];
                            unset($_SESSION['ImageChanged']);
                            ?>
                        </div> <?php
                    }

                    if (isset($_SESSION['ImageNotChanged'])) { ?>
                        <div class="notification is-danger is-rounded">
                            <?php
                            echo $_SESSION['ImageNotChanged'];
                            unset($_SESSION['ImageNotChanged']);
                            ?>
                        </div> <?php
                    }
                    ?>
                    <h3 class="subtitle is-4">Change picture</h3>
                    <form action="settings.php" method="post" enctype="multipart/form-data">
                        <div class="field">
                            <div class="control">
                                <div class="file is-centered">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="attachment" id="attachment"
                                               value="attachment">
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fa fa-upload"></i>
                                            </span>
                                            <span class="file-label">
                                                Choose a file…
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="submit" name="changepicture"
                                class="button is-info is-outlined is-rounded">Change picture
                        </button>
                        <button type="submit" id="submit" name="deletepicture"
                                class="button is-info is-outlined is-rounded">Delete current picture
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