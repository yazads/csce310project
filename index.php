<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petSitting";
$newUser = $_SESSION[ 'newUser' ];
$newPet = $_SESSION[ 'newPet' ];
$newReview = $_SESSION['newReview'];

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

if($newPet){
  // check if post info is set before assigning variables
  // otherwise we get annoying warnings on refresh
  if(isset($_POST["petname"]) && isset($_POST["species"]) && isset($_POST["requirements"])){
    $petname = $_POST["petname"];
    $species = $_POST["species"];
    $requirements = $_POST["requirements"];  
  }

  // to prevent adding empty rows to the db after refreshing, only connect to db if attributes have info
  if(!empty($petname) && !empty($species) && !empty($requirements)){
    try {
      
      // prepare an sql query
      $q = $conn->prepare("INSERT INTO PET (personID, petName, species, requirements)
      VALUES (:personID, :petName, :species, :requirements)");
    
      // replace the placeholders with the info from the sign up form
      $q->bindParam(':personID',$personID);
      $q->bindParam(':petName',$petname);
      $q->bindParam(':species', $species);
      $q->bindParam(':requirements',$requirements);
      
      // do the sql query
      $q->execute();
    } catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }
  // set newPet back to false
  $_SESSION['newPet'] = FALSE;
}

if($newReview){
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
    }catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }
  // set newReview back to false
  $_SESSION['newReview'] = FALSE;
}

/* Get general info about our current user */
if(isset($_POST['email'])){
  $email = $_POST['email'];
    
  // if not set, set session var email to the user's email (otherwise refresh breaks the page)
  if(!isset($_SESSION[ 'email'])){
    $_SESSION[ 'email' ] = $email;
  }
}else{
  $email = $_SESSION[ 'email' ];
}

// query db for persontype, personID, and full name associated with the email
try{
  // prepare the query
  $q = $conn->prepare("SELECT personID, personFName, personLName, personType, phone, streetAddress, city, USState, zipCode FROM PERSON WHERE email = :email");
  // replace the placeholder with the email
  $q->bindParam(':email',$email);
  // do the sql query and store the result in an array
  $q->execute();
  $result = $q->fetch();

  // check that we got the id and name then save them to use later
  if(isset($result['personID']) && isset($result['personFName']) && isset($result['personLName']) && isset($result['personType']) && isset($result['phone']) && isset($result['streetAddress']) && isset($result['city']) && isset($result['USState']) && isset($result['zipCode'])){
    $personID = $result['personID'];
    $personFName = $result['personFName'];
    $personLName = $result['personLName'];
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <style>
      <?php include 'styles/index.css'; ?>
    </style>
  </head>
  <body>
    <div style="background-color:#FAE8E0">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid" >
          <a class="navbar-brand" href="index.php" style="font-size:32px; color:#FAE8E0;">
            <img src="assets/DogHouse.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top logo">
            <strong>Pet Stop</strong>
          </a>
          <span class="dropdown" style="padding-right:1%;">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $personFName; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="margin-right:10%;">
              <li><a class="dropdown-item" href="index.php">Home</a></li>
              <li><a class="dropdown-item" href="acctinfo.php">Account Info</a></li>
              <li><a class="dropdown-item" href="#">Something else</a></li>
              <li><a class="dropdown-item" href="login.php">Sign Out</a></li>
            </ul>
          </span>
        </div>
      </nav>
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
            $q = $conn->prepare("SELECT appointment.appointmentID, person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
            FROM ((appointment
            INNER JOIN person ON appointment.petSitter = person.personID) 
            INNER JOIN review ON review.appointmentID = appointment.appointmentID)
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
          echo "<th>Pet Sitter First Name</th><th> Pet Sitter Last Name</th><th> Pet Sitter Email</th><th>Start Time</th> <th>Duration (hours) </th><th>Review</th></tr>";
        }else{
          echo "<tr><th>Pet Owner First Name</th><th>Pet Owner Last Name</th><th>Pet Owner Email</th><th>Start Time</th> <th>Duration (hours) </th><th>Review</th></tr>";
        }
          
        try {
          // get future appointment information from database
          if($personType == 1){
            // this is a pet owner
            $q = $conn->prepare("SELECT appointment.appointmentID, person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
            FROM ((appointment
            INNER JOIN person ON appointment.petSitter = person.personID) 
            INNER JOIN review ON review.appointmentID = appointment.appointmentID)
            WHERE appointment.petOwner = :personID AND DATE(startTime) >= CURDATE() ORDER BY startTime ASC");
          }else{
            // this is a pet sitter
            $q = $conn->prepare("SELECT appointment.appointmentID, person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
            FROM ((appointment
            INNER JOIN person ON appointment.petOwner = person.personID)
            INNER JOIN review ON review.appointmentID = appointment.appointmentID)
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