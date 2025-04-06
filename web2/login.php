<?php 
session_start();
include 'function.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login-Nectar Mount Resort</title>
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
<link href="assets/css/login.css" rel="stylesheet" type="text/css"/>
  </head>
  <body class="text-center" style="background-image: url('assets/img/Nectar2.jpg');background-repeat: no-repeat;background-size: cover;">
   

<main class="form-signin bg-secondary-subtle w-100 m-auto border border-2 border-dark">
    <section>
    
        
        
    <?php 
    
    
    
    if($_SERVER['REQUEST_METHOD']=="POST"){
       extract($_POST);
        
       $UserName= cleanInput($UserName);
       
       $message= array();
       
       if(empty($UserName)){
           $message['error_username']="User Name should not be blank";
       }
       
       if(empty($Password)){
           $message['error_password']="The Password should not be blank";
       }
       
       if(empty($message)){
          $Password= sha1($Password);
          $sql="SELECT * FROM tbl_users u LEFT JOIN tbl_user_roles r ON r.RoleId=u.RoleId LEFT JOIN tbl_customers c ON c.UserId=u.UserId LEFT JOIN tbl_customer_title t ON t.TitleId=c.TitleId WHERE u.UserName='$UserName' AND u.Password='$Password'";
        //  print_r($sql);
          $db= dbConn();
          $result=$db->query($sql);
          if($result->num_rows<=0){
              $message['error_login']="Invalid User Name or Password";
          } else {
             $row = $result->fetch_assoc() ;
              $_SESSION['userid'] = $row['UserId'];
              $_SESSION['title'] = $row['TitleName'];
              $_SESSION['firstname'] = $row['FirstName'];
              $_SESSION['lastname'] = $row['LastName'];
              $_SESSION['userrole'] = $row['RoleName'];
              $_SESSION['customerid'] = $row['CustomerId'];
           
            
              if(!empty($_SESSION['checkavailability'])){
                   header("Location:reservation/eventdetails.php"); 
              } else {
                 header("Location:customerdashboard.php"); 
              
              }
          //  print_r($_SESSION);
          var_dump($_SESSION);
          }
          
          
          
       }
       
       
    }
    
    
    ?>
    
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"> 
        <img class="mb-4" src="../system/assets/images/Mount.PNG" style="size: 20px 20px">
    <h1 class="h3 mb-3 fw-normal text-dark">Please Sign in</h1>

    <div class="text-danger">
    
         <?= @$message['error_username'] ?>  
    </div>
    
     <div class="text-danger">
    
         <?= @$message['error_password'] ?>  
    </div>
    
    <div class="text-danger">
    
         <?= @$message['error_login'] ?>  
    </div>
    
    <div class="form-floating">
      <input type="text" class="form-control" id="UserName" name="UserName" placeholder="Enter User Name">
      <label for="UserName">User Name</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter Password">
      <label for="Password">Password</label>
    </div>
      <a href="customers/forgotpassword.php">Forgot password?</a>
     
      <p></p>
    <button class="w-100 btn btn-lg btn-secondary" type="submit">Sign in</button>
    <p></p>
                     <p class="animate__animated animate__fadeInDown"><span>Don't Have an Account?</span>
                     <a href="customers/register_customer.php">Register</a></p>
                    
               
  </form>
        </section>
</main>


    
  </body>
</html>
