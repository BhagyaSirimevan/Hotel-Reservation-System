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
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        //   echo "Get";
        extract($_GET);
        //  var_dump($_GET);
        //   echo '<br>';
        // echo '<br>';

        $db = dbConn();
        $sql = "SELECT * FROM tbl_menupackage WHERE MenuPackageId='$MenuPackageId'";
        //  print_r($sql);
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $MenuPackageId = $row['MenuPackageId'];
                $packagetype = $row['PackageTypeId'];
                $packagename = $row['MenuPackageName'];
                $plateprice = $row['PlatePrice'];
                $servicecharge = $row['ServiceCharge'];
                $platelastprice = $row['PlateLastPrice'];
                $MenuPackageStatus = $row['MenuPackageStatus'];
            }
        }

        $sql = "SELECT * FROM tbl_mpitemlist WHERE MenuPackageId='$MenuPackageId'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $size = array();
            while ($row = $result->fetch_assoc()) {
                $item[] = $row['MenuItemId'];
            }
        }
    }

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
        }
//         else {
//            $db = dbConn();
//            $sql = "SELECT * FROM tbl_menupackage WHERE MenuPackageName	='$packagename'";
//            $result = $db->query($sql);
//            if ($result->num_rows>0){
//               $message['error_packagename'] = "This Menu Package Name is Already Exist" ; 
//            }
//        } 

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

            $db = dbConn();

            // get existiog values in database
            // $sql = "SELECT * FROM tbl_menuitem WHERE MenuItemId='$MenuItemId'";
            $sql = "SELECT PackageTypeId as packagetype,MenuPackageName as packagename,PlatePrice as plateprice,ServiceCharge as servicecharge,PlateLastPrice as platelastprice,MenuPackageStatus as MenuPackageStatus FROM tbl_menupackage WHERE MenuPackageId='$MenuPackageId'";
            //  print_r($sql);
            // print_r($sql);
            $result = $db->query($sql);
            $row = $result->fetch_assoc();

            // get updated field values
            // ex : array(5) { [0]=> string(8) "fullname" [1]=> string(7) "colname" [2]=> string(11) "designation" [3]=> string(8) "district" [4]=> string(12) "Edescription" }

            $updatedfieldnames = updatedFields($row, $_POST);

            // convert updated field values to string 
            // ex: fullname,colname,designation,district,Edescription
            $updatedfieldname_string = implode(",", $updatedfieldnames);

            $userid = $_SESSION['userid'];

            $cdate = date('Y-m-d');
            $sql = "UPDATE tbl_menupackage SET PackageTypeId='$packagetype',MenuPackageName='$packagename',PlatePrice='$plateprice',ServiceCharge='$servicecharge',PlateLastPrice='$platelastprice',MenuPackageStatus='$MenuPackageStatus',UpdateDate='$cdate',UpdateUser='$userid' WHERE MenuPackageId='$MenuPackageId'";

            // print_r($sql);

            $db->query($sql);

            header('Location:editsuccess.php?MenuPackageId=' . $MenuPackageId . '&UpdatedFieldsString=' . urlencode($updatedfieldname_string));

            //  $MenuPackageId = $db->insert_id;



            $sql = "DELETE FROM tbl_mpitemlist WHERE MenuPackageId='$MenuPackageId'";
            $db->query($sql);

            foreach ($item as $value) {
                $sql = "INSERT INTO tbl_mpitemlist(MenuPackageId,MenuItemId) VALUES('$MenuPackageId','$value') ";
                $db->query($sql);
            }

            //  $newmenuitemid = $db->insert_id;
            // header('Location:addsuccess.php?MenuPackageId=' . $MenuPackageId);
        }
    }
    ?>


    <h2>Update Menu Package</h2>
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


                            <input type="hidden" name="MenuPackageId" value="<?= $MenuPackageId ?>"> 

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


                            <div class="row mt-3 mb-2">
                                <div class="table-responsive">
                                    <?php
                                    $sql = "SELECT * FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId";
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
                                                                <input class="form-check-input" type="checkbox" id="<?= $row['MenuItemId'] ?>" name="item[]" value=<?= $row['MenuItemId'] ?> onchange="form.submit()" <?php if (isset($item) && in_array($row['MenuItemId'], $item)) { ?> checked <?php } ?> >
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