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

// echo $pass;

$passphrase = '';

// try{
//   $q = $conn->prepare("SELECT passphrase FROM PERSON WHERE email = :email");
//   $q->bindParam(':email',$email);
//   $q->execute();
//   $passresult = $q->fetchAll();

//   if(isset($passresult['passphrase'])){
//     $passphrase = $passresult['passphrase'];
//   }
//   else{
//     $passphrase = 'not working';
//   }

//   echo 'DB password = ', $passphrase;
//   echo "\r\n";
//   echo 'Site password = ', $pass;

// }
// catch(PDOException $e) {
//   echo $sql . "<br>" . $e->getMessage();
// }




// if($pass === $passphrase){
//   header('Location: login.php');
// }

// echo $result['passphrase'];

// if(!empty($pass)){
//   try{

//     echo $pass;
//     $q = $conn->prepare("SELECT passphrase FROM PERSON WHERE email = :email");
//     $q->bindParam(':email',$email);
//     $q->execute();
//     $result = $q->fetch();
//     echo $result['passphrase'];
    
//     // if($result['passphrase'] === $pass){
//     //   echo "Correct password";
//     //   header('Location: index.php');
//     // }
//     // else{
//     //   header('Location: login.php');
//     // }
//   }
//   catch(PDOException $e){
//     echo $sql . "<br>" . $e->getMessage();
//   }
// }

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
require 'assets/head.php';
require 'assets/navbar.php'
?>
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
        $futureAppointments = TRUE;
        require 'assets/appointmentTable.php';
        ?>
      </div>
    </div>
  </div>
  </body>
</html>