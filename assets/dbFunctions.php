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
  dbConnect();
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
?>