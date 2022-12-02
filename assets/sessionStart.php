<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petSitting";
$newUser = $_SESSION[ 'newUser' ];
$newPet = $_SESSION[ 'newPet' ];
$editPet = $_SESSION[ 'editPet' ];
$newReview = $_SESSION['newReview'];
?>