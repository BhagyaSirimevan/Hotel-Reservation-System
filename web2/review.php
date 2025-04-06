<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>


<?php
// 2nd step- extact the form field 
// convert array keys to the seperate variable with the value(extract)
extract($_POST);
//  var_dump($_POST);
// 1st step- check the request method  
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
  
    // Required Validation
    $message = array();

    if (empty($name)) {
        $message['error_name'] = "Should be Enter Your Name..!";
    }
    
     if (empty($description)) {
        $message['error_description'] = "Should be Enter Your Message..!";
    }
  
  
    if (empty($message)) {
        
        
        $Image = $_FILES['image'];
        

        $filename = $Image['name'];

        $filetmpname = $Image['tmp_name'];

        $filesize = $Image['size'];

        $fileerror = $Image['error'];

        $fileext = explode(".", $filename);

        $fileext = strtolower(end($fileext));

        $allowedext = array("jpg", "jpeg", "png", "gif");

        if (in_array($fileext, $allowedext)) {

            if ($fileerror === 0) {
                if ($filesize <= 2097152) {
                    $file_name_new = uniqid("", true) . "." . $fileext;
                    $file_destination = "assets/img/customer/" . $file_name_new;

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
    
        print_r($message);

    if (empty($message)) {


        $db = dbConn();
        $cdate = date('Y-m-d');

         $sql = "INSERT INTO tbl_reviews(CustomerName,Image,Email,Subject,Description,AddDate) "
        . "VALUES('$name','$file_name_new','$email','$subject','$description','$cdate')";

    //   print_r($sql);

        $db->query($sql);
        //  header('Location:customeraddsuccess.php?regno='.$regno);
        // header('Location:customeraddsuccess.php?regno=' . $regno);
    }
}
?>



<section id="contact" class="contact">
    <div class="container">
        <div class="section-title">
            <h2>Reviews</h2>
            <h3>Check Out Our Customer Reviews</h3>

            <div class="row mt-4">
                
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="row mt-3">
                   
                        <?php
                       
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_reviews";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                ?>
                                 <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>

                                        <div class="col-md-12">
                                            <div class='alert bg-body-secondary' role='alert'>
                                                <div class="row mt-3">
                                                    <div class="col-md-2">
                                                      
                                                          <img src="assets/img/customer/<?= $row['Image'] ?>" style="width:100px">
                                                      
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <h5 class="text-success">  <?= $row['CustomerName'] ?></h5>
                                                        </div>
                                                        <div class="row">
                                                            <strong style="text-align: left"><?= $row['Description'] ?></strong>
                                                        </div>
                                                        <div class="row">
                                                             <strong style="text-align: left"><?= $row['AddDate'] ?></strong>
                                                        </div>
                                                            
                                                             
                                                    
                                                    </div>
                                                 
                                                       
                                                   
                                                </div>



                                                

                                            </div>
                                        </div>
                        
                        
                        
                        
                     
                                        
                                   

                                    <?php
                                }
                               ?>   
                        <?php    } 
                        
                        ?>
                  
                       
                </div>
                    
                    


                </div>

                <div class="col-lg-6 mt-5 mt-lg-0 d-flex align-items-stretch">
                

                    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 

                        <h4 class="text-success">Write a Review</h4>
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="name">Your Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="<?= @$name ?>" >
                                <div class="text-danger">
                                    <?= @$message['error_name'] ?>  
                                </div>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="name">Your Image</label>
                                <input type="file" name="image" class="form-control" id="image" value="<?= @$image ?>" >
                                

                            </div>

                            <div class="form-group col-md-12 mt-3">
                                <label for="name">Your Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?= @$email ?>" >
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="name">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" value="<?= @$subject ?>" >
                        </div>
                        <div class="form-group mt-3 mb-3">
                            <label for="name">Message</label>
                            <textarea class="form-control" name="description" rows="10" value="<?= @$description ?>" ></textarea>
                             <div class="text-danger">
                                    <?= @$message['error_description'] ?>  
                                </div>
                        </div>
                        <!--              <div class="my-3">
                                        <div class="loading">Loading</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">Your message has been sent. Thank you!</div>
                                      </div>-->
                        <button type="submit" class="btn btn-success" name="action" value="save">Send Message</button>


                    </form>
                       
                </div>

            </div>

        </div>
</section>








</div>






<?php include 'footer.php'; ?>