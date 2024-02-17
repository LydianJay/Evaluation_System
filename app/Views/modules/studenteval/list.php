<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h4 class="font-weight-bolder mb-0"><?php echo ucfirst($module_title) ?> List</h4>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                </div>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <a class="nav-link text-dark d-flex ml-auto" href="<?php echo site_url('logout') ?>">
                <div class="text-dark text-center d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">power_settings_new</i>
                </div>
                <span class="nav-link-text ms-1">Logout</span>
            </a>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div>
            <?php if ($message = session('message')) { ?>
                <?php $messageType = session('message_type'); ?>
                <div class="alert alert-<?php echo $messageType ?> alert-dismissible text-white" role="alert">
                    <span class="text-sm"> <?php echo $message ?></span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
        </div>

        <div class="row">
            <div class="col-12">
                <form action="<?php echo $current_page ?>" method="POST" id="frmFilter">
                    <div class="card">
                        <div class="card-header d-flex">
                            <form action="<?php echo $current_page ?>" method="post">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-2">
                                            <p class="h4 text-center">Evaluation:</p>
                                        </div>
                                        
                                        <div class="col">
                                            <select name="evaluationID" id="evaluationID" class="form-control select2 w-50" required>
                                                <option value=""></option>
                                                <?php foreach ($evaluations as $eval) { ?>
                                                    <option value="<?php echo $eval->id ?>" <?php if ($evaluationID == $eval->id) echo 'selected' ?>><?php echo $eval->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <p class="h4 text-center">Course:</p>
                                        </div>

                                        <div class="col">
                                            <select name="courseID" id="courseID" class="form-control select2 w-50" required>
                                                <option value=""></option>
                                                <?php foreach ($courses as $cour) { ?>
                                                    <option value="<?php echo $cour->courseID ?>" <?php if ($courseID == $cour->courseID) echo 'selected' ?>><?php echo $cour->title ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <p class="h4 text-center">Subject:</p>
                                        </div>

                                        <div class="col">
                                            <select name="subjectID" id="subjectID" class="form-control select2 w-50" required>
                                                <option value=""></option>
                                                <?php foreach ($subjects as $sub) { ?>
                                                    <option value="<?php echo $sub->subID ?>" <?php if ($subID == $sub->subID) echo 'selected' ?>><?php echo $sub->title ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-2">
                                            <p class="h4 text-center">Faculty:</p>
                                        </div>

                                        <div class="col">
                                            <select name="facultyField" id="facultyField" class="form-control select2 w-50" required>
                                                <option value=""></option>
                                                <?php foreach ($subjects as $sub) { ?>
                                                    <option value="<?php echo $sub->subID ?>" <?php if ($subID == $sub->subID) echo 'selected' ?>><?php echo $sub->title ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                    </div>

                                    

                                    <div class="row">
                                        <div class="col align-self-center">
                                            <div class="container" style="width: fit-content;">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <?php if ($records) { ?>
                                <p class="h2 text-center">Evaluation per Program</p>
                                <h4>Term: <?php echo $getEval->name ?></h4>
                                <h4>Program: <?php echo $getCourse->description ?></h4>
                                <p class="h4">Subject: <?php echo $getSub->title ?> </p>
                                <h4>No of students: <?php echo $noOfStud ?></h4>
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Student No.</th>
                                            <th class="text-center">Subject</th>
                                            <td class="text-center">A</td>
                                            <td class="text-center">B</td>
                                            <td class="text-center">C</td>
                                            <td class="text-center">D</td>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total     = 0;
                                        $cat1total = 0;
                                        $cat2total = 0;
                                        $cat3total = 0;
                                        $cat4total = 0;
                                        $ctr = 0;
                                        $id = 1;
                                        foreach ($records as $rec) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $id?></td>
                                                <td class="text-center"><?php echo $rec->subject_title ?></td>
                                                <td class="text-center"><?php echo $rec->cat1 ?></td>
                                                <td class="text-center"><?php echo $rec->cat2 ?></td>
                                                <td class="text-center"><?php echo $rec->cat3 ?></td>
                                                <td class="text-center"><?php echo $rec->cat4 ?></td>
                                                <td class="text-center"><?php echo $total = $rec->cat1 + $rec->cat2 + $rec->cat3 + $rec->cat4  ?></td>
                                            </tr>
                                            
                                        <?php
                                            $id++;
                                            $cat1total += $rec->cat1;
                                            $cat2total += $rec->cat2;
                                            $cat3total += $rec->cat3;
                                            $cat4total += $rec->cat4;
                                            $ctr++;
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            
                                            <th class="text-center">Average</th>
                                            <th class="text-center">
                                                <?php
                                                $ave1 = $cat1total / $ctr;
                                                echo round($ave1, 2);   ?>
                                            </th>
                                            <th class="text-center">
                                                <?php
                                                $ave2 = $cat2total / $ctr;
                                                echo round($ave2, 2);   ?>
                                            </th>
                                            <th class="text-center">
                                                <?php
                                                $ave3 = $cat3total / $ctr;
                                                echo round($ave3, 2);   ?>
                                            </th>
                                            <th class="text-center">
                                                <?php
                                                $ave4 = $cat4total / $ctr;
                                                echo round($ave4, 2);   ?>
                                            </th>
                                            <th class="text-center"><?php
                                                                    $totals = $ave1 + $ave2 + $ave3 + $ave4;
                                                                    echo  round($totals, 2); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            <?php } else { ?>
                                <h4>No data found</h4>
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    dom: 'Bfrtip',
                    searching: false,
                    buttons: [{
                            extend: 'print',
                            footer: true,
                            customize: function(win) {
                                // Add your logo on the right side of the title in the header
                                var logoHtml = '<div style="text-align: center;">' +
                                    '<img src="<?php echo base_url() ?>/assets/img/logos/snsu.png" alt="Logo" style="width: 80px; display: inline-block;">' +
                                    '<h3 style="display: inline-block; margin-right: 10px;">SNSU EVALUATION</h3>' +
                                    '</div>';

                                $(win.document.body).find('table').before(logoHtml);
                            },
                        },
                        {
                            extend: 'pdfHtml5',
                            header: true,
                            footer: true,
                            title: 'Evaluation',
                            orientation: 'portrait',
                            pageSize: 'LETTER',
                            download: 'open',
                            customize: function(doc) {
                                doc.layout = 'lightHorizontalLines';
                                doc.pageMargins = [30, 30, 30, 30];
                                doc.defaultStyle.fontSize = 12;
                                doc.styles.tableHeader.fontSize = 12;
                                doc.styles.title.fontSize = 14;
                            }
                        }
                    ],
                });
            });
        </script>