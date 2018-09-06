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
            $_SESSION['success'] = "API Key requested! <br> We keep in contact!";
            header("Location: ../api.php?request=send");
            exit();
        } else {
            $_SESSION['failed'] = "Request failed! <br> Please try again";
            header("Location: ../api.php?request=failed");
            exit();
        }

    } else {
        $_SESSION['failed'] = "Request failed! <br> Please try again";
        header("Location: ../api.php?request=failed");
        exit();
    }

} else {
    $_SESSION['failed'] = "Request failed! <br> Please try again";
    header("Location: ../api.php?request=failed1");
    exit();
}