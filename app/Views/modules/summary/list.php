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
        <form action="<?php echo $current_page ?>" method="post">
            
            <div class="row">
                <div class="col-6">
                        <div class="card-header d-flex">
                            <h4 class = 'me-1' >Faculty</h4>
                            <select name="facultyID" id="facultyID" class="form-control select2" style="width: 200px;" required>
                                <option value=""></option>
                                <?php foreach ($evaluations as $eval) { ?>
                                    <option value="<?php echo $eval->id ?>" <?php if ($facultyID == $eval->id) echo 'selected' ?>><?php echo $eval->fname . ' ' .  $eval->lname ?></option>
                                <?php } ?>
                            </select>
                        </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col d-flex flex-row justify-content-end flex-nowrap">
                            <p class="h4 mx-1">Term:</p>
                            <select name="termField" id="termField" class="form-control select2 w-25">
                                
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
                        <div class="col d-flex flex-row justify-content-end flex-nowrap">
                            <p class="h4 mx-1">A/Y:</p>
                            <select name="acadYearField" id="acadYearField" class="form-control select2 w-25">
                        
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
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary mx-2" method="POST" action="<?php echo $current_page ?>">
                        Filter
                    </button>
                    
                </div>
            </div>
        </form>
        
        <div class="row"  id = "pdfContent">
            
            <div class="col-12 ">
                <div class="card my-4" >
                    <div class="card-body pb-2">
                        <div class="container-fluid d-flex flex-column justify-content-center">
                            <img src= "<?php echo base_url().'assets/img/logos/snsu.png' ?>" alt="snsu logo" style = "width:125px; height: 125px; margin: auto;">
                        </div>
                        <div class="container-fluid mb-5">
                            <p class="h5 text-center">Surigao Del Norte State University</p>
                        </div>
                        <?php if ($groupedRecords) { ?>
                            <div class="row">
                                <div class="col-6">
                                    <h5 id = "fName">Faculty: <?php echo $recFaculty->fname . ' ' .  $recFaculty->lname ?></h4>
                                </div>
                                <div class="col d-flex flex-column justify-content-end">
                                    <p class="h5 text-end">Term - A/Y: 
                                        <?php
                                            if(isset($textTerm)){
                                                echo $textTerm;
                                            }
                                            else {
                                                echo 'N/A';
                                            }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th style="width: 200px;">Subjects</th>
                                        <?php foreach ($categories as $cat) { ?>
                                            <?php $words = explode(' ', $cat->title);
                                            $firstWord = isset($words[0]) ? $words[0] : '';
                                            ?>
                                            <td class="text-center" style="width: 200px;"><?php echo $cat->catName; ?></td>
                                        <?php } ?>
                                        <td class="text-center">Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data         = array();
                                    $countFaculty = 0;
                                    $totalV       = 0;
                                    $noOfStudents = array();
                                    foreach ($groupedRecords as $title => $rec) {
                                    ?>
                                        <tr>
                                            <td><?php echo $rec['title']; ?></td>
                                            <?php
                                            $ctr = 0;
                                            $totalH = 0;

                                            $sum = 0;

                                            for ($i = 1; $i <= 4; $i++) {
                                            ?>
                                                <td class="text-center">
                                                    <?php
                                                    $categoryKey = 'cat' . $i;
                                                    if($countStud == 0 || $rec['count'] == 0){
                                                        echo 'N/A';
                                                    }
                                                    else {
                                                        if(isset($rec[$categoryKey])) {
                                                            echo number_format($rec[$categoryKey] / $rec['count'], 2);
                                                            $sum += $rec[$categoryKey] / $rec['count'];
                                                            // echo $rec['count'];
                                                        }
                                                        else {
                                                            echo '';
                                                        }
                                                        //echo $countStud;
                                                    }
                                                   // echo isset($rec[$categoryKey]) ? number_format($countStud, 2) : '';
                                                    ?>
                                                </td>
                                            <?php
                                                $ctr++;
                                                // if($countStud == 0) {
                                                //     echo 'N/A';
                                                // }
                                                // else {
                                                    
                                                //     $totalH += isset($rec[$categoryKey]) ? $rec[$categoryKey] / $countStud : 0;
                                                // }
                                            }
                                            ?>

                                            <td class="text-center"><?php echo number_format($sum, 2) ?></td>
                                        </tr>
                                    <?php
                                        $countFaculty++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Average</th>
                                        <?php
                                        
                                        foreach ($groupedRecords as $title => $rec) {
                                            for ($i = 1; $i <= 4; $i++) {
                                                $categoryKey = 'cat' . $i;
                                                if($rec['count'] > 0){
                                                    $data[$i - 1] = (isset($data[$i - 1]) ? $data[$i - 1] + $rec[$categoryKey] /  $rec['count'] : $rec[$categoryKey] /  $rec['count']);

                                                }
                                            }
                                        }
                                        foreach ($data as $dat) {
                                        ?>
                                            <th class="text-center">
                                                <?php
                                                
                                                if( $countStud == 0 || $dat == 0){
                                                    echo 'N/A';
                                                }
                                                else {
                                                    $ave =  round($dat , 2);
                                                    echo number_format($ave / count($groupedRecords), 2, '.', ',');
                                                    $totalV += $ave;
                                                }

                                               
                                                ?></th>
                                        <?php
                                        }
                                        ?>
                                        <td class="text-center">
                                            <?php 
                                            // echo $totalV
                                            $r = round($totalV, 2);
                                            echo number_format($r, 2, '.', ','); 
                                            ?>
                                        </td>
                                    </tr>
                                    <tr><th></th></tr>
                                    <tr>
                                        <th class = 'text-center'>Average Sem Rating
                                            
                                        </th>
                                        <th class="text-center">
                                        <?php 
                                               $s = round($totalV / (count($groupedRecords) * 5), 2);
                                               echo number_format($s, 2, '.', ','); 
                                            ?>
                                        </th>
                                    </tr>
                                </tfoot>

                            </table>
                        <?php } else { ?>
                            <h4>No data found</h4>
                        <?php } ?>

                        <div class="container-fluid mt-5">
                            <div class="container">
                                <p class="h4">Legend</p>
                            </div>
                            <?php
                                foreach ($categories as $cat) {
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
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container" id = "saveAs">
                <button class="btn btn-info align-middle">DOWNLOAD PDF</button>
            </div>
        </div>

        