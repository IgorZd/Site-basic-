<?php

$server = 'site';
$username = 'root';
$password = '';
$dbname = 'site';

$conn = new mysqli($server, $username, $password, $dbname);

if($conn->connect_error){
    die('Connection fail:'. $conn->connect_error);
}

?>