
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>
<section id="services" class="services">
    <div class="container">

        <div class="section-title">
            <h2>Menu Packages</h2>
            <h3>Check Our Tasty Menu</h3>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="row">

                    <?php
                    $db = dbConn();

                    $sql = "SELECT * FROM tbl_menupackage WHERE MenuPackageStatus='Available'";
                    //   print_r($sql);
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                    
                        while ($row = $result->fetch_assoc()) {
                            $menupackageid = $row['MenuPackageId'];
                       
                            ?>

                            <div class="col-md-4">
                                <div class='alert bg-body-secondary' role='alert' style="background-image: url('assets/img/food3.jpg');background-repeat: no-repeat;background-size: cover;opacity: 0.8">


                                    <h5 class="text-success text-center bg-white" style="font-family: arial"> <?= $row['MenuPackageName'] ?> </h5>
                                    <div class="row mt-3">
                                     <?php 
                                     
                                    $sql2 = "SELECT * FROM tbl_menuitem_category";
                                    $result2 = $db->query($sql2);
                                     if ($result2->num_rows > 0) {
                                          while ($row2 = $result2->fetch_assoc()) {
                                              $categoryid = $row2['MenuItemCategoryId'];
                                              ?>
                                        <ul style="list-style: none">
                                            <li><strong class='text-white'><?= $row2['CategoryName']?></strong>
                                            <?php 
                                            $sql3 = "SELECT * FROM tbl_mpitemlist l LEFT JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId "
                                            . "WHERE l.MenuPackageId='$menupackageid' AND m.MenuItemCategoryId='$categoryid' ";
                                            
                                            $result3 = $db->query($sql3);
                                            if ($result3->num_rows > 0) {
                                                ?>
                                                <ul>
                                                
                                                <?php
                                                   while ($row3 = $result3->fetch_assoc()) {
                                                       ?>
                                                    <li style="color: white"><?= $row3['MenuItemName'] ?></li>
                                                
                                                    <?php   
                                                   }
                                                   ?> 
                                                    </ul>
                                                    <?php
                                         
                                            }
                                            
                                            
                                            ?>
                                                
                                            </li>
                                            
                                        </ul>   
                                        
                                        <?php
                                          }
                                          ?>
                                        <h5 class="text-success text-center bg-white" style="font-family: arial">Plate Value <?= $row['PlateLastPrice'] ?> </h5>
                                         <?php
                                     }
                                     
                                     
                                     
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