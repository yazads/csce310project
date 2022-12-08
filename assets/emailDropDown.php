<?php
  $page = pathinfo($_SERVER['REQUEST_URI'])['filename'];
  // only get the pet's current owner if we're on editpet.php (instead of createpet.php)
  if($page == 'editpet'){
    $curOwner = getPetOwnerEmailByPetID($petID)['email'];
  }

  if($personType == 3){
    // display drop down to assign the pet to an owner
    echo "<div class='input-group mb-3'>";
    echo "<span class='input-group-text'>Owner</span>";
    echo "<select class='form-control' id='sel1' name='petOwner'>";

    // get the emails for all the pet owners in the db
    $petOwners = getEmailsByPersonType('1');
    for($x = 0; $x < count($petOwners); $x++){
      // display each email
      $email = $petOwners[$x]['email'];

      // if we're on editpet.php and this is the email associated with the pet, have this be the default option
      $value = "value='$email'";
      if($page == 'editpet' && $email == $curOwner){
        $value = " selected ";
      }
      echo "<option $value>$email</option>";
    }
    echo "</select></div>";
  }

  function getEmailsByPersonType($t){
    // connect to the db
    require 'dbConnect.php';
    try{
      // query db for emails belonging to all people with person type $personType
      $q = $conn->prepare("SELECT email FROM person WHERE personType = :personType");
      // replace the placeholder with the person type
      $q->bindParam(':personType',$t);
      $q->execute();
      return $q->fetchAll();
    }catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

  function getPetOwnerEmailByPetID($id){
    // connect to the db
    require 'dbConnect.php';
    try{
      // query db for email belonging to this pet's owner
      $q = $conn->prepare("SELECT email FROM person INNER JOIN pet ON pet.personID = person.personID WHERE pet.petID = :id");
      // replace the placeholder with the person type
      $q->bindParam(':id',$id);
      $q->execute();
      return $q->fetch();
    }catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  function getPetsByPersonID($id) {
    require 'dbConnect.php';
    try {
      // query db for email belonging to this pet's owner
      $q = $conn->prepare("SELECT petName FROM pet INNER JOIN person ON pet.personID = person.personID WHERE pet.personID = :id");
      // replace the placeholder with the person type
      $q->bindParam(':id',$id);
      $q->execute();
      return $q->fetch();
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
?>