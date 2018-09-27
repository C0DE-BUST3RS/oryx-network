<?php
//Require the functions
require '../includes/functions.inc.php';
//Require var $conn
require '../includes/dbh.inc.php';
//Require the send email functions
require '../includes/sendemail.inc.php';

if (isset($_POST['submit'])) {
    //Get the values using POST
    $requestEmail = $conn->real_escape_string($_POST['requestEmail']);
    $requestID = $conn->real_escape_string($_POST['requestID']);
    $status = $conn->real_escape_string($_POST['requestAccepted']);
    $userID = $conn->real_escape_string($_POST['userID']);

    if ($status == "declined") {
        $dbAccepted = "0";
        $dbDeclined = "1";
        $dbVisible = "0";

        //Update the rows in the DB
        SetStatusKeyRequest($dbAccepted, $dbDeclined, $dbVisible, $requestID);

        //Send the user an email that his request has been declined
        SendEmail($requestEmail, "", false, false, false, false, false, true);

        //Send the user back to the right page
        header("Location: api-key-requests.php?declined");
        exit();

    } elseif ($status == "accepted") {
        $dbAccepted = 1;
        $dbDeclined = 0;
        $dbVisible = 0;

        $key = GenerateAPIKey();
        $date = GetCurrentDate();

        //Update the rows in the DB
        SetStatusKeyRequest($dbAccepted, $dbDeclined, $dbVisible, $requestID);
        PlaceNewAPIKeyDB($date, $userID, $requestEmail, $key);

        //Send the user an email that his request has been accepted
        SendEmail($requestEmail, "", false, false, false, false, true);

        //Send the user back to the right page
        header("Location: api-key-requests.php?accepted");
        exit();
    }

} else {
    //If the button was not pressed redirect
    header("Location api-key-requests.php");
    exit();
}