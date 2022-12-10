<?php
  require 'assets/sessionStart.php';

  /* Depending on where we're coming from, update different parts of the database:
  *
  * $newUser -- insert new user using POST vars fname, lname, email, phone, street, city, state, zip, type (sent from signup.php)
  * $newReview -- update review using POST vars newReviewText, appointmentID (sent from editreview.php)
  */

  function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
  ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
  }

  if(isset($_POST["pass"])){
    $pass = $_POST["pass"];
  }

  if($newUser){
    // check if post info is set before assigning variables
    // otherwise we get annoying warnings on refresh
    if(isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["passphrase"]) && isset($_POST["phone"]) && isset($_POST["street"]) && isset($_POST["city"]) && isset($_POST["state"]) && isset($_POST["zip"]) && isset($_POST["type"])){
      $fname = $_POST["fname"];
      $lname = $_POST["lname"];
      $pass = $_POST["passphrase"];
      $email = $_POST["email"];
      $phone = $_POST["phone"];
      $street = $_POST["street"];
      $city = $_POST["city"];
      $usState = $_POST["state"];
      $zip = $_POST["zip"];
      $personType = $_POST["type"];

      // add info to db
      // to prevent adding empty rows to the db after refreshing, only connect to db if attributes have info
      if(!empty($fname) && !empty($lname) && !empty($email) && !empty($pass) && !empty($phone) && !empty($street) && !empty($city) && !empty($usState) && !empty($zip) && !empty($personType)){
        try {   
          // prepare an sql query
          $q = $conn->prepare("INSERT INTO PERSON (email, passphrase, phone, personFName, personLName, streetAddress, city, USState, zipCode, personType)
          VALUES (:email, :passphrase, :phone, :fname, :lname, :street, :city, :usState, :zip, :personType)");
        
          // replace the placeholders with the info from the sign up form
          $q->bindParam(':email',$email);
          $q->bindParam(':passphrase',$pass);
          $q->bindParam(':phone',$phone);
          $q->bindParam(':fname', $fname);
          $q->bindParam(':lname',$lname);
          $q->bindParam(':street',$street);
          $q->bindParam(':city',$city);
          $q->bindParam(':usState',$usState);
          $q->bindParam(':zip',$zip);
          $q->bindParam(':personType',$personType);
          
          // do the sql query
          $q->execute();
        } catch(PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
        }
      }
    } 
    // set newUser back to false
    $_SESSION['newUser'] = FALSE;
  }

  if($newReview){
    // see if we need to delete or update a review
    if(isset($_POST['deleteReview'])){
      // check if post info is set before assigning variables
      // otherwise we get annoying warnings on refresh
      if(isset($_POST['appointmentID'])){
        $appointmentID = $_POST['appointmentID'];
      }

      // if appointmentID is non-empty, attempt to delete associated review from db 
      if(!empty($appointmentID)){
        try{
          // use a prepared statement for the query to stop sql injections
          $q = $conn->prepare("DELETE FROM REVIEW WHERE appointmentID = :appointmentID");
          // replace the placeholder with the apptID
          $q->bindParam(':appointmentID',$appointmentID);

          // do the sql query
          $q->execute();
        }catch(PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
        }
      }
    }else{
      // update or create the review

      // check if post info is set before assigning variables
      // otherwise we get annoying warnings on refresh
      if(isset($_POST['newReviewText']) && isset($_POST['appointmentID'])){
        $newReviewText = $_POST['newReviewText'];
        $appointmentID = $_POST['appointmentID'];
      }

      // only update review in db if apptID and newReviewText are non-empty
      if(!empty($newReviewText) && !empty($appointmentID)){
        // try to update the database
        try{
          // use a prepared statement for the query to stop sql injections
          $q = $conn->prepare("UPDATE REVIEW SET reviewText = :newReviewText WHERE appointmentID = :appointmentID");
          // replace the placeholders with the apptID and text
          $q->bindParam(':newReviewText',$newReviewText);
          $q->bindParam(':appointmentID',$appointmentID);

          // do the sql query
          $q->execute();

          // check if the # of rows affected is 0
          if($q->rowCount() == 0){
            // there's no review for the appt yet, so we need to insert one
            $q = $conn->prepare("INSERT INTO REVIEW (personID, appointmentID, reviewText) VALUES (:personID, :appointmentID, :newReviewText)");
            // replace the placeholders with the personID, apptID, and text
            $q->bindParam(':personID',$personID);
            $q->bindParam(':newReviewText',$newReviewText);
            $q->bindParam(':appointmentID',$appointmentID);  

            // do the sql query
            $q->execute();
          } 
        }catch(PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
        }
      }
    }
    // set newReview back to false
    $_SESSION['newReview'] = FALSE;
  }

  require 'assets/getUserInfo.php';

  //set temp passphrase

  if($comeFromLogin){
    $passphrase = '';

    // check if the email is in the db
    try{
      $q = $conn->prepare("SELECT passphrase FROM PERSON WHERE email = :email");
      $q->bindParam(':email',$email);
      $q->execute();
      $passresult = $q->fetch();
    
      // check if the query returned a passphrase
      if(isset($passresult['passphrase'])){
        // set the passphrase to the one returned from the db
        $passphrase = $passresult['passphrase'];
      }
      else{
        // if the query didn't return a passphrase, set it to something that won't work
        $passphrase = 'not working';
      }
    }
    catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
    
    // check if the passphrase is correct
    if($pass !== $passphrase){
      // if the passphrase is wrong, set the error message and redirect to login
      $inccorect_login = 'Incorrect email or password';
      header('Location: login.php');
    }
    
    $_SESSION['comeFromLogin'] = FALSE;
  }
  require 'assets/head.php';
