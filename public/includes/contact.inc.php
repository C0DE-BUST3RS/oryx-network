<?php
//Require the functions and start the session
require 'functions.inc.php';

if (isset($_POST['submit']) && !empty($_POST['contactMessage'])) {
    //Get the values
    $firstname = htmlspecialchars($conn->escape_string($_POST['contactFirstname']));
    $lastname = htmlspecialchars($conn->escape_string($_POST['contactLastname']));
    $email = htmlspecialchars($conn->escape_string($_POST['contactEmail']));
    $content = htmlspecialchars($conn->escape_string($_POST['contactMessage']));

    //Get some value's for query
    $date = GetCurrentDate();
    $ip = GetUserIP();

    //Check if the email is real
    if (CheckIfRealEmail($email)) {

        //Check if the user is logged in
        if (CheckIfLoggedIn()) {
            $loggedin = true;
        } else {
            $loggedin = false;
        }

        //Put all form fields into the DB
        $stmt = $conn->prepare("INSERT INTO `contact-messages` (contact_date, `logged-in`, firstname, lastname, email, ip, content) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssss", $date, $loggedin, $firstname, $lastname, $email, $ip, $content);

        //Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = "Message successfully send!";
            header("Location: ../contact.php?contact=send");
            exit();
        } else {
            $_SESSION['failed'] = "Message not send!";
            header("Location: ../contact.php?contact=failed");
            exit();
        }

    } else {
        $_SESSION['failed'] = "Check your email address!";
        header("Location: ../contact.php?contact=failed");
        exit();
    }

} else {
    header("Location: ../contact.php");
    exit();
}