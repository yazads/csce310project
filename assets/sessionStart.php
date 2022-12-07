<?php
    session_start();
    $newUser = $_SESSION[ 'newUser' ];
    $newPet = $_SESSION[ 'newPet' ];
    $editPet = $_SESSION[ 'editPet' ];
    $newReview = $_SESSION['newReview'];
    $comeFromLogin = $_SESSION['comeFromLogin'];
    $editAcctInfo = $_SESSION['editAcctInfo'];
    require 'dbConnect.php';
?>