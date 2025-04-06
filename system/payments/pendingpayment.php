<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Customer Payment Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            
        </div>
    </div>


    <h2>Pending Customer Payment List</h2>
    
    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);


        if (!empty($billno)) {
            $where .= " c.BillNo LIKE '%$billno%' AND";
        }
        
        if (!empty($resno)) {
            $where .= " ReservationNo LIKE '%$resno%' AND";
        }
        
        if (!empty($paymentcategory)) {
            $where .= " c.PaymentCategoryId = '$paymentcategory' AND";
        }

       
        if (!empty($paidamount)) {
            $where .= " PaidAmount LIKE '%$paidamount%' AND";
        }


        if (!empty($balanceamount)) {
            $where .= " BalanceAmount LIKE '%$balanceamount%' AND";
        }

        if (!empty($paymentmethod)) {
            $where .= " c.PaymentMethodId = '$paymentmethod' AND";
        }
        
        if (!empty($paiddate)) {
            $where .= " PaidDate LIKE '%$paiddate%' AND";
        }
        
        
        if (!empty($status)) {
            $where .= " c.PaymentStatusId = '$status' AND";
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
            <div class="col-md-1">
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
                    <option value="">Select Payment Category</option>

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
            

            <div class="col-md-1">
                <input type="text" class="form-control" placeholder="Paid Amount" name="paidamount" >
            </div>
            <div class="col-md-1">
                <input type="text" class="form-control" placeholder="Balance Amount" name="balanceamount" >
            </div>
            
            <div class="col-md-2">
                  <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_paymentmethod";
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
            

            <div class="col-md-1">
                <input type="date" class="form-control" placeholder="Paid Date" name="paiddate" >
            </div>

            <div class="col-md-1">
                  <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_paymentstatus";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="status" name="status">
                    <option value="">Select Status</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['PaymentStatusId']; ?> <?php if ($row['PaymentStatusId'] == @$status) { ?>selected <?php } ?>><?= $row['PaymentStatusName'] ?></option>

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
    
  



    
  
    <div class="table-responsive">
        <?php
        
        if(($_SESSION['userrole'] == "Billingclerk")){
              $sql = "SELECT * FROM tbl_customerpayments c "
                . "LEFT JOIN tbl_paymentcategory p ON p.PaymentCategoryId=c.PaymentCategoryId "
                . "LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=c.PaymentMethodId "
                . "LEFT JOIN tbl_bank_details b ON b.BankId=c.PaidBank "
                . "LEFT JOIN tbl_paymentstatus s ON s.PaymentStatusId=c.PaymentStatusId "
                . "WHERE c.PaymentStatusId=1 AND c.PaymentMethodId!=1 $where";
            
        } elseif($_SESSION['userrole'] == "Manager"){
              $sql = "SELECT * FROM tbl_customerpayments c "
                . "LEFT JOIN tbl_paymentcategory p ON p.PaymentCategoryId=c.PaymentCategoryId "
                . "LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=c.PaymentMethodId "
                . "LEFT JOIN tbl_bank_details b ON b.BankId=c.PaidBank "
                . "LEFT JOIN tbl_paymentstatus s ON s.PaymentStatusId=c.PaymentStatusId "
                . "WHERE c.PaymentStatusId=1 AND c.PaymentMethodId=1 $where";
            
        } elseif($_SESSION['userrole'] == "Owner"){
              $sql = "SELECT * FROM tbl_customerpayments c "
                . "LEFT JOIN tbl_paymentcategory p ON p.PaymentCategoryId=c.PaymentCategoryId "
                . "LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=c.PaymentMethodId "
                . "LEFT JOIN tbl_bank_details b ON b.BankId=c.PaidBank "
                . "LEFT JOIN tbl_paymentstatus s ON s.PaymentStatusId=c.PaymentStatusId "
                . "WHERE c.PaymentStatusId=1 $where";
            
        }
        
        
      
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Bill No</th>
                     <th scope="col">Reservation No</th>
                   
                    <th scope="col">Payment Category</th>
                    <th scope="col">Paid Amount</th>
                    <th scope="col">Balance Amount</th>
                    <th scope="col">Payment Method</th>
                      <th scope="col">Paid Date</th>
                       <th scope="col">Slip</th>
                    <th scope="col">Status</th>
                    
                    <?php
                if ($_SESSION['userrole'] == "Billingclerk") {
                    ?>
                 <th scope="col">Verify</th>

                    <?php
                }
                ?>
                    
                    
                 

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
                         
                            <td><?= $row['PaymentCategory'] ?></td>
                            <td><?= $row['PaidAmount'] ?></td>  
                            <td><?= $row['BalanceAmount'] ?></td>
                            <td><?= $row['PaymentMethod'] ?></td>
                            <td><?= $row['PaidDate'] ?></td>
                            <td><a href=""><img class="img-fluid" width="100" src="../../web2/assets/img/payment/<?= $row['PaymentSlipImage'] ?>"></a></td>
                            
                            <td><?= $row['PaymentStatusName'] ?></td>
                            
                            <?php
                if ($_SESSION['userrole'] == "Billingclerk") {
                    ?>
                   <td><a href="edit.php?PaymentId=<?= $row['PaymentId'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit" style="font-size:15px"></i> </a></td>

                    <?php
                } elseif($_SESSION['userrole'] == "Owner"){
                    ?>
                   <td><a href="edit.php?PaymentId=<?= $row['PaymentId'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit" style="font-size:15px"></i> </a></td>              
                  <?php  
                }
                ?>
                            
                            
                            
                            
                              
                           


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