<?php
  $page = pathinfo($_SERVER['REQUEST_URI'])['filename'];
  if($page == 'selectappointment'){
      $appts = getAllApptIDs();
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

  function getAllApptIDs() {
    require 'dbConnect.php';
      try {
        // query db for email belonging to this pet's owner
        $q = $conn->prepare("SELECT * FROM appointment INNER JOIN petAppointment ON appointment.appointmentID = petAppointment.appointmentID INNER JOIN pet ON pet.petID = petAppointment.petID WHERE appointment.petSitter IS NULL");
        $q->execute();
        return $q->fetchAll();
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
  }
?>