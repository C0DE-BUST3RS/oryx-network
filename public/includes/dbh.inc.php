<?php
/**
 * Created by IntelliJ IDEA.
 * User: Luuk Kenselaar <luuk.kenselaar@protonmail.com>
 * Date: 23-6-2018
 * Time: 00:24
 */

require 'credentials.inc.php';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn) {
    echo 'Connected!';
} else {
    echo 'Not connected!';
}
