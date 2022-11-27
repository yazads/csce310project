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
    <title>Pet Stop | Login</title>
  </head>
  <body>
  <?php
      session_start();
  ?>
    <div>
        <center style="margin-top:3%; margin-bottom:3%;"> <img src="Pet_Stop.png" alt="Logo" width="250" height="250" class="d-inline-block align-text-top" style="border-radius: 40px;"> </center>
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
      <center style="margin-bottom:10px;"><a href="index.php"><button type="Submit" class="btn btn-outline-primary">Log In</button></a></center>
</form>
<?php 
    // note that we don't need to add to database when we get to index.php
    $_SESSION[ 'newUser' ] = FALSE;
    // unset email session var
    unset($_SESSION[ 'email' ]);
?>
      <div>
        <center><a href="signup.php"><button type="button" class="btn btn-outline-primary">Don't Have an Account? Sign Up!</button></a></center>
      </div>
  </body>
</html>