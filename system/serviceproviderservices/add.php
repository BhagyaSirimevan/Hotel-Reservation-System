<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Service Provider Services Management </h1>

    </div>

    <?php

    // 2nd step- extact the form field 
    // convert array keys to the seperate variable with the value(extract)
    extract($_POST);

    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {

         // var_dump($_POST);
        // 3rd step- clean input

        $name = cleanInput($name);

        // Required Validation
        $message = array();

        if (empty($regno)) {
            $message['error_regno'] = "The Reg No Should be Selected...";
        }

        if (empty($provideservice)) {
            $message['error_provideservice'] = "The Provide Service Should Be Selected...";
        }

        if (empty($name)) {
            $message['error_name'] = "The Name Should Not Be Blank...";
        }

        

        if (empty($Status)) {
            $message['error_status'] = "Should be select Status..!";
        }
        
        
        if (empty($message)) {
            $SampleImage = $_FILES['sampleimage'];

            $filename = $SampleImage['name'];

            $filetmpname = $SampleImage['tmp_name'];

            $filesize = $SampleImage['size'];

            $fileerror = $SampleImage['error'];

            $fileext = explode(".", $filename);

            $fileext = strtolower(end($fileext));

            $allowedext = array("jpg", "jpeg", "png", "gif");

            if (in_array($fileext, $allowedext)) {

                if ($fileerror === 0) {
                    if ($filesize <= 2097152) {
                        $file_name_new = uniqid("", true) . "." . $fileext;
                        $file_destination = "../assets/images/provideservices/" . $file_name_new;

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

            $sql = "INSERT INTO tbl_serviceproviderservice(RegNo,BusinessName,ProvideServiceListId,Name,SampleImage,Status,AddUser,AddDate) "
                    . "VALUES('$regno','$businessname','$provideservice','$name','$file_name_new','$Status','$userid','$cdate')";
            //    print_r($sql);

            $db = dbConn();
            $db->query($sql);

            $newserviceproviderserviceid = $db->insert_id;

          
           

            header('Location:addsuccess.php?ProviderServiceId=' . $newserviceproviderserviceid);
            // print_r($sql); 
        }
    }
    ?>


    <h2>Add New Service Provider Service</h2>
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 

        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-6">
                <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
            </div>
        </div>

        <div class="row mt-3">

            <div class="col-md-6">

                <div class="row">

                    <div class="row">
                        <div class="col-md-4">
                            <label for="regno" class="form-label">Reg No <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control form-select" id="regno" name="regno" onchange="form.submit()">
                                <option value="" >Select Reg No</option>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT RegNo from tbl_serviceprovider";
                                $result = $db->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value=<?= $row['RegNo']; ?> <?php if ($row['RegNo'] == @$regno) { ?> selected <?php } ?>><?= $row['RegNo'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?= @$message["error_regno"] ?></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <label for="brname" class="form-label">Business Name </label>
                        </div>
                        <div class="col-md-8 mt-3">


                            <?php
                            if (!empty($regno)) {
                                $db = dbConn();
                                $sql = "SELECT BusinessName from tbl_serviceprovider WHERE RegNo='$regno'";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $businessname = $row['BusinessName'];
                                }
                            }
                            ?>

                            <input type="text" class="form-control" id="businessname" name="businessname" value="<?= @$businessname ?>" readonly>





                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="provideservice" class="form-label">Provide Service <span class="text-danger">*</span></label>

                        </div>
                        <div class="mb-2 col-md-8">
                            <select class="form-control form-select" id="provideservice" name="provideservice" >
                                <option value="" >Select Provide Service</option>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * from tbl_providerservicelist p LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=p.ServiceProviderId LEFT JOIN tbl_service e ON e.ServiceId=p.ServiceId WHERE s.RegNo='$regno'";
                                $result = $db->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value=<?= $row['ProvideServiceListId']; ?> <?php if ($row['ProvideServiceListId'] == @$provideservice) { ?> selected <?php } ?>><?= $row['ServiceName'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?= @$message["error_provideservice"] ?></div>
                        </div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-md-4 mb-2">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8 mb-2"> 
                            <input type="text" class="form-control" id="name" name="name" value="<?= @$name ?>">
                            <div class="text-danger">
                                <?= @$message['error_name'] ?>  
                            </div>
                        </div>


                    </div>

                    <div class="row mt-3">

                        <div class="col-md-4 mb-2">
                            <label for="sampleimage" class="form-label">Sample Image <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8 mb-2"> 
                            <input type="file" class="form-control" id="sampleimage" name="sampleimage" value="<?= @$sampleimage ?>">
                            <div class="text-danger">
                                <?= @$message['error_sampleimage'] ?>  
                            </div>
                        </div>


                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4 mt-2">

                            <label>Select Status <span class="text-danger">*</span></label>
                            <br>
                        </div>


                        <div class="col-md-8 mb-2">
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="Status" id="available" value="Available" <?php if (isset($Status) && $Status == 'Available') { ?> checked <?php } ?>>
                                <label class="form-check-label" for="available">Available</label>
                            </div>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="Status" id="notavailable" value="Not Available" <?php if (isset($Status) && $Status == 'Not Available') { ?> checked <?php } ?>>
                                <label class="form-check-label" for="notavailable">Not Available</label>
                                          </div>

                            <div class="text-danger">
                                <?= @$message['error_status'] ?>  
                            </div>

                        </div>

                    </div>



                  
                        <div class="row mt-3">
                            <div class="col-md-8">
                                  </div>
                          

                            <div class="col-md-4">
                              <a href="add.php" class="btn btn-secondary" name="action" value="cancel">Cancel </a>
                                <button type="submit" class="btn btn-success" name="action" value="save">Submit</button>
                            </div>
                        </div>
                  
                </div>

            </div>



        </div>




    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 