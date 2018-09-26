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
    $userID = $conn->real_escape_string($_POST['userID']);

    if ($requestAccepted == "false") {
        $dbAccepted = "0";
        $dbDeclined = "1";
        $dbVisible = "0";

        $result = SetStatusKeyRequest($dbAccepted, $dbDeclined, $dbVisible, $requestID);

        header("Location: api-key-requests.php");
        exit();

    } elseif ($requestAccepted == "true") {
        $dbAccepted = 1;
        $dbDeclined = 0;
        $dbVisible = 0;

        $key = GenerateAPIKey();
        $date = GetCurrentDate();

        //Update the rows in the DB
        $result = SetStatusKeyRequest($dbAccepted, $dbDeclined, $dbVisible, $requestID);
        $result = PlaceNewAPIKeyDB($date, $userID, $requestEmail, $key);

        header("Location: api-key-requests.php?added");
        exit();
    }

} else {
    //If the button was not pressed redirect
    header("Location api-key-requests.php");
    exit();
}