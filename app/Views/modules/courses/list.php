<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h6 class="font-weight-bolder mb-0"><?php echo ucfirst($module_title) ?> List</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                </div>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a class="btn btn-primary btn-sm mb-0 me-3" href="<?php echo $current_page . '/create' ?>"> Create <?php echo ucfirst($module_title) ?></a>
                    </li>
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
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3"><?php echo ucfirst($module_title) ?> table</h6>
                        </div>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive">
                            <table class="table table-sm align-items-center mb-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xl font-weight-bolder opacity-7" style="text-align:center">Title</th>
                                        <th class="text-uppercase text-secondary text-xl font-weight-bolder opacity-7" style="text-align:center">Description</th>
                                        <th class="text-uppercase text-secondary text-xl font-weight-bolder opacity-7" style="text-align:center">OPTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $rec) { ?>
                                        <tr>
                                            <td style="text-align:center"><?php echo ucfirst($rec->title) ?></td>
                                            <td style="text-align:center"><?php echo ucfirst($rec->description) ?></td>
                                            <td style="text-align:center">
                                                <a href="<?php echo $current_page . '/view/' . $rec->courseID ?>" class="btn btn-info btn-sm mb-0">VIEW</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $('#dataTable').DataTable({
                language: {
                    'paginate': {
                        'previous': '<i class="fas fa-chevron-left"></i>',
                        'next': '<i class="fas fa-chevron-right"></i>'
                    }
                }
            });
        </script>