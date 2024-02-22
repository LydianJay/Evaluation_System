



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
        
        <div class="row my-2">
            <div class="col">
                <p class="h4 text-center">Semester Summary</p>
                <p class="h6 text-center">Points For Student Evaluation</p>
            </div>
        </div>

        <div class="row my-2">
            <div class="col">
                <table class="table border-dark" id = "dataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <?php
                                foreach ($evalrow as $name){
                                    
                                    $split = explode(" ",$name->name);
                                    $parsed = $split[2].'-'.$split[count($split) - 1];
                                    echo "<th class='text-center'>".$parsed."</th>";
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
                                            $average = $row->sum / $row->no * 5;
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
                    <tfoot>
                        <tr>
                            <td class="text-center">Average Rating</td>
                            <?php
                                foreach ($evalrow as $evalinfo){
                                    $isEmpty = true;
                                    
                                    foreach($query as $row) {
                                        if($row->evalID == $evalinfo->id) {
                                            $average = $row->sum / $row->no * 5 / 5;
                                            echo "<td class='text-center'>".number_format((float)$average, 2, '.', '')."</td>";
                                            $isEmpty = false;
                                            break;
                                        }
    
                                    }
                                    if($isEmpty) {
                                        echo "<td class='text-center'>N/A</td>";
                                    }
                                }
                            ?>
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
                    title: 'Semester Evaluation',
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