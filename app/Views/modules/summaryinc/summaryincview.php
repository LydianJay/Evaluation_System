<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

     <!-- Navbar -->
     <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3 justify-content-end">
            
            
            <a class="nav-link text-dark d-flex ml-auto" href="<?php echo site_url('logout') ?>">
                <div class="text-dark text-center d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">power_settings_new</i>
                </div>
                <span class="nav-link-text ms-1">Logout</span>
            </a>
        </div>
    </nav>




    <div class="container-fluid py-4">

        <div class="row pt-5">
            <div class="col-12">
                <p class="h3 text-center">TEACHING EFFECTIVENESS EVALUATION</p>
            </div>
        </div>

        <form action="<?php echo $current_page ?>" method="post">

            <div class="row mt-5">
                <div class="col-2 ms-3">
                    <p class="h4 text-end">Course:</p>                
                </div>
                <div class="col-3">

                    <select name = "courseField" id = "courseField" class="form-control select2 w-50">
                        
                            <?php
                                foreach ($courseTbl as $course) {
                            ?>
                            <option value="<?php echo $course->courseID ?>" <?php  
                                if(isset($course)) {
                                    if ( $course->courseID == $selectedCourse) echo 'selected';
                                }
                            ?>>
                                <?php 
                                echo $course->title;
                                ?> 
                            </option>
                            <?php }?>
                    </select>
                
                </div>
                <div class="col-2">
                    <p class="h4 text-end">Term:</p>
                </div>
                <div class="col-3">
                    <select name="termField" id="termField" class="form-control select2 w-50">
                        
                        <?php
                            for($i = 0; $i < 2; $i++) {
                        ?>
                    
                        <option value="<?php echo $i+1; ?>"  <?php echo ($i+1) == $selectedTerm ? 'selected' : '' ?>><?php echo $i == 0 ? '1st Semester' : '2nd Semester';?>
                        </option>
                        
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-2 ms-3">
                    <p class="h4 text-end">Professor:</p>
                    
                </div>
                <div class="col-3">

                    <select name="profField" id="profField" class="form-control select2 w-50">
                                          
                        <?php
                            foreach ($facultyTbl as $fac) {
                        ?>
                        <option value="<?php echo $fac->id ?>" <?php  
                            if(isset($fac)) {
                                if ( $fac->id == $selectedProf) echo 'selected';
                            }
                        ?>>
                            <?php 
                            echo $fac->fname." ".$fac->lname;
                            ?> 
                        </option>
                        <?php }?>
                    </select>
                
                </div>
                <div class="col-2">
                    <p class="h4 text-end">AY:</p>
                </div>
                <div class="col-3">
                    <select name="acadYearField" id="acadYearField" class="form-control select2 w-50">
                        
                        <?php
                            // ===============================================
                            // NOTE: 
                            // This is a bit of a shitty implementation as 
                            // user can only select from year 2020 to 2069
                            // 
                            // A solution is to query the current year then add
                            // and subtract 25 or maybe 50 years to it
                            // e.g current year: 2024, range: (2024-25) to (2024+25)
                            // ===============================================
                        
                            for($i = 2020; $i <= 2069; $i++) { 
                        ?>
                            
                            <option value="<?php echo $i;?>" <?php echo ($selectedYear == $i) ?  'selected' : '';?>> 
                                <?php echo $i."-".$i+1; ?>
                            </option>
                        <?php }?>
                    </select>
                </div>
            </div>
            

            <div class="row">
                <div class="col">
                    <div class="container mt-5" style="width: fit-content;">
                        <button class="btn btn-primary" type = "submit">Filter</button>

                    </div>
                </div>
            </div>

        </form>

        

        <div class="row">
            <div class="col">
                <p class="h3 text-center mt-5">Student Evaluation</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <p class="h5 text-center my-2">Average Rating per Semester</p>
            </div>
        </div>

        <div class="row my-5">
            <div class="col">
                <table class="table table-bordered border-dark" id = "docu">
                    <thead>
                        <tr>
                            <th></th>
                            <?php
                                foreach ($catTbl as $cat) {
                            ?>
                            <th class ="text-center">
                                <p class="h4">

                            <?php 
                                    echo $cat->catName;
                            ?>     
                                </p>
                            </th>

                            <?php } ?>
                            <th class="text-center">
                                <p class="h4">
                                    Total
                                </p>
                            </th>
                        </tr>
                    </thead>
                
                    <tbody>
                        <tr>
                            <th class="text-center">
                                    <p class="h4">Evaluation</p>
                            </th>
                            <?php
                                $sum = 0;
                                if(isset($ratings)){
                                    foreach($ratings as $rating) {
                            ?>
                            <th class="text-center">
                                <p class="h6">

                            <?php 

                                    // ========================================================
                                    //                          IMPORTANT
                                    //
                                    // if the number of questions per category changed
                                    // this calculculation will not work anymore
                                    // SOLUTION: 
                                    // S1: query the number of questions per category and change 
                                    // the contant '5' with queried number
                                    //
                                    // There are more possible solutions to this
                                    //
                                    // As for now this should work... Im to lazy solving this shit
                                    // -LydianJay :)
                                    // =======================================================

                                    $res = $rating->rating / ($rating->num / 5); 
                                    echo $res;
                                    $sum += $res;
                            ?>     
                                </p>

                            </th>

                            <?php 
                                    } 
                                }
                            ?>
                            
                            <th class="text-center">
                                <p class="h6">
                                    <?php echo $sum; ?>
                                </p>
                            </th>
                        </tr>
                    </tbody>

                </table>                    
            </div>
        </div>

        
        

        <div class="container-fluid pt-2">
            <div class="container">
                <p class="h4">Legend</p>
            </div>
            <?php
                foreach ($catTbl as $cat) {
            ?>
            <div class="container">
                    <p class="h6">
                        <?php
                            echo $cat->catName." - ".$cat->title;
                        ?>
                    </p>
            </div>

            <?php } ?>

        </div>

    </div>



</main>



<script>
    $(document).ready(function() {
        $('#docu').DataTable({
            dom: 'Bfrtip',
            searching: false,
            buttons: [{
                    extend: 'print',
                    footer: true,
                    customize: function(win) {
                        // Add your logo on the right side of the title in the header
                        var logoHtml = '<div style="text-align: center; padding-bottom: 30px;">' +
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
                    title: 'Semester Evaluation',
                    orientation: 'portrait',
                    pageSize: 'LETTER',
                    download: 'open',
                    customize: function(doc) {
                        doc.layout = 'lightHorizontalLines';
                        doc.pageMargins = [30, 30, 30, 30];
                        doc.defaultStyle.fontSize = 18;
                        doc.styles.tableHeader.fontSize = 20;
                        doc.styles.title.fontSize = 24;
                    }
                }
            ],
        });
    });
</script>