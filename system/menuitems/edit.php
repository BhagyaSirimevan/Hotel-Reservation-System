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
    
     if ($_SERVER['REQUEST_METHOD'] == "GET") {
         
       //  echo "Get";
        extract($_GET);
      //  var_dump($_GET);
     
        
        $db = dbConn();
      $sql = "SELECT * FROM tbl_menuitem WHERE MenuItemId='$MenuItemId'";
    //  print_r($sql);
        $result = $db->query($sql);
        
         
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               
                $itemcategory = $row['MenuItemCategoryId'];
                $itemname = $row['MenuItemName'];
                $itemcost = $row['MenuItemCost'];
                $profitratio = $row['ProfitRatio'];
                $portionprice = $row['PortionPrice'];
                $MenuItemStatus = $row['MenuItemStatus'];
                $itemimage = $row['MenuItemImage'];
                $MenuItemId = $row['MenuItemId'];
       
                 
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
    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST") {


        // 2nd step- extact the form field 
        // convert array keys to the seperate variable with the value(extract)
        extract($_POST);

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
        }


        if (empty($itemcost)) {
            $message['error_itemcost'] = "Menu Item Cost should not be blank..!";
        } elseif (!is_numeric($itemcost)) {
            $message['error_itemcost'] = "Menu Item Cost is Invalid..!";
        } elseif ($itemcost<0) {
            $message['error_itemcost'] = "Menu Item Cost cannot be Negative..!";
        }
        
        
        if (empty($profitratio)) {
            $message['error_profitratio'] = "Profit Ratio should not be blank..!";
        } elseif (!is_numeric($profitratio)) {
            $message['error_profitratio'] = "Profit Ratio is Invalid..!";
        } elseif ($profitratio<0) {
            $message['error_profitratio'] = "Profit Ratio cannot be Negative..!";
        }

        
        if (empty($portionprice)) {
            $message['error_portionprice'] = "Portion Price should not be blank..!";
        } elseif (!is_numeric($portionprice)) {
            $message['error_portionprice'] = "Portion Price is Invalid..!";
        } elseif ($portionprice<0) {
            $message['error_portionprice'] = "Portion Price cannot be Negative..!";
        }



        if (empty($MenuItemStatus)) {
            $message['error_status'] = "Should be select Status..!";
        }



        //  var_dump($message);



        print_r($prv_image);
        print_r($itemimage);
        if (empty($message) && !empty($_FILES['itemimage']['name'])) {
            
         
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
        } else {
            $file_name_new = $prv_image;
        }

        //  var_dump($message);

        if (empty($message)) {
            
            $db = dbConn();
            
           // get existiog values in database
           // $sql = "SELECT * FROM tbl_menuitem WHERE MenuItemId='$MenuItemId'";
              $sql = "SELECT MenuItemCategoryId as itemcategory,MenuItemName as itemname,MenuItemCost as itemcost,ProfitRatio as profitratio,PortionPrice as portionprice,MenuItemImage as file_name_new,MenuItemStatus as MenuItemStatus FROM tbl_menuitem  WHERE MenuItemId='$MenuItemId'";
                print_r($sql);
            
             print_r($sql);
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            
             // get updated field values
            // ex : array(5) { [0]=> string(8) "fullname" [1]=> string(7) "colname" [2]=> string(11) "designation" [3]=> string(8) "district" [4]=> string(12) "Edescription" }

            $updatedfieldnames = updatedFields($row,$_POST) ;
            
             // convert updated field values to string 
            // ex: fullname,colname,designation,district,Edescription
            $updatedfieldname_string = implode(",", $updatedfieldnames) ;

            $userid = $_SESSION['userid'];

            $cdate = date('Y-m-d');
            $sql = "UPDATE tbl_menuitem SET MenuItemCategoryId='$itemcategory',MenuItemName='$itemname',MenuItemCost='$itemcost',ProfitRatio='$profitratio',PortionPrice='$portionprice',MenuItemImage='$file_name_new',MenuItemStatus='$MenuItemStatus',UpdateDate='$cdate',UpdateUser='$userid' WHERE MenuItemId='$MenuItemId'";
             print_r($sql);
 
           
            $db->query($sql);
            
       
       
            header('Location:editsuccess.php?MenuItemId='.$MenuItemId.'&UpdatedFieldsString='. urlencode($updatedfieldname_string));


             print_r($sql); 
        }
    }
    ?>


    <h2>Update Menu Item</h2>
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
                        <input type="text" class="form-control" id="profit" name="profitratio" value="<?= @$profitratio ?>">
                        <div class="text-danger">
                            <?= @$message['error_profitratio'] ?>  
                        </div>

                    </div>
                    
                     <div class="col-md-12 mb-2">
                        <label for="portion" class="form-label">Portion Price (Rs)</label>
                        <input type="text" class="form-control" id="portion" name="portionprice" value="<?= @$portionprice ?>">
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
                        
                        <input type="hidden" name="prv_image" value="<?= empty($itemimage)?"noimage.jpg":$itemimage ?>">



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
            <div class="col-md-3">
                 <img class="img-fluid" width="250" src="../assets/images/menuitem/<?= empty($itemimage) ? "noimage.jpg" : $itemimage ?>">
                
                
            </div>
        </div>


        
        
        <div class="row">
            <div class="col-md-7"></div>

            <div class="col-md-5">
                
                
           <input type="hidden" name="MenuItemId" value="<?= $MenuItemId ?>"> 
                
                <a href="add.php" class="btn btn-secondary">Cancel </a>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>

    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 
