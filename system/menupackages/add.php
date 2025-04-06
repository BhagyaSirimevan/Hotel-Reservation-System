<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Menu Package Management </h1>
        
    </div>

    <?php
//     
    // ignore spaces (trim)     
    //  $Pname=trim($Pname);  
    // remove backslash \
    //  $Pname=stripcslashes($Pname);   
    // 
    //  $Pname= htmlspecialchars($Pname); 
    //  echo $Pname; 
    //  echo $pQty;
    //  echo $Pprice;
    // 2nd step- extact the form field 
    // convert array keys to the seperate variable with the value(extract)
    // $menuitemlist= array() ; 
    extract($_POST);
//    if(!empty(@$item)){
//        echo 'item';
//        print_r(@$item);
//         echo '<br>';
//        foreach (@$item as $value){
//            $db = dbConn();
//            $sql= "SELECT m.MenuItemName,m.PortionPrice,c.CategoryName,m.MenuItemId,m.MenuItemCategoryId FROM tbl_menuitem m INNER JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId ";
//            $result = $db->query($sql);
//            $row = $result->fetch_assoc();
//            
//            $_SESSION['selecteditems'][$row['MenuItemId']] = array('menuitemname'=> $row['MenuItemName'],'portionprice'=>$row['PortionPrice'],'categoryid'=>$row['MenuItemCategoryId']);
//        }
//        echo '<br>';
//        print_r($_SESSION['selecteditems']);
//         echo '<br>';
//        
//    }
    // $menuitemlist = array_merge($menuitemlist,@$item);
    // var_dump($_POST);
    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {


        //  var_dump($_POST);
        // 3rd step- clean input
        $packagetype = cleanInput($packagetype);
        $packagename = cleanInput($packagename);
        //    $plateprice = cleanInput($plateprice);
        $servicecharge = cleanInput($servicecharge);
        $platelastprice = cleanInput($platelastprice);

        // Required Validation
        $message = array();

        if (empty($packagetype)) {
            $message['error_packagetype'] = "Should be Select Menu Package Type..!";
        }

        if (empty($packagename)) {
            $message['error_packagename'] = "Menu Package Name should not be blank..!";
        } else {
            $db = dbConn();
            $sql = "SELECT * FROM tbl_menupackage WHERE MenuPackageName	='$packagename'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $message['error_packagename'] = "This Menu Package Name is Already Exist";
            }
        }

        if (empty($plateprice)) {
            $message['error_plateprice'] = "Plate Price should not be blank..!";
        } elseif (!is_numeric($plateprice)) {
            $message['error_plateprice'] = "Plate Price is Invalid..!";
        } elseif ($plateprice < 0) {
            $message['error_plateprice'] = "Plate Price cannot be Negative..!";
        }


        if (empty($servicecharge)) {
            $message['error_servicecharge'] = "Service Charge should not be blank..!";
        } elseif (!is_numeric($servicecharge)) {
            $message['error_servicecharge'] = "Service Charge is Invalid..!";
        } elseif ($servicecharge < 0) {
            $message['error_servicecharge'] = "Service Charge cannot be Negative..!";
        }

        if (empty($platelastprice)) {
            $message['error_platelastprice'] = "Plate Last Price should not be blank..!";
        } elseif (!is_numeric($platelastprice)) {
            $message['error_platelastprice'] = "Plate Last Price is Invalid..!";
        } elseif ($platelastprice < 0) {
            $message['error_platelastprice'] = "Plate Last Price cannot be Negative..!";
        }



        if (empty($MenuPackageStatus)) {
            $message['error_status'] = "Should be select Status..!";
        }









        //  var_dump($message);
        //  var_dump($message);

        if (empty($message)) {

            $userid = $_SESSION['userid'];

            $cdate = date('Y-m-d');
            $sql = "INSERT INTO tbl_menupackage(PackageTypeId,MenuPackageName,PlatePrice,ServiceCharge,PlateLastPrice,MenuPackageStatus,AddDate,AddUser) "
                    . "VALUES('$packagetype','$packagename','$plateprice','$servicecharge','$platelastprice','$MenuPackageStatus','$cdate','$userid')";
            // print_r($sql);

            $db = dbConn();
            $db->query($sql);

            $MenuPackageId = $db->insert_id;

            foreach ($item as $value) {
                $sql = "INSERT INTO tbl_mpitemlist(MenuPackageId,MenuItemId) VALUES('$MenuPackageId','$value') ";
                //     print_r($sql);
                $db->query($sql);
            }

            //  $newmenuitemid = $db->insert_id;

            header('Location:addsuccess.php?MenuPackageId=' . $MenuPackageId);
        }
    }
    ?>


    <h2>Add New Menu Package</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


        <div class="row">



            <div class="col-md-4">

                <div class="row">
                    <div class="col-md-12 mt-3 mb-2">
                        <label for="packagetype" class="form-label">Menu Package Type</label>

                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM tbl_packagetype";
                        $result = $db->query($sql);
                        ?>

                        <select class="form-select" id="packagetype" name="packagetype">
                            <option value="">Select Menu Package Type</option>

                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>

                                    <option value=<?= $row['PackageTypeId']; ?> <?php if ($row['PackageTypeId'] == @$packagetype) { ?>selected <?php } ?>><?= $row['PackageTypeName'] ?></option>


                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="text-danger">
                            <?= @$message['error_packagetype'] ?>  
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="package" class="form-label">Menu Package Name</label>
                        <input type="text" class="form-control" id="package" name="packagename" value="<?= @$packagename ?>">
                        <div class="text-danger">
                            <?= @$message['error_packagename'] ?>  
                        </div>


                    </div>



                    <div class="col-md-12 mb-2">
                        <label for="plate" class="form-label">Plate Price (Rs)</label>

                        <?php
                        if (!empty(@$item)) {
                            @$plateprice = 0;
                            foreach (@$item as $value) {
                                $sql = "SELECT PortionPrice FROM tbl_menuitem WHERE MenuItemId='$value'";
                                // print_r($sql);
                                $db = dbConn();
                                $result = $db->query($sql);
                                $row = $result->fetch_assoc();

                                @$plateprice = @$plateprice + $row['PortionPrice'];
                            }
                            //  print_r(@$plateprice); 
                        }
                        ?>


                        <input type="number" class="form-control" id="plate" name="plateprice" value="<?= @$plateprice ?>" readonly>

                        <div class="text-danger">
                            <?= @$message['error_plateprice'] ?>  
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="scharge" class="form-label">Service Charge (%)</label>
                        <input type="number" class="form-control" id="scharge" name="servicecharge" value="<?= @$servicecharge ?>" onchange="form.submit()">
                        <div class="text-danger">
                            <?= @$message['error_servicecharge'] ?>  
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="lastprice" class="form-label">Plate Last Price (Rs)</label>


                        <?php
                        if (!empty(@$plateprice && @$servicecharge)) {
                            @$platelastprice = 0;
                            @$platelastprice = @$plateprice + (@$plateprice * @$servicecharge / 100);
                        }
                        ?>
                        <input type="number" class="form-control" id="lastprice" name="platelastprice" value="<?= @$platelastprice ?>" readonly>
                        <div class="text-danger">
                            <?= @$message['error_platelastprice'] ?>  
                        </div>

                    </div>




                    <div class="col-md-12 mb-2">

                        <label>Select Status</label>
                        <br>


                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" name="MenuPackageStatus" id="available" value="Available" <?php if (isset($MenuPackageStatus) && $MenuPackageStatus == 'Available') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="available">Available</label>
                        </div>
                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" name="MenuPackageStatus" id="notavailable" value="Not Available" <?php if (isset($MenuPackageStatus) && $MenuPackageStatus == 'Not Available') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="notavailable">Not Available</label>
                        </div>




                        <div class="text-danger">
                            <?= @$message['error_status'] ?>  
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-2">

                        </div>

                        <div class="col-md-10">
                            <a href="add.php" class="btn btn-secondary" name="action" value="cancel">Cancel</a>
                            <button type="submit" class="btn btn-success" name="action" value="save">Submit</button>
                        </div>
                    </div>




                </div>

            </div>
            <div class="col-md-8">
                <div class="col-md-12 mt-3">
                    <div class="card border-secondary mb-3" style="max-width: 50rem;">
                        <div class="card-header bg-secondary text-center text-white">Menu Item List</div>
                        <div class="card-body text-black">

                            <div class="row">

                                
                               
                                <div class="col-md-4">

                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM tbl_menuitem_category";
                                    $result = $db->query($sql);
                                    ?>

                                    <select class="form-select" id="itemcategory" name="itemcategory" onchange="form.submit()">
                                        <option value="">Select Category</option>

                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>

                                                <option value=<?= $row['MenuItemCategoryId']; ?> <?php if ($row['MenuItemCategoryId'] == @$itemcategory) { ?>selected <?php } ?>><?= $row['CategoryName'] ?></option>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>


                            <div class="row mt-3 mb-2">
                                <div class="table-responsive">
                                    <?php
                                   
