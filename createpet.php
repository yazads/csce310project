<?php
require 'assets/sessionStart.php';

// connect to petsitting db
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

require 'assets/getUserInfo.php';
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
        <title>Pet Stop | Add Pet</title>
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
            <h1 style="text-align:center; margin-bottom:5%;"> New Pet </h1>
        </div>
        <div style="margin-right:30%; margin-left:30%;">
            <form action="acctinfo.php" method="post">
                <div class="input-group mb-3">
                    <span class="input-group-text">Pet Name</span>
                    <input type="text" placeholder="Shadow" aria-label="Pet Name" class="form-control" name="petname">
                </div>

                <div class="input-group">
                    <span class="input-group-text">Requirements</span>
                    <textarea class="form-control" placeholder="Food, Walks, Medicine, etc." aria-label="With textarea" name="requirements"></textarea>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="species" id="flexRadioDefault1" value="1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Dog
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="species" id="flexRadioDefault2" value="2">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Cat
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="species" id="flexRadioDefault3" value="3">
                        <label class="form-check-label" for="flexRadioDefault3">
                            Fish
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="species" id="flexRadioDefault4" value="4">
                        <label class="form-check-label" for="flexRadioDefault4">
                            Bird
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="species" id="flexRadioDefault5" value="5">
                        <label class="form-check-label" for="flexRadioDefault5">
                            Monkey
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="species" id="flexRadioDefault6" value="6">
                        <label class="form-check-label" for="flexRadioDefault6">
                            Other (Identify in Requirements)
                        </label>
                </div>
                <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;">Create New Pet</button></a></center>
            </form>
        </div>
        <?php 
            // note that we need to add to database when we get back
            $_SESSION[ 'newPet' ] = TRUE;
        ?>
    </body>
</html>