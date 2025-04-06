<?php 
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">User Management </h1>
        
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
   
      if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET); 
        $db = dbConn();
        $sql = "SELECT UserName,Password,RoleId,u.Status,RegNo,FullName,Name FROM tbl_users u LEFT JOIN tbl_employees e ON e.UserId=u.UserId LEFT JOIN tbl_designation d ON d.DesignationId=e.DesignationId WHERE u.UserId='$UserId'";
        $result = $db->query($sql);
       // print_r($sql);
      //  echo "<br>";
              //  echo "<br>";

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
               //   var_dump($row);
//                          echo "<br>";
//
//                          echo "<br>";

                  $username = $row['UserName'];
                  $pwd = $row['Password'];
                  $conpwd = $row['Password'];
                  $userrole = $row['RoleId'];
                  $Ustatus = $row['Status'];
                  $empregno = $row['RegNo'];
                  $fullname = $row['FullName'];
                  $desig = $row['Name'];
              }
          }
        
      }
    
    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST") {


        // 2nd step- extact the form field 
        // convert array keys to the seperate variable with the value(extract)
        extract($_POST);
       // var_dump($_POST);
        $Ustatus = ($_POST['Ustatus'])?1:0 ;
       // echo $Ustatus;

        // 3rd step- clean input

        // Required Validation
        $message = array();

//        if (empty($empregno)) {
//            $message['error_empregno'] = "Employee Reg No should be select..!";
//        }

//        if (empty($fullname)) {
//            $message['error_fullname'] = "Full Name should not be blank..!";
//        }
//        if (empty($desig)) {
//            $message['error_desig'] = "Designation should not be blank..!";
//        }


//        if (empty($username)) {
//            $message['error_username'] = "User Name should not be blank..!";
//        }

//        if (empty($pwd)) {
//            $message['error_pwd'] = "Password should not be blank..!";
//        } elseif (strlen($pwd) < 8) {
//            $message['error_pwd'] = "Password must be at least 8 characters long..!";
//        } elseif (!preg_match('/[A-Z]/', $pwd) || !preg_match('/[a-z]/', $pwd) || !preg_match('/[0-9]/', $pwd) || !preg_match('/[^A-Za-z0-9]/', $pwd)) {
//            $message['error_pwd'] = "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character..!";
//        } elseif ($pwd == $username) {
//            $message['error_pwd'] = "Password must not be the same as the username..!";
//        } elseif (strpos($pwd, ' ') != false) {
//            $message['error_pwd'] = "Password should not contain spaces";
//        } 

//        if (empty($conpwd)) {
//            $message['error_conpwd'] = "Confirm Password should not be blank..!";
//        }


        if (empty($userrole)) {
            $message['error_userrole'] = "User Role should be select..!";
        }

        if (!isset($Ustatus)) {
            $message['error_ustatus'] = "User Status Should be select ..!";
        }


//        if ($pwd != $conpwd) {
//            $message['error_conpwd'] = " The Password and Confirm Password Not Matching ";
//        }





        if (empty($message)) {
            
            $db = dbConn();
            
             // get existiog values in database
            $sql="SELECT RoleId as userrole,Status as Ustatus FROM tbl_users u WHERE UserId='$UserId'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
//            echo "row";
//            var_dump($row);
//            echo "<br>";
//            echo "<br>";
            
//            echo "post";
//            var_dump($_POST);
            $updatedfieldnames = updatedFields($row,$_POST) ;
//            echo "updated";
//            var_dump($updatedfieldnames);
//            echo "<br>";
//            echo "<br>";
            
            $updatedfieldname_string = implode(",", $updatedfieldnames) ;
            
//            var_dump($updatedfieldname_string);
//            echo "<br>";
//            echo "<br>";

            $userid = $_SESSION['userid'];

            $cdate = date('Y-m-d');
           
            
            $sql = "UPDATE tbl_users SET RoleId='$userrole',Status='$Ustatus',UpdateUser='$userid',UpdateDate='$cdate' WHERE UserId='$UserId'" ;
          //  echo $sql;
            
           $db->query($sql);

           
            header('Location:editsuccess.php?UserId='.$UserId.'&UpdatedFieldsString='. urlencode($updatedfieldname_string));
          

           // echo $sql;
        }
    }
    ?>


    <h2>Update User</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


        <div class="row mb-3">

            <div class="col-md-6">
                <label for="employee_regno" class="form-label">Employee Reg No</label>
                <select class="form-select" disabled class="form-control" id="employee_regno" name="empregno">
                    <option value="">Select Employee Reg No</option>

                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM tbl_employees";
                    $result = $db->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        ?>


                        <option value=<?= $row['RegNo']; ?> <?php if ($row['RegNo'] == @$empregno) { ?>selected <?php } ?>><?= $row['RegNo'] ?></option>
                        <?php
                    }
                    ?>    

                </select>
                <div class="text-danger">
                    <?= @$message['error_empregno'] ?>  
                </div>
            </div>

            <div class="col-md-6">
                <label for="full_name" class="form-label">Employee Full Name</label>
                <?php
