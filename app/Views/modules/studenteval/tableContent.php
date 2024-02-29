
    <div class="row mt-5">
        <div class="col">
            <table class="table border-dark" id = "dataTable">
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
                        $ave = array_fill(0,$noCat,0);
                        $counter = 0;

                        if(isset($ratings)){
                            $arrayCount = count($ratings);
                            $noStudents = $arrayCount / $noCat;
                            for($y = 0; $y < $noStudents; $y++) {
                        
                    ?>        
                    <tr>
                        <?php
                                echo "<td class='text-center'>".($y+1)."</td>";
                                
                                for($x = 0; $x < $noCat; $x++) {
                                        
                                        
                        ?>

                        <td class ="text-center">
                            <?php
                                        
                                    
                                    $value = $ratings[ $x + $y * $noCat]->rating;
                                    echo $value;
                                    
                                    $ave[$x] += $value;


                            ?>
                        </td>

                        <?php 
                                }
                        ?>
                    </tr>
                    
                    <?php  
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
                                if(isset($ratings)){
                                    if(count($ratings) > 0){
                                        
                                        echo round($ave[$var] / $noStudents, 4);
                                    }
                                }
                            ?>
                        </th>

                        <?php }?>
                    </tr>
                    
                </tfoot>
                
            </table>

        </div>
    </div>


    <div class="container mt-5" id = "saveAs">
        <button class="btn btn-info align-middle">DOWNLOAD PDF</button>
    </div>


</div>