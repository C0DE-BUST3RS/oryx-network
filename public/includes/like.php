<?php
//Require the functions and start the session
require 'functions.inc.php';

//Check if the user has been logged in
If (!CheckIfLoggedIn()) {
    header("Location: ../index.php");
}

if (isset($_GET['type'], $_GET['id'])){

    $type   = $_GET['type'];
    $id     = (int)$_GET['id'];
    $gebruikerID = $_SESSION['user']['id'];

    switch($type){
        case 'post':
            $conn->query("
                INSERT INTO `post_like` (`user_id`, `post`)
                  SELECT '$gebruikerID', '$id'
                  FROM `post`
                  WHERE EXISTS (
                    SELECT id
                    FROM post
                    WHERE id = '$id')
                  AND NOT  EXISTS (
                    SELECT id
                    FROM post_like
                    WHERE user_id = '$gebruikerID'
                    AND post = '$id')
                  LIMIT 1
            ");
            break;
    }
header('Location: ../feed.php');
}