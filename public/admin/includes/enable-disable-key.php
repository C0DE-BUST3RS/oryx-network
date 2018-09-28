<?php
//Require the functions
require '../../includes/functions.inc.php';
//Require var $conn
require '../../includes/dbh.inc.php';
//Require the send email functions
require '../../includes/sendemail.inc.php';

if (isset($_POST['submit'])) {
    //Get the values using POST
    $email = $conn->real_escape_string($_POST['email']);
    $status = $conn->real_escape_string($_POST['status']);

    if ($status == "disable") {

        $stmt = $conn->prepare("UPDATE `api-key` SET active = 0 WHERE email = ?;");
        $stmt->bind_param("s",$email);
        $stmt->execute();

        //Send the user back to the right page
        header("Location: ../api-keys.php?disabled");
        exit();

    } elseif ($status == "enable") {

        $stmt = $conn->prepare("UPDATE `api-key` SET active = 1 WHERE email = ?;");
        $stmt->bind_param("s",$email);
        $stmt->execute();

        //Send the user back to the right page
        header("Location: ../api-keys.php?enabled");
        exit();
    }

} else {
    //If the button was not pressed redirect
    header("Location ../api-keys.php");
    exit();
}