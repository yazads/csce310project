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