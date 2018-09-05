<?php
//Require the functions and start the session
require 'functions.inc.php';

if (isset($_POST['submit']) && !empty($_POST['requestReason']) && !empty($_POST['requestEmail']) && isset($_SESSION['user']['id'])) {
    //Get the values
    $email = htmlspecialchars($conn->escape_string($_POST['requestEmail']));
    $reason = htmlspecialchars($conn->escape_string($_POST['requestReason']));

    //Get some value's for query
    $date = GetCurrentDate();
    $ip = GetUserIP();
    $userid = GetIDFromEmail($email);

    $accepted = false;

    //Check if the email is real
    if (CheckIfRealEmail($email)) {

        //Put all form fields into the DB
        $stmt = $conn->prepare("INSERT INTO `api-key-request` (date, ip, user_id, email, accepted) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $date, $ip, $userid, $email, $accepted);

        //Execute the query
        if ($stmt->execute()) {
            header("Location: ../api.php?request=send");
            exit();
        } else {
            header("Location: ../api.php?request=failed");
            exit();
        }

    } else {
        header("Location: ../api.php?request=failed");
        exit();
    }

} else {
    header("Location: ../api.php?request=failed1");
    exit();
}