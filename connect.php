<?php

error_reporting(E_ERROR);

$servername = "localhost";
$username = "root";
$password = "";
$database = "cursus";

$conn = mysqli_connect($servername,$username,$password,$database);


if(!$conn)

{

$servername = "Localhost";
$username = "deb43619_tomfaust";
$password = "Spike123";
$database = "deb43619_tomfaust";

$conn = mysqli_connect($servername, $username, $password,$database);
}
?>