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
                    <div class="card-body pb-2">
                        <form action="<?php echo $current_page ?>" method="post">
                            <div class="card-header d-flex">
                                <h4>Faculty</h4>
                                <select name="facultyID" id="facultyID" class="form-control select2" style="width: 200px;" required>
                                    <option value=""></option>
                                    <?php foreach ($evaluations as $eval) { ?>
                                        <option value="<?php echo $eval->id ?>" <?php if ($facultyID == $eval->id) echo 'selected' ?>><?php echo $eval->fname . ' ' .  $eval->lname ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                        <?php if ($groupedRecords) { ?>
                            <h4>Faculty: <?php echo $recFaculty->fname . ' ' .  $recFaculty->lname ?></h4>
                            <h4>No Students : <?php echo $countStud ?></h4>
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th style="width: 200px;">Subjects</th>
                                        <?php foreach ($categories as $cat) { ?>
                                            <?php $words = explode(' ', $cat->title);
                                            $firstWord = isset($words[0]) ? $words[0] : '';
                                            ?>
                                            <td class="text-center" style="width: 200px;"><?php echo $cat->catName . ' ' . $firstWord . '..'; ?></td>
                                        <?php } ?>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data         = array();
                                    $countFaculty = 0;
                                    $totalV       = 0;
                                    foreach ($groupedRecords as $title => $rec) {
                                    ?>
                                        <tr>
                                            <td><?php echo $rec['title']; ?></td>
                                            <?php
                                            $ctr = 0;
                                            $totalH = 0;
                                            // Assuming you have a predefined set of categories (cat1, cat2, cat3, cat4)
                                            for ($i = 1; $i <= 4; $i++) {
                                            ?>
                                                <td class="text-center">
                                                    <?php
                                                    $categoryKey = 'cat' . $i;
                                                    echo isset($rec[$categoryKey]) ? $rec[$categoryKey] : '';
                                                    ?>
                                                </td>
                                            <?php
                                                $ctr++;
                                                $totalH += isset($rec[$categoryKey]) ? $rec[$categoryKey] : 0;
                                            }
                                            ?>

                                            <td class="text-center"><?php echo $totalH ?></td>
                                        </tr>
                                    <?php
                                        $countFaculty++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-end">Average</th>
                                        <?php
                                        foreach ($groupedRecords as $title => $rec) {
                                            for ($i = 1; $i <= 4; $i++) {
                                                $categoryKey = 'cat' . $i;
                                                $data[$i - 1] = (isset($data[$i - 1]) ? $data[$i - 1] + $rec[$categoryKey] : $rec[$categoryKey]);
                                            }
                                        }
                                        foreach ($data as $dat) {
                                        ?>
                                            <th class="text-center">
                                                <?php
                                                $ave =  round($dat /  $countFaculty / $countStud, 2);
                                                echo  $ave;
                                                $totalV += $ave;
                                                ?></th>
                                        <?php
                                        }
                                        ?>
                                        <td class="text-center"><?php echo $totalV ?></td>
                                    </tr>
                                </tfoot>

                            </table>
                        <?php } else { ?>
                            <h4>No data found</h4>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    dom: 'Bfrtip',
                    searching: false,
                    "paging": false,
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
                                // Check if doc object is defined
                                if (typeof doc !== 'undefined') {
                                    doc.layout = 'lightHorizontalLines';
                                    doc.pageMargins = [30, 30, 30, 30];
                                    doc.defaultStyle.fontSize = 12;
                                    doc.styles.tableHeader.fontSize = 12;
                                    doc.styles.title.fontSize = 14;
                                }
                            }
                        }
                    ],
                });
            });
        </script>