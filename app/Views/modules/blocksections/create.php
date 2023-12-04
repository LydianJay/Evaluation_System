<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="main-content position-relative max-height-vh-100 h-100">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h6 class="font-weight-bolder mb-0">Create <?php echo ucfirst($module_title) ?></h6>
                </nav>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="card card-body mx-3 mx-md-4 mt-5">
                <form action="<?php echo $current_page . '/save' ?>" method="post">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="width: 100px;">SUBJECT CODE</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="subCode" id="subCode" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>TITLE</td>
                                <td>
                                    <div class="input-group input-group-outline my-3" style="width: 300px;">
                                        <input type="text" name="title" id="title" class="form-control">
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