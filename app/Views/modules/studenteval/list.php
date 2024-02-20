<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h4 class="font-weight-bolder mb-0"><?php echo ucfirst($module_title) ?> List</h4>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                </div>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
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
        <form action="<?php echo $current_page ?>" method="post">
            <div class="row mt-5">
                <div class="col-2 ms-3">
                    <p class="h4 text-end">Faculty:</p>                
                </div>
                <div class="col-3">

                    <select name = "facultyField" id = "facultyField" class="form-control select2 w-50">
                        <?php
                            foreach($tblFaculty as $faculty){
                        ?>
                        <option value="<?php echo $faculty->id; ?>" 
                            <?php
                                if(isset($sFaculty)) {
                                    echo $faculty->id == $sFaculty ? 'selected' : '';
                                }
                            ?>
                        > 
                            
                            <?php echo $faculty->fname." ".$faculty->lname;?> 
                        
                        </option>
                            
                        <?php
                            }
                        ?>
                    </select>
                
                </div>

                <div class="col-2">
                    <p class="h4 text-end">Term:</p>
                </div>
                <div class="col-3">
                    <select name="termField" id="termField" class="form-control select2 w-50">
                        <?php for($i = 0; $i < 2; $i++) {?>
                        
                        <option value="<?php echo $i+1; ?>" 
                            <?php 
                                if(isset($sTerm)) {
                                    echo $sTerm == ($i+1) ? 'selected' : '';
                                }
                            ?>
                        
                        > 
                            <?php
                                echo ($i+1) == 1 ? '1st Term' : '2nd Term';
                            ?>    
                        </option>
                        
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-2 ms-3">
                    <p class="h4 text-end">Course:</p>                
                </div>
                <div class="col-3">

                    <select name = "subjectField" id = "subjectField" class="form-control select2 w-50">
                        <?php foreach($tblSubject as $sub){ ?>
                        <option value="<?php echo $sub->subID; ?>" 
                            <?php
                                if(isset($sSubject)){
                                    echo $sub->subID == $sSubject ? 'selected' : '';
                                }
                            ?>
                        >
                            <?php
                                echo $sub->title;
                            ?>
                        </option>

                        <?php }?>
                    </select>
                
                </div>

                <div class="col-2">
                    <p class="h4 text-end">AY:</p>
                </div>
                <div class="col-3">
                    <select name="yearField" id="yearField" class="form-control select2 w-50">
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
                            
                            <option value="<?php echo $i;?>" <?php echo ($sYear == $i) ?  'selected' : '';?>> 
                                <?php echo $i."-".$i+1; ?>
                            </option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="container mt-2" style="width: fit-content;">
                        <button class="btn btn-primary" type = "submit">Filter</button>

                    </div>
                </div>
            </div>
        </form>
    
        

        <div class="row mt-5">
            <div class="col">
                <p class="h4 text-center">Evaluation Per Subject</p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <table class="table table-bordered border-dark" id = "dataTable">
                    <thead>
                        <tr>
                            
                            <th class="text-center">Student No. </th>
                            <?php foreach($tblCat as $cat){?>
                                
                                <th class="text-center">
                                    <?php
                                        echo $cat->catName;
                                    ?>
                                </th>

                            <?php }?>

                        </tr>
                        
                    </thead>
                    <tbody>

                        <?php 
                            $no = 1;
                            $ave = array_fill(0,$noCat,0);
                            $counter = 0;
                            if(isset($ratings)){
                                foreach($tblCat as $cat) {
                            
                        ?>        
                        <tr>
                            <?php
                                    echo "<td class='text-center'>".$no."</td>";
                                    
                                    foreach($ratings as $rating) {
                                        if($cat->catID == $rating->catID) {
                                            
                            ?>

                            <td class ="text-center">
                                <?php
                                            
                                            
                                            $index = (  (($counter % $noCat) * $noCat) + ($cat->catID - 1)  );
                                            echo $ratings[$index]->rating;
                                            $ave[$cat->catID - 1] += $ratings[$counter]->rating;
                                            $counter++;
                                        }


                                ?>
                            </td>

                            <?php 
                                    }
                            ?>
                        </tr>
                        
                        <?php  
                                    $no++; 
                                }
                            }
                            
                        ?>


                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center">Average</th>
                            <?php
                                for($var = 0; $var < $noCat; $var++) {
                            ?>
                            <th class="text-center">
                                <?php
                                    echo $ave[$var] / $ratings[0]->sCount;
                                ?>
                            </th>

                            <?php }?>
                        </tr>
                        
                    </tfoot>
                    
                </table>

            </div>
        </div>


    </div>

        
</main>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            dom: 'Bfrtip',
            searching: false,
            buttons: [{
                    extend: 'print',
                    footer: true,
                    customize: function(win) {
                        // Add your logo on the right side of the title in the header
                        var logoHtml = '<div style="text-align: center;">' +
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
                    title: 'Evaluation',
                    orientation: 'portrait',
                    pageSize: 'LETTER',
                    download: 'open',
                    customize: function(doc) {
                        doc.layout = 'lightHorizontalLines';
                        doc.pageMargins = [30, 30, 30, 30];
                        doc.defaultStyle.fontSize = 12;
                        doc.styles.tableHeader.fontSize = 12;
                        doc.styles.title.fontSize = 14;
                    }
                }
            ],
        });
    });
</script>