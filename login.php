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
    <title>Pet Sitting 2.0 | Login</title>
  </head>
  <body>
  <?php
      session_start();
  ?>
    <div style="position:relative; margin-top:1%; margin-left:95%;">
        <a href="landing.php">
            <button type="button" class="btn btn-outline-primary">Back</button>
        </a>
    </div>
    <div>
        <h1 style="text-align:center; margin-bottom:5%;"> Pet Sitting 2.0 Login!</h1>
    </div>
    <div style="margin-right:30%; margin-left:30%;">
    <form action="index.php" method="post">
        <div class="input-group mb-3" >
            <span class="input-group-text" id="basic-addon1">Username</span>
            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="email">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Password</span>
            <input type="text" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1">
        </div>
      
    </div>
      <center><a href="index.php"><button type="Submit" class="btn btn-outline-primary">Log In</button></a></center>
</form>
<?php 
    // note that we don't need to add to database when we get to index.php
    $_SESSION[ 'newUser' ] = FALSE;
?>
  </body>
</html>