
<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Refund Payment Management </h1>
    </div>
    
<div class="row">
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        //  var_dump($_GET);

        $db = dbConn();
        $sql = "SELECT * FROM tbl_refundpayment WHERE RefundNo='$RefundNo'";
        //  print_r($sql);
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $ReservationNo = $row['ReservationNo'];
                $lastresprice = $row['LastReservationPrice'];
                $RefundNo = $row['RefundNo'];
                $method = $row['PaymentMethodId'];
               
                if ($method == 2) {
                    $bank = $row['BankId'];
                    $branch = $row['Branch'];
                    $accnumber = $row['AccountNo'];
                    $accholder = $row['AccountHolder'];
                }
               
            }
        }
    }
   

    extract($_POST);
   
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
      //  var_dump($_POST);
        $message = array();

        if (empty($refundpaymentstatus)) {
            $message['error_refundpaymentstatus'] = "Refund Payment Status should be selected..!";
        } else{
             if($refundpaymentstatus == 1){
                  if (empty($pendingreason)) {
                     $message['error_pendingreason'] = "Refund Payment Pending Reason should be Enter..!";
                  
                  }
                 
                 
             }
        }
        
        
        

        
        if (empty($message)) {

            $db = dbConn();
            $cdate = date('Y-m-d');
            $userid = $_SESSION['userid'];

            $sql = "UPDATE tbl_refundpayment SET RefundStatusId='$refundpaymentstatus',PendingReason='$pendingreason',UpdateUser='$userid',UpdateDate='$cdate' WHERE RefundNo='$RefundNo'";
                      
            $db->query($sql);

            
            header('Location:editsuccess.php?RefundNo=' . $RefundNo);
        }
    }
    ?>
         
    <h2>Approve Refund Payment</h2>
        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                 
        
        <div class="row">
            

            <input type="hidden" name="RefundNo" value="<?= $RefundNo ?>"> 
           

            <div class="col-md-2"></div>
            <div class="col-md-8">
              
 <div class="alert bg-secondary-light">
       <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
            </div>
        </div>
                <div class="row mt-2">

                    <div class="col-md-5">
                        <label for="ReservationNo" class="form-label">Reservation No</label>
                    </div>

                    <div class="col-md-6">
                        
                        <?php
                        $db = dbConn();
                        $sql = "SELECT ReservationNo FROM tbl_reservation WHERE ReservationNo='$ReservationNo'";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $ReservationNo = $row['ReservationNo'];
                         }
                 //       $paidamount = $lastresprice * $row['PaymentRatio'];
                        ?>


                        <input type="text" class="form-control" id="ReservationNo" name="ReservationNo" value="<?= @$ReservationNo ?>" readonly>
                      
                    </div>

                </div>
     
                <div class="row mt-2">
                    <div class="col-md-5 mb-2">
                        <label for="resdate" class="form-label">Reservation Date</label>

                    </div>

                    <div class="col-md-6 mb-2">
                        
                        <?php
                        $db = dbConn();
                        $sql = "SELECT ReservationDate FROM tbl_reservation WHERE ReservationNo='$ReservationNo'";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $resdate = $row['ReservationDate'];
                         }
                 //       $paidamount = $lastresprice * $row['PaymentRatio'];
                        ?>
                        
                        
                        <input type="date" class="form-control" id="resdate" name="resdate" value="<?= @$resdate ?>" readonly>
                      
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-5 mb-2">
                        <label for="lastresprice" class="form-label">Last Reservation Price (Rs)</label>
                    </div>

                    <div class="col-md-6 mb-2">

                        <?php
                        $db = dbConn();
                        $sql = "SELECT LastReservationPrice FROM tbl_reservation WHERE ReservationNo='$ReservationNo'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();

                        @$lastresprice = $row['LastReservationPrice'];
                        ?>


                        <input type="text" class="form-control" id="lastresprice" name="lastresprice" value="<?= @$lastresprice ?>" readonly>
                       

                    </div>
                </div>

                

                <div class="row mt-2">
                    <div class="col-md-5 mb-2">
                        <label for="paidamount" class="form-label">Total Paid Amount (Rs)</label>
                    </div>
                    <div class="col-md-6 mb-2">

                        <?php
                        $db = dbConn();
                        $sql = "SELECT SUM(PaidAmount) FROM tbl_customerpayments WHERE ReservationNo='$ReservationNo' AND PaymentStatusId=2";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $paidamount = $row['SUM(PaidAmount)'];
                         }
                 //       $paidamount = $lastresprice * $row['PaymentRatio'];
                        ?>

                        <input type="text" class="form-control" id="paidamount" name="paidamount" value="<?= @$paidamount ?>" readonly>
                       

                    </div>
                </div>
     
     <div class="row mt-2">
                        <div class="col-md-5 mb-2">

                            <label for="requestamount" class="form-label">Refundable Amount (Rs)</label>

                        </div> 

                        <div class="col-md-6 mb-2">
                            
                        <?php
                        
                        
                        $db = dbConn();
                        $sql = "SELECT ReservationDate FROM tbl_reservation WHERE ReservationNo='$ReservationNo'";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $reservationdate = $row['ReservationDate'];
                        
                        $requestdate = date('Y-m-d');
                        
                        $mindate = date('Y-m-d', strtotime($reservationdate . ' -14 days')); // Calculate the selected date

                        }
                        
                        if($requestdate < $mindate){
                         $requestamount = $paidamount;   
                            
                        } else {
                            
                        $db = dbConn();
                        $sql = "SELECT PaymentRatio FROM tbl_paymentcategory WHERE PaymentCategoryId=1";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        
                        $advancepayment = $lastresprice * $row['PaymentRatio'];  
                      
                        }
                        
                        $db = dbConn();
                        $sql = "SELECT PaymentRatio FROM tbl_paymentcategory WHERE PaymentCategoryId=4";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        
                        $fullpayment = $lastresprice * $row['PaymentRatio'];  
                        }
                        if($paidamount == $advancepayment){
                            $requestamount = 0;
                        } elseif($paidamount == $fullpayment) {
                            $requestamount = $fullpayment - $advancepayment ; 
                        }
                        
                            
                            
                        }
                          
                            
                            ?>
                            
                            
                           

                            <input type="text" class="form-control" id="requestamount" name="requestamount" value="<?= @$requestamount ?>" readonly>
                            

                        </div>

                    </div>
     
     <div class="row mt-2">
                        <div class="col-md-5 mb-2">
                            <label for="paymentmethod" class="form-label">Refund Payment Method</label>

                        </div> 

                        <div class="col-md-6 mb-2">

                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_paymentmethod WHERE PaymentMethodId='$method'";
                            $result = $db->query($sql);
                            
                            if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();    
                            
                            $method = $row['PaymentMethodId'];
                            
                              }
                            
                            ?>

                        
                        <input type="text" class="form-control" id="method" name="method" value="<?= $row['PaymentMethod'] ?>" readonly>
                           
                           <input type="hidden" name="method" value="<?= $method ?>"> 
            
                          
                        </div>
                    </div>
     
     <?php
                    if (@$method == 2) {
                        ?>

                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="bank" class="form-label">Bank Name</label>  
                            </div>

                            <div class="col-md-6">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_bank WHERE BankId='$bank'";
                                $result = $db->query($sql);
                                
                                if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();   
                                 $bank = $row['BankId'];
                                }
                                ?>

                                <input type="text" class="form-control" id="bank" name="bank" value="<?= $row['BankName'] ?>" readonly>
                               <input type="hidden" id="bank" name="bank" value="<?= $bank ?>">
                            

                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="branch" class="form-label">Branch Name</label>

                            </div>

                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="branch" name="branch" value="<?= @$branch ?>" readonly>
                                <div class="text-danger">
                                    <?= @$message['error_branch'] ?>  
                                </div>  
                            </div>
                        </div>
                
                
                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="accnumber" class="form-label">Account No</label>

                            </div>

                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="accnumber" name="accnumber" value="<?= @$accnumber ?>" readonly>
                                <div class="text-danger">
                                    <?= @$message['error_accnumber'] ?>  
                                </div>  
                            </div>
                        </div>
                
                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="accholder" class="form-label">Account Holder Name </label>

                            </div>

                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="accholder" name="accholder" value="<?= @$accholder ?>" readonly>
                                <div class="text-danger">
                                    <?= @$message['error_accholder'] ?>  
                                </div>  
                            </div>
                        </div>



                        <?php
                    }
                    ?>
                
                
                <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="description" class="form-label">Description</label>

                            </div>

                            <div class="col-md-6 mb-2">
                                <textarea class="form-control" id="description" name="description" readonly><?= @$description ?></textarea>

                            </div>
                </div>
     
                <div class="alert alert-secondary mt-4">
                    <div class="row mt-2">
                        <div class="col-md-5 mb-2">
                            <label for="refundpaymentstatus" class="form-label">Refund Payment Status <span class="text-danger"><strong>*</strong></span></label>

                        </div> 

                        <div class="col-md-7 mb-2">

                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_refund_status WHERE RefundStatusId=2 OR RefundStatusId=1";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="refundpaymentstatus" name="refundpaymentstatus" onchange="form.submit()">
                                <option value="">Select Refund Payment Status</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['RefundStatusId']; ?> <?php if ($row['RefundStatusId'] == @$refundpaymentstatus) { ?>selected <?php } ?>><?= $row['RefundStatusName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="text-danger">
                                <?= @$message['error_refundpaymentstatus'] ?>  
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <?php 
                        if(@$refundpaymentstatus == 1){
                            ?>
                            
                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="pendingreason" class="form-label">Pending Reason <span class="text-danger"><strong>*</strong></span></label>

                            </div>

                            <div class="col-md-7 mb-2">
                                <textarea class="form-control" id="pendingreason" name="pendingreason"><?= @$pendingreason ?></textarea>
                                <div class="text-danger">
                                <?= @$message['error_pendingreason'] ?>  
                            </div>
                            </div>
                </div>
                          <?php  
                        }
                        
                        ?>
                    </div>
                    
                </div>
                
                
              

                <div class="row mt-2">
                    <div class="col-md-7"></div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Submit</button>

                    </div>
                </div>



                


            </div>
                </div>

           
            
              </div>

    </form>
        
          </div>
    

</main>



<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>