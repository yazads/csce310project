<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petSitting";
$newUser = $_SESSION[ 'newUser' ];
$newPet = $_SESSION[ 'newPet' ];
$editPet = $_SESSION['editPet'];

// connect to petsitting db
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// update the db if we're coming from editpet.php or createpet.php
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

if($editPet){
  // see if we need to delete or update a pet
  if(isset($_POST['deletePet'])){
    // TODO: add triggers to db, to delete associated appts b4 deleting pet
    // check if post info is set before assigning variables
    // otherwise we get annoying warnings on refresh
    if(isset($_POST['petID'])){
      $petID = $_POST['petID'];
    }

    // if petID is non-empty, attempt to delete associated pet from db 
    if(!empty($petID)){
      try{
        // use a prepared statement for the query to stop sql injections
        $q = $conn->prepare("DELETE FROM PET WHERE petID = :petID");
        // replace the placeholder with the apptID
        $q->bindParam(':petID',$petID);

        // do the sql query
        $q->execute();
      }catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
    }
  }else{
    // update the pet
    
    // check if post info is set before assigning variables
    // otherwise we get annoying warnings on refresh
    if(isset($_POST['newPetName']) && isset($_POST['newSpecies']) && isset($_POST['newRequirements']) && isset($_POST['petID'])){
      $newPetName = $_POST['newPetName'];
      $newSpecies = $_POST['newSpecies'];
      $newRequirements = $_POST['newRequirements'];
      $petID = $_POST['petID'];
    }

    // only update review in db if new petname, species, requirements, and (not new) petID are non-empty
    if(!empty($newPetName) && !empty($newSpecies) && !empty($newRequirements) && !empty($petID)){
      // try to update the database
      try{
        // use a prepared statement for the query to stop sql injections
        $q = $conn->prepare("UPDATE PET SET petName = :newPetName, species = :newSpecies, requirements = :newRequirements WHERE petID = :petID");
        // replace the placeholders with the petname, species, requirements, and petID
        $q->bindParam(':newPetName',$newPetName);
        $q->bindParam(':newSpecies',$newSpecies);
        $q->bindParam(':newRequirements',$newRequirements);
        $q->bindParam(':petID',$petID);

        // do the sql query
        $q->execute();
      }catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
    }
  }
  // set editPet back to false
  $_SESSION['editPet'] = FALSE;
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
    <title>Pet Stop | Account</title>
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
        <div class = "fleft">
            <h2>My Pets</h2>
            <br></br>
            <?php
            echo "<table style='border: solid 1px black;'>";
            echo "<th>Pet Name</th> <th>Species</th> <th>Requirements</th> <th>Customize</th></tr>";

            class TableRows extends RecursiveIteratorIterator {
              function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
              }

              function current() {
                $curVal = parent::current();
                if(parent::key() == 'species'){
                  /* convert from int to species such that:
                   * 1 = dog
                   * 2 = cat
                   * 3 = fish
                   * 4 = bird
                   * 5 = monkey
                   * 6 = other
                   */
                  switch($curVal){
                    case '1':
                      $curVal = 'Dog';
                      break;
                    case '2':
                      $curVal = 'Cat';
                      break;
                    case '3':
                      $curVal = 'Fish';
                      break;
                    case '4':
                      $curVal = 'Bird';
                      break;
                    case '5':
                      $curVal = 'Monkey';
                      break;
                    default:
                      $curVal = 'Other';
                      break;
                  }
                }else if(parent::key() == 'petID'){
                  // display a button that lets you edit the pet and pass along the petID to the next page
                  $petID = parent::current();
                  return "<form action='editpet.php' method='post' id='editPet'><input type='hidden' name='petID' value='".$petID."'>
                  <td style='width:150px;border:1px solid black;'> <center><button class='btn btn-outline-primary' type='submit' >Edit Pet</button></center></form></td>";
                }
                return "<td style='width:150px;border:1px solid black;'>" . $curVal. "</td>";
              }

              function beginChildren() {
                echo "<tr>";
              }

              function endChildren() {
                echo "</tr>" . "\n";
              }
            }

            try {
              $q = $conn->prepare("SELECT petName, species, requirements, petID FROM pet WHERE personID = :personID");
              // replace the placeholder with the personID
              $q->bindParam(':personID',$personID);

              // do the sql query and store the result in an array
              $q->execute();
                
              $result = $q->setFetchMode(PDO::FETCH_ASSOC);
              foreach(new TableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
                echo $v;
              }
            } catch(PDOException $e) {
              echo "Error: " . $e->getMessage();
            }
            echo "</table>";
            ?>
            <br></br>
            <a href="createpet.php"><button type="button" class="btn btn-outline-primary">Add New Pet</button></a>
        </div>
        
        <div class = "fright">
            <h2>My Info</h2>
            <br></br>
            <?php
            echo "<p>First Name: " . $personFName . "</p>";
            echo "<p>Last Name: " . $personLName . "</p>";
            echo "<p>Email: " . $email . "</p>";
            echo "<p>Phone: " . $phone . "</p>";
            echo "<p>Street: " . $streetAddress . "</p>";
            echo "<p>City: " . $city . "</p>";
            echo "<p>State: " . $usState . "</p>";
            echo "<p>Zip: " . $zipCode . "</p>";
            if($personType == '1')
              echo "<p>You are a <b>Pet Owner</b></p>";
            else
              echo "<p>You are a <b>Pet Sitter</b></p>";
            ?>
        </div>
    </div>
  </div>
  </body>
</html>