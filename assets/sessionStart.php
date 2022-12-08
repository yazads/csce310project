<?php
    session_start();
    $newUser = $_SESSION[ 'newUser' ];
    $newPet = $_SESSION[ 'newPet' ];
    $newAppt = $_SESSION['newAppt'];
    $editPet = $_SESSION[ 'editPet' ];
    $editAppt = $_SESSION['editAppt'];
    $selectAppt = $_SESSION['selectAppt'];
    $newReview = $_SESSION['newReview'];
    $comeFromLogin = $_SESSION['comeFromLogin'];
    $editAcctInfo = $_SESSION['editAcctInfo'];
    require 'dbConnect.php';
?>