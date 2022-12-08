<?php
  require 'assets/sessionStart.php';
  require 'assets/getUserInfo.php';
  require 'assets/head.php';
  require 'assets/navbar.php';

  // get appointmentID passed on from previous page
  if(isset($_POST['appointmentID'])){
    $appointmentID = $_POST['appointmentID'];
      
    // if not set, set session var appointmentID to the appointmentID (otherwise refresh breaks the page)
    if(!isset($_SESSION[ 'appointmentID'])){
      $_SESSION[ 'appointmentID' ] = $appointmentID;
    }
  }else{
    $appointmentID = $_SESSION[ 'appointmentID' ];
  }

  // get review text from db
  try{
    // use a prepared statement for the query
    $q = $conn->prepare("SELECT reviewText FROM review WHERE appointmentID = :appointmentID");
    // replace the placeholder with the appointmentID
    $q->bindParam(':appointmentID',$appointmentID);
    // run the query and store the result
    $q->execute();
    $result = $q->fetch();
      
    // check that we got a 'reviewText' column and save its contents for later
    if(isset($result['reviewText'])){
      $reviewText = $result['reviewText'];
    }else{
      $reviewText = "";
    }
  }catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
  }
?>

<!DOCTYPE html>
  <div style="margin-top:1%; margin-left:95%;">
    <a href="index.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
  </div>
  <div class = "wrap">
    <!-- display appointment details to give the user a frame of reference for what to write in their review -->
    <h2> Appointment Details </h2>
    <!-- form to update review -->
    <form method='post' action='index.php'>
    <?php
      $futureAppointments = FALSE;
      require 'assets/appointmentTable2.php';
    ?>
      <h2><label for="newReviewText">Type New Review:</label></h2>
      
      <?php 
        echo "<textarea id='newReviewText' name='newReviewText' rows='4' cols='50'>". $reviewText."</textarea>";
        echo "<input type='hidden' name='appointmentID' value='".$appointmentID."'>";
        // note that we need to add to database when we get to index.php
        $_SESSION['newReview'] = TRUE;
      ?>

      <br></br>
      <center><button class='btn btn-outline-primary' type='submit' name = 'updateReview'>Update Review</button></center>
      <br></br>
      <center><button class='btn btn-outline-danger' type='submit' name = 'deleteReview'>Delete Review</button></center>
    </form>
  </div>
</html>