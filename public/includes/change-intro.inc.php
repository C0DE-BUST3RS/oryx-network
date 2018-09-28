<?php
//Require the functions and start the session
require 'functions.inc.php';

//Check if the user pressed the submit button
if (isset($_POST['submit'])) {

    if (ChangeIntro($_SESSION['user']['id'], $_POST['intro'])) {
        //If the intro has been changed
        header("Location: ../profile.php?intro=changed");
        exit();
    } else {
        //If the intro has not been changed
        header("Location: ../profile.php?intro=failed");
        exit();
    }

} else {
    //If the user didn't press the submit button
    header("Location: ../profile.php");
    exit();
}