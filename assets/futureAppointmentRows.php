<?php
require 'dbFunctions.php';
class FutureTableRows extends RecursiveIteratorIterator {
  function __construct($it) {
    parent::__construct($it, self::LEAVES_ONLY);
  }

  function current() {
    if(pathinfo($_SERVER['REQUEST_URI'])['filename'] == 'index'){
      // have edit appt button
      if(parent::key() == 'appointmentID'){
        $rowAppointmentID = parent::current();
        // this is a future appointment, so display the edit appt button in addition to the list of pets
        $petsArray = getPetsByAppointmentID($rowAppointmentID);
        $petData = "<td style='width:150px;border:1px solid black;'>";
        for($x=0;$x<count($petsArray);$x++){
          $id = $petsArray[$x]['petID'];
          $petData = $petData . getPetNameByPetID($id) . " (" . getSpeciesByPetID($id) . ")";
        }
        $petData = $petData . "</td>";
        return "$petData<form action='editappointment.php' method='post' id='editAppointment'><input type='hidden' name='appointmentID' value='".$rowAppointmentID."'>
        <td style='width:150px;border:1px solid black;'> <center><button class='btn btn-outline-primary' type='submit'>Edit Appointment</button></center></form></td>"; 
      }else{
        // just return the data
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
      }
    }

    function beginChildren() {
      echo "<tr>";
    }

    function endChildren() {
      echo "</tr>" . "\n";
    }
  }
?>