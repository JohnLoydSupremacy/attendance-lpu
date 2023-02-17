<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "attendance_system";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
    die("Connection Failed");
}