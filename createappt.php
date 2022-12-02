<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petSitting";
$newUser = $_SESSION[ 'newUser' ];
$newAppt = $_SESSION[ 'newAppt' ];

// connect to petsitting db
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // only add to db if we're coming from signup.php
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
    }

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

  // get personId based on email
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


  if($newAppt){
    // check if post info is set before assigning variables
    // otherwise we get annoying warnings on refresh
    if(isset($_POST["appointmentDay"]) && isset($_POST["appointmentMonth"]) && isset($_POST["appointmentYear"]) && isset($_POST["startTime"]) && isset($_POST["duration"])){
      $appointmentDay = $_POST["appointmentDay"];
      $appointmentMonth = $_POST["appointmentMonth"];
      $appointmentYear = $_POST["appointmentYear"];  
      $startTime = $_POST["startTime"];
      $duration = $_POST["duration"];    
    }

    // to prevent adding empty rows to the db after refreshing, only connect to db if attributes have info
    if(!empty($appointmentDay) && !empty($appointmentMonth) && !empty($appointmentYear) && !empty($startTime) && !empty($duration)){
      try {
        // prepare an sql query
        $q = $conn->prepare("INSERT INTO APPOINTMENT (petOwner, petSitter, appointmentDay, appointmentMonth, appointmentYear, startTime, duration)
        VALUES (:petOwner, :petSitter, :appointmentDay, :appointmentMonth, :appointmentYear, :startTime, :duration)");

        // replace the placeholders with the info from the sign up form
        $q->bindParam(':petOwner',$personID);
        $q->bindParam(':petSitter',$NULL);
        $q->bindParam(':appointmentDay',$appointmentDay);
        $q->bindParam(':appointmentMonth', $appointmentMonth);
        $q->bindParam(':appointmentYear',$appointmentYear);
        $q->bindParam(':startTime',$startTime);
        $q->bindParam(':duration',$duration);

        // do the sql query
        $q->execute();
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
    }
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
        <?php include 'styles/acctinfo.css'; ?>
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    </head>
    <body style="background-color:#FAE8E0">
        <div>
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
        <div style="margin-top:1%; margin-left:95%;">
            <a href="index.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
        </div>    
        <div>
            <h1 style="text-align:center; margin-bottom:5%;"> New Appointment </h1>
        </div>
        <div style="margin-right:30%; margin-left:30%;">
            <form action="index.php" method="post">

                <div class="input-group mb-3">
                    <span class="input-group-text">Start Day</span>
                    <input type="text" placeholder="dd" aria-label="appt date" class="form-control" name="appointmentDay">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Start Month</span>
                    <input type="text" placeholder="mm" aria-label="appt date" class="form-control" name="appointmentMonth">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Start Year</span>
                    <input type="text" placeholder="yyyy" aria-label="appt date" class="form-control" name="appointmentYear">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Start Time</span>
                    <input type="text" placeholder="23:59" aria-label="appt time" class="form-control" name="startTime">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Duration (days)</span>
                    <input type="text" placeholder="7" aria-label="end date" class="form-control" name="duration">
                </div>
                <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;">Create New Appointment</button></a></center>
            </form>
        </div>
        <?php 
            // note that we need to add to database when we get back
            $_SESSION[ 'newAppt' ] = TRUE;
        ?>
    </body>
</html>