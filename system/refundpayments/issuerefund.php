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

                    $resno = $row['ReservationNo']; 
                    $lastresprice = $row['LastReservationPrice'];
                    $RefundNo = $row['RefundNo'];
                    $method = $row['PaymentMethodId'];
                    $requestamount = $row['RefundableAmount'];
                    $approveddate = $row['UpdateDate'];

                    if ($method == 2) {
                        $bank = $row['BankId'];
                        $branch = $row['Branch'];
                        $accnumber = $row['AccountNo'];
                        $accholder = $row['AccountHolder'];
                    } elseif ($method == 1) {
                        $cashcollect = $row['CashCollectorId'];
                        if ($cashcollect == 2) {
                            $collectorname = $row['CollectPerson'];
                            $collectornic = $row['CollectorNIC'];
                        }
                      //  var_dump($_GET);
                    }
                }
            }
        }


        extract($_POST);
        // var_dump(extract($_POST));
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
          //  var_dump($_POST);
            $message = array();

            if (!empty($paymentmethod) && $paymentmethod == 1) {
            if (empty($paiddate)) {
                $message['error_paiddate'] = "Paid Date should be selected..!";
            }
             }
            
            if (!empty($paymentmethod) && $paymentmethod == 2) {
                
            if (empty($bankid)) {
                $message['error_bankid'] = "Paid Bank should be selected..!";
            }
            
            if (empty($branchname)) {
                $message['error_branchname'] = "Branch Name should be enter..!";
            }
            
            if (empty($referenceno)) {
                $message['error_referenceno'] = "Reference No should be enter..!";
            }
                
            if (empty($paiddate)) {
                $message['error_paiddate'] = "Paid Date should be selected..!";
            }
           
   
        }
            
            
            
            if (empty($message) && !empty($paymentmethod) && $paymentmethod == 2) {
                $PaymentSlipImage = $_FILES['slipimage'];

                echo $filename = $PaymentSlipImage['name'];

                echo $filetmpname = $PaymentSlipImage['tmp_name'];

                echo $filesize = $PaymentSlipImage['size'];

                echo $fileerror = $PaymentSlipImage['error'];

                $fileext = explode(".", $filename);

                $fileext = strtolower(end($fileext));

                $allowedext = array("jpg", "jpeg", "png", "gif");

                if (in_array($fileext, $allowedext)) {

                    if ($fileerror === 0) {
                        if ($filesize <= 2097152) {
                            $file_name_new = uniqid("", true) . "." . $fileext;
                            $file_destination = "../assets/images/refundpayment/" . $file_name_new;

                            if (move_uploaded_file($filetmpname, $file_destination)) {
                                echo "The file was uploaded successfully.";
                            } else {
                                $message['error_file'] = "There was an error uploading the file.";
                            }
                        } else {
                            $message['error_file'] = "This File is Invalid ...!";
                        }
                    } else {
                        $message['error_file'] = "This File has Error ...!";
                    }
                } else {

                    $message['error_file'] = "This File Type not Allowed...!";
                }
            }


            if (empty($message)) {

            $db = dbConn();
            $cdate = date('Y-m-d');
            $userid = $_SESSION['userid'];

          echo  $sql = "INSERT INTO tbl_issuerefundpayment(RefundNo,PaymentMethodId,BankId,PaidBranch,PaidAccNo,ReferenceNo,PaidDate,PaymentSlipImage,AddUser,AddDate) "
                        . "VALUES('$RefundNo','$paymentmethod','$bankid','$branchname','$accnumber','$referenceno','$paiddate','$file_name_new','$userid','$cdate')";
            $db->query($sql);

         //   print_r($sql);

            $issuerefundpaymentid = $db->insert_id;
            $refundbillno = date('Y') . date('m') . date('d') . $issuerefundpaymentid;

            $sql = "UPDATE tbl_issuerefundpayment SET RefundBillNo='$refundbillno' WHERE RefundIssueId='$issuerefundpaymentid'";

            $db->query($sql);

            $sql = "UPDATE tbl_refundpayment SET RefundStatusId=4 WHERE RefundNo='$RefundNo'";

            $db->query($sql);
            
            $sql = "UPDATE tbl_reservation SET ResPaymentStatusId=4 WHERE ReservationNo='$resno'";

            $db->query($sql);
            
            

            header('Location:issuerefundsuccess.php?RefundBillNo=' . $refundbillno);
            }
        }
        ?>

        <h2>Issue Refund Payment </h2> 
        <div class="row">
            <div class="col-md-11"></div>
            <div class="col-md-1">
                <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
            </div>
        </div>
        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <div class="row mt-3">

                <div class="col-md-6">

                    <div class="card">
                        <h3 class="text-center text-success">Refund Request details</h3>
                        <div class="row mt-4">

                            <div class="col-md-5">
                                <label for="refundno" class="form-label">Refund No</label>
                            </div>

                            <div class="col-md-6">


                                <input type="text" class="form-control" id="refundno" name="refundno" value="<?= @$RefundNo ?>" readonly>

                            </div>

                        </div>  

                        <div class="row mt-2">

                            <div class="col-md-5">
                                <label for="customername" class="form-label">Customer Name</label>
                            </div>

                            <div class="col-md-6">
                               

                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_reservation r LEFT JOIN tbl_customers c ON c.CustomerId=r.CustomerId LEFT JOIN tbl_customer_title t ON t.TitleId=c.TitleId WHERE ReservationNo='$resno'";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                    
                                        ?>

                                        <input type="text" class="form-control" id="customername" name="customername" value="<?= $row['TitleName'] . " " . $row['FirstName'] . " " . $row['LastName'] ?>" readonly>

                                            <?php
                                    }
                                }
                                ?>


                            </div>

                        </div>

                        <div class="row mt-2">

                            <div class="col-md-5">
                                <label for="customerregno" class="form-label">Customer Reg No</label>
                            </div>

                            <div class="col-md-6">

                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_reservation r LEFT JOIN tbl_customers c ON c.CustomerId=r.CustomerId WHERE ReservationNo='$resno'";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                }
                                ?>

                                <input type="text" class="form-control" id="customerregno" name="customerregno" value="<?= $row['RegNo'] ?>" readonly>

                            </div>

                        </div>

                        <div class="row mt-2">

                            <div class="col-md-5">
                                <label for="resno" class="form-label">Reservation No</label>
                            </div>

                            <div class="col-md-6">
                                
                                
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_refundpayment WHERE RefundNo='$RefundNo'";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $resno = $row['ReservationNo'];
                                }
                                ?>
                                

                                <input type="text" class="form-control" id="resno" name="resno" value="<?= $row['ReservationNo'] ?>" readonly>
                                 <input type="hidden" id="resno" name="resno" value="<?= $resno ?>">
                            </div>

                        </div>



                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">

                                <label for="requestamount" class="form-label">Refundable Amount (Rs)</label>

                            </div> 

                            <div class="col-md-6 mb-2">



                                <input type="text" class="form-control" id="requestamount" name="requestamount" value="<?= @$requestamount ?>" readonly>


                            </div>

                        </div>



                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="paymentmethod" class="form-label">Request Payment Method</label>

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
                                <input type="hidden" id="method" name="method" value="<?= $method ?>">


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
                        } elseif (@$method == 1) {
                            ?>
                            <div class="row mt-2">
                                <div class="col-md-5 mb-2">
                                    <label for="cashcollect" class="form-label">Cash Collect By </label>  
                                </div>

                                <div class="col-md-6">
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM tbl_cashcollect WHERE CashCollectorId='$cashcollect'";
                                    $result = $db->query($sql);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $cashcollect = $row['CashCollectorId'];
                                    }
                                    ?>

                                    <input type="text" class="form-control" id="cashcollect" name="cashcollect" value="<?= $row['CollectorName'] ?>" readonly> 
                                    <input type="hidden" id="cashcollect" name="cashcollect" value="<?= $cashcollect ?>">


                                </div>

                            </div>

                            <?php
                            if (@$cashcollect == 2) {
                                ?>

                                <div class="row mt-2">
                                    <div class="col-md-5 mb-2">
                                        <label for="collectorname" class="form-label">Collector Name </label>

                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" id="collectorname" name="collectorname" value="<?= @$collectorname ?>" readonly>
                                        <div class="text-danger">
                                            <?= @$message['error_collectorname'] ?>  
                                        </div>  
                                    </div>
                                </div> 

                                <div class="row mt-2">
                                    <div class="col-md-5 mb-2">
                                        <label for="collectornic" class="form-label">Collector NIC  </label>

                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" id="collectornic" name="collectornic" value="<?= @$collectornic ?>" readonly>
                                        <div class="text-danger">
                                            <?= @$message['error_collectornic'] ?>  
                                        </div>  
                                    </div>
                                </div> 


                                <?php
                            }
                            ?>

                            <?php
                        }
                        ?>
                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="approveddate" class="form-label">Approved Date</label>

                            </div>

                            <div class="col-md-6 mb-2">



                                <input type="text" class="form-control" id="approveddate" name="approveddate" value="<?= @$approveddate ?>" readonly>

                            </div>
                        </div>
                    </div>





                </div> 
                <div class="col-md-6">


                    <div class="alert alert-secondary alert-link">
                        <h3 class="text-center text-danger">Refund Payment details</h3>  


                        <div class="row mt-4">
                            <div class="col-md-5 mb-2">
                                <label for="paymentmethod" class="form-label">Paid By</label>

                            </div> 

                            <div class="col-md-6 mb-2">

                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_paymentmethod WHERE PaymentMethodId='$method'";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $paymentmethod = $row['PaymentMethodId'];
                                }
                                ?>


                                <input type="text" class="form-control" id="paymentmethod" name="paymentmethod" value="<?= $row['PaymentMethod'] ?>" readonly>
                                <input type="hidden" id="paymentmethod" name="paymentmethod" value="<?= $paymentmethod ?>">
                             

                            </div>
                        </div>


                        <?php
                        if (@$paymentmethod == 2) {
                            ?>
                        
                            <div class="row">
                                <div class="col-md-5 mb-2">
                                    <label for="bank" class="form-label">Paid Bank <span class="text-danger"><strong>*</strong></span></label>  
                                </div>

                                <div class="col-md-6">
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM tbl_bank_details";
                                    $result = $db->query($sql);
                                    ?>

                                    <select class="form-select" id="bankid" name="bankid" onchange="form.submit()">
                                        <option value="">Select Bank</option>

                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>

                                                <option value=<?= $row['BankId']; ?> <?php if ($row['BankId'] == @$bankid) { ?>selected <?php } ?>><?= $row['BankName'] ?></option>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger">
                                        <?= @$message['error_bankid'] ?>  
                                    </div>

                                </div>

                            </div>

                            <div class="row mt-2">
                                <div class="col-md-5 mb-2">
                                    <label for="branchname" class="form-label">Paid Branch <span class="text-danger"><strong>*</strong></span></label>

                                </div>

                                <div class="col-md-6 mb-2">



                                    <input type="text" class="form-control" id="branchname" name="branchname" value="<?= @$branchname ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_branchname'] ?>  
                                    </div>  
                                </div>
                            </div>


                            <div class="row mt-2">
                                <div class="col-md-5 mb-2">
                                    <label for="paidaccount" class="form-label">Paid Account No  </label>

                                </div>

                                <div class="col-md-6 mb-2">
   
                                    <?php
                                    
                                    if(!empty($bankid)){
                                        
                                   
                                    if ($bankid == 1) {
                                        $db = dbConn();
                                        $sql = "SELECT * FROM tbl_bank_details WHERE BankId=1";
                                        $result = $db->query($sql);
                                    } elseif ($bankid == 2) {
                                        $db = dbConn();
                                        $sql = "SELECT * FROM tbl_bank_details WHERE BankId=2";
                                        $result = $db->query($sql);
                                        } 

                                   
                                    if ($result->num_rows > 0) {
                                       $row = $result->fetch_assoc();
                                         ?>
                                     <input type="text" class="form-control" id="paidaccount" name="paidaccount" value="<?= $row['AccountNo'] ?>" readonly> 
                                     <?php
                                    }
                                   
                                     }
                                    ?>


                                    <div class="text-danger">
                                        <?= @$message['error_paidaccount'] ?>  
                                    </div>  
                                </div>
                            </div>
                        
                        
                        <div class="row mt-2">
                            <div class="col-md-5">
                                <label for="referenceno" class="form-label">Reference No <span class="text-danger"><strong>*</strong></span></label>

                            </div>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="referenceno" name="referenceno" value="<?= @$referenceno ?>">
                                <div class="text-danger">
                                    <?= @$message['error_referenceno'] ?>  
                                </div>  
                            </div>
                        </div>
                        
                        
                        <div class="row mt-2">

                            <div class="col-md-5 mb-2">
                                <label for="paiddate" class="form-label">Paid Date <span class="text-danger"><strong>*</strong></span></label>

                            </div>

                            <div class="col-md-6 mb-2">
                                
                                <?php 
                                
                                $maxdate = date('Y-m-d', strtotime($approveddate . ' +7 days')); // Calculate the selected date

                                ?>

                                <input type="date" min="<?= $approveddate ?>" max="<?= $maxdate ?>" class="form-control" id="paiddate" name="paiddate" value="<?= @$paiddate ?>">
                                <div class="text-danger">
                                    <?= @$message['error_paiddate'] ?>  
                                </div>  
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                        <div class="col-md-5 mb-2">
                            <label for="image" class="form-label">Payment Slip Image <span class="text-danger"><strong>*</strong></span></label>

                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="file" class="form-control" id="image" name="slipimage" value="<?= @$slipimage ?>">
                            <div class="text-danger">
                                <?= @$message['error_slipimage'] ?>  
                            </div>

                        </div>
                    </div>
                        
                        
                        





                            <?php
                        } elseif (@$paymentmethod == 1) {
                        ?>
                        <div class="row mt-2">

                            <div class="col-md-5 mb-2">
                                <label for="paiddate" class="form-label">Paid Date <span class="text-danger"><strong>*</strong></span></label>

                            </div>

                            <div class="col-md-6 mb-2">
                                
                             
                                <input type="date" min="<?= date('Y-m-d')?>" max="<?= date('Y-m-d') ?>" class="form-control" id="paiddate" name="paiddate" value="<?= @$paiddate ?>">
                                <div class="text-danger">
                                    <?= @$message['error_paiddate'] ?>  
                                </div>  
                            </div>
                        </div>
                        
                        <?php
                    }
                        ?>



                    </div>







                    <div class="row mt-2">
                        <div class="col-md-7"></div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Submit</button>

                        </div>
                    </div>
                </div> 
            </div>   



            <div class="row">


                <input type="hidden" name="RefundNo" value="<?= $RefundNo ?>"> 


            </div>

        </form>

    </div>


</main>



<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>
