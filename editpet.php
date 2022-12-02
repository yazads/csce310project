<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petSitting";
$newUser = $_SESSION[ 'newUser' ];
$newPet = $_SESSION[ 'newPet' ];

// connect to petsitting db
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

require 'assets/getUserInfo.php';

// get petID passed on from previous page
if(isset($_POST['petID'])){
  $petID = $_POST['petID'];
      
  // if not set, set session var petID to the petID (otherwise refresh breaks the page)
  if(!isset($_SESSION[ 'petID'])){
    $_SESSION[ 'petID' ] = $petID;
  }
}else{
  $petID = $_SESSION[ 'petID' ];
}  

// get pet's requirements from db
try{
  // use a prepared statement for the query
  $q = $conn->prepare("SELECT petName, species, requirements FROM pet WHERE petID = :petID");
  // replace the placeholder with the petID
  $q->bindParam(':petID',$petID);
  // run the query and store the result
  $q->execute();
  $result = $q->fetch();
      
  // check that we got petName, species, and requirements columns and save their contents for later
  if(isset($result['petName']) && isset($result['species']) && isset($result['requirements'])){
    $petName = $result['petName'];
    $species = $result['species'];
    $requirements = $result['requirements'];
  }else{
    $petName = $species = $requirements = "";
  }
}catch(PDOException $e){
  echo $sql . "<br>" . $e->getMessage();
}
?>

<script>
// prevent resubmission of form on refresh
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
</script>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <!-- Bootstrap CSS -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
            integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
            crossorigin="anonymous"
        />
        <title>Pet Stop | Edit Pet</title>
        <link rel="icon" type="image/x-icon" href="assets/DogHouse.png">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
        <style>
        <?php include 'styles/acctinfo.css'; ?>
        </style>
    </head>
    <body style="background-color:#FAE8E0">
        <div>
        <?php require 'assets/navbar.php' ?>
        <div style="margin-top:1%; margin-left:95%;">
            <a href="acctinfo.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
        </div>    
        <div>
        <div>
            <h1 style="text-align:center; margin-bottom:5%;"> Edit Pet </h1>
        </div>
        <div style="margin-right:30%; margin-left:30%;">
        <!-- Table of pet details to give user a frame of reference for which pet they're editing -->
        <?php
        echo "<center><table style='border: solid 1px black;'>";
        echo "<th>Pet Name</th><th> Species</th><th> Requirements</th></tr>";

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
        try {
          // get appointment information from database
          $q = $conn->prepare("SELECT petName, species, requirements FROM pet WHERE petID = :petID");
        
          // replace the placeholder with the petID
          $q->bindParam('petID',$petID);

          // do the sql query and store the result in an array
          $q->execute();
                
          $result = $q->setFetchMode(PDO::FETCH_ASSOC);
          foreach(new TableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
            echo $v;
          }
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
        echo "</table></center>";
        ?>
        <br><br>
            <!-- Form for user to edit their pet -->
            <form action="acctinfo.php" method="post">
                <div class="input-group mb-3">
                    <span class="input-group-text">Pet Name</span>
                    <input type="text" <?php echo "value=".$petName; ?> aria-label="Pet Name" class="form-control" name="newPetName">
                </div>

                <div class="input-group">
                    <span class="input-group-text">Requirements</span>
                    <?php
                    echo "<input type='hidden' name='petID' value='".$petID."'>";
                    echo "<textarea class='form-control' aria-label='With textarea' name='newRequirements'>".$requirements."</textarea>";
                    ?>
                </div>
                <br>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="newSpecies" id="flexRadioDefault1" value="1" <?php if($species == 1) echo "checked='true'";?>>
                        <label class="form-check-label" for="flexRadioDefault1">
                            Dog
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="newSpecies" id="flexRadioDefault2" value="2" <?php if($species == 2) echo "checked='true'";?>>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Cat
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="newSpecies" id="flexRadioDefault3" value="3" <?php if($species == 3) echo "checked='true'";?>>
                        <label class="form-check-label" for="flexRadioDefault3">
                            Fish
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="newSpecies" id="flexRadioDefault4" value="4" <?php if($species == 4) echo "checked='true'";?>>
                        <label class="form-check-label" for="flexRadioDefault4">
                            Bird
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="newSpecies" id="flexRadioDefault5" value="5" <?php if($species == 5) echo "checked='true'";?>>
                        <label class="form-check-label" for="flexRadioDefault5">
                            Monkey
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="newSpecies" id="flexRadioDefault6" value="6" <?php if($species == 6) echo "checked='true'";?>>
                        <label class="form-check-label" for="flexRadioDefault6">
                            Other (Identify in Requirements)
                        </label>
                </div>
                <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;" name='updatePet'>Update Pet</button></a></center>
                <br>
                <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;background-color:red" name='deletePet'>Delete Pet</button></a></center>
            </form>
        </div>
        <?php 
            // note that we need to update database when we get back
            $_SESSION[ 'editPet' ] = TRUE;
        ?>
    </body>
</html>