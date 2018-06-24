<?php
//Require the functions
require_once 'functions.inc.php';
//Require var $conn
require 'dbh.inc.php';

if (isset($_POST['submit'])) {
    // Define variable from POST

    $firstname = $conn->real_escape_string($_POST['registerFirstname']);
    $lastname = $conn->real_escape_string($_POST['registerLastname']);
    $email = $conn->real_escape_string($_POST['registerEmail']);
    $password = $conn->real_escape_string($_POST['registerPassword']);
    $termsofservice = $conn->real_escape_string($_POST['registerTOF']);

    if (CheckIfNotEmpty($firstname, $lastname, $email, $password) == true) {
        if (CheckIfRealName($firstname, $lastname) == true) {
            if (CheckIfRealEmail($email) == true) {
                if (CheckIfPasswordLongEnough($password) == true) {
                	if(CheckIfAcceptedTOF($termsofservice) == true) {
						// Everything is good, process to signup query.
						$query = mysqli_query($conn, "INSERT INTO `user` (`id`, `admin`, `date`, `firstname`, `lastname`, `email`, `password`, `last_login`) VALUES ('" . GenerateUID() . "', 0, '" . GetCurrentDate() . "', '".htmlspecialchars($firstname)."', '".htmlspecialchars($lastname)."', '".htmlspecialchars($email)."', '".HashPassword($password)."', '".GetCurrentDate()."')");
						header("Location: ../feed.php");
					} else {
						// ERROR go back and fix.
						header("Location: ../index.php?error");
					}
            	}
        	}
        }
    }
} else {
    header("Location: ../index.php");
}