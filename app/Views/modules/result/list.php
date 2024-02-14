<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h6 class="font-weight-bolder mb-0">
                    <?php echo ucfirst($module_title) ?> List
                </h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <ul class="ms-md-auto pe-md-3 d-flex align-items-center navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <!-- <a class="btn btn-primary btn-sm mb-0 me-3" href="<?php echo $current_page . '/create' ?>"> Create <?php echo ucfirst($module_title) ?></a> -->
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
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3"><?php echo ucfirst($module_title) ?> table</h6>
                        </div>
                    </div>
                    <div class="card-body pb-2">
                        <?php if ($result) { ?>
                            <h3 style="margin-top: 10px;">Result</h3>
                            <table class="table align-items-center mb-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Rank</th>
                                        <th style="text-align: left;">Faculty Name</th>
                                        <th style="text-align: center;">Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rank = 1;
                                    foreach ($result as $res) { ?>
                                        <?php if ($res->eval_stat == 0) { ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $rank++ ?></td>
                                                <td style="text-align: left;"><?php echo $res->fname . ' ' . $res->mname . ' ' . $res->lname ?></td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    //average
                                                    $ave = $res->total_rating / $count / 10;
                                                    echo number_format($ave);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    dom: 'Bfrtip',
                    searching: false, // Disable search
                    buttons: [
                        'print',
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            download: 'open'
                        }
                    ],
                });
            });
        </script>