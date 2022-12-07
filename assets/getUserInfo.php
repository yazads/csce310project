<?php
/* Get general info about our current user */
if(isset($_POST['email'])){
  $email = $_POST['email'];
    
  // if not set, set session var email to the user's email (otherwise refresh breaks the page)
  if(!isset($_SESSION[ 'email'])){
    $_SESSION[ 'email' ] = $email;
  }
}else{
  $email = $_SESSION[ 'email' ];
}

// query db for persontype, personID, and full name associated with the email
try{
  // prepare the query
  $q = $conn->prepare("SELECT personID, personFName, personLName, passphrase, personType, phone, streetAddress, city, USState, zipCode FROM PERSON USE INDEX(personEmail) WHERE email = :email");
  // replace the placeholder with the email
  $q->bindParam(':email',$email);
  // do the sql query and store the result in an array
  $q->execute();
  $result = $q->fetch();

  // check that we got the id and name then save them to use later
  if(isset($result['personID']) && isset($result['personFName']) && isset($result['personLName']) && isset($result['passphrase']) && isset($result['personType']) && isset($result['phone']) && isset($result['streetAddress']) && isset($result['city']) && isset($result['USState']) && isset($result['zipCode'])){
    $personID = $result['personID'];
    $personFName = $result['personFName'];
    $personLName = $result['personLName'];
    $passphrase = $result['passphrase'];
    $personType = $result['personType'];
    $phone = $result['phone'];
    $streetAddress = $result['streetAddress'];
    $city = $result['city'];
    $usState = $result['USState'];
    $zipCode = $result['zipCode'];
  }
}catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
?>