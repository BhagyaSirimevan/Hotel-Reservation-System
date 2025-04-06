<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Service Provider Management </h1>

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

        $first_name = cleanInput($first_name);
        $last_name = cleanInput($last_name);
       
        $house_no = cleanInput($house_no);
        $street = cleanInput($street);
        $city = cleanInput($city);
        $contact_number = cleanInput($contact_number);
        $alternate_number = cleanInput($alternate_number);
        $nic = cleanInput($nic);
        $brnumber = cleanInput($brnumber);

        // Required Validation
        $message = array();

        if (!isset($title)) {
            $message['error_title'] = "The Title Should Be Selected...";
        }

        if (empty($first_name)) {
            $message['error_first_name'] = "The First Name Should Not Be Blank...";
        }

        if (empty($last_name)) {
            $message['error_last_name'] = "The Last Name Should Not Be Blank...";
        }


        if (empty($house_no)) {
            $message['error_house_no'] = "The House No Should Not Be Blank...";
        }

        if (empty($street)) {
            $message['error_street'] = "The Street Name Should Not Be Blank...";
        }

        if (empty($city)) {
            $message['error_city'] = "The City Should Not Be Blank...";
        }

        if (empty($district)) {
            $message['error_district'] = "The District Should Be Seleceted...";
        }

        if (empty($contact_number)) {
            $message['error_contact_number'] = "The Contact Number Should Not Be Blank...";
        } elseif (contactNoValidation($contact_number)) {
            $message['error_contact_number'] = "Invalid Contact Number";
        }

        if (!empty($alternate_number) && contactNoValidation($alternate_number)) {
            $message['error_alternate_number'] = "Invalid Contact Number";
        }

        if (empty($email)) {
            $message['error_email'] = "The Email Should Not Be Blank...";
        } elseif (emailValidation($email)) {
            $message['error_email'] = "Invalid Email Address";
        } else {
            $db = dbConn();
            $sql = "SELECT * from tbl_serviceprovider WHERE Email='$email'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $message['error_email'] = "Email Already Exists";
            }
        }

        if (empty($brnumber)) {
            $message['error_brnumber'] = "The Business Registration Number Should Not be Blank...";
        }
        
        if (empty($brname)) {
            $message['error_brname'] = "The Business Name Should Not be Blank...";
        }
        
        


        if (empty($nic)) {
            $message['error_nic'] = "NIC should not be blank..!";
        } elseif (nicValidation($nic)) {
            $message['error_nic'] = "Invalid Nic Format";
        } else {
            $db = dbConn();
            $sql = "SELECT * FROM tbl_serviceprovider WHERE NIC='$nic'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $message['error_nic'] = "This Nic is Already Exist";
            }
        }


        if (empty($agreementstartdate)) {
            $message['error_agreementstartdate'] = "The Agreement Start Date Should Be Selected...";
        }

        if (empty($agreementenddate)) {
            $message['error_agreementenddate'] = "The Agreement End Date Should Be Selected...";
        }


        if (empty($Status)) {
            $message['error_status'] = "Should be select Status..!";
        }


        //  var_dump($message);

        if (empty($message)) {

            $userid = $_SESSION['userid'];

            $cdate = date('Y-m-d');

            $sql = "INSERT INTO tbl_serviceprovider(Title,FirstName,LastName,NIC,ContactNo,ContactNo2,Email,BusinessName,BRNumber,HouseNo,StreetName,City,DistrictId,AgreementStartDate,AgreementEndDate,Status,AddUser,AddDate) "
                    . "VALUES('$title','$first_name','$last_name','$nic','$contact_number','$alternate_number','$email','$brname','$brnumber','$house_no','$street','$city','$district','$agreementstartdate','$agreementenddate','$Status','$userid','$cdate')";
            //    print_r($sql);

            $db = dbConn();
            $db->query($sql);

            $newserviceproviderid = $db->insert_id;

            $regno = date('Y') . date('m') . date('d') . $newserviceproviderid;

            $sql = "UPDATE tbl_serviceprovider SET RegNo='$regno' WHERE ServiceProviderId='$newserviceproviderid'";
            $db->query($sql);
            
            foreach ($service as $value) {
                $sql = "INSERT INTO tbl_providerservicelist(ServiceProviderId,ServiceId) VALUES('$newserviceproviderid','$value') ";
                //     print_r($sql);
                $db->query($sql);
            }

            header('Location:addsuccess.php?ServiceProviderId=' . $newserviceproviderid);
            // print_r($sql); 
        }
    }
    ?>


    <h2>Add New Service Provider</h2>
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 

        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
            </div>
        </div>

        <div class="row">

            <div class="col-md-8">

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label">Title <span class="text-danger">*</span></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="title" id="mr" value="Mr" <?php if (isset($title) && $title == 'Mr') { ?> checked <?php } ?> >
                            <label class="form-check-label" for="mr">Mr.</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="title" id="mrs" value="Mrs" <?php if (isset($title) && $title == 'Mrs') { ?> checked <?php } ?> >
                            <label class="form-check-label" for="mrs">Mrs.</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="title" id="miss" value="Miss" <?php if (isset($title) && $title == 'Miss') { ?> checked <?php } ?> >
                            <label class="form-check-label" for="miss">Miss.</label>
                        </div>
                        <div class="text-danger"><?= @$message["error_title"] ?></div>

                    </div> 

                    <div class="mb-2 col-md-4">
                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= @$first_name ?>"  placeholder="Ex: Kamal">
                        <div class="text-danger"><?= @$message["error_first_name"] ?></div>
                    </div>

                    <div class="mb-2 col-md-4">
                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= @$last_name ?>"  placeholder="Ex: Perera">
                        <div class="text-danger"><?= @$message["error_last_name"] ?></div>
                    </div>

                    <div class="mb-2 col-md-4">
                        <label for="nic" class="form-label">NIC <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nic" name="nic" value="<?= @$nic ?>"  placeholder="Ex: 981234567V">
                        <div class="text-danger"><?= @$message["error_nic"] ?></div>
                    </div>
                    
                    <div class="mb-2 col-md-4">
                        <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= @$contact_number ?>"  placeholder="Ex: 0123456789">
                        <div class="text-danger"><?= @$message["error_contact_number"] ?></div>
                    </div>
                    
                    <div class="mb-2 col-md-4">
                        <label for="alternate_number" class="form-label">Alternate Number [Optional]</label>
                        <input type="text" class="form-control" id="alternate_number" name="alternate_number" value="<?= @$alternate_number ?>"  placeholder="Ex: 0123456789">
                        <div class="text-danger"><?= @$message["error_alternate_number"] ?></div>
                    </div>

                    <div class="mb-2 col-md-4">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= @$email ?>"  placeholder="Ex: kamal@gmail.com">
                        <div class="text-danger"><?= @$message["error_email"] ?></div>
                    </div>

                    

                    <div class="mb-2 col-md-4">
                        <label for="brname" class="form-label">Business Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="brname" name="brname" value="<?= @$brname ?>"  placeholder="Ex: DJ Mithun">
                        <div class="text-danger"><?= @$message["error_brname"] ?></div>
                    </div>

                    <div class="mb-2 col-md-4">
                        <label for="brnumber" class="form-label">Business Registration Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="brnumber" name="brnumber" value="<?= @$brnumber ?>"  placeholder="Ex: BR1234">
                        <div class="text-danger"><?= @$message["error_brnumber"] ?></div>
                    </div>

                    



                    <div class="mb-2 col-md-4">
                        <label for="house_no" class="form-label">House No <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="house_no" name="house_no" value="<?= @$house_no ?>"  placeholder="Ex: No.123">
                        <div class="text-danger"><?= @$message["error_house_no"] ?></div>
                    </div>
                    <div class="mb-2 col-md-4">
                        <label for="street" class="form-label">Street Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="street" name="street" value="<?= @$street ?>"  placeholder="Ex: First Avenue">
                        <div class="text-danger"><?= @$message["error_street"] ?></div>
                    </div>
                    <div class="mb-2 col-md-4">
                        <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city" name="city" value="<?= @$city ?>"  placeholder="Ex: Dematagoda">
                        <div class="text-danger"><?= @$message["error_city"] ?></div>
                    </div>
                    
                    <div class="mb-2 col-md-4">
                        <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                        <select class="form-control form-select" id="district" name="district" >
                            <option value="" >Select a District</option>
                            <?php
                            $db = dbConn();
                            $sql1 = "SELECT * from tbl_district";
                            $result = $db->query($sql1);
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <option value=<?= $row['DistrictId']; ?> <?php if ($row['DistrictId'] == @$district) { ?> selected <?php } ?>><?= $row['DistrictName'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div class="text-danger"><?= @$message["error_district"] ?></div>
                    </div>



                    <div class="mb-2 col-md-4">
                        <label for="agreementstartdate" class="form-label">Agreement Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="agreementstartdate" name="agreementstartdate" value="<?= @$agreementstartdate ?>" min="2022-01-01"  >
                        <div class="text-danger"><?= @$message["error_agreementstartdate"] ?></div>
                    </div>
                    <div class="mb-2 col-md-4">
                        <label for="agreementenddate" class="form-label">Agreement End Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="agreementenddate" name="agreementenddate" value="<?= @$agreementenddate ?>" min="2022-01-01"  >
                        <div class="text-danger"><?= @$message["error_agreementenddate"] ?></div>
                    </div>

                    <div class="col-md-4 mt-3">

                        <label>Select Status <span class="text-danger">*</span></label>  
                        <br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="Status" id="active" value="Active"<?php if (isset($Status) && $Status == 'Active') { ?> checked <?php } ?> >
                            <label class="form-check-label" for="active">Active</label>
                        </div>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="Status" id="inactive" value="In Active"<?php if (isset($Status) && $Status == 'In Active') { ?> checked <?php } ?> >
                            <label class="form-check-label" for="inactive">In Active</label>
                                      </div>


                        <div class="text-danger">
                            <?= @$message['error_status'] ?>  
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="row mt-3">
                            <div class="col-md-9"></div>

                            <div class="col-md-3">
                                <a href="add.php" class="btn btn-secondary" name="action" value="cancel">Cancel </a>
                                <button type="submit" class="btn btn-success" name="action" value="save">Submit</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-secondary text-white text-center">Service List</div>
                    <div class="table-responsive">
                        <?php

                        $sql = "SELECT * FROM tbl_service WHERE ServiceType='Payable' OR ServiceType='Default'";
                        $db = dbConn();
                        $result = $db->query($sql);
                        ?>

                        <table class="table table-sm">
                            <thead class="bg-transparent">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Service Name</th>
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
                                            <td><?= $row['ServiceName'] ?></td>

                                            <td> <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="<?= $row['ServiceId'] ?>" name="service[]" value="<?= $row['ServiceId'] ?>" <?php if (isset($service) && in_array($row['ServiceId'], $service)) { ?> checked <?php } ?> >
                                                    <label class="form-check-label" for="service"></label>
                                                </div>

                                            </td> 


                                        </tr>

                                        <?php
                                        
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




    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 