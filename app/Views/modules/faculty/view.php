<div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h6 class="font-weight-bolder mb-0">
                    <a href="<?php echo $current_page ?>">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    View <?php echo ucfirst($module_title) ?>
                </h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <ul class="ms-md-auto pe-md-3 d-flex align-items-center navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a class="btn btn-outline-primary btn-sm mb-0 me-3" href="<?php echo $current_page . '/create' ?>"> Create <?php echo ucfirst($module_title) ?></a>
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
    <div class="container-fluid px-2 px-md-4">
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

        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask  bg-gradient-primary  opacity-6"></span>
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n6">
            <div class="row gx-4 mb-2">
                <div class="col-auto my-auto">
                    <div class="h-100 d-flex">
                        <h5 class="mb-1"> ID NO. <?php echo $records->idno ?> </h5>
                        <a class="ms-2 btn btn-primary btn-sm" href="<?php echo $current_page . '/edit/' . $records->id ?>">
                            <i class="fas fa-user-edit"></i> EDIT
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-12 col-xl-4">
                        <div class="card card-plain h-100">
                            <div class="card-body p-3">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td style="width: 100px;">FIRST NAME</td>
                                            <td><?php echo ucfirst($records->fname) ?></td>
                                        </tr>
                                        <tr>
                                            <td>MIDDLE NAME</td>
                                            <td><?php echo ucfirst($records->mname) ?></td>
                                        </tr>
                                        <tr>
                                            <td>LAST NAME</td>
                                            <td><?php echo ucfirst($records->lname) ?></td>
                                        </tr>
                                        <tr>
                                            <td>POSITION</td>
                                            <td><?php echo ucfirst($records->position) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card card-plain h-100">
                            <div class="card-body p-3">
                                <table class="table align-items-center mb-0" id="dataTable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Evaluation</th>
                                            <th>Sub Code</th>
                                            <th>Subject</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result) { ?>
                                            <?php foreach ($result as $res) { ?>
                                                <td><?php echo $res->name ?></td>
                                                <td><?php echo $res->subCode ?></td>
                                                <td><?php echo $res->title ?></td>
                                                <td><?php echo $res->total_rating ?></td>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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