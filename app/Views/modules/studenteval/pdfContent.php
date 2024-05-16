<div class="container-fluid pt-5" id="pdfContent">
    

    <div class="container-fluid d-flex flex-column justify-content-center">
        <img src= "<?php echo base_url().'assets/img/logos/snsu.png' ?>" alt="snsu logo" style = "width:125px; height: 125px; margin: auto;">
    </div>
    <div class="container-fluid mb-5">
        
        <p class="h5 text-center">Surigao Del Norte State University</p>
        <p class="h6 text-center">Narciso St, Surigao City, Surigao del Norte</p>
        
    </div>

    <div class="row mt-5">
        <div class="col">
            <p class="h5 text-center">Evaluation per Course</p>
        </div>

    </div>
    
    <div class="row mt-4">
        <div class="col-6">
            <p class="h6 text-start ps-6" id = "fName">
                Faculty: <?php
                    foreach ($tblFaculty as $faculty){
                        if($faculty->id == $sFaculty){
                            echo $faculty->fname. " " . $faculty->lname;
                        }
                    }
                ?> 
            </p>
        </div>
        
        <div class="col">
            <p class="h6 text-end pe-6">Academic Year: 
                <?php
                    if(isset($sTerm) && isset($sYear)) {
                        echo $sYear. " - ". ($sYear+1). " " .($sTerm == 1 ? '[1st Sem]' : '[2nd Sem]');
                    }
                ?>
            </p>
        </div>
    </div>


    <div class="row mt-2">
        <div class="col-6">
            <p class="h6 text-start ps-6">
                Course: <?php
                    foreach ($tblSubject as $sub){
                        if($sub->subID == $sSubject){
                            echo $sub->title;
                        }
                    }
                ?> 
            </p>
        </div>
    </div>