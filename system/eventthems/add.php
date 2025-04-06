<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Event Theme Management </h1>

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
//        $hallname = cleanInput($hallname);
//        $minguest = cleanInput($minguest);
//        $maxguest = cleanInput($maxguest);
//        $avafeatures = cleanInput($avafeatures);

        // Required Validation
        $message = array();

        if (empty($event)) {
            $message['error_event'] = "Event should be selected..!";
        }
        
       
        
        if (empty($themecolor)) {
            $message['error_themecolor'] = "Theme color should be selected ..!";
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
                        $file_destination = "../assets/images/eventthems/" . $file_name_new;

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
            $sql = "INSERT INTO tbl_themecolor(EventId,ColourName,HallImage,ThemeStatus,AddDate,AddUser) "
                    . "VALUES('$event','$themecolor','$file_name_new','$HallStatus','$cdate','$userid')";
            //    print_r($sql);


            $db = dbConn();
            $db->query($sql);

            $newthemecolour = $db->insert_id;

            header('Location:addsuccess.php?ThemeColorId=' . $newthemecolour);

            // print_r($sql); 
        }
    }
    ?>


    <h2>Add New Event Theme Color</h2>
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


       
            <div class="col-md-6">

                <div class="row mt-4">
                    <div class="col-md-4">
                        <label for="event" class="form-label">Event <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-7">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM tbl_event";
                        $result = $db->query($sql);
                        ?>

                        <select class="form-select" id="event" name="event">
                            <option value="">Select Event</option>

                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>

                                    <option value=<?= $row['EventId']; ?> <?php if ($row['EventId'] == @$event) { ?>selected <?php } ?>><?= $row['EventName'] ?></option>


                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="text-danger">
                            <?= @$message['error_event'] ?>  
                        </div>
                    </div>
                </div>
                
                
                
                <div class="row mt-3">

                    <div class="col-md-4 mb-2">
                        <label for="themecolor" class="form-label">Theme Color Name <span class="text-danger">*</span></label>
                    </div>
                      <div class="col-md-7 mb-2"> 
                        <input type="text" class="form-control" id="themecolor" name="themecolor" value="<?= @$themecolor ?>">
                        <div class="text-danger">
                            <?= @$message['error_themecolor'] ?>  
                        </div>
                      </div>


                </div>
                
                
                
                


                
                 <div class="row mt-3">

                    <div class="col-md-4 mb-2">
                        <label for="hallimage" class="form-label">Sample Image <span class="text-danger">*</span></label>
                    </div>
                      <div class="col-md-7 mb-2"> 
                        <input type="file" class="form-control" id="hallimage" name="hallimage" value="<?= @$hallimage ?>">
                        <div class="text-danger">
                            <?= @$message['error_hallimage'] ?>  
                        </div>
                      </div>


                    </div>
                
                <div class="row mt-3">
                    <div class="col-md-4 mt-2">

                        <label>Select Status <span class="text-danger">*</span></label>
                        <br>
                    </div>
                    
                    
                    <div class="col-md-7 mb-2">
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="HallStatus" id="available" value="Available" <?php if (isset($HallStatus) && $HallStatus == 'Available') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="available">Available</label>
                        </div>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="HallStatus" id="notavailable" value="Not Available" <?php if (isset($HallStatus) && $HallStatus == 'Not Available') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="notavailable">Not Available</label>
                                      </div>

                        <div class="text-danger">
                            <?= @$message['error_status'] ?>  
                        </div>

                    </div>

                </div>
                 </div>
              
                 
                    

            </div>
        
        </div>


        <div class="row mt-2">
            <div class="col-md-5"></div>

            <div class="col-md-5">
                <a href="add.php" class="btn btn-secondary">Cancel </a>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>

    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 