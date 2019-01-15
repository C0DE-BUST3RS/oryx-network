<?php

session_start();
require 'dbh.inc.php';
require 'credentials.inc.php';

//This function will check if the email is used
//This function can be used at the signup and login
function CheckIfEmailUsed($email)
{
    global $conn;

    //Prepare the query
    $stmt = $conn->prepare("SELECT email FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);

    //Execute the query
    if ($stmt->execute()) {

        //Store the results
        $stmt->store_result();

        //Get rows
        $rows = $stmt->num_rows;

        if ($rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}

//This function will check if the user input at the Signup is not empty
function CheckIfEmptySignup($firstname, $lastname, $email, $password)
{
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
        return false;
    } else {
        return true;
    }
}

//This function will check if the user input at the Login is not empty
function CheckIfEmptyLogin($email, $password)
{
    if (empty($email) || empty($password)) {
        return true;
    } else {
        return false;
    }
}

//This function will check if the users name is real
function CheckIfRealName($firstname, $lastname)
{
    if (preg_match('/^[A-Za-z \'-]+$/i', $firstname) || preg_match('/^[A-Za-z \'-]+$/i', $lastname)) {
        return true;
    } else {
        return false;
    }
}

//This function will check if the users email is real
function CheckIfRealEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

//This function will check if the users password has the minimum length
function CheckIfPasswordLongEnough($password)
{
    if (strlen($password) >= 4) {
        return true;
    } else {
        return false;
    }
}

//This function wil check if the user is an admin or not.
function CheckIfAdmin($email)
{
    global $conn;

    //Prepare the query
    $stmt = $conn->prepare("SELECT admin FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {

        //Get the results
        $result = $stmt->get_result();

        //Fetch the data
        $row = $result->fetch_assoc();

        $rank = $row['admin'];

        if ($rank == 1) {
            return true;
        } else {
            return false;
        }
    }
}

//This function will generate a random user id, example: F98F13DE-BABA5AFD-5AFDB4F9
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
function HashPassword($nothashedPW)
{
    $hashedPWD = password_hash($nothashedPW, PASSWORD_DEFAULT);
    return $hashedPWD;
}

//This function will un-hash the user password.
function UnHashPassword($UserTypedPassword, $hashedPassword)
{
    if (password_verify($UserTypedPassword, $hashedPassword)) {
        return true;
    } else {
        return false;
    }
}

//Updates the users current password with a new one
function PlaceNewPWInDB($hashedPW, $email)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedPW, $email);

    if ($stmt->execute()) {
        return true;

    } else {
        return false;
    }

}

//This function wil check if the user is already logged in
function CheckIfLoggedIn()
{
    if (isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id'])) {
        return true;
    } else {
        return false;
    }
}

function GetIDFromEmail($email)
{
    global $conn;

    $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $userid = $row['id'];

        return $userid;

    } else {
        return false;
    }
}

//This function will return true if the account is older than 30 days, if not return false
function CheckIfOlderThan30Days($userid)
{
    global $conn;
    date_default_timezone_set('Europe/Amsterdam');

    $stmt = $conn->prepare("SELECT date FROM user WHERE id = ?");
    $stmt->bind_param("s", $userid);

    if ($stmt->execute()) {

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $dateUser = new DateTime(substr($row['date'], 0, 10));
        $dateNow = new DateTime(date('Y-m-d'));

        $interval = $dateNow->diff($dateUser);

        $difference = $interval->format('%a');

        //Check if the amount of days in difference is bigger than 30
        if ($difference >= 30) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

//If a user his account is not older than 30 days, this function will return the days left till the account is old enough
function DaysLeftTillEligibleAPIKey($userid)
{
    global $conn;
    date_default_timezone_set('Europe/Amsterdam');

    $stmt = $conn->prepare("SELECT date FROM user WHERE id = ?");
    $stmt->bind_param("s", $userid);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $dateUserDB = substr($row['date'], 0, 10);

        $dateWhenEligible = new DateTime(date('Y-m-d', strtotime($dateUserDB . '+1 month')));
        $dateNow = new DateTime(date('Y-m-d'));

        $interval = $dateNow->diff($dateWhenEligible);
        $difference = $interval->format('%a');

        return $difference;
    } else {
        return false;
    }
}

//This function will generate the current date and put it inside a variable.
function GetCurrentDate()
{
    date_default_timezone_set('Europe/Amsterdam');
    $date = date('Y-m-d H:i:s');
    return $date;
}

//This function will greet the user on the feed page
function Greetings($firstname)
{
    $firstname = ucwords(strtolower($firstname));

    date_default_timezone_set('Europe/Amsterdam');

    if (date("H") < 12) {
        return "Good morning " . $firstname;
    } elseif (date("H") > 11 && date("H") < 18) {
        return "Good afternoon " . $firstname;
    } elseif (date("H") > 17) {
        return "Good evening " . $firstname;
    }
}

//This function will get the users ip.
function GetUserIP()
{
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = '0.0.0.0';
    }
    return $ip;
}

