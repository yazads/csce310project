<?php
<<<<<<< HEAD
session_start();
$newUser = $_SESSION[ 'newUser' ];
$newPet = $_SESSION[ 'newPet' ];
$editPet = $_SESSION[ 'editPet' ];
$newReview = $_SESSION['newReview'];
require 'dbConnect.php';
=======
    session_start();
    $newUser = $_SESSION[ 'newUser' ];
    $newPet = $_SESSION[ 'newPet' ];
    $editPet = $_SESSION[ 'editPet' ];
    $newReview = $_SESSION['newReview'];
    $comeFromLogin = $_SESSION['comeFromLogin'];
    $editAcctInfo = $_SESSION['editAcctInfo'];
    require 'dbConnect.php';
>>>>>>> 87b15fdce0ad825c71155f3b2dc530affd488354
?>