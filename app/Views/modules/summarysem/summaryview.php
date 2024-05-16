



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

    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-2">
                <p class="h4 text-end">Faculty Name </p>
            </div>
            <div class="col-4">
                <form action="<?php echo $current_page ?>" method="POST">
                    <select name="fName" id="fName" class="form-control select2 w-50" required>
                        
                        <?php
                            foreach ($fnames as $fname) {
                        ?>
                        <option value="<?php echo $fname->id ?>" <?php  
                            if(isset($selectedID)) {
                                if ( $selectedID->id == $fname->id) echo 'selected';
                            }
                            
                            
                        ?>>
                            <?php 
                               echo $fname->fname." ".$fname->lname;
                            ?> 
                        </option>
                        <?php }?>
                    </select>

                    <div class="container my-3" style="width: fit-content;">
                        <button class="btn btn-primary">Filter</button>
                    </div>

                </form>
            </div>
        </div>    
        
    </div>

    <div class="container-fluid" id = "pdfContent">
            <div class="container-fluid d-flex flex-column justify-content-center">
                <img src= "<?php echo base_url().'assets/img/logos/snsu.png' ?>" alt="snsu logo" style = "width:125px; height: 125px; margin: auto;">
            </div>
            <div class="container-fluid mb-5">
                
                <p class="h4 text-center">Surigao Del Norte State University</p>
                <p class="h6 text-center">Narciso St, Surigao City, Surigao del Norte</p>
                <p class="h6 text-center mt-1">CHED-BDM JC#3</p>
                <p class="h6 text-center mt-1">Rating Perion:</p>
            </div>

        
        <div class="row my-2">
            <div class="col">
                <p class="h6 text-start">
                    Name of Faculty: <?php
                        if(isset($selectedID)){
                            echo $selectedID->lname.' '.$selectedID->fname;
                        }
                        else {
                            echo 'No Selected';
                        }
                    ?>
                </p>
                <p class="h6 text-start">
                    Position: <?php
                        if(isset($selectedID)){
                            echo $selectedID->position;
                        }
                        else {
                            echo 'No Selected';
                        }
                    ?>
                </p>
            </div>
        </div>

        <div class="row my-2">
            <div class="col">
                <table class="table table-bordered " id = "dataTable">
                    <thead>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <th></th>
                            <?php
                                foreach ($evalrow as $name) {
                                    
                                    $split = explode(" ",$name->name);
                                    $parsed = $split[2].' Sem '.$split[count($split) - 1];
                                    echo "<th class='text-center text-wrap' style='width: 5vh; max-width: 10vh;'> ".$parsed."</th>";
                                }
                            ?>
                            
                        </tr>
                        
                        <tr>
                            <th class="text-center" style = "width: 5vh; max-width: 10vh; " >
                                <span class="h6 text-wrap">Average Student Evaluation per sem</span>
                            </th>
                            <?php
                                $totalAverage = 0;
                                $c = 0;
                                foreach ($evalrow as $evalinfo) {
                                    $isEmpty = true;
                                    foreach($query as $row){
                                        if($row->evalID == $evalinfo->id){
                                            $average = ($row->sum / $row->no * 4) / 25.0 * 100.0;
                                            echo "<th class='text-center align-middle'>".number_format((float)$average, 2, '.', '')."</th>";
                                            $isEmpty = false;
                                            $totalAverage += $average;
                                            $c++;
                                            break;
                                            
                                        }
                                    }
                                    if($isEmpty) {
                                        echo "<th class='text-center align-middle'>N/A</th>";
                                    }
                                }
                                if($c > 0)
                                    $totalAverage = $totalAverage / $c;
                            ?>

                            
                        </tr>
                    </tbody>
                    <tfoot>
                        <th text-center>
                            Average 
                        </th>
                        <td class="text-center" colspan="6">
                            <?php
                                echo number_format((float)$totalAverage, 3, '.', '');
                            ?>
                        </td>
                    </tfoot>
                    
                </table>
            </div>
        </div>
        
        
    </div>
    <div class="row">
        <div class="container" id = "saveAs">
            <button class="btn btn-info align-middle">DOWNLOAD PDF</button>
        </div>
    </div>





