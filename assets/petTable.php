<?php
// get what page we're on, since only acctinfo has the edit pet option
<<<<<<< HEAD
$page = pathinfo($_SERVER['REQUEST_URI'])['filename'];

$ownerEmail = '';

if($personType == 3){
  // include pet owner info in table (fname, lname, email)
  $ownerEmail = '<th>Pet Owner Email</th>';
}
if($page == 'acctinfo'){
  // display on the left, have a '(My) Pets' header, and have a 'Customize' column
  echo "<div class ='fleft'>";
  $my = '';

  // just say Pets when admin is logged in, otherwise have My Pets
  if($personType == '1'){
    $my = 'My ';
  }
  echo "<h2>".$my."Pets</h2>";

  //display create pet button if we're on acctinfo page
  echo "<a href='createpet.php'><button type='button' class='btn btn-outline-primary'>Add New Pet</button></a><br><br>";

  $lastCol = '<th>Customize</th>';
}else{
  // we're on edit pet, so don't have 'My Pets' header and leave div centered
  echo "<div>";
  $lastCol = '';
}

echo "<center><table style='border: solid 1px black;'>";
echo $ownerEmail."<th>Pet Name</th> <th>Species</th> <th>Requirements</th>".$lastCol."</tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
      parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
      $curVal = parent::current();
      if(parent::key() == 'species'){
        /* convert from int to species such that:
         * 1 = dog
         * 2 = cat
         * 3 = fish
         * 4 = bird
         * 5 = monkey
         * 6 = other
         */
        switch($curVal){
          case '1':
            $curVal = 'Dog';
            break;
          case '2':
            $curVal = 'Cat';
            break;
          case '3':
            $curVal = 'Fish';
            break;
          case '4':
            $curVal = 'Bird';
            break;
          case '5':
            $curVal = 'Monkey';
            break;
          default:
            $curVal = 'Other';
            break;
        }
      }else if(parent::key() == 'petID'){
        // display a button that lets you edit the pet and pass along the petID to the next page
        $petID = parent::current();
        return "<form action='editpet.php' method='post' id='editPet'><input type='hidden' name='petID' value='".$petID."'>
        <td style='width:150px;border:1px solid black;'> <center><button class='btn btn-outline-primary' type='submit' >Edit Pet</button></center></form></td>";
      }
      return "<td style='width:150px;border:1px solid black;'>" . $curVal. "</td>";
    }

    function beginChildren() {
      echo "<tr>";
    }

    function endChildren() {
      echo "</tr>" . "\n";
    }
}

