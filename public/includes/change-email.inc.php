<?php
//Require the functions and start the session
require 'functions.inc.php';

//Check if the user pressed the submit button
if (isset($_POST['submit'])) {

    $newEmail = $conn->real_escape_string($_POST['newEmail']);
    $currentEmail = $conn->real_escape_string($_POST['currentEmail']);

    if (ChangeEmail($newEmail, $currentEmail)) {
        //If the email has been changed
        LogoutUser();
        header("Location: ../index.php?email=changed");
        exit();
    } else {
        //If the email has not been changed
        header("Location: ../settings.php?email=failed");
        exit();
    }

} else {
    //If the user didn't press the submit button
    header("Location: ../settings.php");
    exit();
}