<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <div class="main-content position-relative max-height-vh-100 h-100">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h6 class="font-weight-bolder mb-0">Edit <?php echo ucfirst($module_title) ?></h6>
                </nav>
            </div>
            <a class="nav-link text-dark d-flex ml-auto" href="<?php echo site_url('logout') ?>">
                <div class="text-dark text-center d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">power_settings_new</i>
                </div>
                <span class="nav-link-text ms-1">Logout</span>
            </a>
        </nav>

        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="card card-body mx-3 mx-md-4 mt-5">
                <form action="<?php echo $current_page . '/update' ?>" method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $records->id ?>">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="width: 100px;">ID NO.</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="idno" id="idno" class="form-control" value="<?php echo ucfirst($records->idno) ?>" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>FIRST NAME</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="fname" id="fname" class="form-control" value="<?php echo ucfirst($records->fname) ?>" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>MIDDLE NAME</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="mname" id="mname" class="form-control" value="<?php echo ucfirst($records->mname) ?>" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>LAST NAME</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="lname" id="lname" class="form-control" value="<?php echo ucfirst($records->lname) ?>" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>COURSE</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="course" id="course" class="form-control" value="<?php echo ucfirst($records->course) ?>" required>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>YEAR LEVEL</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="yr_lvl" id="yr_lvl" class="form-control" value="<?php echo ucfirst($records->yr_lvl) ?>" required>
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