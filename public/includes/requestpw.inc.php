<?php
/**
 * Created by IntelliJ IDEA.
 * User: Luuk Kenselaar <luuk.kenselaar@protonmail.com>
 * Date: 30-6-2018
 * Time: 19:40
 */
//Require the functions
require 'functions.inc.php';
//Require var $conn
require 'dbh.inc.php';
//Require send token function
require 'sendtoken.inc.php';

if (CheckIfLoggedIn() == true) {
    header("Location: feed.php");
    exit();
}

if (isset($_POST['submit'])) {

    $emailPost = $conn->real_escape_string($_POST['resetEmail']);

    //Make the value lower case
    $emailPost = strtolower($emailPost);

    if (CheckIfEmailUsed($emailPost) == true) {

        //Get the user id from the DB that belongs to the email
        $result = $conn->query("SELECT * FROM user WHERE email = '$emailPost';");
        $row = $result->fetch_array();
        $id = $row['id'];

        //Generate a activation token
        $token = GenerateToken();
        //Get the current date
        $date = GetCurrentDate();

        $tokenquery = $conn->query("INSERT INTO resettoken (id, date, user_id, email, used, value) VALUES ('','$date','$id','$emailPost',0,'$token');");

        SendToken($emailPost,"",$token,true,false);

        // Set session message.
        $_SESSION['tokensend'] = "Password reset has been send (if the email is used)";

        // Redirect to login page.
        header("Location: ../requestpw.php");
        exit();

    } else {
        //If the email does not exist redirect
        $_SESSION['loginfailed'] = "";
        header("Location: ../requestpw.php");
        exit();
    }

} else {
    //If the login button was not pressed redirect
    header("Location ../index.php");
    exit();
}

