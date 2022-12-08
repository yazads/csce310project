<?php
  $page = pathinfo($_SERVER['REQUEST_URI'])['filename'];
  if($page == 'createappointment'){
    $pets = getPetNameByPersonID($personID);
  }

  for ($x = 0; $x < count($pets); $x++) {
    $petname = $pets[$x];
    echo $petname;
  }

  function getPetNameByPersonID($id) {
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