//                                   if(!empty(@$itemcategory)){
                                //    $sql = "SELECT * FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE m.MenuItemCategoryId='$itemcategory'";
                                 //   print_r($sql);
                                   
//                                    } else  {
                                    //    echo 'table';
                                      //  print_r($_SESSION['selecteditems']);
                                       $sql = "SELECT * FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId";  
                                  //  } 
                                     $db = dbConn();
                                    $result = $db->query($sql);
                                    ?>

                                    <table class="table table-sm">
                                        <thead class="bg-transparent">
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Item Category</th>
                                                <th scope="col">Menu Item Name</th>
                                                <th scope="col">Portion Price (Rs) </th>
                                                <th scope="col">Select </th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if ($result->num_rows > 0) {
                                                //  $totalmenuprice = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    // floatval(@$plateprice) += floatval($row['PortionPrice']);
                                                    ?>

                                                    <tr>
                                                        <td></td>
                                                        <td><?= $row['CategoryName'] ?></td>
                                                        <td><?= $row['MenuItemName'] ?></td>
                                                        <td><?= $row['PortionPrice'] ?></td> 
                                                        <td> <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" onchange="form.submit()" id="<?= $row['MenuItemId'] ?>" name="item[]" value="<?= $row['MenuItemId'] ?>" <?php if (isset($item) && in_array($row['MenuItemId'], $item)) { ?> checked <?php } ?> >
                                                                <label class="form-check-label" for="item"></label>
                                                            </div>

                                                        </td> 


                                                    </tr>

                                                    <?php
                                                    // $db = dbConn();
                                                    // if(!empty(@$item)){
                                                    //   $sql2= "SELECT SUM(m.PortionPrice) FROM `tbl_mpitemlist` l INNER JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId WHERE MenuPackageId='" . @$MenuPackageId . "'";
                                                    //   @$plateprice = $db->query($sql2);
                                                }
                                            }

//}
                                            ?>


                                        </tbody>
                                    </table>
                                </div>




                            </div>






                        </div>
                    </div>
                </div>
            </div>











    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 