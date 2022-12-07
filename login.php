<?php
    session_start();
    require 'assets/head.php';
?>
<html>
    <center style="margin-top:3%; margin-bottom:3%;"> <img src="assets/Pet_Stop.png" alt="Logo" width="250" height="250" class="d-inline-block align-text-top" style="border-radius: 40px;"> </center>
    <div style="margin-right:30%; margin-left:30%;">
        <form action="index.php" method="post">
            <div class="input-group mb-3" >
                <span class="input-group-text" id="basic-addon1">Email</span>
                <input type="text" class="form-control" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1" name="email" required>
            </div>
        
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Password</span>
                <input type="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1" name="pass" required>
            </div>      
        <center style="margin-bottom:10px;"><a href="index.php"><button type="Submit" class="btn btn-outline-primary">Log In</button></a></center>
    </form>
    <?php 
        // note that we don't need to add to database when we get to index.php
        $_SESSION[ 'newUser' ] = FALSE;
        $_SESSION[ 'newPet' ] = FALSE;
        $_SESSION['editPet'] = FALSE;
        $_SESSION['newReview'] = FALSE;
        $_SESSION['comeFromLogin'] = TRUE;

        // unset email session var
        unset($_SESSION[ 'email' ]);
    ?>
    <div>
        <center><a href="signup.php"><button type="button" class="btn btn-outline-primary">Don't Have an Account? Sign Up!</button></a></center>
    </div>
</html>