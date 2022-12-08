<?php
try{
  // first get the pets associated with the appointment
  $q = $conn->prepare("SELECT petID FROM petAppointment WHERE appointmentID = :id");
  // replace the placeholder
  $q->bindParam(':id',$apptID);
  // do the sql query
  $q->execute();
  $petResult = $q->fetchAll();
  $petsArray = $petResult;

  // now, cycle through the array and get the petName & species for each petID
  $petData = "";
  $petName = '';
  $petSpecies = '';
  for($x=0;$x<count($petsArray);$x++){
    $id = $petsArray[$x]['petID'];

    // query for the petName and species associated with the current petid
    $q = $conn->prepare("SELECT petName, species FROM pet WHERE petID = :id");
    // replace the placeholder
    $q->bindParam(':id',$id);
    // do the sql query
    $q->execute();
    // store the result
    $petResult = $q->fetch();

    // save the pet's name
    $petName = $petResult['petName'];

    // convert from species # to dog/cat/fish/bird/monkey/other
    if($petResult['species'] == 1){
      $petSpecies = 'Dog';
    }else if($petResult['species'] == 2){
      $petSpecies = 'Cat';
    }else if($petResult['species'] == 3){
      $petSpecies = 'Fish';
    }else if($petResult['species'] == 4){
      $petSpecies = 'Bird';
    }else if($petResult['species'] == 5){
      $petSpecies = 'Monkey';
    }else{
      $petSpecies = 'Other';
    }
    
    // add the current pet name and species to the list of pets
    $petData = $petData . $petName . " (" . $petSpecies . ")\n";
  }

}catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

echo $petData;

?>