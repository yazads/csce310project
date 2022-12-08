<?php
    require 'assets/sessionStart.php';
    require 'assets/getUserInfo.php';
    require 'assets/head.php';
    require 'assets/navbar.php';
?>

<!DOCTYPE html>
    <div style="margin-top:1%; margin-left:95%;">
        <a href="index.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
    </div>    
    <div>
        <h1 style="text-align:center; margin-bottom:5%;"> Pet Sitter Select Appointment </h1>
    </div>
    <div style="margin-right:30%; margin-left:30%;">
        <form action="index.php" method="post">
            
            <div class="input-group">
                <span class="input-group-text">Pet</span>
                <?php require 'assets/selectappointmentDropDown.php'; ?>
            </div>
            <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;" name='selectAppt'>Select Appointment</button></a></center>
        </form>
    </div>
    <?php 
        // note that we need to add to database when we get back
        $_SESSION[ 'selectAppt' ] = TRUE;
    ?>
</html>