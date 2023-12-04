<!--
=========================================================
* Material Dashboard 2 - v3.0.5
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/img/favicon.png">
    <title> </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="<?php echo base_url() ?>/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="<?php echo base_url() ?>/assets/css/material-dashboard.css?v=3.0.5" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
    <link href="<?php echo base_url() ?>/assets/dataTables/css_jquery.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/dataTables/datatables.bootstrap5.min.css" rel="stylesheet" />

    <!--   Core JS Files   -->
    <script src="<?php echo base_url() ?>/assets/js/core/jquery.com_jquery-3.7.0.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/dataTables/js_jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/dataTables/js_dataTables.bootstrap5.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?php echo base_url() ?>/assets/js/material-dashboard.min.js?v=3.0.5"></script>

    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0px;
        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-200">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'subjects') ? 'active' : "" ?>" href="<?php echo site_url('subjects') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">import_contacts</i>
                        </div>
                        <span class="nav-link-text ms-1">Subjects</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'courses') ? 'active' : "" ?>" href="<?php echo site_url('courses') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">local_library</i>
                        </div>
                        <span class="nav-link-text ms-1">Courses</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'faculty') ? 'active' : "" ?>" href="<?php echo site_url('faculty') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">supervisor_account</i>
                        </div>
                        <span class="nav-link-text ms-1">Faculty</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'students') ? 'active' : "" ?>" href="<?php echo site_url('students') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">people_alt</i>
                        </div>
                        <span class="nav-link-text ms-1">Students</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'blocksections') ? 'active' : "" ?>" href="<?php echo site_url('blocksections') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">grid_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Block Sections</span>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'questions') ? 'active' : "" ?>" href="<?php echo site_url('questions') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">done</i>
                        </div>
                        <span class="nav-link-text ms-1">Questions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'evaluations') ? 'active' : "" ?>" href="<?php echo site_url('evaluations') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">drive_file_rename_outline</i>
                        </div>
                        <span class="nav-link-text ms-1">Evaluations</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'ballots') ? 'active' : "" ?>" href="<?php echo site_url('ballots') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">article</i>
                        </div>
                        <span class="nav-link-text ms-1">Ballots</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>