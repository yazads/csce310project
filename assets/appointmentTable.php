<?php
<<<<<<< HEAD
// get what page we're on, since only edit review doesn't have a button
$page = pathinfo($_SERVER['REQUEST_URI'])['filename'];

echo "<center><table style='border: solid 1px black;'>";

if($futureAppointments){
  // only have customize column show when displaying future appts
  $lastCol = '<th>Customize</th>';
}else{
  // only have review column show when displaying past appts
  $lastCol = '<th>Review</th>';
}

if($personType == 1){
  echo "<th>Pet Sitter First Name</th><th> Pet Sitter Last Name</th><th> Pet Sitter Email</th><th>Start Time</th> <th>Duration (hours) </th>".$lastCol."</tr>";
}else if($personType == 2){
  echo "<tr><th>Pet Owner First Name</th><th>Pet Owner Last Name</th><th>Pet Owner Email</th><th>Start Time</th> <th>Duration (hours) </th>".$lastCol."</tr>";
} else if($personType == 3) {
  echo "<th>Pet Sitter First Name</th><th> Pet Sitter Last Name</th><th> Pet Sitter Email</th><th>Start Time</th> <th>Duration (hours) </th>".$lastCol."</tr>";
}

// have to define the class that displays rows in another file, otherwise we get an error on index.php for defining the class twice
if($futureAppointments){
  require_once('futureAppointmentRows.php');
}else{
  require_once('pastAppointmentRows.php');
}


