<?php
/**
 * Created by IntelliJ IDEA.
 * User: Luuk Kenselaar <luuk.kenselaar@protonmail.com>
 * Date: 23-6-2018
 * Time: 00:48
 */

require 'functions.inc.php';


If (CheckIfLoggedIn() == true) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
} else {
    header("Location: ../index.php");
}