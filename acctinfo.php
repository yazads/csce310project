<?php
require 'assets/sessionStart.php';
require 'assets/getUserInfo.php';

/* update the db if we're coming from editpet.php or createpet.php */
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
    <?php require 'assets/navbar.php' ?>
    <div class = "wrap">
            <?php if($personType == 1)require 'assets/petTable.php';?>
        <div <?php if($personType == 1) echo "class='fright'";?>>
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