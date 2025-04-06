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
        } else {
            $db = dbConn();
            $sql = "SELECT * FROM tbl_hall WHERE HallName='$hallname'";
            $result = $db->query($sql);
            if ($result->num_rows>0){
               $message['error_hallname'] = "This Hall Name is Already Exist" ; 
            }
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




        if (empty($message)) {
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
        }

        //  var_dump($message);

        if (empty($message)) {

            $userid = $_SESSION['userid'];

            $cdate = date('Y-m-d');
            $sql = "INSERT INTO tbl_hall(HallName,MinGuestCount,MaxGuestCount,HallImage,AvailableFeatures,HallStatus,AddDate,AddUser) "
                    . "VALUES('$hallname','$minguest','$maxguest','$file_name_new','$avafeatures','$HallStatus','$cdate','$userid')";
            //    print_r($sql);


            $db = dbConn();
            $db->query($sql);

            $newhallid = $db->insert_id;

            header('Location:addsuccess.php?HallId=' . $newhallid);

            // print_r($sql); 
        }
    }
    ?>


    <h2>Add New Hall</h2>
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
                        <input type="number" min="1" class="form-control" id="min" name="minguest" value="<?= @$minguest ?>">
                        <div class="text-danger">
                            <?= @$message['error_minguest'] ?>  
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="max" class="form-label">Maximum Guest Count</label>
                        <input type="number" min="1" class="form-control" id="max" name="maxguest" value="<?= @$maxguest ?>">
                        <div class="text-danger">
                            <?= @$message['error_maxguest'] ?>  
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">
                       

                        <label for="features" class="form-label">Available Features</label>
                         <textarea class="form-control" id="features" name="avafeatures" value="<?= @$avafeatures ?>"></textarea>
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
            <div class="col-md-3"></div>
        </div>


        <div class="row">
            <div class="col-md-7"></div>

            <div class="col-md-5">
                <a href="add.php" class="btn btn-secondary">Cancel </a>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>

    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 