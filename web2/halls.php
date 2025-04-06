<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

<section id="portfolio" class="portfolio">
      <div class="container">

        <div class="section-title">
          <h2>Halls</h2>
          <h3>The Best Venue for Your Event</h3>
          
          <div class="row mt-4">
              <div class="col-md-12">
                
                  <div class="row mt-3">
                   
                        <?php
                      
                            $db = dbConn();

                            $sql = "SELECT * FROM tbl_hall WHERE HallStatus='Available'";
                            //   print_r($sql);
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                ?>
                                 <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>

                                        <div class="col-md-4">
                                            <div class='alert bg-body-secondary' role='alert'>


                                                <h5 class="text-danger"> Hall <?= $row['HallName'] ?> </h5>
                                                <div class="row mt-3">
                                                    
                                                        <img class="img-fluid" width="200" src="../system/assets/images/hall/<?= $row['HallImage'] ?>">
                                                        
                                                        <strong style="text-align: left">Minimum Guest Count - <?= $row['MinGuestCount'] ?></strong>
                                                        <br>
                                                        <strong style="text-align: left">Maximum Guest Count - <?= $row['MaxGuestCount'] ?></strong>
                                                        <br>
                                                        <strong style="text-align: left">Available Features - <?php
                                                        $featureslist = explode(",", $row['AvailableFeatures']);
                                                        echo '<ul>';
                                                        foreach ($featureslist as $value) {
                                                            echo '<li>' . $value . '</li>';
                                                        }
                                                        echo '</ul>';
                                                        ?></strong>
                                                       
                                                           
                                                   
                                                </div>



                                                

                                            </div>
                                        </div>

                                        
                                   

                                    <?php
                                }
                               ?>   
                        <?php    } 
                        
                        ?>
                  
                </div>
                  
                  
              </div>
             
            
          </div>
          
          
        </div>
          
         
        

      </div>
    
    
    
    </section>



<?php include 'footer.php'; ?>