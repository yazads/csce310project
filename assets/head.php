<?php
// determine what the page title should be and which css file to use
$page = pathinfo($_SERVER['REQUEST_URI'])['filename'];

// set page title var
$pageTitle = '';
switch($page){
  case 'login':
    $pageTitle = 'Login';
    break;
  case 'signup':
    $pageTitle = 'Sign Up';
    break;
  case 'index':
    $pageTitle = 'Home';
    break;
  case 'acctinfo':
    $pageTitle = 'Account';
    break;
  case 'createpet':
    $pageTitle = 'Create Pet';
    break;
  case 'editpet':
    $pageTitle = 'Edit Pet';
    break;
  case 'editreview':
    $pageTitle = 'Edit Review';
    break;
  default:
  $pageTitle = '*ADD PAGE TO HEAD.PHP*';
}

// set css file var
$cssFile = 'styles/acctinfo.css';
if($page == 'index'){
  $cssFile = 'styles/index.css';
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
    <title>Pet Stop | <?php echo $pageTitle; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/DogHouse.png">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <style>
     <?php include $cssFile; ?>
    </style>
  </head>
  <body style="background-color:#FAE8E0">
    <div style="background-color:#FAE8E0">