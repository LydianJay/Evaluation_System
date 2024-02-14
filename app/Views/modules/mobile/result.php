<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h6 class="font-weight-bolder mb-0">
                    <a href="<?php echo $current_page . '/show/' ?>">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <?php echo ucfirst($module_title) ?>
                </h6>
                <h3><?php echo $student ?></h3>
                <a class="nav-link ml-auto text-dark d-flex" href="<?php echo site_url('mobile/logout') ?>">
                    <div class="text-dark text-center  d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">power_settings_new</i>
                    </div>
                    <span class="nav-link-text ms-1 ">Logout</span>
                </a>
            </nav>
        </div>
    </nav>

    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table align-items-center mb-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Rank</th>
                                    <th style="text-align: center;">Faculty Name</th>
                                    <th style="text-align: center;">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rank = 1;
                                foreach ($result as $res) { ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $rank++ ?></td>
                                        <td style="text-align: center;"><?php echo $res->fname . ' ' . $res->mname . ' ' . $res->lname ?></td>
                                        <td style="text-align: center;"><?php echo $res->total_rating ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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
                },
                searching: false, // Disable search
                lengthChange: false, // Hide the "Show X entries" dropdown
                info: false, // Hide the "Showing X to Y of Z entries" info
                paging: false, // Hide pagination
                ordering: false // Disable sorting
            });
        </script>