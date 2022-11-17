<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petsitting";

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
    // connect to petsitting db
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  
    // echo $type;
  
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
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
  
  
  $conn = null;
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
    <title>Pet Sitting 2.0 | Home</title>
  </head>
  <body>
    <h1 style="text-align:center; margin-top:5%; margin-bottom:5%;">Welcome to Pet Sitting 2.0!</h1>
  </body>
</html>