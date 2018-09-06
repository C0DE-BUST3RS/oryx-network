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
function HashPassword($nothashedPWD)
{
    $hashedPWD = password_hash($nothashedPWD, PASSWORD_DEFAULT);
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

        $dateUser = new DateTime(substr($row['date'],0,10));
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

//@TODO This function will get the current Level (Percentage) of the user.
function GetUserLevelPercentage($userid)
{
    if (isset($userid) && !empty($userid)) {
        // need to be done.
    }
}

// This function will add +1 level to the user.
function LevelUserAdd($userid)
{
    global $conn;

    if (isset($userid) && !empty($userid)) {

        //Prepare the query
        $stmt = $conn->prepare("SELECT current_level FROM level WHERE user_id = ?");
        $stmt->bind_param("s", $userid);

        if ($stmt->execute()) {

            //Get the results
            $result = $stmt->get_result();

            //Fetch the data
            $row = $result->fetch_assoc();

            $levelOld = $row['current_level'];

            $levelNew = $levelOld + 1;

            //Prepare the query
            $stmt = $conn->prepare("UPDATE level SET current_level = ? WHERE user_id = ?");
            $stmt->bind_param("ss", $levelNew, $userid);

            if ($stmt->execute()) {

                if (LevelXPAdd($userid, 0) === TRUE) {

                    if (LevelXPRankUp($userid) === TRUE) {

                        if (AmountToLevelUp($userid, 100) === TRUE) {
                            return true;
                        } else {
                            return false;
                        }

                    } else {
                        return false;
                    }

                } else {
                    return false;
                }

            }

        }

    }
}

// This function will -1 level to the user.
function LevelUserMinus($userid)
{
    if (isset($userid) && !empty($userid)) {

        global $conn;

        //Prepare the query
        $stmt = $conn->prepare("UPDATE level SET current_level = -1 WHERE user_id = ?");
        $stmt->bind_param("s", $userid);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

// This function will add the specified amount of XP to the user.
function LevelXPAdd($userid, $xp = 0)
{
    global $conn;

    if (isset($userid) && !empty($userid)) {

        //Prepare the query
        $stmt = $conn->prepare("SELECT current_xp FROM level WHERE user_id = ?");
        $stmt->bind_param("s", $userid);

        if ($stmt->execute()) {

            //Get the results
            $result = $stmt->get_result();

            //Fetch the data
            $row = $result->fetch_assoc();

            $currentXP = $row['current_xp'];

            //Calculate new XP
            $newXP = $currentXP + $xp;

            //Prepare the query
            $stmt = $conn->prepare("UPDATE level SET current_xp = ? WHERE user_id = ?");
            $stmt->bind_param("is", $currentXP, $userid);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }

    } else {
        return false;
    }
}

// This function will rankup the amount of XP to 0 ALWAYS;
function LevelXPRankUp($userid)
{
    global $conn;

    if (isset($userid) && !empty($userid)) {

        //Prepare the query
        $stmt = $conn->prepare("UPDATE level SET current_xp = 0 WHERE user_id = ?");
        $stmt->bind_param("s", $userid);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

// This function will reduce the specified amount of XP to the user.
function LevelXPMinus($userid, $xp = 0)
{
    global $conn;

    if (isset($userid) && !empty($userid)) {

        //Prepare the query
        $stmt = $conn->prepare("UPDATE level SET current_xp = ? WHERE user_id = ?");
        $stmt->bind_param("ss", $xp, $userid);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

// This function will check the amount to rankup level of the user.
function AmountToLevelUp($userid, $amountToLevelUp = 0)
{
    global $conn;

    if (isset($userid) && !empty($userid)) {

        //Prepare the query
        $stmt = $conn->prepare("UPDATE level SET amount_to_level_up = ? WHERE user_id = ?");
        $stmt->bind_param("ss", $amountToLevelUp, $userid);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

// This function will check of the user has passed the amount to level up limit if so it will add +1 to level.
function CheckAmountToLevelUp($userid)
{
    global $conn;

    if (isset($userid) && !empty($userid)) {

        //Prepare the query
        $stmt = $conn->prepare("SELECT * FROM level WHERE user_id = ? AND current_xp >= amount_to_level_up");
        $stmt->bind_param("s", $userid);

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

    } else {
        return false;
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

//This function will load the number of posts
function LoadNumPosts($userid)
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