require 'assets/navbar.php';

if($newAppt){
  // check if post info is set before assigning variables
  // otherwise we get annoying warnings on refresh
  if(isset($_POST["petName"]) && isset($_POST["timedate-y"]) && isset($_POST["timedate-m"]) && isset($_POST["timedate-d"]) && isset($_POST["timedate-h"]) && isset($_POST["timedate-M"]) && isset($_POST["timedate-s"]) && isset($_POST["duration"])){
    $petname = $_POST["petName"];
    $timeanddate = $_POST["timedate-y"] . "-" . $_POST["timedate-m"] . "-" . $_POST["timedate-d"] . " " . $_POST["timedate-h"] . ":" . $_POST["timedate-M"] . ":" . $_POST["timedate-s"];
    $duration = $_POST["duration"];  
  }

  // to prevent adding empty rows to the db after refreshing, only connect to db if attributes have info
  if(!empty($petname) && !empty($timeanddate) && !empty($duration)){
    try {
      // prepare an sql query
      $q = $conn->prepare("INSERT INTO appointment (appointmentID, petOwner, petSitter, startTime, duration)
      VALUES (DEFAULT, :petOwner, NULL, :startTime, :duration)");
    

      $q->bindParam(':petOwner',$personID);
      $q->bindParam(':startTime', $timeanddate);
      $q->bindParam(':duration', $duration);
      
      // do the sql query
      $q->execute();
      $q = $conn->prepare("SELECT MAX(appointmentID) FROM appointment");
      $q->execute();
      $tempAppID = $q->fetch();
      $q = $conn->prepare("INSERT INTO petappointment (petID, appointmentID) VALUES (:petname, :appointmentid)");
      $q->bindParam(':petname', $petname);
      $q->bindParam(':appointmentid', $tempAppID[0]);
      $q->execute();
    } catch(PDOException $e) {
      echo "<br>" . $e->getMessage();
    }
  }
  // set newAppt back to false
  $_SESSION['newAppt'] = FALSE;
}

if($selectAppt){
  // check if post info is set before assigning variables
  // otherwise we get annoying warnings on refresh
  if(isset($_POST["apptID"])){
    $apptID = $_POST["apptID"];
  }

  // to prevent adding empty rows to the db after refreshing, only connect to db if attributes have info
  if(!empty($apptID)){
    try {
      // prepare an sql query
      $q = $conn->prepare("UPDATE appointment SET petSitter = :petSitter WHERE appointmentID = :apptID");
    
      $q->bindParam(':petSitter',$personID);
      $q->bindParam(':apptID',$apptID);
      // do the sql query
      $q->execute();

    } catch(PDOException $e) {
      echo "<br>" . $e->getMessage();
    }
  }
  // set newAppt back to false
  $_SESSION['selectAppt'] = FALSE;
}
if($editAppt){
  // see if we need to delete or update a pet
  if(isset($_POST['deleteAppt'])){
    // check if post info is set before assigning variables
    // otherwise we get annoying warnings on refresh
    if(isset($_POST['apptID'])){
      $apptID = $_POST['apptID'];
    }

    // if petID is non-empty, attempt to delete associated pet from db 

      try{
        $q = $conn->prepare("DELETE FROM petappointment WHERE appointmentID = :apptID");

        $q->bindParam(':apptID', $apptID);
        $q->execute();
        // use a prepared statement for the query to stop sql injections
        $q = $conn->prepare("DELETE FROM appointment WHERE appointmentID = :apptID");
        // replace the placeholder with the apptID
        $q->bindParam(':apptID',$apptID);

        // do the sql query
        $q->execute();
      }catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
  }else{
    // update the pet
    // check if post info is set before assigning variables
    // otherwise we get annoying warnings on refresh
    if(isset($_POST["apptID"]) && isset($_POST["timedate-y"]) && isset($_POST["timedate-m"]) && isset($_POST["timedate-d"]) && isset($_POST["timedate-h"]) && isset($_POST["timedate-M"]) && isset($_POST["timedate-s"]) && isset($_POST["duration"])){
      $apptID = $_POST["apptID"];
      $timeanddate = $_POST["timedate-y"] . "-" . $_POST["timedate-m"] . "-" . $_POST["timedate-d"] . " " . $_POST["timedate-h"] . ":" . $_POST["timedate-M"] . ":" . $_POST["timedate-s"];
      $duration = $_POST["duration"];  
    }


      // try to update the database
      try{
        
        $q = $conn->prepare("UPDATE appointment SET startTime = :timeanddate, duration = :duration WHERE appointmentID = :apptID");
        // replace the placeholders with the petname, species, requirements, and petID
        $q->bindParam(':timeanddate',$timeanddate);
        $q->bindParam(':duration',$duration);
        $q->bindParam(':apptID',$apptID);

        // do the sql query
        $q->execute();
      }catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
  }
  // set editPet back to false
  $_SESSION['editAppt'] = FALSE;
}

?>

<html>
  <h1 style="text-align:center; margin-top:5%; margin-bottom:5%;">Welcome to Pet Stop, <?php echo $personFName; ?>!</h1>
  <div class = "wrap">
    <div class = "fleft">
      <?php $futureAppointments = FALSE; ?>
      <h2>Previous Appointments</h2>
      <?php require 'assets/appointmentTable.php'; ?>
    </div>

    <div class = "fright">
      <h2>Upcoming Appointments</h2>
      <?php
        if($personType != 2){
          echo "<button class='btn btn-outline-primary' onclick=\"location.href='createappointment.php'\">New Appointment</button>";
        }else if($personType != 1){
          echo "<button class='btn btn-outline-primary' onclick=\"location.href='selectappointment.php'\">Pet Sitter Select Appointment</button>";
        }
        echo "<br></br>";
        $futureAppointments = TRUE;
        require 'assets/appointmentTable.php';
         
      ?>        
      
    </div>
  </div>
</html>