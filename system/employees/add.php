<?php 
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
 

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Employee Management </h1>
        
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
        $title = cleanInput($title);
        $fname = cleanInput($fname);
        $lname = cleanInput($lname);
        $colname = cleanInput($colname);
        $fullname = cleanInput($fullname);
        $designation = cleanInput($designation);
        $nic = cleanInput($nic);
    //    $gender = cleanInput($gender);
        $dob = cleanInput($dob);
        $civilstatus = cleanInput($civilstatus);
        $contact = cleanInput($contact);
        $landno = cleanInput($landno);
        $email = cleanInput($email);
        $assdate = cleanInput($assdate);
        $houseno = cleanInput($houseno);
        $streetname = cleanInput($streetname);
        $area = cleanInput($area);
        $district = cleanInput($district);
        $empstatus = cleanInput($empstatus);
        $Edescription = cleanInput($Edescription);
        
       
       
       

        // Required Validation
        $message = array();

        if (empty($title)) {
            $message['error_title'] = "Should be select Title..!";
        }
        
          

        if (empty($fname)) {
            $message['error_fname'] = "First Name should not be blank..!";
        }
        

        if (empty($lname)) {
            $message['error_lname'] = "Last Name should not be blank..!";
        }
        
         

        if (empty($colname)) {
            $message['error_colname'] = "Calling Name should not be blank..!";
        }
        
       

        if (empty($fullname)) {
            $message['error_fullname'] = "Full Name should not be blank..!";
        }
        
      

        if (empty($designation)) {
            $message['error_designation'] = "Should be select Designation..!";
        }
        
       


        if (empty($nic)) {
            $message['error_nic'] = "NIC should not be blank..!";
        } elseif (nicValidation($nic)) {
            $message['error_nic'] = "Invalid Nic Format" ;
        } else {
            $db = dbConn();
            $sql = "SELECT * FROM tbl_employees WHERE NIC='$nic'";
            $result = $db->query($sql);
            if ($result->num_rows>0){
               $message['error_nic'] = "This Nic is Already Exist" ; 
            }
        } 

        if (empty($Gender)) {
            $message['error_gender'] = "Should be select Gender..!";
        }
        
      

        if (empty($dob)) {
            $message['error_dob'] = "Should be select Date of Birth..!";
        }
     

        if (empty($civilstatus)) {
            $message['error_civilstatus'] = "Should be select Civil Status..!";
        } 
        
       

        if (empty($contact)) {
            $message['error_contact'] = "Contact No should not be blank..!";
        }  elseif(contactNoValidation($contact)) {
            $message['error_contact'] =  "Invalid Contact Number" ;
        } 
       
        if (!empty($landno) && contactNoValidation($landno)) {
            $message['error_landno'] = "Invalid Contact Number";
        } 
        
     

        if (empty($email)) {
            $message['error_email'] = "Email should not be blank..!";
        }   elseif(emailValidation($email)) {
            $message['error_email'] =  "Invalid Email Address";
        } else {
            $db = dbConn();
            $sql = "SELECT * FROM tbl_employees WHERE Email='$email'";
            $result = $db->query($sql);
            if ($result->num_rows>0){
               $message['error_email'] = "This Email Address is Already Exist" ; 
            }
        } 

        if (empty($assdate)) {
            $message['error_assdate'] = "Should be select Assignment Date..!";
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
        
      

        if (empty($district)) {
            $message['error_district'] = "Should be select Employee District..!";
        }
        
       

        if (empty($empstatus)) {
            $message['error_empstatus'] = "Should be select Employee Status..!";
        }
        
       //  var_dump($message);




        if (empty($message)) {
            $EmployeeImage = $_FILES['empPto'];

            $filename = $EmployeeImage['name'];

            $filetmpname = $EmployeeImage['tmp_name'];

            $filesize = $EmployeeImage['size'];

            $fileerror = $EmployeeImage['error'];

            $fileext = explode(".", $filename);

            $fileext = strtolower(end($fileext));

            $allowedext = array("jpg", "jpeg", "png", "gif");

            if (in_array($fileext, $allowedext)) {

                if ($fileerror === 0) {
                    if ($filesize <= 2097152) {
                        $file_name_new = uniqid("", true) . "." . $fileext;
                        $file_destination = "../assets/images/employee/" . $file_name_new;

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
            $sql = "INSERT INTO tbl_employees(Title,FirstName,LastName,FullName,CallingName,DesignationId,HouseNo,StreetName,Area,DistrictId,ContactNo,LandNo,DOB,NIC,Gender,CivilStatus,EmpImage,Description,Email,AssignmentDate,Status,AddedDate,AddUser) "
                    . "VALUES('$title','$fname','$lname','$fullname','$colname','$designation','$houseno','$streetname','$area','$district','$contact','$landno','$dob','$nic','$Gender','$civilstatus','$file_name_new','$Edescription','$email','$assdate','$empstatus','$cdate','$userid')";
          //  print_r($sql);
            
            $db = dbConn();
            $db->query($sql);
            
             // last insert record id
            $empid = $db->insert_id;
            
            // generate reg no 
            $regno = date('Y').date('m').date('d').$empid;
            
            $sql="UPDATE tbl_employees SET RegNo='$regno' WHERE EmployeeId='$empid'";
            $db->query($sql); 
            
                   header('Location:addsuccess.php?regno='.$regno);
            
            

           
           // print_r($sql); 
        }
     
    }
    ?>


    <h2>Add New Employee</h2>
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


        <div class="row mb-3">



            <div class="col-md-3">
                <label for="title" class="form-label">Title</label>

                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_employees_title";
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


            <div class="col-md-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="fname" value="<?= @$fname ?>">
                <div class="text-danger">
                    <?= @$message['error_fname'] ?>  
                </div>



            </div>


            <div class="col-md-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="lname" value="<?= @$lname ?>">
                <div class="text-danger">
                    <?= @$message['error_lname'] ?>  
                </div>



            </div>

            <div class="col-md-3">
                <label for="calling_name" class="form-label">Calling Name</label>
                <input type="text" class="form-control" id="calling_name" name="colname" value="<?= @$colname ?>">
                <div class="text-danger">
                    <?= @$message['error_colname'] ?>  
                </div>



            </div>




        </div>


        <div class="row mb-3">

            <div class="col-md-6">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="fullname" value="<?= @$fullname ?>">
                <div class="text-danger">
                    <?= @$message['error_fullname'] ?>  
                </div>



            </div>


            <div class="col-md-3">

                <label for="designation" class="form-label">Designation</label>

                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_designation";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="designation" name="designation">
                    <option value="">Select Designation</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['DesignationId']; ?> <?php if ($row['DesignationId'] == @$designation) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                            <?php
                        }
                    }
                    ?>


                </select>
                <div class="text-danger">
                    <?= @$message['error_designation'] ?>  
                </div>

            </div>

            <div class="col-md-3">
                <label for="empphoto" class="form-label">Employee Photo</label>
                <input type="file" class="form-control" id="empphoto" name="empPto" value="<?= @$empPto ?>">
                <div class="text-danger">
                    <?= @$message['error_empPto'] ?>  
                </div>



            </div>






        </div>

        <div class="row mb-3">

            <div class="col-md-3">
                <label for="nic" class="form-label">NIC</label>
                <input type="text" class="form-control" id="nic" name="nic" value="<?= @$nic ?>">
                <div class="text-danger">
                    <?= @$message['error_nic'] ?>  
                </div>



            </div>

            <div class="col-md-3">

                <label>Select Gender</label>
                <br>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="Gender" id="male" value="Male" <?php if (isset($Gender) && $Gender == 'Male') { ?> checked <?php } ?>>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="Gender" id="female" value="Female" <?php if (isset($Gender) && $Gender == 'Female') { ?> checked <?php } ?>>
                    <label class="form-check-label" for="female">Female</label>
                              </div>




                <div class="text-danger">
                    <?= @$message['error_gender'] ?>  
                </div>




            </div>


            <div class="col-md-3">
                <label for="dob" class="form-label">Date of Birth</label>
               <?php
               $today=date('Y-m-d');
               $mindate= date('Y-m-d',strtotime('-60 years',strtotime($today)));
               $maxdate=date('Y-m-d',strtotime('-18 years',strtotime($today)));
               
               ?>
               
                
                <input type="date" min="<?=$mindate?>" max="<?=$maxdate?>" class="form-control" id="dob" name="dob" value="<?= @$dob ?>">
                <div class="text-danger">
                    <?= @$message['error_dob'] ?>  
                </div>



            </div>


            <div class="col-md-3">

                <label for="civil_status" class="form-label">Civil Status</label>

                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_civil_status";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="civil_status" name="civilstatus">
                    <option value="">Select Civil Status</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['CivilStatusId']; ?> <?php if ($row['CivilStatusId'] == @$civilstatus) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                            <?php
                        }
                    }
                    ?>

                </select>
                <div class="text-danger">
                    <?= @$message['error_civilstatus'] ?>  
                </div>


            </div>



        </div>

        <div class="row mb-3">


            <div class="col-md-3">
                <label for="contact_no" class="form-label">Contact No (Mobile)</label>
                <input type="text" class="form-control" id="contact_no" name="contact" value="<?= @$contact ?>">
                <div class="text-danger">
                    <?= @$message['error_contact'] ?>  
                </div>



            </div>

            <div class="col-md-3">
                <label for="land_no" class="form-label">Contact No (Land) - Optional</label>
                <input type="text" class="form-control" id="land_no" name="landno" value="<?= @$landno ?>">
                <div class="text-danger">
                    <?= @$message['error_landno'] ?>  
                </div>



            </div>

            <div class="col-md-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= @$email ?>">
                <div class="text-danger">
                    <?= @$message['error_email'] ?>  
                </div>



            </div>


            <div class="col-md-3">
                <label for="assignment_date" class="form-label">Assignment Date</label>
                
                <input type="date" min="2017-01-01" max="<?=date('Y-m-d')?>" class="form-control" id="assignment_date" name="assdate" value="<?= @$assdate ?>">
                <div class="text-danger">
                    <?= @$message['error_assdate'] ?>  
                </div>



            </div>




        </div>





        <div class="row mb-3">



            <div class="col-md-3">
                <label for="house_no" class="form-label">House No</label>
                <input type="text" class="form-control" id="house_no" name="houseno" value="<?= @$houseno ?>">
                <div class="text-danger">
                    <?= @$message['error_houseno'] ?>  
                </div>



            </div>


            <div class="col-md-3">
                <label for="street_name" class="form-label">Street Name</label>
                <input type="text" class="form-control" id="street_name" name="streetname" value="<?= @$streetname ?>">
                <div class="text-danger">
                    <?= @$message['error_streetname'] ?>  
                </div>



            </div>


            <div class="col-md-3">
                <label for="area" class="form-label">City</label>
                <input type="text" class="form-control" id="area" name="area" value="<?= @$area ?>">
                <div class="text-danger">
                    <?= @$message['error_area'] ?>  
                </div>



            </div>

            <div class="col-md-3">

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

            <div class="col-md-6">

                <label for="employee_description" class="form-label">Enter Employee Description </label>
                <textarea class="form-control" id="employee_description" name="Edescription"><?= @$Edescription ?></textarea>


            </div>

            <div class="col-md-6">

                <label for="employee_status" class="form-label">Employee Status</label>

                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_employee_status";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="employee_status" name="empstatus">
                    <option value="">Select Employee Status</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['StatusId']; ?> <?php if ($row['StatusId'] == @$empstatus) { ?>selected <?php } ?>><?= $row['StatusName'] ?></option>

                            <?php
                        }
                    }
                    ?>


                </select>
                <div class="text-danger">
                    <?= @$message['error_empstatus'] ?>  
                </div>


            </div>



        </div>

         <div class="row">
            <div class="col-md-10"></div>
           
            <div class="col-md-2">
        <a href="add.php" class="btn btn-secondary">Cancel </a>
        <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>




       
        
        
        
    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 