<?php
require 'assets/sessionStart.php';
require 'assets/getUserInfo.php';
require 'assets/head.php';
require 'assets/navbar.php';

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