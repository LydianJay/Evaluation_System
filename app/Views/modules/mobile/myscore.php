<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h4>
                    <a href="<?php echo $current_page . '/list/' . $evaluationID ?>"><i class="fas fa-arrow-left" aria-hidden="true"></i> </a>
                    <?php echo ucfirst($module_title) ?>
                </h4>
            </nav>
            <a class="nav-link text-dark d-flex ml-auto" href="<?php echo site_url('mobile/logout') ?>">
                <div class="text-dark text-center d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">power_settings_new</i>
                </div>
                <span class="nav-link-text ms-1">Logout</span>
            </a>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo $current_page . '/save' ?>" method="post">
                            <h4><?php echo ucfirst($records->fname) . ' ' .  ucfirst($records->mname) . ' ' . ucfirst($records->lname) ?></h4>
                            <span><?php echo ucfirst($records->position) ?></span>
                            <table class="table table-bordered table-sm mt-5">
                                <thead>
                                    <tr>
                                        <th style="width: 10px; text-align:center">No.</th>
                                        <th style="width: 50px;">Question</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($questions as $ques) { ?>
                                        <tr>
                                            <input type="hidden" name="evaluationID" value="<?php echo $evaluationID ?>">
                                            <input type="hidden" name="facultyID" value="<?php echo $records->id ?>">
                                            <input type="hidden" name="studentIdno" value="<?php echo $studentIdno ?>">
                                            <input type="hidden" name="studentID" value="<?php echo $studentID ?>">
                                            <input type="hidden" name="question_<?php echo $ques->id ?>" value="<?php echo $ques->id ?>">
                                            <td style="width: 10px; text-align:center"><?php echo $ques->questionNo ?></td>
                                            <td style="width: 50px;"><?php echo $ques->questionLabel ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 10px; text-align:center">RATING</td>
                                            <td class="text-center"><?php echo $ques->rating ?></td>
                                        </tr>
                                        <tr></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="div">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>