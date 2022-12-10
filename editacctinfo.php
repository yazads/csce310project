<?php
    require 'assets/sessionStart.php';
    require 'assets/getUserInfo.php';
    require 'assets/head.php';
    require 'assets/navbar.php';

    // if we're admin, then we need to get the userID passed from acctinfo.php
    if($personType == 3){
        // get personID passed on from previous page
        if(isset($_POST['personID'])){
            $personID = $_POST['personID'];
            
            // if not set, set session var personID to the personID (otherwise refresh breaks the page)
            if(!isset($_SESSION[ 'personID'])){
            $_SESSION[ 'personID' ] = $personID;
            }
        }else{
            $personID = $_SESSION[ 'personID' ];
        }
    }

    require 'assets/dbConnect.php';
    // query db for all the info associated with the personID
    try{
        // prepare the query
        $q = $conn->prepare("SELECT personFName, personLName, email, passphrase, personType, phone, streetAddress, city, USState, zipCode FROM PERSON WHERE personID = :personID");
        // replace the placeholder with the email
        $q->bindParam(':personID',$personID);
        // do the sql query and store the result in an array
        $q->execute();
        $result = $q->fetch();

        // check that we got the id and name then save them to use later
        if(isset($result['personFName']) && isset($result['personLName']) && isset($result['email']) && isset($result['passphrase']) && isset($result['personType']) && isset($result['phone']) && isset($result['streetAddress']) && isset($result['city']) && isset($result['USState']) && isset($result['zipCode'])){
        $personFName = $result['personFName'];
        $personLName = $result['personLName'];
        $email = $result['email'];
        $passphrase = $result['passphrase'];
        $personType = $result['personType'];
        $phone = $result['phone'];
        $streetAddress = $result['streetAddress'];
        $city = $result['city'];
        $usState = $result['USState'];
        $zipCode = $result['zipCode'];
        }
    }catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
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
            <span class="input-group-text" id="basic-addon1">Email Address</span>
            <input type="text" class="form-control" <?php echo "value='$email'"; ?> placeholder="Email" aria-label="E-mail_Address@example.com" aria-describedby="basic-addon1" name="newemail">
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

            <?php echo "<input type='hidden' name='personID' value='".$personID."'>"; ?>
            
            <center><button type="submit" class="btn btn-outline-primary">Update Account</button></a></center>
            <br></br>
            <center><button type="submit" class="btn btn-outline-danger" style="padding-top:1%" name='deleteAcct'>Delete Account</button></a></center>
        </form>
    </div>
    <?php 
        // note that we need to update database when we get back
        $_SESSION[ 'editAcctInfo' ] = TRUE;
    ?>
</html>