// get info from db to display in table
try {
  if($page == 'acctinfo' && $personType == 3){
    // query to get all pets
    $q = $conn->prepare("SELECT person.email, pet.petName, pet.species, pet.requirements, pet.petID 
    FROM pet INNER JOIN person ON pet.personID = person.personID");
  }else if($page == 'editpet' && $personType == 3){
    // query to get all pets
    $q = $conn->prepare("SELECT person.email, pet.petName, pet.species, pet.requirements
    FROM pet INNER JOIN person ON pet.personID = person.personID WHERE petID = :petID");
    // replace the placeholder with the petID
    $q->bindParam('petID',$petID);
  }else if($page == 'acctinfo'){
    // query to get all pets for the user
    $q = $conn->prepare("SELECT petName, species, requirements, petID FROM pet WHERE personID = :personID");
    // replace the placeholder with the personID
    $q->bindParam(':personID',$personID);
  }else{
    // query to get the info for one pet
    $q = $conn->prepare("SELECT petName, species, requirements FROM pet WHERE petID = :petID");
    // replace the placeholder with the petID
    $q->bindParam('petID',$petID);
  }
  // do the sql query and store the result in an array
  $q->execute();
    
  $result = $q->setFetchMode(PDO::FETCH_ASSOC);
  foreach(new TableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
    echo $v;
  }
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
echo "</table> </center>";
if($page == 'acctinfo'){
  echo "</div>";
}

=======
  $page = pathinfo($_SERVER['REQUEST_URI'])['filename'];

  $ownerEmail = '';

  if($personType == 3){
    // include pet owner info in table (fname, lname, email)
    $ownerEmail = '<th>Pet Owner Email</th>';
  }
  if($page == 'acctinfo'){
    // display on the left, have a '(My) Pets' header, and have a 'Customize' column
    echo "<div class ='fleft'>";
    $my = '';

    // just say Pets when admin is logged in, otherwise have My Pets
    if($personType == '1'){
      $my = 'My ';
    }
    echo "<h2>".$my."Pets</h2>";

    //display create pet button if we're on acctinfo page
    echo "<a href='createpet.php'><button type='button' class='btn btn-outline-primary'>Add New Pet</button></a><br><br>";

    $lastCol = '<th>Customize</th>';
  }else{
    // we're on edit pet, so don't have 'My Pets' header and leave div centered
    echo "<div>";
    $lastCol = '';
  }

  echo "<center><table style='border: solid 1px black;'>";
  echo $ownerEmail."<th>Pet Name</th> <th>Species</th> <th>Requirements</th>".$lastCol."</tr>";

  class TableRows extends RecursiveIteratorIterator {
      function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
      }

      function current() {
        $curVal = parent::current();
        $page = pathinfo($_SERVER['REQUEST_URI'])['filename'];
        if(parent::key() == 'species'){
          /* convert from int to species such that:
          * 1 = dog
          * 2 = cat
          * 3 = fish
          * 4 = bird
          * 5 = monkey
          * 6 = other
          */
          switch($curVal){
            case '1':
              $curVal = 'Dog';
              break;
            case '2':
              $curVal = 'Cat';
              break;
            case '3':
              $curVal = 'Fish';
              break;
            case '4':
              $curVal = 'Bird';
              break;
            case '5':
              $curVal = 'Monkey';
              break;
            default:
              $curVal = 'Other';
              break;
          }
        }else if(parent::key() == 'petID' && $page == 'acctinfo'){
          // display a button that lets you edit the pet and pass along the petID to the next page
          $petID = parent::current();
          return "<form action='editpet.php' method='post' id='editPet'><input type='hidden' name='petID' value='".$petID."'>
          <td style='width:150px;border:1px solid black;'> <center><button class='btn btn-outline-primary' type='submit' >Edit Pet</button></center></form></td>";
        }else if(parent::key() == 'petID'){
          // we're on editpet, so we don't want to display anything
          return;
        }
        return "<td style='width:150px;border:1px solid black;'>" . $curVal. "</td>";
      }

      function beginChildren() {
        echo "<tr>";
      }

      function endChildren() {
        echo "</tr>" . "\n";
      }
  }

  // get info from db to display in table
  try {
    if($page == 'acctinfo' && $personType == 3){
      // query to get all pets
      $q = $conn->prepare("SELECT * FROM petAndOwner");
    }else if($page == 'editpet' && $personType == 3){
      // query to get all pets
      $q = $conn->prepare("SELECT * FROM petAndOwner WHERE petID = :petID");
      // replace the placeholder with the petID
      $q->bindParam('petID',$petID);
    }else if($page == 'acctinfo'){
      // query to get all pets for the user
      $q = $conn->prepare("SELECT petName, species, requirements, petID FROM pet WHERE personID = :personID");
      // replace the placeholder with the personID
      $q->bindParam(':personID',$personID);
    }else{
      // query to get the info for one pet
      $q = $conn->prepare("SELECT petName, species, requirements FROM pet WHERE petID = :petID");
      // replace the placeholder with the petID
      $q->bindParam('petID',$petID);
    }
    // do the sql query and store the result in an array
    $q->execute();
      
    $result = $q->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
      echo $v;
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  echo "</table> </center>";
  if($page == 'acctinfo'){
    echo "</div>";
  }
>>>>>>> 87b15fdce0ad825c71155f3b2dc530affd488354
?>