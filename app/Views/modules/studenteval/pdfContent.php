<div class="container-fluid pt-5" id="pdfContent">
    <div class="row mt-5">
        <div class="col">
            <p class="h4 text-center">Evaluation per Course</p>
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
                        echo $sYear. " - ". ($sYear+1). " " .($sTerm == 1 ? '[1st Term]' : '[2nd Term]');
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