<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h4 class="font-weight-bolder mb-0">
                    <?php echo ucfirst($module_title) ?>
                </h4>
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
                                            <td class="text-center">
                                                <div class="form-check form-check-inline px-0">
                                                    <input class="form-check-input" type="radio" name="rating_<?php echo $ques->id ?>" id="inlineRadio1_<?php echo $ques->id ?>" value="1">
                                                    <label class="form-check-label" for="inlineRadio1_<?php echo $ques->id ?>">1</label>
                                                </div>
                                                <div class="form-check form-check-inline px-0">
                                                    <input class="form-check-input" type="radio" name="rating_<?php echo $ques->id ?>" id="inlineRadio2_<?php echo $ques->id ?>" value="2">
                                                    <label class="form-check-label" for="inlineRadio2_<?php echo $ques->id ?>">2</label>
                                                </div>
                                                <div class="form-check form-check-inline px-0">
                                                    <input class="form-check-input" type="radio" name="rating_<?php echo $ques->id ?>" id="inlineRadio3_<?php echo $ques->id ?>" value="3">
                                                    <label class="form-check-label" for="inlineRadio3_<?php echo $ques->id ?>">3</label>
                                                </div>
                                                <div class="form-check form-check-inline px-0">
                                                    <input class="form-check-input" type="radio" name="rating_<?php echo $ques->id ?>" id="inlineRadio4_<?php echo $ques->id ?>" value="4">
                                                    <label class="form-check-label" for="inlineRadio4_<?php echo $ques->id ?>">4</label>
                                                </div>
                                                <div class="form-check form-check-inline px-0">
                                                    <input class="form-check-input" type="radio" name="rating_<?php echo $ques->id ?>" id="inlineRadio5_<?php echo $ques->id ?>" value="5">
                                                    <label class="form-check-label" for="inlineRadio5_<?php echo $ques->id ?>">5</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="div">
                                <a class="btn btn-outline-secondary" href="<?php echo $current_page . '/list/' . $evaluationID ?>">Cancel</a>
                                <button type="submit" id="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>