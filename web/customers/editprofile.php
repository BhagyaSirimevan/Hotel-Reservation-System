<?php session_start(); ?>
<?php
ob_start();
?>
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>


<main id="main" class="main">
 
<section class="section profile">
      <div class="row">
       
        <div class="col-md-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Edit Profile</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                 
                  <h5 class="card-title">Profile Details</h5>
        
<?php
    
     if ($_SERVER['REQUEST_METHOD'] == "GET") {
         
        $userid = $_SESSION['userid'];
        
        $sql = "SELECT * FROM tbl_customers c LEFT JOIN tbl_customer_title t ON t.TitleId=c.TitleId"
                . "                           LEFT JOIN tbl_customer_status s ON s.StatusId=c.StatusId"
                . "                           LEFT JOIN tbl_gender g ON g.GenderId=c.GenderId"
                . "                           LEFT JOIN tbl_district d ON d.DistrictId=c.DistrictId" 
                . "                           LEFT JOIN tbl_users u ON u.UserId=c.UserId WHERE c.UserId='$userid'";

        $db = dbConn();
        $result = $db->query($sql);
        
         
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               
            $title = $row['TitleId'];
            $fname = $row['FirstName'];
            $lname = $row['LastName'];
            $nic = $row['NIC'];
            $gender = $row['GenderId'];
            $district = $row['DistrictId'];
            $houseno = $row['HouseNo'];
            $streetname = $row['StreetName'];
            $area = $row['Area'];
            $contact = $row['ContactNo'];
            $contact2 = $row['Contact2'];
            $email = $row['Email'];
            
              
                 
            }
        }
        
        
       
    }
    

    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST") {


        // 2nd step- extact the form field 
        // convert array keys to the seperate variable with the value(extract)
        extract($_POST);

        //  var_dump($_POST);
        // 3rd step- clean input
            $title = cleanInput($title);
            $fname = cleanInput($fname);
            $lname = cleanInput($lname);
            $nic = cleanInput($nic);
            $gender = cleanInput($gender);
            $district = cleanInput($district);
            $houseno = cleanInput($houseno);
            $streetname = cleanInput($streetname);
            $area = cleanInput($area);
            $contact = cleanInput($contact);
            $contact2 = cleanInput($contact2);
            $email = cleanInput($email);
        
        
        // Required Validation
        $message = array();

        if (empty($title)) {
                $message['error_title'] = "Title should be selected..!";
            }


            if (empty($fname)) {
                $message['error_fname'] = "First Name should not be blank..!";
            }

            if (empty($lname)) {
                $message['error_lname'] = "Last Name should not be blank..!";
            }

            if (empty($nic)) {
                $message['error_nic'] = "NIC should not be blank..!";
            } elseif (nicValidation($nic)) {
                $message['error_nic'] = "Invalid Nic Format";
            } 
            

            if (empty($gender)) {
                $message['error_gender'] = "Should be select Gender..!";
            }

            if (empty($district)) {
                $message['error_district'] = "Should be select district..!";
            }



            if (empty($houseno)) {
                $message['error_houseno'] = "House No should not be blank..!";
            }


            if (empty($streetname)) {
                $message['error_streetname'] = "Street Name should not be blank..!";
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
            }
            
            if(empty($message)){
                $db = dbConn();
                $sql = "SELECT NIC,Email FROM tbl_customers WHERE CustomerId=".$_SESSION['customerid'];
                print_r($sql);
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                
                $oldnic = $row['NIC'];
                $oldemail = $row['Email'];
                
                if($nic != $oldnic){
                  $sql = "SELECT NIC FROM tbl_customers WHERE CustomerId!=".$_SESSION['customerid']." AND NIC='$nic'";
                  print_r($sql);
                  $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_nic'] = "This NIC is Already Exist";
                }
                } 
                
                if($email != $oldemail){
                  $sql = "SELECT Email FROM tbl_customers WHERE CustomerId!=".$_SESSION['customerid']." AND Email='$email'";
                  print_r($sql);
                  $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_email'] = "This Email is Already Exist";
                }
                } 
                
                
            }



        //  var_dump($message);




        //  var_dump($message);

        if (empty($message)) {
            
                $db = dbConn();
                $cdate = date('Y-m-d');
               
                $customerid = $_SESSION['customerid'];

             //   $sql = "UPDATE tbl_users SET UserName='$username',Password='$pwd',RoleId='6',Status='1',UpdateDate='$cdate' WHERE UserId='$userid' ";
                        
                print_r($sql);

                
                $db->query($sql);

           echo     $sql = "UPDATE tbl_customers SET TitleId='$title',FirstName='$fname',LastName='$lname',NIC='$nic',GenderId='$gender',ContactNo='$contact',Contact2='$contact2',HouseNo='$houseno',StreetName='$streetname',Area='$area',DistrictId='$district',Email='$email',UpdateDate='$cdate',StatusId='1' WHERE CustomerId='$customerid'";

                
                
                print_r($sql);

                $db->query($sql);
               //  header('Location:customeraddsuccess.php?regno='.$regno);
               // header('Location:userprofile.php');
        }
    }
    ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 





            <div class="row mb-3">

                <div class="col-md-4">
                    <label for="title" class="form-label">Title</label>

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
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="fname" value="<?= @$fname ?>">
                    <div class="text-danger">
                        <?= @$message['error_fname'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="lname" value="<?= @$lname ?>">
                    <div class="text-danger">
                        <?= @$message['error_lname'] ?>  
                    </div>



                </div>

            </div>


            <div class="row mb-3">


                <div class="col-md-4">
                    <label for="nic" class="form-label">NIC</label>
                    <input type="text" class="form-control" id="nic" name="nic" value="<?= @$nic ?>">
                    <div class="text-danger">
                        <?= @$message['error_nic'] ?>  
                    </div>



                </div>



                <div class="col-md-4">

                    <label for="gender" class="form-label">Gender</label>

                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM tbl_gender";
                    $result = $db->query($sql);
                    ?>

                    <select class="form-select" id="gender" name="gender">
                        <option value="">Select Gender</option>

                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>

                                <option value=<?= $row['GenderId']; ?> <?php if ($row['GenderId'] == @$gender) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                <?php
                            }
                        }
                        ?>


                    </select>
                    <div class="text-danger">
                        <?= @$message['error_gender'] ?>  
                    </div>


                </div>

                <div class="col-md-4">

                    <label for="district" class="form-label">District</label>

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
                    <label for="house_no" class="form-label">House No</label>
                    <input type="text" class="form-control" id="house_no" name="houseno" value="<?= @$houseno ?>">
                    <div class="text-danger">
                        <?= @$message['error_houseno'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="street_name" class="form-label">Street Name</label>
                    <input type="text" class="form-control" id="street_name" name="streetname" value="<?= @$streetname ?>">
                    <div class="text-danger">
                        <?= @$message['error_streetname'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="area" class="form-label">Area</label>
                    <input type="text" class="form-control" id="area" name="area" value="<?= @$area ?>">
                    <div class="text-danger">
                        <?= @$message['error_area'] ?>  
                    </div>



                </div>






            </div>

            <div class="row mb-3"> 

                <div class="col-md-4">
                    <label for="contact_no" class="form-label">Contact No</label>
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
                    <label for="email" class="form-label">Email Address</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?= @$email ?>">
                    <div class="text-danger">
                        <?= @$message['error_email'] ?>  
                    </div>



                </div>

            </div>




            <div class="row mb-3">


            </div>

            

                                    <div class="row">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">

                                            <a href="register_customer.php" class="btn btn-secondary">Cancel </a>
                                            <button type="submit" class="btn btn-warning">Update</button> 
                                        </div>
                                    </div>
                                        <input type="hidden" name="UserId" value="<?= $userid ?>"> 
                                    </form>
                  
       

       
            

               
             

     
                </div>


              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>    
    
</main>


<?php include '../dashboardfooter.php'; ?> 
<?php ob_end_flush() ?> 
