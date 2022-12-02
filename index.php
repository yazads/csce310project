<?php
require 'assets/sessionStart.php';
// connect to petsitting db
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* Depending on where we're coming from, update different parts of the database:
 *
 * $newUser -- insert new user using POST vars fname, lname, email, phone, street, city, state, zip, type (sent from signup.php)
 * $newPet -- insert new pet using POST vars petname, species, requirements (sent from createpet.php)
 * $newReview -- update review using POST vars newReviewText, appointmentID (sent from editreview.php)
*/

if($newUser){
  // check if post info is set before assigning variables
  // otherwise we get annoying warnings on refresh
  if(isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["street"]) && isset($_POST["city"]) && isset($_POST["state"]) && isset($_POST["zip"]) && isset($_POST["type"])){
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $usState = $_POST["state"];
    $zip = $_POST["zip"];
    $personType = $_POST["type"];

    // add info to db
    // to prevent adding empty rows to the db after refreshing, only connect to db if attributes have info
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($phone) && !empty($street) && !empty($city) && !empty($usState) && !empty($zip) && !empty($personType)){
      try {   
        // prepare an sql query
        $q = $conn->prepare("INSERT INTO PERSON (email, phone, personFName, personLName, streetAddress, city, USState, zipCode, personType)
        VALUES (:email, :phone, :fname, :lname, :street, :city, :usState, :zip, :personType)");
      
        // replace the placeholders with the info from the sign up form
        $q->bindParam(':email',$email);
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
?>

<script>
// prevent resubmission of form on refresh
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
      crossorigin="anonymous"
    />
    <title>Pet Stop | Home</title>
    <link rel="icon" type="image/x-icon" href="assets/DogHouse.png">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <style>
      <?php include 'styles/index.css'; ?>
    </style>
  </head>
  <body>
    <div style="background-color:#FAE8E0">
    <?php require 'assets/navbar.php' ?>
    <h1 style="text-align:center; margin-top:5%; margin-bottom:5%;">Welcome to Pet Stop, <?php echo $personFName; ?>!</h1>
    <div class = "wrap">
      <div class = "fleft">
        <h2>Previous Appointments</h2>
        <?php
        echo "<table style='border: solid 1px black;'>";
        if($personType == 1){
          echo "<th>Pet Sitter First Name</th><th> Pet Sitter Last Name</th><th> Pet Sitter Email</th><th>Start Time</th> <th>Duration (hours) </th> <th>Review</th></tr>";
        }else{
          echo "<tr><th>Pet Owner First Name</th><th>Pet Owner Last Name</th><th>Pet Owner Email</th><th>Start Time</th> <th>Duration (hours) </th><th>Review</th></tr>";
        }

        // version of table rows that does not have button to edit reviews (to be used for pet sitters and future appointments)
        class TableRows extends RecursiveIteratorIterator {
          function __construct($it) {
            parent::__construct($it, self::LEAVES_ONLY);
          }

          function current() {
            if(!(parent::key() == 'appointmentID')){
              // only display info when the current attribute is NOT appointmentID
              return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
            }
          }

          function beginChildren() {
            echo "<tr>";
          }

          function endChildren() {
            echo "</tr>" . "\n";
          }
        }

        // version of table rows that has a button to edit reviews (only for past appts of pet owners)
        class TableRowsButtons extends RecursiveIteratorIterator {
          function __construct($it) {
            parent::__construct($it, self::LEAVES_ONLY);
          }

          function current() {
            if(parent::key() == 'appointmentID'){
              // don't actually display the appointment id, just save it for later in case they want to change the review
              $rowAppointmentID = parent::current();
              return "<form action='editreview.php' method='post' id='editReview'><input type='hidden' name='appointmentID' value='".$rowAppointmentID."'>";
            }else if (parent::key() == 'reviewText'){
              // return the data plus a button to change the review
              return "<td style='width:150px;border:1px solid black;'> <center><button class='btn btn-outline-primary' type='submit' >Edit Review</button></center></form>" . parent::current(). "</td>";
            }else{
              // just return the data
              return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
            }
          }

          function beginChildren() {
            echo "<tr>";
          }

          function endChildren() {
            echo "</tr>" . "\n";
          }
        }

        try {
          // get past appointment information from database
          if($personType == 1){
            // this is a pet owner
            $q = $conn->prepare("SELECT DISTINCT appointment.appointmentID, person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
            FROM ((appointment
            INNER JOIN person ON appointment.petSitter = person.personID) 
            LEFT JOIN review ON review.appointmentID = appointment.appointmentID)
            WHERE appointment.petOwner = :personID AND DATE(startTime) < CURDATE() ORDER BY startTime ASC");
          }else{
            // this is a pet sitter
            $q = $conn->prepare("SELECT appointment.appointmentID, person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
            FROM ((appointment
            INNER JOIN person ON appointment.petOwner = person.personID)
            INNER JOIN review ON review.appointmentID = appointment.appointmentID)
            WHERE appointment.petSitter = :personID AND DATE(startTime) < CURDATE() ORDER BY startTime ASC");
          }
          // replace the placeholder with the personID
          $q->bindParam(':personID',$personID);

          // do the sql query and store the result in an array
          $q->execute();

          // TODO:
          // for each appointment, get the pet list and maybe get info for each pet in list
            
          $result = $q->setFetchMode(PDO::FETCH_ASSOC);
          // print out the table of past appts, w/ or w/o edit buttons, depending on person type
          if($personType == 1){
            // pet owners get edit review buttons
            foreach(new TableRowsButtons(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
              echo $v;
            }
          }else{
            // pet sitters can't edit reviews
            foreach(new TableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
              echo $v;
            }
          }
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
        echo "</table>";
        ?>
      </div>
      <div class = "fright">
        <h2>Upcoming Appointments</h2>
        <?php
        echo "<table style='border: solid 1px black;'>";
        if($personType == 1){
          echo "<th>Pet Sitter First Name</th><th> Pet Sitter Last Name</th><th> Pet Sitter Email</th><th>Start Time</th> <th>Duration (hours) </th></tr>";
        }else{
          echo "<tr><th>Pet Owner First Name</th><th>Pet Owner Last Name</th><th>Pet Owner Email</th><th>Start Time</th> <th>Duration (hours) </th></tr>";
        }
          
        try {
          // get future appointment information from database
          if($personType == 1){
            // this is a pet owner
            $q = $conn->prepare("SELECT appointment.appointmentID, person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration
            FROM (appointment
            INNER JOIN person ON appointment.petSitter = person.personID) 
            WHERE appointment.petOwner = :personID AND DATE(startTime) >= CURDATE() ORDER BY startTime ASC");
          }else{
            // this is a pet sitter
            $q = $conn->prepare("SELECT appointment.appointmentID, person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration
            FROM (appointment
            INNER JOIN person ON appointment.petOwner = person.personID)
            WHERE appointment.petSitter = :personID AND DATE(startTime) >= CURDATE() ORDER BY startTime ASC");
          }
          // replace the placeholder with the personID
          $q->bindParam(':personID',$personID);

          // do the sql query and store the result in an array
          $q->execute();

          // TODO:
          // for each appointment, get the pet list and get info for each pet in list
          $result = $q->setFetchMode(PDO::FETCH_ASSOC);
          foreach(new TableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
            echo $v;
          }
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
        $conn = null;
        echo "</table>";
        ?>
      </div>
    </div>
  </div>
  </body>
</html>