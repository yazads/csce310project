<?php?>

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
        <title>Pet Stop | Home</title>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
        <style>
        <?php include 'styles/acctinfo.css'; ?>
        </style>
    </head>
    <body style="background-color:#FAE8E0">
        <div>
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid" >
                <a class="navbar-brand" href="index.php" style="font-size:32px; color:#FAE8E0;">
                    <img src="assets/DogHouse.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top logo">
                    <strong>Pet Stop</strong>
                </a>
                <span class="dropdown" style="padding-right:1%;">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $personFName; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="margin-right:10%;">
                    <li><a class="dropdown-item" href="index.php">Home</a></li>
                    <li><a class="dropdown-item" href="acctinfo.php">Account Info</a></li>
                    <li><a class="dropdown-item" href="#">Something else</a></li>
                    <li><a class="dropdown-item" href="login.php">Sign Out</a></li>
                    </ul>
                </span>
            </div>
        </nav>
        <div style="margin-top:1%; margin-left:95%;">
            <a href="acctinfo.php"><button type="button" class="btn btn-outline-primary">Back</button></a>
        </div>    
        <div>
            <h1 style="text-align:center; margin-bottom:5%;"> New Pet </h1>
        </div>
        <div style="margin-right:30%; margin-left:30%;">
            <form action="index.php" method="post">
                <div class="input-group mb-3">
                    <span class="input-group-text">Pet Name</span>
                    <input type="text" placeholder="Shadow" aria-label="Pet Name" class="form-control" name="petname">
                </div>

                <div class="input-group">
                    <span class="input-group-text">Requirements</span>
                    <textarea class="form-control" placeholder="Food, Walks, Medicine, etc." aria-label="With textarea"></textarea>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Dog
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Cat
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Fish
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Bird
                        </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Monkey
                        </label>
                </div>                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Other (Identify in Requirements)
                        </label>
                </div>
                <center><button type="submit" class="btn btn-outline-primary" style="padding-top:1%;">Create New Pet</button></a></center>
            </form>
        </div>
    </body>
</html>