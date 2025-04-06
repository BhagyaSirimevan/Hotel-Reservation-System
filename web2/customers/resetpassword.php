<?php
ob_start();
include '../header.php';
include '../menu.php';
?>


<main id='main'>

    <section id="book-a-table" class="book-a-table">
        <div class="section-title text-center">
            <h1> <span>Reset Password</span></h1>
        </div>

        <?php
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        extract($_GET);
                    //     var_dump($_GET);

                     //   $Email = $_GET['Email'];
                        // var_dump($_GET['Email']);
                      //  $_SESSION['Email'] = $email;
                        
//        $db = dbConn();
//   echo $sql = "SELECT Email FROM tbl_customers WHERE Email='$email'";
//        $result = $db->query($sql);
//
//        if ($result->num_rows > 0) {
//            $row = $result->fetch_assoc();
//               
//                $email = $row['Email'];
//            
//        }                
        
        
         }
        
        
       
 extract($_POST);
// 1st step- check the request method  
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

          //  var_dump($_POST);
          //   echo "</br>";
         //   echo $password."password";
          //  echo $pwd."pwd";
          //  echo "</br>";
         //   echo $conpwd."conpwd";
        //    echo $conpwd;
          //   echo "</br>";
          //  echo $Email."Email";
        //    echo $email."email";
            // Required Validation
            $message = array();

            if (empty($pwd)) {
                $message['error_pwd'] = "Password should not be blank..!";
            } elseif (strlen($pwd) < 8) {
                $message['error_pwd'] = "Password must be at least 8 characters long..!";
            } elseif (!preg_match('/[A-Z]/', $pwd) || !preg_match('/[a-z]/', $pwd) || !preg_match('/[0-9]/', $pwd) || !preg_match('/[^A-Za-z0-9]/', $pwd)) {
                $message['error_pwd'] = "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character..!";
            }  elseif (strpos($pwd, ' ') != false) {
                $message['error_pwd'] = "Password should not contain spaces";
            }

            if (empty($conpwd)) {
                $message['error_conpwd'] = "Confirm Password should not be blank..!";
            }

            if ($pwd != $conpwd) {
                $message['error_conpwd'] = " The Password and Confirm Password Not Matching ";
            }



            if (empty($message)) {
                
            $pwd = sha1($pwd);
            $conpwd = sha1($conpwd);    
            
            $sql="UPDATE tbl_users SET Password ='$pwd' WHERE UserId=(SELECT UserId from tbl_customers WHERE Email='$Email')";
              //  print_r($sql);

                $db = dbConn();
                $db->query($sql);
                
            header('Location:resetpasswordsuccess.php?Email=' . $Email);
            
            }
        }
        ?>





        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">     

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card bg-light">

                        <br>
                        
                        <div class="row">
                           
                            <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <h8 class="h10 text-danger">* Password must be at least 8 characters long. </h8> 
                                        <br>
                                        <h8 class="h8 text-danger">* Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character. </h8> 
                                        <br>
                                        <h8 class="h8 text-danger">* Password must not be the same as the user name. </h8> 
                                        <br> 
                                        <h8 class="h8 text-danger">* Password should not contain spaces. </h8> 
                                    </div>


                                </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="pwd" value="<?= @$pwd ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_pwd'] ?>  
                                    </div>



                                </div>

                                




                                <div class="row mt-3">
                                    <label for="confirmpassword" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="confirmpassword" name="conpwd" value="<?= @$conpwd ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_conpwd'] ?>  
                                    </div>



                                </div>


                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-success" style="width: 620px">Change</button>
                                
                            </div>
                            <div class="col-md-1"></div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">


                                <p class="animate__animated animate__fadeInDown">Back to Login page?
                                    <a href="../login.php">Login</a></p>

                            </div>
                            <div class="col-md-3"></div>

                        </div>


                    </div>
                </div>
                <div class="col-md-3">
                      <input type="hidden" name="Email" value="<?= $Email ?>"> 
                </div>
            </div>











        </form>  






    </section>


</main>












<?php
include '../footer.php';
ob_end_flush();
?>
