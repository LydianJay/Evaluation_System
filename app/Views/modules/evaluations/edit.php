<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="main-content position-relative max-height-vh-100 h-100">
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
            <div class="card card-body mx-3 mx-md-4 mt-5">
                <form action="<?php echo $current_page . '/update' ?>" method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $records->id ?>">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td style="width: 100px;">NAME</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="name" id="name" class="form-control" value="<?php echo $records->name ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 100px;">DESCRIPTION</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="desc" id="desc" class="form-control" value="<?php echo $records->desc ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 100px;">STATUS</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <select name="status" id="status" class="form-select form-selectw-md">
                                            <option value="0" <?php if ($records->status == 0) {
                                                                    echo 'selected';
                                                                } ?>>Close</option>
                                            <option value="1" <?php if ($records->status == 1) {
                                                                    echo 'selected';
                                                                } ?>>Pending</option>
                                            <option value="2" <?php if ($records->status == 2) {
                                                                    echo 'selected';
                                                                } ?>>Open</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="div">
                        <a class="btn btn-outline-secondary" href="<?php echo $current_page . '/view/' . $records->id ?>">Cancel</a>
                        <button type="submit" id="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

        </div>