<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin Dashboard</title>
    
    <link rel="stylesheet" href="<?=base_url('assets/template/dist')?>/assets/css/main/app.css">
    <link rel="shortcut icon" href="<?=base_url('assets/template/dist')?>/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="<?=base_url('assets/template/dist')?>/assets/images/logo/favicon.png" type="image/png">
    
<link rel="stylesheet" href="<?=base_url('assets/template/dist')?>/assets/css/shared/iconly.css">
<link rel="stylesheet" href="<?=base_url('assets')?>/template/dist/assets/extensions/sweetalert2/sweetalert2.min.css">
<script src="<?=base_url('assets')?>/template/dist/assets/extensions/sweetalert2/sweetalert2.min.js"></script>

</head>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <div class="logo">
                            <a href="<?=base_url('admin')?>"><img src="<?=base_url('assets/template/dist')?>/assets/images/logo/logo.svg" alt="Logo"></a>
                        </div>
                        <div class="header-top-right">

                            <div class="dropdown">
                                <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar avatar-md2" >
                                        <img src="<?php echo (isset($_SESSION['profile'][0]['profile_picture']) ) ?  $_SESSION['profile'][0]['profile_picture'] :  base_url('assets/template/dist/assets/images/faces/2.jpg') ;?>" alt="Avatar">
                                    </div>
                                    <div class="text">
                                        <h6 class="user-dropdown-name"><?php echo (isset($_SESSION['profile'][0]['profile_picture']) ) ?  $_SESSION['profile'][0]['nama_depan'] : "" ;?></h6>
                                        <p class="user-dropdown-status text-sm text-muted">Member</p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                                  <li><a class="dropdown-item" href="#">My Account</a></li>
                                  <li><a class="dropdown-item" href="#">Settings</a></li>
                                  <li><hr class="dropdown-divider"></li>
                                  <li><a class="dropdown-item" href="<?=base_url('logout')?>">Logout</a></li>
                                </ul>
                            </div>

                            <!-- Burger button responsive -->
                            <a href="#" class="burger-btn d-block d-xl-none">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
                        </div>
                    </div>
                </div>