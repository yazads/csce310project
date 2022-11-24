<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petSitting";
$newUser = $_SESSION[ 'newUser' ];

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
        VALUES (:email, :phone, :fname, :lname, :street, :usState, :city, :zip, :personType)");
      
        // replace the placeholders with the info from the sign up form
        $q->bindParam(':email',$email);
        $q->bindParam(':phone',$phone);
        $q->bindParam(':fname', $fname);
        $q->bindParam(':lname',$lname);
        $q->bindParam(':street',$street);
        $q->bindParam(':usState',$usState);
        $q->bindParam(':city',$city);
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
    $q = $conn->prepare("SELECT personID, personFName, personLName, personType FROM PERSON WHERE email = :email");
    // replace the placeholder with the email
    $q->bindParam(':email',$email);
    // do the sql query and store the result in an array
    $q->execute();
    $result = $q->fetch();

    // check that we got the id and name then save them to use later
    if(isset($result['personID']) && isset($result['personFName']) && isset($result['personLName']) && isset($result['personType'])){
      $personID = $result['personID'];
      $personFName = $result['personFName'];
      $personLName = $result['personLName'];
      $personType = $result['personType'];
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
        .wrap {
            width: 100%;
            overflow:auto;
            text-align:center;
            height:100%;
            padding-top: 5%;
        }
        .fleft {
            float:left; 
            width: 50%;
            height: 100%;
            text-align:center;
        }

        .fright {
            float: right;
            height: 100%;          
            width: 50%;
            text-align:center;
        }
        .logo {
            border-radius:5px;
        }
      </style>
  </head>
  <body>
    <div style="background-color:#FAE8E0">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid" >
          <a class="navbar-brand" href="index.php" style="font-size:32px; color:#FAE8E0;">
            <img src="DogHouse.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top logo">
            <strong>Pet Stop</strong>
          </a>
          <span class="dropdown" style="padding-right:1%;">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $personFName; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="margin-right:10%;">
              <li><a class="dropdown-item" href="#">Account Info</a></li>
              <li><a class="dropdown-item" href="#">Something else</a></li>
              <li><a class="dropdown-item" href="login.php">Sign Out</a></li>
            </ul>
          </span>
        </div>
      </nav>
    <div class = "wrap">
        <div class = "fleft">
            <h2>My Pets</h2>
            goofy ahh
        </div>
        <div class = "fright">
            <h2>My Info</h2>
            silly goose
        </div>
    </div>
  </div>
<?php
    echo "<table style='border: solid 1px black;'>";
    echo "<tr><th>AppointmentID</th><th>Pet Owner ID</th><th>Pet Sitter ID</th><th>Day</th> <th>Month</th> <th>Year</th> <th>Start Time</th> <th>Duration</th> <th>Pets</th></tr>";

    class TableRows extends RecursiveIteratorIterator {
      function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
      }

      function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
      }

      function beginChildren() {
        echo "<tr>";
      }

      function endChildren() {
        echo "</tr>" . "\n";
      }
    }

    try {
        // get appointment information from database
      if($personType == 1){
        // this is a pet owner
        $q = $conn->prepare("SELECT * FROM Appointment where petOwner = :personID");
      }else{
        // this is a pet sitter
        $q = $conn->prepare("SELECT * FROM Appointment where petSitter = :personID");
      }
      // replace the placeholder with the personID
      $q->bindParam(':personID',$personID);

      // do the sql query and store the result in an array
      $q->execute();
      $result = $q->fetch();

      // TODO:
      // convert from personIDs to actual names (or maybe we want to do just emails or both emails and names idk?)
      // for each appointment, get the pet list and review
      // maybe get info for each pet in list
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
  </body>
</html>