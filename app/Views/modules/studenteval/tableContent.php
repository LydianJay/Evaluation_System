
    <div class="row mt-5">
        <div class="col">
            <table class="table table-bordered" id = "dataTable">
                <thead>
                    <tr>
                        
                        <th class="text-center" style = "width: 5vh; max-width: 5vh; ">Student No. </th>
                        <?php foreach($tblCat as $cat){?>
                            
                            <th class="text-center" style = "width: 5vh; max-width: 5vh; ">
                                <?php
                                    echo $cat->catName;
                                ?>
                            </th>

                        <?php }?>
                        <th class="text-center" style = "width: 5vh; max-width: 5vh; ">Total</th>
                    </tr>
                    
                </thead>
                <tbody>

                    <?php 
                        $ave = array_fill(0,$noCat,0);
                        $counter = 0;
                        
                        if(isset($ratings)){
                            $arrayCount = count($ratings);
                            $noStudents = $arrayCount / $noCat;
                            $colSum = 0;
                            for($y = 0; $y < $noStudents; $y++) {
                        
                    ?>        
                    <tr>
                        <?php
                                echo "<td class='text-center'>".($y+1)."</td>";
                                $rowSum = 0;
                                
                                for($x = 0; $x < $noCat; $x++) {
                                        
                                        
                        ?>

                        <td class ="text-center">
                            <?php
                                        
                                    
                                    $value = $ratings[ $x + $y * $noCat]->rating;
                                    echo $value;
                                    $rowSum += $ratings[ $x + $y * $noCat]->rating;
                                    $ave[$x] += $value;


                            ?>
                        </td>
                            
                        <?php 
                                }
                            $colSum += $rowSum;
                        ?>
                        <td class="text-center"> 
                            <?php echo $rowSum; ?>
                        </td>
                        
                    </tr>
                            
                    
                    <?php  
                            }


                        }
                        
                    ?>



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

                        <?php 
                            }
                            
                        ?>
                       
                        <th class="text-center"><?php 
                            if(isset($colSum)) 
                                echo $colSum / 100 * $noStudents; 
                        ?></th>
                    </tr>

                </tbody>
                <tfoot>
                    
                    
                </tfoot>
                
            </table>

        </div>
    </div>


    


</div>

<div class="container" id = "saveAs">
    <button class="btn btn-info align-middle">DOWNLOAD PDF</button>
</div>