<?php
//Require the functions
require '../includes/functions.inc.php';
//Require var $conn
require '../includes/dbh.inc.php';

if (isset($_POST['submit'])) {
    //Get the values using POST
    $requestEmail = $conn->real_escape_string($_POST['requestEmail']);
    $requestID = $conn->real_escape_string($_POST['requestID']);
    $requestAccepted = $conn->real_escape_string($_POST['requestAccepted']);

    if ($requestAccepted == "false") {
        $dbAccepted = "0";
        $dbDeclined = "1";
        $dbVisible = "0";

        $stmt = $conn->prepare("UPDATE `api-key-request` SET `api-key-request`.accepted = ?, `api-key-request`.declined = ?, `api-key-request`.visible = ? WHERE email = ?;");
        $stmt->bind_param("ssss", $dbAccepted, $dbDeclined, $dbVisible, $requestEmail);
        $stmt->execute();
        header("Location: api-key-requests.php");
        exit();

    } elseif ($requestAccepted == "true") {
        $dbAccepted = 1;
        $dbDeclined = 0;
        $dbVisible = 0;

        $stmt = $conn->prepare("UPDATE `api-key-request` SET `api-key-request`.accepted = ?, `api-key-request`.declined = ?, `api-key-request`.visible = ? WHERE email = ?;");
        $stmt->bind_param("ssss", $dbAccepted, $dbDeclined, $dbVisible, $requestEmail);
        $stmt->execute();
        header("Location: api-key-requests.php");
        exit();
    }

} else {
    //If the button was not pressed redirect
    header("Location api-key-requests.php");
    exit();
}