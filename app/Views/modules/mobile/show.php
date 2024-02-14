<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <h4 class="font-weight-bolder mb-0">
                <?php echo ucfirst($module_title) ?>

            </h4>
            <h3><?php echo $student ?></h3>
            <a class="nav-link ml-auto text-dark d-flex" href="<?php echo site_url('mobile/logout') ?>">
                <div class="text-dark text-center  d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">power_settings_new</i>
                </div>

                <span class="nav-link-text ms-1 ">Logout</span>
            </a>
        </div>
    </nav>

    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <?php foreach ($records as $rec) { ?>
                <?php if ($rec->status != 1) { ?>
                    <div class="col-md-6 col-sm-6 mb-4">
                        <a href="<?php echo site_url('mobile/list/' . $rec->id) ?>" class="card">
                            <div class="card-header p-3 pt-2">
                                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="text-end pt-1 px-3">
                                    <p class="mb-0" style="padding-left: 50px; font-weight: bold">
                                        <?php echo $rec->name ?>
                                    </p>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                            </div>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>