//This function will generate a reset or activation token that will be send to the user
function GenerateToken()
{
    $string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $string = str_shuffle($string);
    $token = substr($string, 40);
    $tokenfinal = str_shuffle($token);
    return $tokenfinal;
}

//This function will check if the activation token and email are the same as in the db table
function CheckBeforeActivation($email, $token)
{
    global $conn;

    //Prepare the query
    $stmt = $conn->prepare("SELECT * FROM activationtoken WHERE activationtoken.email = ? AND activationtoken.value = ?");
    $stmt->bind_param("ss", $email, $token);

    //Execute the query
    if ($stmt->execute()) {

        //Store the results
        $stmt->store_result();

        //Get rows
        $rows = $stmt->num_rows;

        if ($rows > 0) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

//This function will check if the reset token and email are the same as in the db table
function CheckBeforeReset($email, $token)
{
    global $conn;

    //Prepare the query
    $stmt = $conn->prepare("SELECT * FROM resettoken WHERE resettoken.email = ? AND resettoken.value = ? AND resettoken.used = 0");
    $stmt->bind_param("ss", $email, $token);

    //Execute the query
    if ($stmt->execute()) {

        //Store the results
        $stmt->store_result();

        //Get rows
        $rows = $stmt->num_rows;

        if ($rows > 0) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

//This function will activate the account.
function ActivateAccount($email)
{
    global $conn;

    //Prepare the query
    $stmt = $conn->prepare("UPDATE activationtoken SET used = 1 WHERE email = ?");
    $stmt->bind_param("s", $email);

    //Execute the query
    if ($stmt->execute()) {

        //Prepare the query
        $stmt = $conn->prepare("UPDATE user SET activated = 1 WHERE email = ?");
        $stmt->bind_param("s", $email);

        //Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

//This function checks if the account has been activated
//The function returns true if the account is activated
function CheckIfActivated($email)
{
    global $conn;

    //Prepare the query
    $stmt = $conn->prepare("SELECT * FROM user WHERE user.email = ? AND user.activated = 1");
    $stmt->bind_param("s", $email);

    //Execute the query
    if ($stmt->execute()) {

        //Store the results
        $stmt->store_result();

        //Get rows
        $rows = $stmt->num_rows;

        if ($rows > 0) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

//This function will logout the user
function LogoutUser()
{
    session_start();
    session_unset();
    session_destroy();
}

//This function will echo the copyright year in the footer
function CopyrightYear()
{
    if (date('Y') == 2018) {
        echo "2018";
    } elseif (date('Y') != 2018) {
        echo "2018 - " . date('Y');
    }
}

//This function will convert datetime / timestamp to : 0 time ago
function time_elapsed_string($datetime, $full = false)
{
    date_default_timezone_set('Europe/Amsterdam');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


//This function will setup the sessions for auto-filling.
function RefillAtErrorSignup($firstname, $lastname, $email)
{
    $_SESSION['user']['firstname'] = $firstname;
    $_SESSION['user']['lastname'] = $lastname;
    $_SESSION['user']['email'] = $email;
}

//This function will automatically fill in the firstname when there is an error in the signup form.
function FirstnameFillIn()
{
    if (isset($_SESSION['user']['firstname'])) {
        echo ucwords($_SESSION['user']['firstname']);
    }
}

//This function will automatically fill in the lastname when there is an error in the signup form.
function LastnameFillIn()
{
    if (isset($_SESSION['user']['lastname'])) {
        echo ucwords($_SESSION['user']['lastname']);
    }
}

//This function will automatically fill in the email when there is an error in the signup form.
function EmailFillIn()
{
    if (isset($_SESSION['user']['email'])) {
        echo $_SESSION['user']['email'];
    }
}

//This function is used at the PW request page.
//If the user provided a token and a email, the form will be filled in
function PWResetTokenFillIn()
{
    if (isset($_GET['token'])) {
        echo $_GET['token'];
    }
}

//This function is used at the PW request page.
//If the user provided a token and a email, the form will be filled in
function PWResetEmailFillIn()
{
    if (isset($_GET['email'])) {
        echo $_GET['email'];
    }
}

//This function will retrieve the latest profile data, after that it puts the data into a session
function LoadProfileData($userid)
{
    global $conn;

    //Prepare the query
    $stmt = $conn->prepare("SELECT profiles.intro, profiles.profile_picture FROM profiles WHERE user_id = ?");
    $stmt->bind_param("s", $userid);

    if ($stmt->execute()) {

        //Store the results
        $result = $stmt->get_result();

        //Fetch the data
        $row = $result->fetch_assoc();

        $_SESSION['user']['introduction'] = $row['intro'];
        $_SESSION['user']['picture'] = $row['profile_picture'];
    } else {
        return false;
    }
}

//This function will load the number of posts for a specific user
function LoadNumPostsUser($userid)
{
    global $conn;

    //Prepare the query
    $stmt = $conn->prepare("SELECT post.content FROM post WHERE user_id = ?");
    $stmt->bind_param("s", $userid);

    if ($stmt->execute()) {

        //Store the results
        $stmt->store_result();

        //Get rows
        $rows = $stmt->num_rows;

        if ($rows > 0) {
            return $rows;
        }

        return 0;

    } else {
        return 0;

    }

}

//This function will change the intro
function ChangeIntro($userid, $newintro)
{
    global $conn;
    $newintro = htmlspecialchars($conn->real_escape_string($newintro));

    //Prepare the query
    $stmt = $conn->prepare("UPDATE profiles SET intro = ? WHERE user_id = ?");
    $stmt->bind_param("ss", $newintro, $userid);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

}

//This function will change the user his email
function ChangeEmail($newemail, $currentemail)
{
    global $conn;

    //Prepare the query
    $stmt = $conn->prepare("UPDATE user SET email = ? WHERE email = ?");
    $stmt->bind_param("ss", $newemail, $currentemail);

    //Execute the query
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

}

//This function will return the path to the users profile picture
function GetPathProfilePicture($userid)
{
    global $conn;

    //Prepare the query
    $stmt = $conn->prepare("SELECT profile_picture FROM profiles WHERE user_id = ?");
    $stmt->bind_param("s", $userid);

    //Execute the query
    if ($stmt->execute()) {

        //Get the results
        $result = $stmt->get_result();

        //Fetch the data
        $row = $result->fetch_assoc();

        $path = $row['profile_picture'];

        return $path;

    } else {
        return false;
    }
}

// This function will return the amount of followers the user current has.
function totalUserFollowers($userid)
{
    global $conn;

    $stmt = $conn->prepare("SELECT user.id,follower.user_id,follower.follower_id FROM follower,user WHERE user.id = follower.user_id AND follower.user_id = ?");
    $stmt->bind_param('s', $userid);
    $stmt->execute();

    $stmt->store_result();
    $count = $stmt->num_rows;

    return $count;

}

//Returns the total number of users
function NumTotalUsers()
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM user");
    $stmt->execute();

    $stmt->store_result();
    $count = $stmt->num_rows;

    return $count;
}

//Returns the total number of posts
function NumTotalPosts()
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM post");
    $stmt->execute();

    $stmt->store_result();
    $count = $stmt->num_rows;

    return $count;
}

//Returns the total number of contact messages
function NumTotalContactMessages()
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM `contact-messages`");
    $stmt->execute();

    $stmt->store_result();
    $count = $stmt->num_rows;

    return $count;
}

//@TODO Finish the function
function NumTotalAPICalls()
{
}

//Returns the number of new API key requests
function NumNewAPIKeyRequests()
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM `api-key-request` WHERE visible = 1 ");
    $stmt->execute();

    $stmt->store_result();
    $count = $stmt->num_rows;

    return $count;
}

//Set the status of the API key request
function SetStatusKeyRequest($dbAccepted, $dbDeclined, $dbVisible, $requestID)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE `api-key-request` SET `api-key-request`.accepted = ?, `api-key-request`.declined = ?, `api-key-request`.visible = ? WHERE id = ?;");
    $stmt->bind_param("ssss", $dbAccepted, $dbDeclined, $dbVisible, $requestID);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

//Generate an API key
function GenerateAPIKey()
{
    $characters = '0123456789abcdefghijklMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 40; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//Place the new API key in the table
function PlaceNewAPIKeyDB($date, $lastip, $userid, $email, $value)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO `api-key` (date, last_ip, user_id, email, used, value) VALUES (?,?,?,?,0,?)");
    $stmt->bind_param("sssss", $date, $lastip, $userid, $email, $value);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

//Check if user has an API key.
function checkUserAPIKey($userid)
{
    global $conn;

    $stmt = $conn->prepare("SELECT user_id FROM `api-key` WHERE user_id = ? AND active = 1;");
    $stmt->bind_param("s", $userid);

    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;

    if ($count < 1) {
        return false;
    } else {
        return true;
    }
}

// Get the API key of the user.
function getUserAPIKey($userid)
{
    global $conn;

    if (checkUserAPIKey($userid) == true) {

        $stmt = $conn->prepare("SELECT value FROM `api-key` WHERE user_id = ?;");
        $stmt->bind_param("s", $userid);

        //Execute the query
        if ($stmt->execute()) {

            //Get the results
            $result = $stmt->get_result();

            //Fetch the data
            $row = $result->fetch_assoc();

            $value = $row['value'];

            return $value;

        } else {
            return false;
        }

    } else {
        return false;
    }
}
