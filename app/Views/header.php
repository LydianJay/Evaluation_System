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
    <link href="<?php echo base_url() ?>assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="<?php echo base_url() ?>assets/css/material-dashboard.css?v=3.0.5" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Perfect Scrollbar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.2/perfect-scrollbar.min.js"></script>

    <!-- Smooth Scrollbar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.6.0/smooth-scrollbar.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- custom download pdf function  -->
    <script src="<?php echo base_url() ?>/custom/printing.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>

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
        .table {
           
            border-color: black;
        }
        h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6 {
            color: black;
        }
        h7, .h7 {
            font-size: 0.8rem;
            line-height: 1.625;
            font-weight: 600;
            color: black;
        }
        td {
            border-width: 1px;
            color: black;
        }
        th {
            color: black;
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
                    <a class="nav-link text-white <?php echo ($module_title == 'studenteval') ? 'active' : "" ?>" href="<?php echo site_url('studenteval') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">drive_file_rename_outline</i>
                        </div>
                        <span class="nav-link-text ms-1">Student Summary</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'summary') ? 'active' : "" ?>" href="<?php echo site_url('summary') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">drive_file_rename_outline</i>
                        </div>
                        <span class="nav-link-text ms-1">Faculty Summary</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'summarysem') ? 'active' : "" ?>" href="<?php echo site_url('summarysem') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">drive_file_rename_outline</i>
                        </div>
                        <span class="nav-link-text ms-1">Semester Summary</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'summaryinc') ? 'active' : "" ?>" href="<?php echo site_url('summaryinc') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">drive_file_rename_outline</i>
                        </div>
                        <span class="nav-link-text ms-1">Extensive Summary</span>
                    </a>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link text-white <?php echo ($module_title == 'ballots') ? 'active' : "" ?>" href="<?php echo site_url('ballots') ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">article</i>
                        </div>
                        <span class="nav-link-text ms-1">Ballots</span>
                    </a>
                </li> -->
            </ul>
        </div>
    </aside>