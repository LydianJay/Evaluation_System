



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
                
                <p class="h5 text-center">Surigao Del Norte State University</p>
            </div>

        
        <div class="row my-2">
            <div class="col">
                <p class="h5 text-center">Semester Summary</p>
                <p class="h6 text-center">Points For Student Evaluation</p>
            </div>
        </div>

        <div class="row my-2">
            <div class="col">
                <table class="table table-primary table-bordered" id = "dataTable">
                    <thead>
                        <tr>
                            <td></td>
                            <?php
                                foreach ($evalrow as $name) {
                                    
                                    $split = explode(" ",$name->name);
                                    $parsed = $split[2].'-'.$split[count($split) - 1];
                                    echo "<td class='text-center'>".$parsed."</td>";
                                }
                            ?>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td class="text-center">Average per Sem</td>
                            <?php
                                foreach ($evalrow as $evalinfo){
                                    $isEmpty = true;
                                    foreach($query as $row){
                                        if($row->evalID == $evalinfo->id){
                                            $average = $row->sum / $row->no * 4;
                                            echo "<td class='text-center'>".number_format((float)$average, 2, '.', '')."</td>";
                                            $isEmpty = false;
                                            break;
                                        }
                                    }
                                    if($isEmpty){
                                        echo "<td class='text-center'>N/A</td>";
                                    }
                                }
                            ?>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
        </div>
        
        
    </div>
    <div class="row">
        <div class="container" id = "saveAs">
            <button class="btn btn-info align-middle">DOWNLOAD PDF</button>
        </div>
    </div>


</main>



