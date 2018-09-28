<?php
//Require the functions and start the session
require 'functions.inc.php';

if (isset($_POST['submit']) && !empty($_POST['requestReason']) && !empty($_POST['requestEmail']) && !empty($_POST['requestValue']) && isset($_SESSION['user']['id'])) {
    //Get the values
    $email = htmlspecialchars($conn->escape_string($_POST['requestEmail']));
    $reason = htmlspecialchars($conn->escape_string($_POST['requestReason']));
    $callsPerDay = htmlspecialchars($conn->escape_string($_POST['requestValue']));

    //Get some value's for query
    $date = GetCurrentDate();
    $ip = GetUserIP();
    $userid = GetIDFromEmail($email);

    $accepted = false;
    $declined = false;

    //Check if the email is real
    if (CheckIfRealEmail($email)) {

        //Put all form fields into the DB
        $stmt = $conn->prepare("INSERT INTO `api-key-request` (date, ip, user_id, email, reason, calls, accepted, declined) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss", $date, $ip, $userid, $email, $reason, $callsPerDay, $accepted, $declined);

        //Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = "API Key requested! <br> We keep in touch!";
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