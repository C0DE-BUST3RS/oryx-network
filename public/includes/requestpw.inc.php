<?php
//Require the functions
require 'functions.inc.php';
//Require var $conn
require 'dbh.inc.php';
//Require send token function
require 'sendemail.inc.php';

// If the submit button has been clicked proceed.
if (isset($_POST['submit'])) {

    $emailPost = $conn->real_escape_string($_POST['resetEmail']);

    //Make the value lower case
    $emailPost = strtolower($emailPost);

    if (CheckIfEmailUsed($emailPost)) {

        //Prepare the query
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $emailPost);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        //Assign the userid to a var
        $userid = $row['id'];

        //Generate a activation token
        $token = GenerateToken();
        //Get the current date
        $date = GetCurrentDate();

        //Place the reset token in the table
        $stmt = $conn->prepare("INSERT INTO resettoken (id, date, user_id, email, used, value) VALUES ('',?,?,?,0,?)");
        $stmt->bind_param("ssss", $date,$userid,$emailPost,$token);
        $stmt->execute();

        //Send the token to the user
        SendEmail($emailPost,"",$token,true,false, false);

        //Set the session
        $_SESSION['tokensend'] = "Password reset has been send (if the email is used)";

        //Redirect to the requestpw page
		if($_POST['resetAdmin'] !== 'true') {
			header("Location: ../requestpw.php");
			exit();
		} else {
			header("Location: ../admin/users-overview.php");
			exit();
		}

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

