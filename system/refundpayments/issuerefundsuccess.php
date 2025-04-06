<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>
        
        <div class="row">
                <div class='col-md-5'></div>
                <div class='col-md-6'>
                    <img src="../../web2/assets/customer/assets/img/regsuccess.png" width="150px" height="150px" alt="alt"/>
                </div>
        </div>

        <h1 class="text-center"> Refund Payment Released Successfully..! </h1>

    </div>
    
    <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        extract($_GET);
                        //  var_dump($_GET);

                        $refundbillno = $_GET['RefundBillNo'];

                        $sql = "SELECT * FROM tbl_issuerefundpayment r LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=r.PaymentMethodId LEFT JOIN tbl_bank_details b ON b.BankId=r.BankId WHERE RefundBillNo='$refundbillno'";
                        //  print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        ?> 

                        <h3 class="text-lg-center text-success">Issue Refund Payment Details</h3>
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
                                        <td>Refund Bill No</td>
                                        <td><?= $row['RefundBillNo'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Refund No</td>
                                        <td><?= $row['RefundNo'] ?></td>

                                    </tr>
                                    
                                   
                                    
                                      <tr>
                                            <td>Payment Method</td>
                                            <td><?= $row['PaymentMethod'] ?></td>

                                        </tr>   

                                  

                                    <?php
                                    if ($row['PaymentMethod'] == "Cash") {
                                        ?>
                                      
                                        
                                        <tr>
                                            <td>Paid Date</td>
                                            <td><?= $row['PaidDate'] ?></td>

                                        </tr>   
                                        
                                        <?php
                                    } elseif ($row['PaymentMethod'] == "Bank Deposit") {
                                        ?>
                                       

                                        <tr>
                                            <td>Paid Bank</td>
                                            <td><?= $row['BankName'] ?></td>

                                        </tr>

                                        <tr>
                                            <td>Branch</td>
                                            <td><?= $row['BranchName'] ?></td>

                                        </tr>
                                        
                                        <tr>
                                            <td>Account No</td>
                                            <td><?= $row['AccountNo'] ?></td>

                                        </tr>
                                        
                                        <tr>
                                            <td>Reference No</td>
                                            <td><?= $row['ReferenceNo'] ?></td>

                                        </tr>
                                        
                                        <tr>
                                            <td>Paid Date</td>
                                            <td><?= $row['PaidDate'] ?></td>

                                        </tr>  

            <?php
        } 
            ?>
                                             
                                    
                                   

    <?php
    }
}
?>

                        </tbody>
                    </table>
                </div>


            </div>
            <div class="col-md-3"></div>

            

<!--            <div class="row mt-3">
                <div class="col-md-5"></div>
                <div class="col-md-6">

                    <a href="../customerdashboard.php" class="btn btn-success">Back to Dashboard</a>

                </div>
                <div class="col-md-6"></div>
            </div>-->



        </div>
    
</main>

<?php include '../footer.php'; ?>

