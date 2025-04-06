<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Menu Item Management </h1>
        
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
    extract($_POST);

    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {




        //  var_dump($_POST);
        // 3rd step- clean input
        $itemcategory = cleanInput($itemcategory);
        $itemname = cleanInput($itemname);
        $itemcost = cleanInput($itemcost);
        $profitratio = cleanInput($profitratio);
        $portionprice = cleanInput($portionprice);

        // Required Validation
        $message = array();

        if (empty($itemcategory)) {
            $message['error_itemcategory'] = "Should be Select Menu Item Category..!";
        }



        if (empty($itemname)) {
            $message['error_itemname'] = "Menu Item Name should not be blank..!";
        } else {
            $db = dbConn();
            $sql = "SELECT * FROM tbl_menuitem WHERE MenuItemName='$itemname'";
            $result = $db->query($sql);
            if ($result->num_rows>0){
               $message['error_itemname'] = "This Menu Item Name is Already Exist" ; 
            }
        } 


        if (empty($itemcost)) {
            $message['error_itemcost'] = "Menu Item Cost should not be blank..!";
        } elseif (!is_numeric($itemcost)) {
            $message['error_itemcost'] = "Menu Item Cost is Invalid..!";
        } elseif ($itemcost < 0) {
            $message['error_itemcost'] = "Menu Item Cost cannot be Negative..!";
        }


        if (empty($profitratio)) {
            $message['error_profitratio'] = "Profit Ratio should not be blank..!";
        } elseif (!is_numeric($profitratio)) {
            $message['error_profitratio'] = "Profit Ratio is Invalid..!";
        } elseif ($profitratio < 0) {
            $message['error_profitratio'] = "Profit Ratio cannot be Negative..!";
        }

        if (empty($portionprice)) {
            $message['error_portionprice'] = "Portion Price should not be blank..!";
        } elseif (!is_numeric($portionprice)) {
            $message['error_portionprice'] = "Portion Price is Invalid..!";
        } elseif ($portionprice < 0) {
            $message['error_portionprice'] = "Portion Price cannot be Negative..!";
        }



        if (empty($MenuItemStatus)) {
            $message['error_status'] = "Should be select Status..!";
        }



        //  var_dump($message);




        if (empty($message)) {
            $MenuItemImage = $_FILES['itemimage'];

            $filename = $MenuItemImage['name'];

            $filetmpname = $MenuItemImage['tmp_name'];

            $filesize = $MenuItemImage['size'];

            $fileerror = $MenuItemImage['error'];

            $fileext = explode(".", $filename);

            $fileext = strtolower(end($fileext));

            $allowedext = array("jpg", "jpeg", "png", "gif");

            if (in_array($fileext, $allowedext)) {

                if ($fileerror === 0) {
                    if ($filesize <= 2097152) {
                        $file_name_new = uniqid("", true) . "." . $fileext;
                        $file_destination = "../assets/images/menuitem/" . $file_name_new;

                        if (move_uploaded_file($filetmpname, $file_destination)) {
                            echo "The file was uploaded successfully.";
                        } else {
                            $message['error_file'] = "There was an error uploading the file.";
                        }
                    } else {
                        $message['error_file'] = "This File is Invalid ...!";
                    }
                } else {
                    $message['error_file'] = "This File has Error ...!";
                }
            } else {

                $message['error_file'] = "This File Type not Allowed...!";
            }
        }

        //  var_dump($message);

        if (empty($message)) {

            $userid = $_SESSION['userid'];

            $cdate = date('Y-m-d');
            $sql = "INSERT INTO tbl_menuitem(MenuItemCategoryId,MenuItemName,MenuItemCost,ProfitRatio,PortionPrice,MenuItemImage,MenuItemStatus,AddDate,AddUser) "
                    . "VALUES('$itemcategory','$itemname','$itemcost','$profitratio','$portionprice','$file_name_new','$MenuItemStatus','$cdate','$userid')";
            //    print_r($sql);


            $db = dbConn();
            $db->query($sql);

            $newmenuitemid = $db->insert_id;

            header('Location:addsuccess.php?MenuItemId=' . $newmenuitemid);

            // print_r($sql); 
        }
    }
    ?>


    <h2>Add New Menu Item</h2>
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


        <div class="row">

            <div class="col-md-3"></div>

            <div class="col-md-6">

                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="itemcategory" class="form-label">Menu Item Category</label>

                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM tbl_menuitem_category";
                        $result = $db->query($sql);
                        ?>

                        <select class="form-select" id="itemcategory" name="itemcategory">
                            <option value="">Select Menu Item Category</option>

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
                        <div class="text-danger">
                            <?= @$message['error_itemcategory'] ?>  
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="item" class="form-label">Menu Item Name</label>
                        <input type="text" class="form-control" id="item" name="itemname" value="<?= @$itemname ?>">
                        <div class="text-danger">
                            <?= @$message['error_itemname'] ?>  
                        </div>



                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="cost" class="form-label">Menu Item Cost (Rs)</label>
                        <input type="text" class="form-control" id="cost" name="itemcost" value="<?= @$itemcost ?>">
                        <div class="text-danger">
                            <?= @$message['error_itemcost'] ?>  
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="profit" class="form-label">Profit Ratio (%)</label>
                        <input type="text" class="form-control" id="profit" name="profitratio" value="<?= @$profitratio ?>" onchange="form.submit()">
                        <div class="text-danger">
                            <?= @$message['error_profitratio'] ?>  
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="portion" class="form-label">Portion Price (Rs)</label>

                        <?php
                        if (!empty(@$itemcost && @$profitratio)) {
                            @$portionprice = @$itemcost + (@$itemcost * @$profitratio / 100);
                        }

                        ?>


                        <input type="text" class="form-control" id="portion" name="portionprice" value="<?= @$portionprice ?>" readonly>
                        <div class="text-danger">
                            <?= @$message['error_portionprice'] ?>  
                        </div>

                    </div>



                    <div class="col-md-12 mb-2">
                        <label for="image" class="form-label">Menu Item Image</label>
                        <input type="file" class="form-control" id="image" name="itemimage" value="<?= @$itemimage ?>">
                        <div class="text-danger">
                            <?= @$message['error_itemimage'] ?>  
                        </div>



                    </div>

                    <div class="col-md-12 mb-2">

                        <label>Select Status</label>
                        <br>


                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" name="MenuItemStatus" id="available" value="Available" <?php if (isset($MenuItemStatus) && $MenuItemStatus == 'Available') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="available">Available</label>
                        </div>
                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" name="MenuItemStatus" id="notavailable" value="Not Available" <?php if (isset($MenuItemStatus) && $MenuItemStatus == 'Not Available') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="notavailable">Not Available</label>
                                      </div>




                        <div class="text-danger">
                            <?= @$message['error_status'] ?>  
                        </div>

                    </div>




                </div>

            </div>
            <div class="col-md-3"></div>
        </div>


        <div class="row">
            <div class="col-md-7"></div>

            <div class="col-md-5">
                <a href="add.php" class="btn btn-secondary" name="action" value="cancel">Cancel </a>
                <button type="submit" class="btn btn-success" name="action" value="save">Submit</button>
            </div>
        </div>








    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 