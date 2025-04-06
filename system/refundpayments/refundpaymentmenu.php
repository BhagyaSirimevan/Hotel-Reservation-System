<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input
       // $resno = cleanInput($resno);
       // $regno = cleanInput($regno);
//        $cusname = cleanInput($cusname);
//        $event = cleanInput($event);
//        $resdate = cleanInput($resdate);
//        $time = cleanInput($time);
//        $guest = cleanInput($guest);
//        $hall = cleanInput($hall);

        if (!empty($refundno)) {
            $where .= " RefundNo LIKE '%$refundno%' AND";
        }
        
         if (!empty($resno)) {
            $where .= " r.ReservationNo LIKE '%$resno%' AND";
        }


      

        if (!empty($paymentmethod)) {
            $where .= " m.PaymentMethodId = '$paymentmethod' AND";
        }

      
        if (!empty($requestdate)) {
            $where .= " c.AddDate = '$requestdate' AND";
        }
        
        if (!empty($refundpaymentstatus)) {
            $where .= " s.RefundStatusId = '$refundpaymentstatus' AND";
        }

      
//        
//        if(!empty($minprice) && !empty($maxprice) ){
//              $where.=" Price BETWEEN '$minprice' AND '$maxprice' AND";
//
//        }
//        


        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = "WHERE $where";
        }
    }
    ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Refund Payment Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            
        </div>
    </div>
    
    <?php
                if ($_SESSION['userrole'] == "Owner") {
                    ?>
                <div class="row mt-4">
        
        <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-warning text-center text-white">

            

            <div class="card-body text-center">
                <h4 class="card-title text-center">Pending Request </h4>

                <div class="row">
                    
                    <div class="ps-3">
                     <?php 
                
                $db = dbConn();
                $sql = "SELECT COUNT(RefundId) FROM tbl_refundpayment WHERE RefundStatusId=1";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                }
                ?>
                      
                <h1 class="text-center text-dark"><?=  $row['COUNT(RefundId)'] ?> </h1>
                     
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="pendingrequest.php" class="btn btn-secondary" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card --> 
    
    
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-success text-center text-white">

            

            <div class="card-body text-center">
                <h4 class="card-title text-center">Approved Request </h4>

                <div class="row">
                    
                    <div class="ps-3">
         <?php 
                
                $db = dbConn();
                $sql = "SELECT COUNT(RefundId) FROM tbl_refundpayment WHERE RefundStatusId=2";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                }
                ?>
                      
                <h1 class="text-center text-dark"><?=  $row['COUNT(RefundId)'] ?> </h1>
                     
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="approvedrequest.php" class="btn btn-secondary" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card -->
    
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-info text-center text-white">

            

            <div class="card-body text-center">
                <h4 class="card-title text-center">Released Request </h4>

                <div class="row">
                    
                    <div class="ps-3">
          <?php 
                
                $db = dbConn();
                $sql = "SELECT COUNT(RefundId) FROM tbl_refundpayment WHERE RefundStatusId=4";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                }
                ?>
                      
                <h1 class="text-center text-dark"><?=  $row['COUNT(RefundId)'] ?> </h1>
                     
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="releaserequest.php" class="btn btn-secondary" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card -->
    
    </div>    

                    <?php
                } elseif($_SESSION['userrole'] == "Manager"){
                    ?>
    <div class="row mt-4">
        
        <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-warning text-center text-white">

            

            <div class="card-body text-center">
                <h4 class="card-title text-center">Pending Request </h4>

                <div class="row">
                    
                    <div class="ps-3">
                     <?php 
                
                $db = dbConn();
                $sql = "SELECT COUNT(RefundId) FROM tbl_refundpayment WHERE RefundStatusId=1";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                }
                ?>
                      
                <h1 class="text-center text-dark"><?=  $row['COUNT(RefundId)'] ?> </h1>
                     
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="pendingrequest.php" class="btn btn-secondary" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card --> 
    
    
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-success text-center text-white">

            

            <div class="card-body text-center">
                <h4 class="card-title text-center">Approved Request </h4>

                <div class="row">
                    
                    <div class="ps-3">
         <?php 
                
                $db = dbConn();
                $sql = "SELECT COUNT(RefundId) FROM tbl_refundpayment WHERE RefundStatusId=2";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                }
                ?>
                      
                <h1 class="text-center text-dark"><?=  $row['COUNT(RefundId)'] ?> </h1>
                     
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="approvedrequest.php" class="btn btn-secondary" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card -->
    
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-info text-center text-white">

            

            <div class="card-body text-center">
                <h4 class="card-title text-center">Released Request </h4>

                <div class="row">
                    
                    <div class="ps-3">
          <?php 
                
                $db = dbConn();
                $sql = "SELECT COUNT(RefundId) FROM tbl_refundpayment WHERE RefundStatusId=4";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                }
                ?>
                      
                <h1 class="text-center text-dark"><?=  $row['COUNT(RefundId)'] ?> </h1>
                     
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="releaserequest.php" class="btn btn-secondary" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card -->
    
    </div> 
    
    <?php
                } elseif($_SESSION['userrole'] == "Billingclerk"){
                    ?>
                    <div class="row mt-4">
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-success text-center text-white">

            

            <div class="card-body text-center">
                <h4 class="card-title text-center">Approved Request </h4>

                <div class="row">
                    
                    <div class="ps-3">
         <?php 
                
                $db = dbConn();
                $sql = "SELECT COUNT(RefundId) FROM tbl_refundpayment WHERE RefundStatusId=2";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                }
                ?>
                      
                <h1 class="text-center text-dark"><?=  $row['COUNT(RefundId)'] ?> </h1>
                     
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="approvedrequest.php" class="btn btn-secondary" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card -->
    
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-info text-center text-white">

            

            <div class="card-body text-center">
                <h4 class="card-title text-center">Released Request </h4>

                <div class="row">
                    
                    <div class="ps-3">
          <?php 
                
                $db = dbConn();
                $sql = "SELECT COUNT(RefundId) FROM tbl_refundpayment WHERE RefundStatusId=4";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                }
                ?>
                      
                <h1 class="text-center text-dark"><?=  $row['COUNT(RefundId)'] ?> </h1>
                     
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="releaserequest.php" class="btn btn-secondary" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card -->
    
    </div>
    <?php
                    
                }
                ?>
    
    
    
    
    
    <div class="row mt-4">
         <h2 class="text-center">Refund Payment History</h2>
        
        <div class="row mt-4">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

        <div class="row">
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Refund No" name="refundno" >
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Res No" name="resno" >
            </div>
            
           
            
            <div class="col-md-2">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_paymentmethod";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="paymentmethod" name="paymentmethod">
                    <option value="">Select Method</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['PaymentMethodId']; ?> <?php if ($row['PaymentMethodId'] == @$paymentmethod) { ?>selected <?php } ?>><?= $row['PaymentMethod'] ?></option>


                            <?php
                        }
                    }
                    ?>
                </select>
            </div>


            <div class="col-md-2">
                <input type="date" class="form-control" placeholder="Date" name="requestdate" >
            </div>

           

            <div class="col-md-2">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_refund_status";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="refundpaymentstatus" name="refundpaymentstatus">
                    <option value="">Select Status</option>

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


            </div>

            



            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px"> Search </i> </button>
            </div>



        </div>
            </form>
            
          <div class="row">
    <div class="table-responsive">
        <?php
        
      
        
        $sql = "SELECT * FROM tbl_refundpayment c LEFT JOIN tbl_reservation r ON r.ReservationNo=c.ReservationNo LEFT JOIN tbl_customers t ON t.CustomerId=r.CustomerId LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=c.PaymentMethodId LEFT JOIN tbl_refund_status s ON s.RefundStatusId=c.RefundStatusId $where";
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Refund No</th>
                     <th scope="col">Reservation No</th>
                    <th scope="col">Total Paid Amount</th>
                    <th scope="col">Refundable Amount</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Request Date</th>
                    <th scope="col">Status</th>
                 

                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>

                        <tr>
                            <td></td>
                            <td><?= $row['RefundNo'] ?></td>
                            <td><?= $row['ReservationNo'] ?></td>
                            <td><?= $row['TotalPaidAmount'] ?></td>
                            <td><?= $row['RefundableAmount'] ?></td>
                            <td><?= $row['PaymentMethod'] ?></td>
                            <td><?= $row['AddDate'] ?></td>
                             <td><?= $row['RefundStatusName'] ?></td>
                              
                           


                        </tr>

                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
        
          </div>
        </div>
      </div>
        
        
    </div>
    
    
    
    
    
</main>    
  
<?php include '../footer.php'; ?> 
