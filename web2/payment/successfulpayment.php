
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

        if (!empty($billno)) {
            $where .= " BillNo LIKE '%$billno%' AND";
        }
        
         if (!empty($resno)) {
            $where .= " r.ReservationNo LIKE '%$resno%' AND";
        }


        if (!empty($paymentcategory)) {
            $where .= " p.PaymentCategoryId = '$paymentcategory' AND";
        }

        if (!empty($paymentmethod)) {
            $where .= " m.PaymentMethodId = '$paymentmethod' AND";
        }

      
        if (!empty($paiddate)) {
            $where .= " PaidDate = '$paiddate' AND";
        }
        
        if (!empty($paymentstatus)) {
            $where .= " s.PaymentStatusId = '$paymentstatus' AND";
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
          <li class="breadcrumb-item active">Payment</li>
         
        
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
                 <a href="indexcustomer.php" class="btn btn-success"><i class="bi bi-plus">Make New Payment</i></a> 
        
            </div>
        </div>
              
              
              
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                 
                    <div class="card-title text-center"><h3>Your Successful Payment History</h3></div>
        <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

        <div class="row">
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Bill No" name="billno" >
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Res No" name="resno" >
            </div>
            
           

           
            <div class="col-md-2">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_paymentcategory";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="paymentcategory" name="paymentcategory">
                    <option value="">Select Category</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['PaymentCategoryId']; ?> <?php if ($row['PaymentCategoryId'] == @$paymentcategory) { ?>selected <?php } ?>><?= $row['PaymentCategory'] ?></option>


                            <?php
                        }
                    }
                    ?>
                </select>
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
                <input type="date" class="form-control" placeholder="Date" name="paiddate" >
            </div>

           

            <div class="col">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_paymentstatus";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="paymentstatus" name="paymentstatus">
                    <option value="">Select Status</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['PaymentStatusId']; ?> <?php if ($row['PaymentStatusId'] == @$paymentstatus) { ?>selected <?php } ?>><?= $row['PaymentStatusName'] ?></option>

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
        
        $userid = $_SESSION['userid'] ;
        
        $sql = "SELECT * FROM tbl_customerpayments c LEFT JOIN tbl_reservation r ON r.ReservationNo=c.ReservationNo LEFT JOIN tbl_paymentcategory p ON p.PaymentCategoryId=c.PaymentCategoryId LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=c.PaymentMethodId LEFT JOIN tbl_bank_details b ON b.BankId=c.PaidBank LEFT JOIN tbl_paymentstatus s ON s.PaymentStatusId=c.PaymentStatusId WHERE c.AddUser='$userid' AND c.PaymentStatusId!=1 AND c.PaymentStatusId!=3 $where";
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Bill No</th>
                     <th scope="col">Reservation No</th>
                    <th scope="col">Reservation Price</th>
                    <th scope="col">Payment Category</th>
                    <th scope="col">Paid Amount</th>
                    <th scope="col">Balance Amount</th>
                    <th scope="col">Payment Method</th>
                      <th scope="col">Paid Date</th>
                    <th scope="col">Payment Status</th>
                 

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
                            <td><?= $row['BillNo'] ?></td>
                            <td><?= $row['ReservationNo'] ?></td>
                            <td><?= $row['LastReservationPrice'] ?></td>
                            <td><?= $row['PaymentCategory'] ?></td>
                            <td><?= $row['PaidAmount'] ?></td>  
                            <td><?= $row['BalanceAmount'] ?></td>
                            <td><?= $row['PaymentMethod'] ?></td>
                            <td><?= $row['PaidDate'] ?></td>
                             <td><?= $row['PaymentStatusName'] ?></td>
                              
                           


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