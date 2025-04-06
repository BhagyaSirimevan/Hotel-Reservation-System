
<?php ob_start(); ?>
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>



<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
    <section>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Cancel Reservation</h1>


            </div>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            extract($_GET);
              //  var_dump($_GET);

            $ReservationNo = $_GET['ReservationNo'];
        }

        extract($_POST);
        // var_dump($_FILES);
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
            var_dump($_POST);
            $message = array();
            
           if (empty($cancelreason)) {
            $message['error_cancelreason'] = "Should be select Your Cancellation Reason..!";
        } 
            

            if (empty($message)) {

                $db = dbConn();
                $cdate = date('Y-m-d');
                $userid = $_SESSION['userid'];
                
                $sql = "INSERT INTO rescancelreason(ReservationNo,CancelReason,CancelDate) VALUES('$ReservationNo','$cancelreason','$cdate')";
                $db->query($sql);
                
                $sql = "UPDATE tbl_reservation SET ReservationStatusId='3',UpdateUser='$userid',UpdateDate='$cdate' WHERE ReservationNo='$ReservationNo'";

                $db->query($sql);

                header('Location:cancelsuccess.php?ReservationNo=' . $ReservationNo);
            }
        }
        ?>




        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="row mt-4">
                <div class="col-md-2"></div>
             

                <div class="col-md-3">

                    <div class="row">

                        <input type="hidden" name="ReservationNo" value="<?= $ReservationNo ?>"> 
                
                     <label for="resno" class="form-label">Reservation No</label>
                     </div>

                        <div class="row mt-2">


                            <input type="text" class="form-control" id="ReservationNo" name="ReservationNo" value="<?= @$ReservationNo ?>" readonly>
                            <div class="text-danger">
                                <?= @$message['error_resno'] ?>  
                            </div>
                        </div>

                   
                    
                    <div class="row mt-3">
                       
                             <label>Select Your Cancellation Reason</label>  
                               </div>
                   
                    <div class="row">

               
                    <br>


                    <div class="form-check mt-3">
                        <input class="form-check-input" type="radio" name="cancelreason" id="personalreason" value="Personal Reasons" <?php if (isset($cancelreason) && $cancelreason == 'Personal Reasons') { ?> checked <?php } ?>>
                        <label class="form-check-label" for="personalreason">Personal Reasons</label>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="radio" name="cancelreason" id="financialproblem" value="Financial Problem" <?php if (isset($cancelreason) && $cancelreason == 'Financial Problem') { ?> checked <?php } ?>>
                        <label class="form-check-label" for="financialproblem">Financial Problem</label>
                    </div>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="radio" name="cancelreason" id="healthproblem" value="Health Problem" <?php if (isset($cancelreason) && $cancelreason == 'Health Problem') { ?> checked <?php } ?>>
                        <label class="form-check-label" for="healthproblem">Health Problem</label>
                    </div>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="radio" name="cancelreason" id="naturaldisaster" value="Natural Disaster" <?php if (isset($cancelreason) && $cancelreason == 'Natural Disaster') { ?> checked <?php } ?>>
                        <label class="form-check-label" for="naturaldisaster">Natural Disaster</label>
                    </div>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="radio" name="cancelreason" id="legalissue" value="Legal Issue" <?php if (isset($cancelreason) && $cancelreason == 'Legal Issue') { ?> checked <?php } ?>>
                        <label class="form-check-label" for="legalissue">Legal Issue</label>
                    </div>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="radio" name="cancelreason" id="personaltragedy" value="Personal Tragedy" <?php if (isset($cancelreason) && $cancelreason == 'Personal Tragedy') { ?> checked <?php } ?>>
                        <label class="form-check-label" for="personaltragedy">Personal Tragedy</label>
                    </div>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="radio" name="cancelreason" id="suddendeparture" value="A Sudden Departure Abroad" <?php if (isset($cancelreason) && $cancelreason == 'A Sudden Departure Abroad') { ?> checked <?php } ?>>
                        <label class="form-check-label" for="suddendeparture">A Sudden Departure Abroad</label>
                    </div>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="radio" name="cancelreason" id="other" value="Other" <?php if (isset($cancelreason) && $cancelreason == 'Other') { ?> checked <?php } ?> onchange="form.submit()">
                        <label class="form-check-label" for="other">Other</label>
                    </div>
                    
                    <?php 
                    
                      if(isset($cancelreason) && $cancelreason == 'Other') {
                          ?>
                    
                    <div class="row mt-2">
                          
                                <label for="otherreason" class="form-label">Enter Your Reason (Optional)</label>

                         

                            <div class="row">
                                <textarea class="form-control" id="otherreason" name="otherreason"><?= @$otherreason ?></textarea>

                            </div>
                    </div>
                    
                          
                    <?php      
                      }
                    
                    ?>
                    
                    




                    <div class="text-danger">
                        <?= @$message['error_cancelreason'] ?>  
                    </div>

                </div>
                       

                    <div class="row mt-2">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-success" style="width: 200px" name="action" value="save">Cancel Reservation</button>

                        </div>
                    </div>

                </div>



            </div>

        </form>
    </section>

</main>


<?php include '../dashboardfooter.php'; ?>
<?php ob_end_flush(); ?>
