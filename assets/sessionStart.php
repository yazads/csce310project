<?php
session_start();
$newUser = $_SESSION[ 'newUser' ];
$newPet = $_SESSION[ 'newPet' ];
$editPet = $_SESSION[ 'editPet' ];
$newReview = $_SESSION['newReview'];
require 'dbConnect.php';
?>