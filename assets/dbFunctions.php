<?php
  /* connect to the db */
  function dbConnect($conn){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "petSitting";

    // connect to petsitting db
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  /* get all emails with personType $t */ 
  function getEmailsByPersonType($t){
    // connect to the db
    dbConnect($conn);
    try{
      // query db for emails belonging to all people with person type $personType
      $q = $conn->prepare("SELECT email FROM person WHERE personType = :personType");
      // replace the placeholder with the person type
      $q->bindParam(':personType',$t);
      $q->execute();
      return $q->fetchAll();
    }catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }  
  }


  /* get the email associated with a pet's owner */ 
  function getPetOwnerEmailByPetID($id){
    // connect to the db
    dbConnect();
    try{
      // query db for email belonging to this pet's owner
      $q = $conn->prepare("SELECT email FROM person INNER JOIN pet ON pet.personID = person.personID WHERE pet.petID = :id");
      // replace the placeholder with the person type
      $q->bindParam(':id',$id);
      $q->execute();
      return $q->fetch();
    }catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

/* get the personID associated with an email */ 
function getPersonIDByEmail($email){
  // get the personID associated with the email
  try{
    require 'dbConnect.php';
    // use a prepared statement for the query to stop sql injections
    $q = $conn->prepare('SELECT personID FROM person WHERE email = :email');
    // replace the placeholder
    $q->bindParam(':email',$email);
    // do the sql query
    $q->execute();

    // store the result
    $result = $q->fetch();

    // only return personID if it exists, otherwise we get an annoying error
    if(isset($result['personID'])){
      return $result['personID'];
    }else{
      // return 0 if no personID so nothing breaks
      return '0';
    }
  }catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
}


/* get pets associated with an appointment */
function getPetsByAppointmentID($id){
  // connect to db
  require 'dbConnect.php';
  try{
    $q = $conn->prepare("SELECT petID FROM petAppointment WHERE appointmentID = :id");
    // replace the placeholder
    $q->bindParam(':id',$id);
    // do the sql query
    $q->execute();
    $result = $q->fetchAll();
    return $result;

  }catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }

}

/* get petname associated with petID */
function getPetNameByPetID($id){
  //connect to db
  require 'dbConnect.php';
  try{
    $q = $conn->prepare("SELECT petName FROM pet WHERE petID = :id");
    // replace the placeholder
    $q->bindParam(':id',$id);
    // do the sql query
    $q->execute();
    // store the result
    $result = $q->fetch();

    // only return petname if it exists, otherwise we get an annoying error
    if(isset($result['petName'])){
      return $result['petName'];
    }else{
      // return 'rover' if nothing so nothing breaks
      return 'rover';
    }
  }catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
}

/* get the species for a pet based on their pet id */
function getSpeciesByPetID($id){
  //connect to db
  require 'dbConnect.php';
  try{
    $q = $conn->prepare("SELECT species FROM pet WHERE petID = :id");
    // replace the placeholder
    $q->bindParam(':id',$id);
    // do the sql query
    $q->execute();
    // store the result
    $result = $q->fetch();
    // only return species if it exists, otherwise we get an annoying error
    if(isset($result['species'])){
      if($result['species'] == 1){
        return 'Dog';
      }else if($result['species'] == 2){
        return 'Cat';
      }else if($result['species'] == 3){
        return 'Fish';
      }else if($result['species'] == 4){
        return 'Bird';
      }else if($result['species'] == 5){
        return 'Monkey';
      }else{
        return 'Other';
      }
    }else{
      // return 'Unknown' if nothing so nothing breaks
      return 'Unknown';
    }
  }catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
}
?>