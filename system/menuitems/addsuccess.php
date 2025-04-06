<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center">  New Menu Item Added Successfully! </h1>
       

    </div>
    
    
    <div class="row">
        
        <div class="col-md-2"></div>
        <div class="col-md-8">
             <div class="table-responsive">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                extract($_GET);
              //    var_dump($_GET);

                $newmenuitemid = $_GET['MenuItemId'];

                $sql = "SELECT * FROM tbl_menuitem m "
                        . "LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE m.MenuItemId='$newmenuitemid'";
              //  print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                
                    ?> 
            
            <h5 class="text-lg-center">New Menu Item Details</h1>
                    <table class="table table-striped table-sm">
                        <thead class="bg-secondary text-lg" >
                            <tr>
                                <th scope="col">Field</th>
                                <th scope="col">Value</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                             if ($result->num_rows > 0) {
                               $row = $result->fetch_assoc() ;
                        ?>  
                            <tr>
                                <td>Menu Item Category</td>
                                <td><?= $row['CategoryName'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Menu Item Name</td>
                                <td><?= $row['MenuItemName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Menu Item Cost (Rs)</td>
                                <td><?= $row['MenuItemCost'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Profit Ratio (%)</td>
                                <td><?= $row['ProfitRatio'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Portion Price (Rs)</td>
                                <td><?= $row['PortionPrice'] ?></td>

                            </tr>
                            
                            
                             <tr>
                                <td>Menu Item Image</td>
                                <td><?= $row['MenuItemImage'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Menu Item Status</td>
                                <td><?= $row['MenuItemStatus'] ?></td>

                            </tr>
                            
                            
                             <?php
                            
            } } ?>
                            
                        </tbody>
                    </table>
                </div>

            
        </div>
        <div class="col-md-2"></div>
        
       

            </div>
    
    <div class="row">
        <div class="col-md-8"></div>
       
        <div class="col-md-4"> <a href="menuitems.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>
    
    
    
     </main>

        <?php include '../footer.php'; ?> 