//                    $db= dbConn();
//                    $sql= "SELECT * FROM tbl_employees WHERE EmployeeId=$empid " ;
//                    $result= $db->query($sql); 
//                    $title= $result['Title'];
//                    $fname= $result['FirstName'];
//                    $lname= $result['LastName'];
                ?>

                <input type="text" disabled class="form-control" class="form-control" id="full_name" name="fullname" value="<?= @$fullname ?>">
                <div class="text-danger">
                    <?= @$message['error_fullname'] ?>  
                </div>


            </div>


        </div>


        <div class="row mb-3">

            <div class="col-md-6">
                <label for="designation" class="form-label">Designation</label>
                <input type="text" disabled class="form-control" class="form-control" id="designation" name="desig" value="<?= @$desig ?>">
                <div class="text-danger">
                    <?= @$message['error_desig'] ?>  
                </div>

            </div>


            <div class="col-md-6">

                <label for="user_name" class="form-label">User Name</label>
                <input type="text" disabled class="form-control" class="form-control" id="user_name" name="username" value="<?= @$username ?>">
                <div class="text-danger">
                    <?= @$message['error_username'] ?>  
                </div>


            </div>

        </div>



        <div class="row mb-3">  





            <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" disabled class="form-control" class="form-control" id="password" name="pwd" value="<?= @$pwd ?>">
                <div class="text-danger">
                    <?= @$message['error_pwd'] ?>  
                </div>
            </div>


            <div class="col-md-6">
                <label for="confirmpassword" class="form-label">Confirm Password</label>
                <input type="password" disabled class="form-control" class="form-control" id="confirmpassword" name="conpwd" value="<?= @$conpwd ?>">
                <div class="text-danger">
                    <?= @$message['error_conpwd'] ?>  
                </div>
            </div>



        </div>


        <div class="row mb-3">  
            
            <div class="col-md-6">
                <h7 class="h7 text-danger">* Password must be at least 8 characters long. </h7> 
                <br>
                <h7 class="h7 text-danger">* Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character </h7> 
                <br>
                <h7 class="h7 text-danger">* Password must not be the same as the user name. </h7> 
                <br> 
                <h7 class="h7 text-danger">* Password should not contain spaces. </h7> 
            </div>

            <div class="col-md-3">
                <label for="user_role" class="form-label">User Role</label>
                <select class="form-select" id="user_role" name="userrole">
                    <option value="">Select User Role</option>

                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM tbl_user_roles";
                    $result = $db->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        ?>


                        <option value=<?= $row['RoleId']; ?> <?php if ($row['RoleId'] == @$userrole) { ?>selected <?php } ?>><?= $row['RoleName'] ?></option>
                        <?php
                    }
                    ?>    

                </select>
                <div class="text-danger">
                    <?= @$message['error_userrole'] ?>  
                </div>
            </div> 
            
              <div class="col-md-3 mt-2">
                <label>Select User Status</label>

                <div class="form-check form-check">
                    <input class="form-check-input" type="radio" name="Ustatus" id="user_status_yes" value="1" <?php if (isset($Ustatus) && $Ustatus == 1) { ?> checked <?php } ?> >
                    <label class="form-check-label" for="user_status_yes">Active</label>
                </div>

                <div class="form-check form-check">
                    <input class="form-check-input" type="radio" name="Ustatus" id="user_status_no" value="0" <?php if (isset($Ustatus) && $Ustatus == 0) { ?> checked <?php } ?>>
                    <label class="form-check-label" for="user_status_no">In Active</label>
                </div>

                <div class="text-danger">
                    <?= @$message['error_ustatus'] ?>  
                </div>


            </div>
        
        </div>

                <input type="hidden" name="UserId" value="<?= $UserId ?>"> 


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