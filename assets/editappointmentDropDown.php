<?php
  $page = pathinfo($_SERVER['REQUEST_URI'])['filename'];
  if($page == 'editappointment'){
    $appts = getApptIDsbyPersonID($personID);
  }

  echo "<select class='form-control' id='sel1' name='apptID'>";
  for ($x = 0; $x < count($appts); $x++) {
    $apptID = $appts[$x]['appointmentID'];
    $petID = $appts[$x]['petID'];
    $petname = $appts[$x]['petName'];
    $value = "value='$apptID'";
    echo "<option $value>Appointment $apptID for pet $petname</option>";
  }
  echo "</select>";

  // start time
  
  // duration

  function getApptIDsbyPersonID($id) {
    require 'dbConnect.php';
    try {
      // query db for email belonging to this pet's owner
      $q = $conn->prepare("SELECT appointment.appointmentID, pet.petID, pet.petName FROM appointment INNER JOIN petappointment ON appointment.appointmentID = petappointment.appointmentID INNER JOIN pet ON petappointment.petID = pet.petID WHERE appointment.petOwner = :id");
      // replace the placeholder with the person type
      $q->bindParam(':id',$id);
      $q->execute();
      return $q->fetchAll();
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
?>