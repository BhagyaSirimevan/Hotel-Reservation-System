
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>
<section id="services" class="services">
    <div class="container">

        <div class="section-title">
            <h2>Additional Items</h2>
            <h3>Check Our Additional Items</h3>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="row">

                    <?php
                    $db = dbConn();

                    $sql = "SELECT * FROM tbl_menuitem_category";
                    //   print_r($sql);
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                    
                        while ($row = $result->fetch_assoc()) {
                            $categoryid = $row['MenuItemCategoryId'];
                       
                            ?>

                            <div class="col-md-3">
                                <div class='alert bg-body-secondary' role='alert'>


                                    <h5 class="text-success text-center" style="font-family: arial"> <?= $row['CategoryName'] ?> </h5>
                                    <div class="row mt-3">
                                  
                                     
                                         
                                            <?php 
                                            $sql3 = "SELECT * FROM tbl_menuitem m WHERE m.MenuItemCategoryId='$categoryid' ";
                                            
                                            $result3 = $db->query($sql3);
                                            if ($result3->num_rows > 0) {
                                                ?>
                                        <ul style="list-style: none">
                                                
                                                <?php
                                                   while ($row3 = $result3->fetch_assoc()) {
                                                       ?>
                                                    <div class="card mt-4">
                                                        <li class="text-center bg-secondary text-white"><strong><?= $row3['MenuItemName'] ?></strong>
                                                    </li>
                                                    <img class="img-fluid" style="height:200px; width:270px"  src="../system/assets/images/menuitem/<?= $row3['MenuItemImage'] ?>">
                                                    <strong class="text-center">Per Person Price Rs. <?= $row3['PortionPrice'] * 125 / 100 ?></strong>
                                                    </div>
                                                
                                                    <?php   
                                                   }
                                                   ?> 
                                                    </ul>
                                                    <?php
                                         
                                            }
                                            
                                            
                                            ?>
                                                
                                            
                                            
                                          
                                        
                                        <?php
                                          
                                          ?>
                                       <?php
                                     
                                     
                                     
                                     
                                     ?>

                                    </div>

                                </div>
                            </div>




                            <?php
                        }
                        ?>   
                    <?php }
                    ?>

                </div>


            </div>


        </div>

    </div>
</section><!-- End Services Section -->

<?php include 'footer.php'; ?>