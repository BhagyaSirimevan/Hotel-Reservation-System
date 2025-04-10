<?php 
session_start(); 
if(!isset($_SESSION['userid'])){
    header("Location:login.php");
}

 include 'config.php'; 
 include 'function.php'; 
 ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>Nectar Mount Resort - Dashboard</title>
    <link href="<?= SYSTEM_PATH ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= SYSTEM_PATH ?>assets/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
<header class="navbar navbar-dark sticky-top bg-success flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#"><h5>Nectar Mount Resort</h5></a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
        <a class="nav-link px-3 text-bg-success" href="<?= SYSTEM_PATH ?>logout.php"> <span data-feather="log-out" class="align-text-top bg-secondary"></span>Log out</a>
    </div>
  </div>
</header>
<div class="container-fluid">
  <div class="row">
