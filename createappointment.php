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
        <h1 style="text-align:center; margin-bottom:5%;"> New Appointment </h1>
    </div>
    <div style="margin-right:30%; margin-left:30%;">
        <form action="imdex.php" method="post">
            
            <div class="input-group">
                <span class="input-group-text">Pet</span>
                <?php require 'assets/createappointmentDropDown.php'; ?>
            </div>

            <div class="input-group">
                <span class="input-group-text">Start date and time</span>
                <input type="text" placeholder="YYYY" aria-label="Pet Name" class="form-control" name="timedate-y"></input>
                <input type="text" placeholder="MM" aria-label="Pet Name" class="form-control" name="timedate-m"></input>
                <input type="text" placeholder="DD" aria-label="Pet Name" class="form-control" name="timedate-d"></input>
                <span class="input-group-text"></span>
                <input type="text" placeholder="HH" aria-label="Pet Name" class="form-control" name="timedate-h"></input>
                <input type="text" placeholder="MM" aria-label="Pet Name" class="form-control" name="timedate-M"></input>
                <input type="text" placeholder="SS" aria-label="Pet Name" class="form-control" name="timedate-s"></input>
            </div>
            <div class="input-group">
                <span class="input-group-text">Duration (in hours)</span>
                <input type="text" placeholder="e.g. 5" aria-label="Pet Name" class="form-control" name="duration"></input>
            </div>
            <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;">Create New Appointment</button></a></center>
        </form>
    </div>
    <?php 
        // note that we need to add to database when we get back
        $_SESSION[ 'newAppt' ] = TRUE;
    ?>
</html>