<?php
// gotta define a const to get person type cuz for some reason it won't let me use $personType in the TableRows class
// same goes for $futureAppointments
define('PERSON_TYPE', $personType);
class TableRows extends RecursiveIteratorIterator {
  function __construct($it) {
    parent::__construct($it, self::LEAVES_ONLY);
  }

  function current() {
    if(pathinfo($_SERVER['REQUEST_URI'])['filename'] == 'editreview' && !(parent::key() == 'appointmentID')){
      // when we're on editreview.php, only display info when the current attribute is NOT appointmentID
      return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }else if(pathinfo($_SERVER['REQUEST_URI'])['filename'] == 'index'){
      // either have edit review or edit appt button depending on user type and if it's a future or past appt
      if(parent::key() == 'appointmentID'){
        $rowAppointmentID = parent::current();
        // don't actually display the appointment id, just save it for later in case they want to change the review
        return "<form action='editreview.php' method='post' id='editReview'><input type='hidden' name='appointmentID' value='".$rowAppointmentID."'>";
      }else if (parent::key() == 'reviewText' && PERSON_TYPE == '1'){
        // return the data plus a button to change the review
        return "<td style='width:150px;border:1px solid black;'> <center><button class='btn btn-outline-primary' type='submit' >Edit Review</button></center></form>" . parent::current(). "</td>";
      }else{
        // just return the data
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
      }
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