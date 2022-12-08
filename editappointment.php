<?php
    require 'assets/sessionStart.php';
    require 'assets/getUserInfo.php';
    require 'assets/head.php';
    require 'assets/navbar.php';

    // get pet's requirements from db
    try{
    // use a prepared statement for the query
    $q = $conn->prepare("SELECT petName, species, requirements FROM pet WHERE petID = :petID");
    // replace the placeholder with the petID
    $q->bindParam(':petID',$petID);
    // run the query and store the result
    $q->execute();
    $result = $q->fetch();
        
    // check that we got petName, species, and requirements columns and save their contents for later
    if(isset($result['petName']) && isset($result['species']) && isset($result['requirements'])){
        $petName = $result['petName'];
        $species = $result['species'];
        $requirements = $result['requirements'];
    }else{
        $petName = $species = $requirements = "";
    }
    }catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
    }
?>

<!DOCTYPE html>
    <div style="margin-top:1%; margin-left:95%;">
        <a href="acctinfo.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
    </div>    
    <div>
        <div>
            <h1 style="text-align:center; margin-bottom:5%;"> Edit Appointment </h1>
        </div>
        <div style="margin-right:30%; margin-left:30%;">
        <!-- Table of pet details to give user a frame of reference for which pet they're editing -->
        <!-- <?php require 'assets/petTable.php'; ?> -->
        <br><br>
            <!-- Form to edit the pet -->
            <form action="acctinfo.php" method="post">
                <?php require 'assets/emailDropDown.php'?>
                <div class="input-group mb-3">
                    <span class="input-group-text">Appointments</span>
                    <?php require 'assets/editappointmentDropDown.php' ?>
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
                <br>
                <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;" name='updateAppt'>Update Appointment</button></a></center>
                <br>
                <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;background-color:red" name='deleteAppt'>Delete Appointment</button></a></center>
            </form>
    </div>
    <?php 
        // note that we need to update database when we get back
        $_SESSION[ 'editAppt' ] = TRUE;
    ?>
</html>