<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petSitting";
$newUser = $_SESSION[ 'newUser' ];
$newPet = $_SESSION[ 'newPet' ];
$reviewContents = "";

// connect to petsitting db
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
   // query db for first name associated with the email
   try{
    // prepare the query
    $q = $conn->prepare("SELECT personID, personFName FROM PERSON WHERE email = :email");
    // replace the placeholder with the email
    $q->bindParam(':email',$email);
    // do the sql query and store the result in an array
    $q->execute();
    $result = $q->fetch();

    // check that we got the id and name then save them to use later
    if(isset($result['personFName']) && isset($result['personFName'])){
      $personFName = $result['personID'];
      $personFName = $result['personFName'];
    }
  }catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }

  // get appointmentID passed on from previous page
  if(isset($_POST['appointmentID'])){
    $appointmentID = $_POST['appointmentID'];
    
  // if not set, set session var appointmentID to the appointmentID (otherwise refresh breaks the page)
  if(!isset($_SESSION[ 'appointmentID'])){
    $_SESSION[ 'appointmentID' ] = $appointmentID;
  }
  }else{
    $appointmentID = $_SESSION[ 'appointmentID' ];
  }

  // get review text from db
  try{
    // use a prepared statement for the query
    $q = $conn->prepare("SELECT reviewText FROM review WHERE appointmentID = :appointmentID");
    // replace the placeholder with the appointmentID
    $q->bindParam(':appointmentID',$appointmentID);
    // run the query and store the result
    $q->execute();
    $result = $q->fetch();
    
    // check that we got a 'reviewText' column and save its contents for later
    if(isset($result['reviewText'])){
        $reviewText = $result['reviewText'];
    }else{
        $reviewText = "";
    }
  }catch(PDOException $e){
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
    <title>Pet Stop | Edit Review</title>
    <link rel="icon" type="image/x-icon" href="assets/DogHouse.png">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <style>
     <?php include 'styles/acctinfo.css'; ?>
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
    <div class = "wrap">
        <!-- display appointment details to give the user a frame of reference for what to write in their review -->
        <h2> Appointment Details </h2>
        <?php
        echo "<center><table style='border: solid 1px black;'>";
        echo "<th>Pet Sitter First Name</th><th> Pet Sitter Last Name</th><th> Pet Sitter Email</th><th>Start Time</th> <th>Duration (hours) </th> <th>Previous Review</th></tr>";

        class TableRows extends RecursiveIteratorIterator {
            function __construct($it) {
              parent::__construct($it, self::LEAVES_ONLY);
            }

            function current() {
                return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
            }
              
            }

            function beginChildren() {
              echo "<tr>";
            }

            function endChildren() {
              echo "</tr>" . "\n";
            }
      
        

        try {
            // get appointment information from database
            $q = $conn->prepare("SELECT DISTINCT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
            FROM ((appointment
            INNER JOIN person ON appointment.petSitter = person.personID) 
            LEFT JOIN review ON review.appointmentID = appointment.appointmentID)
            WHERE appointment.appointmentID = :appointmentID AND DATE(startTime) < CURDATE() ORDER BY startTime ASC");
        
            // replace the placeholder with the appointmentID
            $q->bindParam(':appointmentID',$appointmentID);

            // do the sql query and store the result in an array
            $q->execute();
                
            $result = $q->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo "</table></center>";
        ?>

        <!-- form to update review -->
        <form method='post' action='index.php'>
        <h2><label for="newReviewText">Type New Review:</label></h2>
        <?php 
        echo "<textarea id='newReviewText' name='newReviewText' rows='4' cols='50'>". $reviewText."</textarea>";
        echo "<input type='hidden' name='appointmentID' value='".$appointmentID."'>";
        // note that we need to add to database when we get to index.php
        $_SESSION['newReview'] = TRUE;
        ?>
        <br>
        <center><button class='btn btn-outline-primary' type='submit'>Update Review</button></center>
        </form>
            
    </div>
  </div>
  </body>
</html>