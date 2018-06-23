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
    $firstname = $conn->real_escape_string($_POST['']);
    $lastname = $conn->real_escape_string($_POST['']);
    $email = $conn->real_escape_string($_POST['']);
    $password = $conn->real_escape_string($_POST['']);

    if (CheckIfEmptySignup($firstname, $lastname, $email, $password) == true) {


        if (CheckIfRealName($firstname, $lastname) == true) {


            if (CheckIfRealEmail($email) == true) {


                if (CheckIfPasswordLongEnough($password) == true) {

                } else {

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