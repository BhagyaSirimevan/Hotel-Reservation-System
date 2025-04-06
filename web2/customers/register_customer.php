<?php
ob_start();
session_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
    <section>
      
            
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="col-md-8">
            <h1 class="h2">Register as New Customer  </h1>
             </div>
            <div class="col-md-1">
                    <strong class="text-danger"> Required <span class="text-danger">*</strong></p> 
            </div>
       
        </div>
             
                
      
        <div class="row">
            <div class="col-md-2">
                <?php
                if (!empty($_SESSION['checkavailability'])) {
                    $hall = $_SESSION['checkavailability']['hall'];

                    $db = dbConn();
                    $sql = "SELECT HallName FROM tbl_hall WHERE HallId=$hall";
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                    ?> 

                    <h4>  <strong class='text-danger'>Selected Hall - 

                            <?php echo $row['HallName']; ?> </strong> </h4> 


                </div>

                <div class="col-md-9">
                    <a href="../checkavailability.php" class="btn btn-secondary">Change Hall</a>
                </div>
            
            
            <?php
        } 
        ?>

               
            </div>

<?php


// 2nd step- extact the form field 
        // convert array keys to the seperate variable with the value(extract)
        extract($_POST);
            $message = array();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
          
            if (empty($nic)) {
                $message['error_nic'] = "NIC should not be blank..!";
            } elseif (nicValidation($nic)) {
                $message['error_nic'] = "Invalid Nic Format";
            } else {
                $db = dbConn();
                $sql = "SELECT * FROM tbl_customers WHERE NIC='$nic'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_nic'] = "This Nic is Already Exist";
                }
            }
            
        }
        
       

