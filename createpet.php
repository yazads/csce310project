<?php
require 'assets/sessionStart.php';
require 'assets/getUserInfo.php';
require 'assets/head.php';
require 'assets/navbar.php';
?>
        <div style="margin-top:1%; margin-left:95%;">
            <a href="acctinfo.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
        </div>    
        <div>
            <h1 style="text-align:center; margin-bottom:5%;"> New Pet </h1>
        </div>
        <div style="margin-right:30%; margin-left:30%;">
            <form action="acctinfo.php" method="post">
                <?php require 'assets/emailDropDown.php'?>
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