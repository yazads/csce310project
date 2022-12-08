<?php
// get the page we're on
$page = pathinfo($_SERVER['REQUEST_URI'])['filename'];

/* set up basic table structure */
echo "<center><table style='border: solid 1px black;'>";

// show pet sitter info for persontypes 1 & 3 and pet owner info for persontypes 2 & 3
$peopleCols = '';
switch($personType){
  case '1':
    $peopleCols = "<th>Pet Sitter First Name</th><th> Pet Sitter Last Name</th><th> Pet Sitter Email</th>";
    break;
  case '2':
    $peopleCols = "<th>Pet Owner First Name</th><th>Pet Owner Last Name</th><th>Pet Owner Email</th>";
    break;
  default:
   $peopleCols = "<th>Pet Sitter First Name</th><th> Pet Sitter Last Name</th><th> Pet Sitter Email</th> <th>Pet Owner First Name</th><th>Pet Owner Last Name</th><th>Pet Owner Email</th>";
}

// only show reviews for past appts
$reviewCol = '';
$editApptCol = '';
$reviewButton = FALSE;
if(!$futureAppointments){
  $reviewCol = "<th>Review</th>";

  // only have review button when on index and not a pet sitter
  if($page == 'index' && $personType != 2){
    $reviewButton = TRUE;
  }
}else{
  // only show edit appt col for future appts
  $editApptCol = "<th>Customize</th>";
}

echo "<tr>".$peopleCols."<th>Start Time</th> <th>Duration (hours) </th> <th>Pets</th>".$reviewCol.$editApptCol."</tr>";

/* query db */
require 'dbConnect.php';
try{
  if($page == 'index'){
    // if on index, get all the appts
    if($personType == 1){
      // query where ownerEmail = email
      if(!$futureAppointments){
        // query where startTime <= now and select reviewText
        $q = $conn->prepare("SELECT sitterFName, sitterLName, sitterEmail, startTime, duration, appointmentID, reviewText 
        FROM appointmentView WHERE ownerEmail = :email AND DATE(startTime) <= CURDATE() ORDER BY startTime ASC");
      }else{
        // query where startTime > now
        $q = $conn->prepare("SELECT sitterFName, sitterLName, sitterEmail, startTime, duration, appointmentID 
        FROM appointmentView WHERE ownerEmail = :email AND DATE(startTime) > CURDATE() ORDER BY startTime ASC");
      }
      // replace the placeholder with the email
      $q->bindParam(':email',$email);
    }else if($personType == 2){
      // query where sitterEmail = email
      if(!$futureAppointments){
        // query where startTime <= now and select reviewText
        $q = $conn->prepare("SELECT ownerFName, ownerLName, ownerEmail, startTime, duration, appointmentID, reviewText 
        FROM appointmentView WHERE sitterEmail = :email AND DATE(startTime) <= CURDATE() ORDER BY startTime ASC");
      }else{
        // query where startTime > now
        $q = $conn->prepare("SELECT ownerFName, ownerLName, ownerEmail, startTime, duration, appointmentID
        FROM appointmentView WHERE sitterEmail = :email AND DATE(startTime) > CURDATE() ORDER BY startTime ASC");
      }
      // replace the placeholder with the email
      $q->bindParam(':email',$email);
    }else{
      // don't use where in query
      if(!$futureAppointments){
        // query where startTime <= now and select reviewText
        $q = $conn->prepare("SELECT * FROM appointmentView WHERE DATE(startTime) <= CURDATE() ORDER BY startTime ASC");
      }else{
        // query where startTime > now
        $q = $conn->prepare("SELECT sitterFName, sitterLName, sitterEmail, ownerFName, ownerLName, ownerEmail, startTime, duration, appointmentID FROM appointmentView WHERE DATE(startTime) > CURDATE() ORDER BY startTime ASC");
      }
    }
  }else if($page == 'editreview'){
    // just get the one appointment
    if($personType == 1){
      // only need to get sitter info
      $q = $conn->prepare("SELECT ownerFName, ownerLName, ownerEmail, startTime, duration, appointmentID, reviewText 
        FROM appointmentView WHERE appointmentID = :appointmentID AND DATE(startTime) <= CURDATE() ORDER BY startTime ASC");
    }else{
      // need to get both sitter and owner info
      $q = $conn->prepare("SELECT * FROM appointmentView WHERE appointmentID = :appointmentID AND DATE(startTime) <= CURDATE() ORDER BY startTime ASC");
    }
    // replace the placeholder with the appointmentID
    $q->bindParam(':appointmentID',$appointmentID);
  }
  
  // do the sql query and store the result in an array
  $q->execute();
  $apptResult = $q->setFetchMode(PDO::FETCH_ASSOC);
  $apptResult = $q->fetchAll();

  for($row = 0; $row < count($apptResult); $row++){
    // get the appt info $apptResult's pointer is currently pointed at
    $curRow = current($apptResult);
    // start a new row in the table for this appt
    echo "<tr>";
    // output this row's info depending on the column key

    for($col =  0; $col < count($curRow); $col++){
      // get the attribute name and value $curRow's pointer is currently pointed at
      $curKey = key($curRow);
      $curVal = current($curRow);

      // start a new data item in the table for this attribute
      echo "<td style='width:150px;border:1px solid black;'>";
      if($curKey == 'appointmentID'){
        $apptID = $curVal;
        // store apptid in a hidden form
        echo "<form action='editappointment.php' method='post' id='editReview'>";
        echo "<input type='hidden' name='appointmentID' value='".$apptID."'>";

        // display pet info
        require 'displayPetInfo.php';

        //display edit appt button (if future appt & on index)
        if($futureAppointments && $page == 'index'){
          echo "</td><td style='width:150px;border:1px solid black;'> <center><button class='btn btn-outline-primary' type='submit'>Edit Appointment</button></center></form>";
        }
      }else if($curKey == 'reviewText'){
        // display edit review button (if on index & not pet sitter)
        if($reviewButton){
          echo "<center><button class='btn btn-outline-primary' type='submit' >Edit Review</button></center></form>";
        }
        echo $curVal;
      }else{
        // just display attribute info
        echo $curVal;
      }
      // close the data item and advance the $curRow pointer to the next attribute in the array
      echo "</td>";
      next($curRow);
    }
    // close the table row and advance the $apptResult pointer to the next appointment in the array
    echo "</tr>";
    next($apptResult);
  }
}catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

echo "</table></center>";

?>