<?php session_start(); ?>
<?php 
if(!isset($_SESSION['userid'])){
    header('Location:login.php');
}

?>
<?php include 'function.php'; ?>
<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Nectar Mount Resort</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= WEB_PATH ?>assets/customer/assets/img/favicon.png" rel="icon">
  <link href="<?= WEB_PATH ?>assets/customer/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= WEB_PATH ?>assets/customer/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= WEB_PATH ?>assets/customer/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= WEB_PATH ?>assets/customer/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= WEB_PATH ?>assets/customer/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?= WEB_PATH ?>assets/customer/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?= WEB_PATH ?>assets/customer/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= WEB_PATH ?>assets/customer/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= WEB_PATH ?>assets/customer/assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center bg-success">
  
     
   <div class="d-flex align-items-center justify-content-between">
       
      <a href="index.php" class="logo d-flex align-items-center">
       
        <span class="d-none d-lg-block text-white">Nectar Mount Resort</span>
        
      </a>
<!--         <i class="bi bi-list toggle-sidebar-btn"></i>-->
     
    </div><!-- End Logo -->

   

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        

        

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
         
            <span class="d-none d-md-block dropdown-toggle ps-2 text-white">Log In - <?= $_SESSION['title']." ". $_SESSION['firstname']." ".$_SESSION['lastname'] ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $_SESSION['title']." ". $_SESSION['firstname']." ".$_SESSION['lastname'] ?></h6>
             
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= WEB_PATH ?>customers/userprofile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= WEB_PATH ?>customers/editprofile.php">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= WEB_PATH?>logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->


