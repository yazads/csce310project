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
        <title>Pet Stop | Edit Account</title>
        <link rel="icon" type="image/x-icon" href="assets/DogHouse.png">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
        <style>
        <?php include 'styles/acctinfo.css'; ?>
        </style>
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
            <a href="acctinfo.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
        </div>    
        <div>
        <div>
            <h1 style="text-align:center; margin-bottom:5%;"> Edit My Account </h1>
        </div>
        <div style="margin-right:30%; margin-left:30%;">
        <!-- Table of pet details to give user a frame of reference for which pet they're editing -->
        <?php
        echo "<center><table style='border: solid 1px black;'>";
        echo "<th>First Name</th><th>Last Name</th><th>phone</th><th>Street Address</th><th>city</th><th>usState</th><th>zipCode</th><th>personType</th></tr>";

        class TableRows extends RecursiveIteratorIterator {
          function __construct($it) {
            parent::__construct($it, self::LEAVES_ONLY);
          }
          function current() {
            $curVal = parent::current();
            if(parent::key() == 'personType'){
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
                    $curVal = 'Pet Owner';
                    break;
                  case '2':
                    $curVal = 'Pet Sitter';
                    break;
                }
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
          // get appointment information from database
          $q = $conn->prepare("SELECT personFName, personLName, phone, streetAddress, city, usState, zipCode, personType FROM person WHERE personID = :personID");
        
          // replace the placeholder with the petID
          $q->bindParam('personID',$personID);

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
        <br><br>
            <!-- Form for user to edit their pet -->
            <form action="acctinfo.php" method="post">
                <div class="input-group mb-3">
                    <span class="input-group-text">First and Last name</span>
                    <input type="text" placeholder="First Name" aria-label="First name" class="form-control" name="newpersonFname" <?php echo "value=".$personFName; ?>>
                    <input type="text" placeholder="Last Name" aria-label="Last name" class="form-control" name="newpersonLname" <?php echo "value=".$personLName; ?>>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Email Address</span>
                    <input type="text" class="form-control" placeholder="Email" aria-label="E-mail_Address@example.com" aria-describedby="basic-addon1" name="newemail" <?php echo "value=".$email; ?>>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Phone Number</span>
                    <input type="text" class="form-control" placeholder="123-456-7890" aria-label="Phone" aria-describedby="basic-addon1" name="newphone" <?php echo "value=".$phone; ?>>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Address</span>
                    <input type="text" placeholder="1234 Street Road apt 567" aria-label="Address" class="form-control" name="newstreetAddress" <?php echo "value=".$streetAddress; ?>>
                    <input type="text" placeholder="City" aria-label="City" class="form-control" name="newcity" <?php echo "value=".$city; ?>>
                    <input type="text" placeholder="State" aria-label="State" class="form-control" name="newusState" <?php echo "value=".$usState; ?>>
                    <input type="text" placeholder="Zip Code" aria-label="Zip" class="form-control" name="newzipCode" <?php echo "value=".$zipCode; ?>>
                </div>
                <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;" name='updateAccount'>Update Info</button></a></center>
                <br>
                <center><button type="submit" class="btn btn-outline-danger" style="padding-top:1%;" name='deleteAccount'>Delete My Account</button></a></center>
            </form>
        </div>
        <?php 
            // note that we need to update database when we get back
            $_SESSION[ 'editInfo' ] = TRUE;
        ?>
    </body>
</html>