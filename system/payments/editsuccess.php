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

        <h1 class="text-center"> Payment has been verified Successfully..! </h1>

    </div>
    
    <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        extract($_GET);
                        //  var_dump($_GET);

                        $PaymentId = $_GET['PaymentId'];

                        $sql = "SELECT * FROM tbl_customerpayments c LEFT JOIN tbl_paymentcategory p ON p.PaymentCategoryId=c.PaymentCategoryId LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=c.PaymentMethodId LEFT JOIN tbl_bank_details b ON b.BankId=c.PaidBank LEFT JOIN tbl_paymentstatus s ON s.PaymentStatusId=c.PaymentStatusId WHERE PaymentId='$PaymentId'";
                        //  print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        ?> 

                        <h3 class="text-lg-center text-success">Verify Payment Details</h3>
                        <table class="table table-striped table-sm">
                            <thead class="bg-secondary text-lg text-white" >
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
                                        <td>Bill No</td>
                                        <td><?= $row['BillNo'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Reservation No</td>
                                        <td><?= $row['ReservationNo'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Last Reservation Price</td>
                                        <td><?= $row['LastReservationPrice'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Payment Category</td>
                                        <td><?= $row['PaymentCategory'] ?></td>

                                    </tr>


                                    <tr>
                                        <td>Paid Amount</td>
                                        <td><?= $row['PaidAmount'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Balance Amount</td>
                                        <td><?= $row['BalanceAmount'] ?></td>

                                    </tr>



                                    <?php
                                    if ($row['PaymentMethod'] == "Cash") {
                                        ?>
                                        <tr>
                                            <td>Payment Method</td>
                                            <td><?= $row['PaymentMethod'] ?></td>

                                        </tr>   
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
                                            <td>Paid Branch</td>
                                            <td><?= $row['PaidBranch'] ?></td>

                                        </tr>

            <?php
        } elseif ($row['PaymentMethod'] == "Online Transfer") {
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
                                            <td>Reference No</td>
                                            <td><?= $row['ReferenceNo'] ?></td>

                                        </tr>
            <?php
        }
        ?>

                                    <tr>
                                        <td>Paid Date</td>
                                        <td><?= $row['PaidDate'] ?></td>

                                    </tr>
                                    
                                     <tr>
                                        <td>Payment Status</td>
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
            <div class="col-md-3"></div>

           
<!--            <div class="row mt-3">
                <div class="col-md-5"></div>
                <div class="col-md-6">

                    <a href="../indexcustomer.php" class="btn btn-success">Back to Dashboard</a>

                </div>
                <div class="col-md-6"></div>
            </div>-->



        </div>
    


</main>


<?php include '../footer.php'; ?>