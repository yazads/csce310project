<?php
require 'assets/sessionStart.php';
require 'assets/getUserInfo.php';
require 'assets/head.php';
require 'assets/navbar.php';

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
        <div style="margin-top:1%; margin-left:95%;">
            <a href="acctinfo.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
        </div>    
        <div>
        <div>
            <h1 style="text-align:center; margin-bottom:5%;"> Edit Pet </h1>
        </div>
        <div style="margin-right:30%; margin-left:30%;">
        <!-- Table of pet details to give user a frame of reference for which pet they're editing -->
        <?php require 'assets/petTable.php'; ?>
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