// 1st step- check the request method  
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {

            // 3rd step- clean input
            $title = cleanInput($title);
            $fname = cleanInput($fname);
            $lname = cleanInput($lname);
            $nic = cleanInput($nic);
           
            $district = cleanInput($district);
            $houseno = cleanInput($houseno);
            $streetname = cleanInput($streetname);
            $area = cleanInput($area);
            $contact = cleanInput($contact);
            $contact2 = cleanInput($contact2);
            $email = cleanInput($email);

            // Required Validation
        

            if (empty($title)) {
                $message['error_title'] = "Title should be selected..!";
            }


            if (empty($fname)) {
                $message['error_fname'] = "First Name should not be blank..!";
            } elseif (textFieldValidation($fname)) {
                $message['error_fname'] = "Invalid First Name";
            }


            if (empty($lname)) {
                $message['error_lname'] = "Last Name should not be blank..!";
            } elseif (textFieldValidation($lname)) {
                $message['error_lname'] = "Invalid Last Name";
            }

             if (empty($nic)) {
                $message['error_nic'] = "NIC should not be blank..!";
            } elseif (nicValidation($nic)) {
                $message['error_nic'] = "Invalid Nic Format";
            } else {
                $db = dbConn();
                $sql = "SELECT * FROM tbl_customers WHERE NIC='$nic'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_nic'] = "This Nic is Already Exist";
                }
            }


            if (empty($district)) {
                $message['error_district'] = "Should be select district..!";
            }



            if (empty($houseno)) {
                $message['error_houseno'] = "House No should not be blank..!";
            }


            if (empty($streetname)) {
                $message['error_streetname'] = "Street Name should not be blank..!";
            } elseif (textFieldValidation($streetname)) {
                $message['error_streetname'] = "Invalid Street Name";
            }

            if (empty($area)) {
                $message['error_area'] = "Area should not be blank..!";
            } 

            if (empty($contact)) {
                $message['error_contact'] = "Contact No should not be blank..!";
            } elseif (contactNoValidation($contact)) {
                $message['error_contact'] = "Invalid Contact Number";
            }

            if (!empty($contact2) && contactNoValidation($contact2)) {
                $message['error_contact2'] = "Invalid Contact Number";
            }


            if (empty($email)) {
                $message['error_email'] = "Email should not be blank..!";
            } elseif (emailValidation($email)) {
                $message['error_email'] = "Invalid Email Address";
            } else {
                $db = dbConn();
                $sql = "SELECT * FROM tbl_customers WHERE Email='$email'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_email'] = "This Email Address is Already Exist";
                }
            }


            if (empty($username)) {
                $message['error_username'] = "User Name should not be blank..!";
            } else {
                $db = dbConn();
                $sql = "SELECT * FROM tbl_users WHERE UserName='$username'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_username'] = "This User name is Already Exist";
                }
            }

            if (empty($pwd)) {
                $message['error_pwd'] = "Password should not be blank..!";
            } elseif (strlen($pwd) < 8) {
                $message['error_pwd'] = "Password must be at least 8 characters long..!";
            } elseif (!preg_match('/[A-Z]/', $pwd) || !preg_match('/[a-z]/', $pwd) || !preg_match('/[0-9]/', $pwd) || !preg_match('/[^A-Za-z0-9]/', $pwd)) {
                $message['error_pwd'] = "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character..!";
            } elseif ($pwd == $username) {
                $message['error_pwd'] = "Password must not be the same as the username..!";
            } elseif (strpos($pwd, ' ') != false) {
                $message['error_pwd'] = "Password should not contain spaces";
            }

            if (empty($conpwd)) {
                $message['error_conpwd'] = "Confirm Password should not be blank..!";
            }

            if ($pwd != $conpwd) {
                $message['error_conpwd'] = " The Password and Confirm Password Not Matching ";
            }


            if (empty($message)) {

                //  $userid = $_SESSION['userid'];


                $cdate = date('Y-m-d');
                $pwd = sha1($pwd);
                $conpwd = sha1($conpwd);

                $sql = "INSERT INTO tbl_users(UserName,Password,RoleId,Status,AddDate) "
                        . "VALUES('$username','$pwd','6','1','$cdate')";
                print_r($sql);

                $db = dbConn();
                $db->query($sql);

                $userid = $db->insert_id;

                $regno = date('Y') . date('m') . date('d') . $userid;
                $_SESSION['RegNumber'] = $regno;

                $sql = "INSERT INTO tbl_customers(RegNo,TitleId,FirstName,LastName,NIC,GenderId,ContactNo,Contact2,HouseNo,StreetName,Area,DistrictId,Email,UserId,AddDate,StatusId) "
                        . "VALUES('$regno','$title','$fname','$lname','$nic','$gender','$contact','$contact2','$houseno','$streetname','$area','$district','$email','$userid','$cdate','1')";

                print_r($sql);

                $db->query($sql);
                //  header('Location:customeraddsuccess.php?regno='.$regno);
                header('Location:customeraddsuccess.php?regno=' . $regno);
            }
        }
        ?>


        <!--    <h2>Register as Customer</h2>-->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 



            <div class="row mb-3">

                <div class="col-md-4">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>

                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM tbl_customer_title";
                    $result = $db->query($sql);
                    ?>

                    <select class="form-select" id="title" name="title">
                        <option value="">Select Title</option>

                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>

                                <option value=<?= $row['TitleId']; ?> <?php if ($row['TitleId'] == @$title) { ?>selected <?php } ?>><?= $row['TitleName'] ?></option>

                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="text-danger">
                        <?= @$message['error_title'] ?>  
                    </div>
                </div>


                <div class="col-md-4">
                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="first_name" name="fname" value="<?= @$fname ?>">
                    <div class="text-danger">
                        <?= @$message['error_fname'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="last_name" name="lname" value="<?= @$lname ?>">
                    <div class="text-danger">
                        <?= @$message['error_lname'] ?>  
                    </div>



                </div>

            </div>


            <div class="row mb-3">


                <div class="col-md-4">
                    <label for="nic" class="form-label">NIC <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nic" name="nic" value="<?= @$nic ?>" onchange="form.submit()">
                    <div class="text-danger">
                        <?= @$message['error_nic'] ?>  
                    </div>



                </div>



                <div class="col-md-4">

                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>

                    <?php
                    if (!empty($nic) && empty(@$message['error_nic'])) {

                        $number = genderValidation($nic);

                        if ($number > 500) {
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_gender WHERE GenderId=2";
                            $result = $db->query($sql);
                        } elseif ($number < 500) {
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_gender WHERE GenderId=1";
                            $result = $db->query($sql);
                        }
                        
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                             $gender= $row['GenderId'];
                                
                                ?>
                                <input type="text" class="form-control"  value="<?= $row['Name'] ?>" readonly>
                                
                                     <input type="hidden" id="gender" name="gender" value="<?= $gender ?>">
                                <?php
                            }
                        }
                        ?>
                        
                        <?php
                        
                    } else{
                        ?>
                                  <input type="text" class="form-control" readonly>
                                  <?php 
                    }
                    ?>

                 
                </div>

                <div class="col-md-4">

                    <label for="district" class="form-label">District <span class="text-danger">*</span></label>

                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM tbl_district";
                    $result = $db->query($sql);
                    ?>

                    <select class="form-select" id="district" name="district">
                        <option value="">Select District</option>

                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>

                                <option value=<?= $row['DistrictId']; ?> <?php if ($row['DistrictId'] == @$district) { ?>selected <?php } ?>><?= $row['DistrictName'] ?></option>

                                <?php
                            }
                        }
                        ?>


                    </select>
                    <div class="text-danger">
                        <?= @$message['error_district'] ?>  
                    </div>
                </div>






            </div>




            <div class="row mb-3">


                <div class="col-md-4">
                    <label for="house_no" class="form-label">House No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="house_no" name="houseno" value="<?= @$houseno ?>">
                    <div class="text-danger">
                        <?= @$message['error_houseno'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="street_name" class="form-label">Street Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="street_name" name="streetname" value="<?= @$streetname ?>">
                    <div class="text-danger">
                        <?= @$message['error_streetname'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="area" class="form-label">Area <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="area" name="area" value="<?= @$area ?>">
                    <div class="text-danger">
                        <?= @$message['error_area'] ?>  
                    </div>



                </div>






            </div>

            <div class="row mb-3"> 

                <div class="col-md-4">
                    <label for="contact_no" class="form-label">Contact No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="contact_no" name="contact" value="<?= @$contact ?>">
                    <div class="text-danger">
                        <?= @$message['error_contact'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="contact_2" class="form-label">Contact No (Optional) </label>
                    <input type="text" class="form-control" id="contact_2" name="contact2" value="<?= @$contact2 ?>">
                    <div class="text-danger">
                        <?= @$message['error_contact2'] ?>  
                    </div>



                </div>

                <div class="col-md-4">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="email" name="email" value="<?= @$email ?>">
                    <div class="text-danger">
                        <?= @$message['error_email'] ?>  
                    </div>



                </div>

            </div>




            <div class="row mb-3">





                <div class="col-md-4">


                    <label for="user_name" class="form-label">User Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="user_name" name="username" value="<?= @$username ?>">
                    <div class="text-danger">
                        <?= @$message['error_username'] ?>  
                    </div>



                </div>

                <div class="col-md-4">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="pwd" value="<?= @$pwd ?>">
                    <div class="text-danger">
                        <?= @$message['error_pwd'] ?>  
                    </div>



                </div>




                <div class="col-md-4">
                    <label for="confirmpassword" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="confirmpassword" name="conpwd" value="<?= @$conpwd ?>">
                    <div class="text-danger">
                        <?= @$message['error_conpwd'] ?>  
                    </div>



                </div>




            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <h8 class="h10 text-danger">* Password must be at least 8 characters long. </h8> 
                    <br>
                    <h8 class="h8 text-danger">* Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character </h8> 
                    <br>
                    <h8 class="h8 text-danger">* Password must not be the same as the user name. </h8> 
                    <br> 
                    <h8 class="h8 text-danger">* Password should not contain spaces. </h8> 
                </div>


            </div>

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2">

                    <a href="register_customer.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success" name="action" value="save">Register</button>
                </div>
            </div>

        </form>

    </section>

</main>



<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 

