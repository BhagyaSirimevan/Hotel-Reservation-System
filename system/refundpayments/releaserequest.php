<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Refund Payment Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            
        </div>
    </div>


    <h2>Released Refund Payment List</h2>
    
    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);
        
        if (!empty($refundbillno)) {
            $where .= " RefundBillNo LIKE '%$refundbillno%' AND";
        }

        if (!empty($refundno)) {
            $where .= " r.RefundNo LIKE '%$refundno%' AND";
        }
        
        if (!empty($resno)) {
            $where .= " r.ReservationNo LIKE '%$resno%' AND";
        }
        
       
        if (!empty($refundableamount)) {
            $where .= " r.RefundableAmount LIKE '%$refundableamount%' AND";
        }
        
        

        if (!empty($paymentmethod)) {
            $where .= " r.PaymentMethodId = '$paymentmethod' AND";
        }
        
        if (!empty($paiddate)) {
            $where .= " PaidDate LIKE '%$paiddate%' AND";
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
    
    
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

        <div class="row">
            
             <div class="col">
                <input type="text" class="form-control" placeholder="Refund Bill No" name="refundbillno" >
            </div>
            
            <div class="col">
                <input type="text" class="form-control" placeholder="Refund Req No" name="refundno" >
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Reservation No" name="resno" >
            </div>
            
                         
           
            <div class="col">
                <input type="text" class="form-control" placeholder="Refundable Amount" name="refundableamount" >
            </div>
            
            <div class="col">
                  <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_paymentmethod  WHERE PaymentMethodId!=4";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="paymentmethod" name="paymentmethod">
                    <option value="">Select Payment Method</option>

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
            

            

            
            
            <div class="col">
                <input type="date" class="form-control" placeholder="Paid Date" name="paiddate" >
            </div>



            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px"> Search </i> </button>
            </div>



        </div>
            </form>
    
  



    
  
    <div class="table-responsive">
        <?php
        
        $sql = "SELECT * FROM tbl_issuerefundpayment ir LEFT JOIN tbl_refundpayment r ON r.RefundNo=ir.RefundNo LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=r.PaymentMethodId LEFT JOIN tbl_refund_status s ON s.RefundStatusId=r.RefundStatusId LEFT JOIN tbl_bank b ON b.BankId=r.BankId WHERE r.RefundStatusId=4 $where";
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                     <th scope="col">Refund Bill No</th>
                    <th scope="col">Refund Request No</th>
                     <th scope="col">Reservation No</th>
                    <th scope="col">Refund Amount</th>
                      <th scope="col">Payment Method</th>
                   
                     <th scope="col">Paid Date</th>
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
                             <td><?= $row['RefundBillNo'] ?></td> 
                            <td><?= $row['RefundNo'] ?></td>
                            <td><?= $row['ReservationNo'] ?></td> 
                            <td><?= $row['RefundableAmount'] ?></td>
                            <td><?= $row['PaymentMethod'] ?></td>
                          
                              <td><?= $row['PaidDate'] ?></td>
                                <td><?= $row['RefundStatusName'] ?></td>
                          
                              
                           


                        </tr>

                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
        
      
        

    
  
    </main>
    

  
<?php include '../footer.php'; ?> 