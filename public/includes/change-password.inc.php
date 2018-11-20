<?php
//Require the functions and start the session
require 'functions.inc.php';

//Check if the user pressed the submit button
if (isset($_POST['submit'])) {

    $newPassword = $conn->real_escape_string($_POST['newPassword']);

    $hashedPW = HashPassword($newPassword);

    if (PlaceNewPWInDB($hashedPW, $_SESSION['user']['email'])) {
        //If the password has been changed
        LogoutUser();
        header("Location: ../index.php?password=changed");
        exit();
    } else {
        //If the password has not been changed
        header("Location: ../settings.php?email=fail");
        exit();
    }

} else {
    //If the user didn't press the submit button
    header("Location: ../settings.php");
    exit();
}