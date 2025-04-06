<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>

<main id="main">
    <section>
        <div class='alert alert-secondary' role='alert'>
            <div class="row">
                <div class='col-md-5'></div>
                <div class='col-md-6'>
                    <img src="../assets/customer/assets/img/regsuccess.png" width="150px" height="150px" alt="alt"/>
                </div>
            </div>

            <h1 class="text-center">  Your Refund Payment Request has been Sent Successfully! </h1>

        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        extract($_GET);
                        //  var_dump($_GET);

                        $refundpaymentid = $_GET['RefundId'];

                        $sql = "SELECT * FROM tbl_refundpayment r LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=r.PaymentMethodId LEFT JOIN tbl_bank b ON b.BankId=r.BankId LEFT JOIN tbl_cashcollect t ON t.CashCollectorId=r.CashCollectorId WHERE RefundId='$refundpaymentid'";
                        //  print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        ?> 

                        <h3 class="text-lg-center text-success">Your Refund Payment Details</h3>
                        <table class="table table-striped table-sm">
                            <thead class="bg-secondary text-lg" >
                                <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Value</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    ?>  
                                    <tr>
                                        <td>Refund No</td>
                                        <td><?= $row['RefundNo'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Reservation No</td>
                                        <td><?= $row['ReservationNo'] ?></td>

                                    </tr>
                                    
                                    <tr>
                                        <td>Reservation Date</td>
                                        <td><?= $row['ReservationDate'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Last Reservation Price</td>
                                        <td><?= $row['LastReservationPrice'] ?></td>

                                    </tr>
                                    
                                    <tr>
                                        <td>Total Paid Amount</td>
                                        <td><?= $row['TotalPaidAmount'] ?></td>

                                    </tr>
                                    
                                    <tr>
                                        <td>Refundable Amount</td>
                                        <td><?= $row['RefundableAmount'] ?></td>

                                    </tr>


                                    <?php
                                    if ($row['PaymentMethod'] == "Cash") {
                                        ?>
                                        <tr>
                                            <td>Payment Method</td>
                                            <td><?= $row['PaymentMethod'] ?></td>

                                        </tr>   
                                        
                                        <tr>
                                            <td>Cash Collect By</td>
                                            <td><?= $row['CollectorName'] ?></td>

                                        </tr>   
                                    
                                    <?php 
                                     if ($row['CollectorName'] == "Other Person") {
                                         ?>
                                        
                                         <tr>
                                            <td>Collector Name</td>
                                            <td><?= $row['CollectPerson'] ?></td>

                                        </tr> 
                                        
                                        <tr>
                                            <td>Collector NIC</td>
                                            <td><?= $row['CollectorNIC'] ?></td>

                                        </tr> 
                                        
                                        
                                    <?php     
                                     }
                                    ?>
                                        
                                        
                                        
                                        
                                        <?php
                                    } elseif ($row['PaymentMethod'] == "Bank Deposit") {
                                        ?>
                                        <tr>
                                            <td>Payment Method</td>
                                            <td><?= $row['PaymentMethod'] ?></td>

                                        </tr>  

                                        <tr>
                                            <td>Paid Bank</td>
                                            <td><?= $row['BankName'] ?></td>

                                        </tr>

                                        <tr>
                                            <td>Branch</td>
                                            <td><?= $row['Branch'] ?></td>

                                        </tr>
                                        
                                        <tr>
                                            <td>Account No</td>
                                            <td><?= $row['AccountNo'] ?></td>

                                        </tr>
                                        
                                        <tr>
                                            <td>Account Holder</td>
                                            <td><?= $row['AccountHolder'] ?></td>

                                        </tr>

            <?php
        } 
            ?>
                                             

                                    <tr>
                                        <td>Description</td>
                                        <td><?= $row['Description'] ?></td>

                                    </tr>
                                    
                                   

    <?php
    }
}
?>

                        </tbody>
                    </table>
                </div>


            </div>
            <div class="col-md-3"></div>

            <div class="row">
                <div class="col-md-8"></div>
                <strong class="text-danger text-center">Refund Payment Verification in progress... Please wait until the status changes.</strong>



            </div>

            <div class="row mt-3">
                <div class="col-md-5"></div>
                <div class="col-md-6">

                    <a href="../customerdashboard.php" class="btn btn-success">Back to Dashboard</a>

                </div>
                <div class="col-md-6"></div>
            </div>



        </div>





    </section>




</main>

<?php include '../dashboardfooter.php'; ?>
