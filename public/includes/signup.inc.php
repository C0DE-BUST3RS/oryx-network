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

if (isset($_POST['submit'])) {

} else {
    header("Location ../index.php");
    exit();
}