try {
  // get appointment information from database
  if($page == 'index'){
    // get all the appts for the user
    if($personType == 1){
      // this is a pet owner
      if($futureAppointments){
        // query for appts with dates >= right now
        $q = $conn->prepare("SELECT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, appointment.appointmentID
        FROM (appointment
        INNER JOIN person ON appointment.petOwner = person.personID) 
        WHERE appointment.petOwner = :personID AND DATE(startTime) >= CURDATE() ORDER BY startTime ASC");
      }else{
        // query for appts with dates < right now
        $q = $conn->prepare("SELECT DISTINCT appointment.appointmentID, person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
        FROM ((appointment
        INNER JOIN person ON appointment.petOwner = person.personID) 
        LEFT JOIN review ON review.appointmentID = appointment.appointmentID)
        WHERE person.personID = :personID AND DATE(startTime) < CURDATE() ORDER BY startTime ASC");
      }
    }else if ($personType == 2) {
      // this is a pet sitter
      if($futureAppointments){
        // query for appts with dates >= right now
        $q = $conn->prepare("SELECT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, appointment.appointmentID
        FROM (appointment
        INNER JOIN person ON appointment.petOwner = person.personID)
        WHERE appointment.petSitter = :personID AND DATE(startTime) >= CURDATE() ORDER BY startTime ASC");
      }else{
        // query for appts with dates < right now
        $q = $conn->prepare("SELECT DISTINCT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
        FROM ((appointment
        INNER JOIN person ON appointment.petOwner = person.personID) 
        LEFT JOIN review ON review.appointmentID = appointment.appointmentID)
        WHERE appointment.petSitter = :personID AND DATE(startTime) < CURDATE() ORDER BY startTime ASC");
      }
      #admin tables
    } else {
      if($futureAppointments){
        // query for appts with dates >= right now
        $q = $conn->prepare("SELECT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, appointment.appointmentID
        FROM (appointment
        INNER JOIN person ON appointment.petOwner = person.personID)
        WHERE DATE(startTime) >= CURDATE() ORDER BY startTime ASC");
      }else{
        // query for appts with dates < right now
        $q = $conn->prepare("SELECT DISTINCT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
        FROM ((appointment
        INNER JOIN person ON appointment.petOwner = person.personID) 
        LEFT JOIN review ON review.appointmentID = appointment.appointmentID)
        WHERE DATE(startTime) < CURDATE() ORDER BY startTime ASC");
      }
    }
    // replace the placeholder with the personID
    $q->bindParam(':personID',$personID);
  }else{
    // only get the appt info for this appt
    $q = $conn->prepare("SELECT DISTINCT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
    FROM ((appointment
    INNER JOIN person ON appointment.petOwner = person.personID) 
    LEFT JOIN review ON review.appointmentID = appointment.appointmentID)
    WHERE appointment.appointmentID = :appointmentID AND DATE(startTime) < CURDATE() ORDER BY startTime ASC");

    // replace the placeholder with the appointmentID
    $q->bindParam(':appointmentID',$appointmentID);
  }

  // do the sql query and store the result in an array
  $q->execute();

  // TODO:
  // for each appointment, get the pet list and get info for each pet in list
  $result = $q->setFetchMode(PDO::FETCH_ASSOC);

  // depending if it's future or past appst, use TableRows or FutureTableRows class
  if($futureAppointments){
    foreach(new FutureTableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
      echo $v;
    }
  }else{
    foreach(new TableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
      echo $v;
    }
  }
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
echo "</table></center>";
=======
  // get what page we're on, since only edit review doesn't have a button
  $page = pathinfo($_SERVER['REQUEST_URI'])['filename'];

  echo "<center><table style='border: solid 1px black;'>";

  if($futureAppointments){
    // only have customize column show when displaying future appts
    $lastCol = '<th>Customize</th>';
  }else{
    // only have review column show when displaying past appts
    $lastCol = '<th>Review</th>';
  }

  if($personType == 1){
    echo "<th>Pet Sitter First Name</th><th> Pet Sitter Last Name</th><th> Pet Sitter Email</th><th>Start Time</th> <th>Duration (hours) </th>".$lastCol."</tr>";
  }else if($personType == 2){
    echo "<tr><th>Pet Owner First Name</th><th>Pet Owner Last Name</th><th>Pet Owner Email</th><th>Start Time</th> <th>Duration (hours) </th>".$lastCol."</tr>";
  }

  // have to define the class that displays rows in another file, otherwise we get an error on index.php for defining the class twice
  if($futureAppointments){
    require_once('futureAppointmentRows.php');
  }else{
    require_once('pastAppointmentRows.php');
  }


  try {
    // get appointment information from database
    if($page == 'index'){
      // get all the appts for the user
      if($personType == 1){
        // this is a pet owner
        if($futureAppointments){
          // query for appts with dates >= right now
          $q = $conn->prepare("SELECT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, appointment.appointmentID
          FROM (appointment
          INNER JOIN person ON appointment.petSitter = person.personID) 
          WHERE appointment.petOwner = :personID AND DATE(startTime) >= CURDATE() ORDER BY startTime ASC");
        }else{
          // query for appts with dates < right now
          $q = $conn->prepare("SELECT DISTINCT appointment.appointmentID, person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
          FROM ((appointment
          INNER JOIN person ON appointment.petSitter = person.personID) 
          LEFT JOIN review ON review.appointmentID = appointment.appointmentID)
          WHERE appointment.petOwner = :personID AND DATE(startTime) < CURDATE() ORDER BY startTime ASC");
        }
      }else{
        // this is a pet sitter
        if($futureAppointments){
          // query for appts with dates >= right now
          $q = $conn->prepare("SELECT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, appointment.appointmentID
          FROM (appointment
          INNER JOIN person ON appointment.petOwner = person.personID)
          WHERE appointment.petSitter = :personID AND DATE(startTime) >= CURDATE() ORDER BY startTime ASC");
        }else{
          // query for appts with dates < right now
          $q = $conn->prepare("SELECT DISTINCT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
          FROM ((appointment
          INNER JOIN person ON appointment.petOwner = person.personID) 
          LEFT JOIN review ON review.appointmentID = appointment.appointmentID)
          WHERE appointment.petSitter = :personID AND DATE(startTime) < CURDATE() ORDER BY startTime ASC");
        }
      }

      // replace the placeholder with the personID
      $q->bindParam(':personID',$personID);
    }else{
      // only get the appt info for this appt
      $q = $conn->prepare("SELECT DISTINCT person.personFName, person.personLName, person.email, appointment.startTime, appointment.duration, review.reviewText
      FROM ((appointment
      INNER JOIN person ON appointment.petOwner = person.personID) 
      LEFT JOIN review ON review.appointmentID = appointment.appointmentID)
      WHERE appointment.appointmentID = :appointmentID AND DATE(startTime) < CURDATE() ORDER BY startTime ASC");

      // replace the placeholder with the appointmentID
      $q->bindParam(':appointmentID',$appointmentID);
    }

    // do the sql query and store the result in an array
    $q->execute();

    // TODO:
    // for each appointment, get the pet list and get info for each pet in list
    $result = $q->setFetchMode(PDO::FETCH_ASSOC);

    // depending if it's future or past appst, use TableRows or FutureTableRows class
    if($futureAppointments){
      foreach(new FutureTableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
        echo $v;
      }
    }else{
      foreach(new TableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
        echo $v;
      }
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  echo "</table></center>";
>>>>>>> 87b15fdce0ad825c71155f3b2dc530affd488354
?>