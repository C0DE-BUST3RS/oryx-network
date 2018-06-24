<?php
/**
 * Created by IntelliJ IDEA.
 * User: Luuk Kenselaar <luuk.kenselaar@protonmail.com>
 * Date: 23-6-2018
 * Time: 00:45
 */

//Require the functions
require 'functions.inc.php';
//Require var $conn
require 'dbh.inc.php';

if (isset($_POST['registerSubmit'])) {
    // Define variable from POST
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $termsofservice = $conn->real_escape_string($_POST['tof']);

    if (CheckIfEmptySignup($firstname, $lastname, $email, $password) == true) {


        if (CheckIfRealName($firstname, $lastname) == true) {


            if (CheckIfRealEmail($email) == true) {


                if (CheckIfPasswordLongEnough($password) == true) {

                	if()
					// Everything is good, process to signup squery
                } else {
					// Give error, go back and try again.
                }

            } else {

            }

        } else {

        }

    } else {

    }

} else {
    header("Location ../index.php");
    exit();
}