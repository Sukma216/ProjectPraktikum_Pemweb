<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "beasaku";

$db = new mysqli($host, $user, $password, $database);

if ($db->connect_errno) {
    die("Failed to connect to database: " . $db->connect_error);
}




