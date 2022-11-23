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
    <title>Pet Sitting 2.0 | Sign Up</title>
  </head>
  <body>
    <?php
        session_start();
    ?>
    <div style="margin-top:1%; margin-left:95%;">
        <a href="login.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
    </div>    
    <div>
        <h1 style="text-align:center; margin-bottom:5%;"> Pet Sitting 2.0 Sign Up!</h1>
    </div>
    <div style="margin-right:30%; margin-left:30%;">
    <form action="index.php" method="post">
        <div class="input-group mb-3">
            <span class="input-group-text">First and Last name</span>
            <input type="text" placeholder="First Name" aria-label="First name" class="form-control" name="fname">
            <input type="text" placeholder="Last Name" aria-label="Last name" class="form-control" name="lname">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Email Address</span>
            <input type="text" class="form-control" placeholder="Email" aria-label="E-mail_Address@example.com" aria-describedby="basic-addon1" name="email">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Phone Number</span>
            <input type="text" class="form-control" placeholder="123-456-7890" aria-label="Phone" aria-describedby="basic-addon1" name="phone">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">Address</span>
            <input type="text" placeholder="1234 Street Road apt 567" aria-label="Address" class="form-control" name="street">
            <input type="text" placeholder="City" aria-label="City" class="form-control" name="city">
            <input type="text" placeholder="State" aria-label="State" class="form-control" name="state">
            <input type="text" placeholder="Zip Code" aria-label="Zip" class="form-control" name="zip">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Username</span>
            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Password</span>
            <input type="password" class="form-control" placeholder="Password" aria-label="PW" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Confirm Password</span>
            <input type="password" class="form-control" placeholder="Confirm Password" aria-label="Confirm" aria-describedby="basic-addon1">
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="1" checked>
            <label class="form-check-label" for="exampleRadios1">
                I am a Pet Owner
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type" id="exampleRadios2" value="2">
            <label class="form-check-label" for="exampleRadios2">
                I am a Pet Sitter
            </label>
        </div>
        <center><button type="submit" class="btn btn-outline-primary">Sign Up</button></a></center>
    </form>
    </div>
    <?php 
    // note that we need to add to database when we get to index.php
    $_SESSION[ 'newUser' ] = TRUE;
    // unset email session var
    unset($_SESSION[ 'email' ]);
    ?>
  </body>
</html>