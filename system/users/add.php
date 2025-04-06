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
    // 2nd step- extact the form field 
    // convert array keys to the seperate variable with the value(extract)
    extract($_POST);
    //   var_dump($_POST);
    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {




        // 3rd step- clean input
        $empregno = cleanInput($empregno);
        $fullname = cleanInput($fullname);
        $desig = cleanInput($desig);
        $userrole = cleanInput($userrole);

        // Required Validation
        $message = array();

        if (empty($empregno)) {
            $message['error_empregno'] = "Employee Reg No should be select..!";
        }

//        if (empty($fullname)) {
//            $message['error_fullname'] = "Full Name should not be blank..!";
//        }
//        if (empty($desig)) {
//            $message['error_desig'] = "Designation should not be blank..!";
//        }


        if (empty($username)) {
            $message['error_username'] = "User Name should not be blank..!";
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


        if (empty($userrole)) {
            $message['error_userrole'] = "User Role should be select..!";
        }

        if (!isset($Ustatus)) {
            $message['error_ustatus'] = "User Status Should be select ..!";
        }


        if ($pwd != $conpwd) {
            $message['error_conpwd'] = " The Password and Confirm Password Not Matching ";
        }





        if (empty($message)) {

            $userid = $_SESSION['userid'];

            $cdate = date('Y-m-d');
            $pwd = sha1($pwd);
            $sql = "INSERT INTO tbl_users(UserName,Password,RoleId,Status,AddUser,AddDate) "
                    . "VALUES('$username','$pwd','$userrole','$Ustatus','$userid','$cdate')";
            echo $sql;
            $db = dbConn();
            $db->query($sql);

            $newuserid = $db->insert_id;
            $sql = "UPDATE tbl_employees SET UserId='$newuserid' WHERE RegNo='$empregno'";
            $db->query($sql);
            echo $sql;
            header('Location:addsuccess.php?UserId=' . $newuserid);

            // echo $sql;
        }
    }
    ?>


    <h2>Add New User</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


        <div class="row mb-3">

            <div class="col-md-6">
                <label for="employee_regno" class="form-label">Employee Reg No</label>
                <select class="form-select" id="employee_regno" name="empregno" onchange="form.submit()">
                    <option value="">Select Employee Reg No</option>

                    <?php
                    $db = dbConn();
                    $sql = "SELECT RegNo FROM tbl_employees WHERE UserId=0";
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
                $db = dbConn();
                $sql = "SELECT * FROM tbl_employees WHERE RegNo='" . @$empregno . "'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();

                if ($result->num_rows > 0) {
                    $fullname = $row['FullName'];
                }
                ?>


                <input type="text" class="form-control" id="full_name" name="fullname" value="<?= @$fullname ?>" disabled>
                <div class="text-danger">
                    <?= @$message['error_fullname'] ?>  
                </div>


            </div>


        </div>


        <div class="row mb-3">

            <div class="col-md-6">
                <label for="designation" class="form-label">Designation</label>
                
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_employees e LEFT JOIN tbl_designation d ON d.DesignationId=e.DesignationId  WHERE RegNo='" . @$empregno . "'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();

                if ($result->num_rows > 0) {
                    $desig = $row['Name'];
                }
                ?>
                
                
                <input type="text" class="form-control" id="designation" name="desig" value="<?= @$desig ?>" disabled>
                <div class="text-danger">
                    <?= @$message['error_desig'] ?>  
                </div>

            </div>


            <div class="col-md-6">

                <label for="user_name" class="form-label">User Name</label>
                <input type="text" class="form-control" id="user_name" name="username" value="<?= @$username ?>">
                <div class="text-danger">
                    <?= @$message['error_username'] ?>  
                </div>


            </div>

        </div>



        <div class="row mb-3">  





            <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="pwd" value="<?= @$pwd ?>">
                <div class="text-danger">
                    <?= @$message['error_pwd'] ?>  
                </div>
            </div>


            <div class="col-md-6">
                <label for="confirmpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmpassword" name="conpwd" value="<?= @$conpwd ?>">
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
                    <input class="form-check-input" type="radio" name="Ustatus" id="user_status_yes" value="1" <?php if (isset($Ustatus) && $Ustatus == 'Yes') { ?> checked <?php } ?> >
                    <label class="form-check-label" for="user_status_yes">Active</label>
                </div>

                <div class="form-check form-check">
                    <input class="form-check-input" type="radio" name="Ustatus" id="user_status_no" value="0" <?php if (isset($Ustatus) && $Ustatus == 'No') { ?> checked <?php } ?>>
                    <label class="form-check-label" for="user_status_no">In Active</label>
                </div>

                <div class="text-danger">
                    <?= @$message['error_ustatus'] ?>  
                </div>


            </div>

        </div>


        <div class="row">
            <div class="col-md-10"></div>

            <div class="col-md-2">
                <a href="add.php" class="btn btn-secondary" name="action" value="cancel">Cancel </a>
                <button type="submit" class="btn btn-success" name="action" value="save">Submit</button>
            </div>
        </div>




    </form>


</main>
<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 