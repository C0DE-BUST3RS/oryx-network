<?php
/**
 * Created by IntelliJ IDEA.
 * User: Luuk Kenselaar <luuk.kenselaar@protonmail.com>
 * Date: 23-6-2018
 * Time: 00:45
 */
//Require var $conn
require 'dbh.inc.php';

//This function will check if the email is used
//This function will will be used at the signup and login
function CheckIfEmailUsed()
{

}

//This function will check if the user input at the Signup is not empty
function CheckIfEmptySignup()
{

}

//This function will check if the user input at the Login is not empty
function CheckIfEmptyLogin()
{

}

//This function will check if the users name is real
function CheckIfRealName()
{

}

//This function will check if the users email is real
function CheckIfRealEmail()
{

}

//This function will check if the users password has the minimum length
function CheckPasswordLength()
{

}

//This function will generate a random userid, example: F98F13DE-BABA5AFD-5AFDB4F9
function GenerateUID()
{
    $s = strtoupper(md5(uniqid(rand(), true)));
    $id =
        substr($s, 0, 8) . '-' .
        substr($s, 8, 8) . '-' .
        substr($s, 12, 8);
    return $id;
}

//This function will hash the user his password
function HashPassword()
{

}

//This function will hash the user his password
function LogoutUser()
{

}