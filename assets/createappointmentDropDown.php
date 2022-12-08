<?php
  $page = pathinfo($_SERVER['REQUEST_URI'])['filename'];
  if($page == 'createappointment'){
    if($personType == 1) {
      $pets = getPetNameByPersonID($personID);
    } else {
      $pets = getAllPetNames();
    }
  }

  echo "<select class='form-control' id='sel1' name='petName'>";
  for ($x = 0; $x < count($pets); $x++) {
    $petname = $pets[$x]['petName'];
    $petid = $pets[$x]['petID'];
    $value = "value='$petid'";

    echo "<option $value>$petname</option>";
  }
  echo "</select>";

  function getPetNameByPersonID($id) {
    require 'dbConnect.php';
    try {
      // query db for email belonging to this pet's owner
      $q = $conn->prepare("SELECT petName,petID FROM pet INNER JOIN person ON pet.personID = person.personID WHERE pet.personID = :id");
      // replace the placeholder with the person type
      $q->bindParam(':id',$id);
      $q->execute();
      return $q->fetchAll();
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  function getAllPetNames() {
    require 'dbConnect.php';
    try {
      // query db for email belonging to this pet's owner
      $q = $conn->prepare("SELECT petName,petID FROM pet INNER JOIN person ON pet.personID = person.personID");
      $q->execute();
      return $q->fetchAll();
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
?>