<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="main-content position-relative max-height-vh-100 h-100">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h6 class="font-weight-bolder mb-0">Create <?php echo ucfirst($module_title) ?></h6>
                </nav>
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
            <div class="card card-body mx-3 mx-md-4 mt-5">
                <form action="<?php echo $current_page . '/save' ?>" method="post">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="width: 100px;">Title</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="title" id="title" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Decription</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="description" id="description" class="form-control">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="div">
                        <a class="btn btn-outline-secondary" href="<?php echo $current_page ?>">Cancel</a>
                        <button type="submit" id="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>