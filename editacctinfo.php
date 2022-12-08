<?php
    require 'assets/sessionStart.php';
    require 'assets/getUserInfo.php';
    require 'assets/head.php';
    require 'assets/navbar.php';
?>

<!DOCTYPE html>
    <div style="margin-top:1%; margin-left:95%;">
        <a href="acctinfo.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
    </div>
    <h1 style="text-align:center; margin-top:5%; margin-bottom:5%;">Edit Account Info</h1>
    <div style="margin-right:30%; margin-left:30%;">
        <form action="acctinfo.php" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text">First and Last name</span>
                <input type="text" placeholder="First Name" aria-label="First name" class="form-control"  <?php echo "value='$personFName'"; ?> name="newfname">
                <input type="text" placeholder="Last Name" aria-label="Last name" class="form-control" <?php echo "value='$personLName'"; ?> name="newlname">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Phone Number</span>
                <input type="text" class="form-control" <?php echo "value='$phone'"; ?> placeholder="123-456-7890" aria-label="Phone" aria-describedby="basic-addon1" name="newphone">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text">Address</span>
                <input type="text" <?php echo "value='$streetAddress'"; ?> aria-label="Address" class="form-control" name="newstreet">
                <input type="text" <?php echo "value='$city'"; ?> aria-label="City" class="form-control" name="newcity">
                <input type="text" <?php echo "value='$usState'"; ?> aria-label="State" class="form-control" name="newstate">
                <input type="text" <?php echo "value='$zipCode'"; ?> aria-label="Zip" class="form-control" name="newzip">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Password</span>
                <input type="password" class="form-control" <?php echo "value='$passphrase'"; ?> aria-label="PW" aria-describedby="basic-addon1" name="newpassphrase">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Confirm Password</span>
                <input type="password" class="form-control" <?php echo "value=".$passphrase; ?> placeholder="Confirm Password" aria-label="Confirm" aria-describedby="basic-addon1">
            </div>
            
            <center><button type="submit" class="btn btn-outline-primary">Update</button></a></center>
            <br></br>
            <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;background-color:red" name='deleteAcct'>Delete Account</button></a></center>
        </form>
    </div>
    <?php 
        // note that we need to update database when we get back
        $_SESSION[ 'editAcctInfo' ] = TRUE;
    ?>
</html>