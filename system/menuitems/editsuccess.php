<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center"> Menu Item Updated Successfully! </h1>

    </div>
    
     <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
      //  var_dump($_GET);

        // ex : 8
        $MenuItemId = $_GET['MenuItemId'];

//        echo $MenuItemId;
//       echo "<br>";
//      echo "<br>";

        // fullname,colname,designation,district,Edescription
        $updatedfields = $_GET['UpdatedFieldsString'];

//        echo $updatedfields;
//      echo "<br>";
//      echo "<br>";

        // array(5) { [0]=> string(8) "fullname" [1]=> string(7) "colname" [2]=> string(11) "designation" [3]=> string(8) "district" [4]=> string(12) "Edescription" }
        $updatedfields_array = explode(",", $updatedfields);

        
//        var_dump($updatedfields_array);
//        echo "<br>";
//        echo "<br>";

        $db = dbConn();
        $sql = "SELECT m.MenuItemCategoryId as itemcategory,c.MenuItemCategoryId,c.CategoryName as categoryname,m.MenuItemName as itemname,m.MenuItemCost as itemcost,m.ProfitRatio as profitratio,m.PortionPrice as portionprice,m.MenuItemImage as file_name_new,m.MenuItemStatus as MenuItemStatus FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE m.MenuItemId='$MenuItemId'";
      //  print_r($sql);
        $result = $db->query($sql);

        $row = $result->fetch_assoc();
        ?>

    <div class="row">
        
        

            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <h5 class="text-lg-center">Updated Menu Item Details</h1>
                        <table class="table table-striped table-sm">
                            <thead class="bg-secondary text-lg" >
                                <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Updated Value</th>

                                </tr>
                            </thead>

                            <tbody>
                                
                                 <tr>
                                    <td>Menu Item Category</td>
                                    <td class="<?= in_array('itemcategory', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['categoryname'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Menu Item Name</td>
                                    <td class="<?= in_array('itemname', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['itemname'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Menu Item Cost (Rs)</td>
                                    <td class="<?= in_array('itemcost', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['itemcost'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Profit Ratio (%)</td>
                                    <td class="<?= in_array('profitratio', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['profitratio'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Portion Price (Rs)</td>
                                    <td class="<?= in_array('portionprice', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['portionprice'] ?></td>

                                </tr>
                                
                                
                                
                                <tr>
                                    <td>Menu Item Image</td>
                                    <td class="<?= in_array('file_name_new', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['file_name_new'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Status</td>
                                    <td class="<?= in_array('MenuItemStatus', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['MenuItemStatus'] ?></td>

                                </tr>


                             
                               

                            </tbody>

                        </table>

                </div>


            </div>
            <div class="col-md-2"></div>

            
        </div>


     <?php
    } 
    ?>


<div class="row">
        <div class="col-md-8"></div>
       
        <div class="col-md-4"> <a href="menuitems.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>


</main>



<?php include '../footer.php'; ?> 


  