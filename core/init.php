<?php 

include 'database/connection.php';

include 'classes/user.php';
include 'classes/tweet.php';

global $pdo;

session_start();

error_reporting(0);


$getFromUser = new User($pdo);
$getFromTweet = new Tweet($pdo);


define("BASE_URL", "http://localhost/twitter/");
?>