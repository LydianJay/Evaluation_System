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
            <h3><?php echo $student ?></h3>
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
        <div class="row" id = "pdfContent">
            <div class="col-12 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo $current_page . '/save' ?>" method="post">
                            <h4 id ="fName"><?php echo ucfirst($records->fname) . ' ' .  ucfirst($records->mname) . ' ' . ucfirst($records->lname) ?></h4>
                            <span><?php echo ucfirst($records->position) ?></span>
                            <table class="table table-bordered table-sm mt-5">
                                <tbody>
                                    <?php
                                    $overAllTot = 0;
                                    $ctr = 0;
                                    foreach ($questions as $ques) { ?>
                                        <table class="table table-bordered table-sm mt-2">
                                            <tbody>
                                                <tr>
                                                    <input type="hidden" name="evaluationID" value="<?php echo $evaluationID ?>">
                                                    <input type="hidden" name="facultyID" value="<?php echo $records->id ?>">
                                                    <input type="hidden" name="studentIdno" value="<?php echo $studentIdno ?>">
                                                    <input type="hidden" name="studentID" value="<?php echo $studentID ?>">
                                                    <input type="hidden" name="catID_<?php echo $ques['category']->catID ?>" value="<?php echo $ques['category']->catID ?>">
                                                    <td style="text-align: center; font-weight: bold; width: 50px"><?php echo $ques['category']->catName ?></td>
                                                    <td style="font-weight: bold;">
                                                        <p class="dynamic-text long-text" style="font-weight: bold;">
                                                            <?php echo $ques['category']->title ?>
                                                        </p>
                                                    </td>
                                                    <td style="width: 10px; text-align:center">RATING</td>
                                                </tr>
                                                <?php
                                                $total = 0;
                                                foreach ($ques['questions'] as $que) { ?>
                                                    <tr>
                                                        <input type="hidden" name="quesID_<?php echo $que->quesID ?>" value="<?php echo $que->quesID ?>">
                                                        <td style="text-align: center; width: 50px"><?php echo $que->quesNo ?></td>
                                                        <td>
                                                            <p class="dynamic-text long-text"><?php echo $que->definition ?></p>

                                                        </td>
                                                        <td class="text-center"><?php echo $que->rating ?></td>
                                                    </tr>
                                                <?php
                                                    $total += $que->rating;
                                                    $overAllTot += $que->rating;
                                                } ?>
                                                <tr>
                                                    <td colspan="2" style="text-align: end;">Total</td>
                                                    <td style="text-align: center;"><?php echo $total ?></td>
                                                </tr>
                                                <tr></tr>
                                            </tbody>
                                        </table>
                                    <?php
                                        $ctr++;
                                    } ?>
                                </tbody>
                            </table>
                            <div class="div">
                                <?php if ($overAllTot) { ?>
                                    <h4>Sum of Ratings: <span><?php echo number_format($overAllTot)  ?></span></h4>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" id = "saveAs">
            <button class="btn btn-info align-middle">DOWNLOAD PDF</button>
        </div>