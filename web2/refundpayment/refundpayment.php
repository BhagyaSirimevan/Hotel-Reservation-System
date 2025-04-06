
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>

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
            $where = "AND $where";
        }
    }
    ?>



<main id="main" class="main">
    
    <div class="pagetitle">
      <h1>Payment</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="indexcustomer.php">Home</a></li>
          <li class="breadcrumb-item active">Refund Payment</li>
         
        
        </ol>
      </nav>
    </div>
 
 <section class="section dashboard">
     
      <div class="row mt-4">
       
        <div class="col-md-12">

          <div class="card">
              <div class="row mt-4">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                 <a href="cancelledreservations.php" class="btn btn-success"><i class="bi bi-plus">New Refund Request</i></a> 
        
            </div>
        </div>
              
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                 
                    <div class="card-title text-center"><h3>Your Refund Payment History</h3></div>
        <div class="row">

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
        
        $customerid = $_SESSION['customerid'] ;
        
        $sql = "SELECT * FROM tbl_refundpayment c LEFT JOIN tbl_reservation r ON r.ReservationNo=c.ReservationNo LEFT JOIN tbl_customers t ON t.CustomerId=r.CustomerId LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=c.PaymentMethodId LEFT JOIN tbl_refund_status s ON s.RefundStatusId=c.RefundStatusId WHERE t.CustomerId='$customerid' $where";
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


              </div>

            </div>
          </div>

        </div>
      </div>
    </section>    
    
</main>
  

  

  <!-- ======= Footer ======= -->
  <?php include '../dashboardfooter.php'; ?>