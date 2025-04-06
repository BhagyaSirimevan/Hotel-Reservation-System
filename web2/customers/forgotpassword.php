<?php
ob_start();
include '../header.php';
include '../menu.php';
?>


<main id='main'>

    <section id="book-a-table" class="book-a-table">
        <div class="section-title text-center">
            <h1> <span>Forgot Your Password?</span></h1>
        </div>

        <?php
        extract($_POST);

// 1st step- check the request method  
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {

            // Required Validation
            $message = array();

            if (empty($email)) {
                $message['error_email'] = "Email should not be blank..!";
            } elseif (emailValidation($email)) {
                $message['error_email'] = "Invalid Email Address Format..!";
            } else {
                $db = dbConn();
                $sql = "SELECT FirstName,LastName,Email FROM tbl_customers WHERE Email='$email'";
                $result = $db->query($sql);
                if ($result->num_rows <= 0) {
                    $row = $result->fetch_assoc();
                    $message['error_email'] = "This email does not exist..!";
                } elseif ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $name = $row['FirstName']." ".$row['LastName'];
                
            }
            }



            if (empty($message)) {
                
                header('Location:forgotpasswordsuccess.php?Email=' . $email);
                
                
                
               
                include '../assets/phpmail/mail.php';

                $to = $email;
                $toname = $name;
                $subject = "Nectar Mount Resort - Password reset request";
                $body = "<h1>A new password was requested for Nectar Mount Resort customer account.</h1>";
                $body .= "<p>To reset your password click on the link below:</br>"
                        . "http://localhost/nectar_mount_resort/web2/customers/resetpassword.php?Email=$email</p>";
                $altbody = "You are successfully registered with our system";

                send_email($to, $toname, $subject, $body, $altbody);
            }
        }
        ?>





        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">     

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <br>
                        <h4 class="text-center text-danger">To Reset your password, enter the registered e-mail address.</h4>  
                        <div class="row mt-3">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">

                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Email Address" value="<?= @$email ?>">



                                <div class="text-danger">
                                    <?= @$message['error_email'] ?>  
                                </div> 
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-secondary" style="width: 610px" name="action" value="save">Continue</button>
                            </div>
                            <div class="col-md-1"></div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                
                                
                                <p class="animate__animated animate__fadeInDown">Back to Login page
                                 <a href="../login.php">Login</a></p>
                            <p class="animate__animated animate__fadeInDown">Don't Have an Account?
                                    <a href="register_customer.php">Register</a></p>
                            </div>
                            <div class="col-md-3"></div>

                        </div>


                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>











        </form>  






    </section>


</main>












<?php
include '../footer.php';
ob_end_flush();
?>
