<?php

/* To Connect to MySQL database */

$dsn = 'mysql:host=localhost; dbname=twitter';
$user ='root';
$password ='';

try{

	$pdo = new PDO($dsn, $user, $password);
} catch(PDOException $e){
	echo 'Connection Error! ' . $e-> getMessage();
}
?>