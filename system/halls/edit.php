<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hall Management </h1>
        
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
      //  var_dump($_GET);
        $db = dbConn();
        $sql = "SELECT * FROM tbl_hall WHERE HallId='$HallId'";
     //   print_r($sql);
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $hallname = $row['HallName'];
                $minguest = $row['MinGuestCount'];
                $maxguest = $row['MaxGuestCount'];
                $avafeatures = $row['AvailableFeatures'];
                $HallStatus = $row['HallStatus'];
                $hallimage = $row['HallImage'];
                $HallId = $row['HallId'];
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
        $hallname = cleanInput($hallname);
        $minguest = cleanInput($minguest);
        $maxguest = cleanInput($maxguest);
        $avafeatures = cleanInput($avafeatures);

        // Required Validation
        $message = array();

        if (empty($hallname)) {
            $message['error_hallname'] = "Hall Name should not be blank ..!";
        }

        if (empty($minguest)) {
            $message['error_minguest'] = "Minimum Guest Count should not be blank..!";
        }

        if (empty($maxguest)) {
            $message['error_maxguest'] = "Maximum Guest Count should not be blank..!";
        }

        if (empty($avafeatures)) {
            $message['error_avafeatures'] = "Menu Item Cost should not be blank..!";
        }

        if (empty($HallStatus)) {
            $message['error_status'] = "Should be select Status..!";
        }

        //  var_dump($message);




        if (empty($message)&& !empty($_FILES['hallimage']['name'])) {
             
            $HallImage = $_FILES['hallimage'];

            $filename = $HallImage['name'];

            $filetmpname = $HallImage['tmp_name'];

            $filesize = $HallImage['size'];

            $fileerror = $HallImage['error'];

            $fileext = explode(".", $filename);

            $fileext = strtolower(end($fileext));

            $allowedext = array("jpg", "jpeg", "png", "gif");

            if (in_array($fileext, $allowedext)) {

                if ($fileerror === 0) {
                    if ($filesize <= 2097152) {
                        $file_name_new = uniqid("", true) . "." . $fileext;
                        $file_destination = "../assets/images/hall/" . $file_name_new;

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
            $sql = "SELECT HallName as hallname,MinGuestCount as minguest,MaxGuestCount as maxguest,HallImage as file_name_new,AvailableFeatures as avafeatures,HallStatus as HallStatus FROM tbl_hall WHERE HallId='$HallId'";
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
            $sql = "UPDATE tbl_hall SET HallName='$hallname',MinGuestCount='$minguest',MaxGuestCount='$maxguest',HallImage='$file_name_new',AvailableFeatures='$avafeatures',HallStatus='$HallStatus',UpdateDate='$cdate',UpdateUser='$userid' WHERE HallId='$HallId'";
                 
            //    print_r($sql);

            $db->query($sql);

            header('Location:editsuccess.php?HallId='.$HallId.'&UpdatedFieldsString='. urlencode($updatedfieldname_string));

     

            // print_r($sql); 
        }
    }
    ?>


    <h2>Update Hall</h2>
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


        <div class="row">

            <div class="col-md-3"></div>

            <div class="col-md-6">

                <div class="row">

                    <div class="col-md-12 mb-2">
                        <label for="hall" class="form-label">Hall Name</label>
                        <input type="text" class="form-control" id="hall" name="hallname" value="<?= @$hallname ?>">
                        <div class="text-danger">
                            <?= @$message['error_hallname'] ?>  
                        </div>



                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="min" class="form-label">Minimum Guest Count</label>
                        <input type="text" class="form-control" id="min" name="minguest" value="<?= @$minguest ?>">
                        <div class="text-danger">
                            <?= @$message['error_minguest'] ?>  
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="max" class="form-label">Maximum Guest Count</label>
                        <input type="text" class="form-control" id="max" name="maxguest" value="<?= @$maxguest ?>">
                        <div class="text-danger">
                            <?= @$message['error_maxguest'] ?>  
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">


                        


                        <label for="features" class="form-label">Available Features</label>
                       <textarea class="form-control" id="features" name="avafeatures"><?= @$avafeatures ?></textarea>
                        <div class="text-danger">
                            <?= @$message['error_avafeatures'] ?>  
                        </div>

                    </div>



                    <div class="col-md-12 mb-2">
                        <label for="image" class="form-label">Hall Image</label>
                        <input type="file" class="form-control" id="image" name="hallimage" value="<?= @$hallimage ?>">
                        <div class="text-danger">
                            <?= @$message['error_hallimage'] ?>  
                        </div>
                        
                        <input type="hidden" name="prv_image" value="<?= empty($hallimage)?"noimage.jpg":$hallimage ?>">



                    </div>

                    <div class="col-md-12 mb-2">

                        <label>Select Status</label>
                        <br>


                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" name="HallStatus" id="available" value="Available" <?php if (isset($HallStatus) && $HallStatus == 'Available') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="available">Available</label>
                        </div>
                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" name="HallStatus" id="notavailable" value="Not Available" <?php if (isset($HallStatus) && $HallStatus == 'Not Available') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="notavailable">Not Available</label>
                                      </div>

                        <div class="text-danger">
                            <?= @$message['error_status'] ?>  
                        </div>

                    </div>

                </div>

            </div>
            <div class="col-md-3">
                
              
                 <img class="img-fluid" width="500" src="../assets/images/hall/<?= empty($hallimage) ? "noimage.jpg" : $hallimage ?>">
                
            </div>
        </div>


        <div class="row">
            <div class="col-md-7"></div>

            <div class="col-md-5">

                <input type="hidden" name="HallId" value="<?= $HallId ?>"> 

                <a href="add.php" class="btn btn-secondary">Cancel </a>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>

    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 