<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
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
            </nav>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="title" style="margin-bottom: 10px">
                            <h4><?php echo ucfirst($records->fname) . ' ' .  ucfirst($records->mname) . ' ' . ucfirst($records->lname) ?></h4>
                            <span><?php echo $records->title ?></span>
                        </div>
                        <p style="font-weight: bold;">Instructions:The options on the rating scale, which goes from low to high, represent a number of aspects of the performance of the faculty member.

                            Click the corresponding "save" button to send in your evaluations after the assessment is finished. Check all answers for accuracy before submitting the completed form.
                        </p>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Scale</th>
                                        <th style="text-align: center;">Description Rating</th>
                                        <!-- <th>Qualitative Description</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">5</td>
                                        <td style="text-align: center;">Oustanding</td>
                                        <!-- <td>The performance always exceeds the job requirement. The faculty is an exceptional model</td> -->
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">4</td>
                                        <td style="text-align: center;">Very Satisfactory</td>
                                        <!-- <td>The performance meets and often exceeds the requirement</td> -->
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">3</td>
                                        <td style="text-align: center;">Satisfactory</td>
                                        <!-- <td>The performance meets the job requirements</td> -->
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">2</td>
                                        <td style="text-align: center;">Fair</td>
                                        <!-- <td>The performance needs some development to meet the job requirements</td> -->
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">1</td>
                                        <td style="text-align: center;">Poor</td>
                                        <!-- <td>The faculty fall to meet the job requirement</td> -->
                                    </tr>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                        <form action="<?php echo $current_page . '/save' ?>" method="post" id="frmEntry">
                            <?php foreach ($questions as $ques) { ?>
                                <table class="table table-bordered table-sm mt-2">
                                    <tbody>
                                        <tr>
                                            <input type="hidden" name="evaluationID" value="<?php echo $evaluationID ?>">
                                            <input type="hidden" name="facultyID" value="<?php echo $records->id ?>">
                                            <input type="hidden" name="studentIdno" value="<?php echo $studentIdno ?>">
                                            <input type="hidden" name="studentID" value="<?php echo $studentID ?>">
                                            <input type="hidden" name="subID" value="<?php echo $subID ?>">
                                            <input type="hidden" name="courseID" value="<?php echo $courseID ?>">
                                            <input type="hidden" name="catID_<?php echo $ques['category']->catID ?>" value="<?php echo $ques['category']->catID ?>">
                                            <td style="text-align: center; font-weight: bold;"><?php echo $ques['category']->catName ?></td>
                                            <td style="font-weight: bold;">
                                                <p class="dynamic-text long-text" style="font-weight: bold;">
                                                    <?php echo $ques['category']->title ?>
                                                </p>
                                            </td>
                                        </tr>
                                        <?php foreach ($ques['questions'] as $que) { ?>
                                            <tr>
                                                <input type="hidden" name="quesID_<?php echo $que->quesID ?>" value="<?php echo $que->quesID ?>">
                                                <td style="text-align: center;"><?php echo $que->quesNo ?></td>
                                                <td>
                                                    <p class="dynamic-text long-text"><?php echo $que->definition ?></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 10px; text-align:center">RATING</td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline px-0">
                                                        <input class="form-check-input" type="radio" data-category="<?php echo $ques['category']->catName ?>" name="rating_<?php echo $que->quesID ?>" id="inlineRadio1_<?php echo $que->quesID ?>" value="1" title="Question <?php echo $que->quesNo ?>" required>
                                                        <label class="form-check-label" for="inlineRadio1_<?php echo $que->quesID ?>">1</label>
                                                    </div>
                                                    <div class="form-check form-check-inline px-0">
                                                        <input class="form-check-input" type="radio" data-category="<?php echo $ques['category']->catName ?>" name="rating_<?php echo $que->quesID ?>" id="inlineRadio2_<?php echo $que->quesID ?>" value="2" title="Question <?php echo $que->quesNo ?>" required>
                                                        <label class="form-check-label" for="inlineRadio2_<?php echo $que->quesID ?>">2</label>
                                                    </div>
                                                    <div class="form-check form-check-inline px-0">
                                                        <input class="form-check-input" type="radio" data-category="<?php echo $ques['category']->catName ?>" name="rating_<?php echo $que->quesID ?>" id="inlineRadio3_<?php echo $que->quesID ?>" value="3" title="Question <?php echo $que->quesNo ?>" required>
                                                        <label class="form-check-label" for="inlineRadio3_<?php echo $que->quesID ?>">3</label>
                                                    </div>
                                                    <div class="form-check form-check-inline px-0">
                                                        <input class="form-check-input" type="radio" data-category="<?php echo $ques['category']->catName ?>" name="rating_<?php echo $que->quesID ?>" id="inlineRadio4_<?php echo $que->quesID ?>" value="4" title="Question <?php echo $que->quesNo ?>" required>
                                                        <label class="form-check-label" for="inlineRadio4_<?php echo $que->quesID ?>">4</label>
                                                    </div>
                                                    <div class="form-check form-check-inline px-0">
                                                        <input class="form-check-input" type="radio" data-category="<?php echo $ques['category']->catName ?>" name="rating_<?php echo $que->quesID ?>" id="inlineRadio5_<?php echo $que->quesID ?>" value="5" title="Question <?php echo $que->quesNo ?>" required>
                                                        <label class="form-check-label" for="inlineRadio5_<?php echo $que->quesID ?>">5</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </form>
                        <div class="div">
                            <a class="btn btn-outline-secondary" href="<?php echo $current_page . '/list/' . $evaluationID ?>">Cancel</a>
                            <button type="button" id="cmdSave" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#cmdSave').on('click', function() {
                    if (check_fields()) {
                        $('#cmdSave').attr('disabled', 'disabled');
                        $('#frmEntry').submit();
                    }
                });

                function check_fields() {
                    var valid = true;
                    var req_fields = [];

                    $('#frmEntry [required]').each(function() {
                        if ($(this).val().trim() === '') {
                            req_fields.push($(this).attr('title'));
                            valid = false;
                        }
                    });

                    // Check if radio buttons are selected
                    $('#frmEntry input[type="radio"]').each(function() {
                        var groupName = $(this).attr('name');
                        if (!$('input[name="' + groupName + '"]:checked').length) {
                            var category = $(this).data('category');
                            var questionNo = $(this).attr('title').replace('Question ', ''); // Extracting question number
                            req_fields.push("Category: " + category + ", Question No: " + questionNo);
                            valid = false;
                        }
                    });

                    if (!valid) {
                        // Remove duplicates from the array
                        req_fields = req_fields.filter(function(value, index, self) {
                            return self.indexOf(value) === index;
                        });

                        alert("The following fields are required:\n" + req_fields.join('\n'));
                    }

                    return valid;
                }
            });
        </script>