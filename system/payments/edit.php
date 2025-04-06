
<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Customer Payment Management </h1>

    </div>


    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        //    var_dump($_GET);

        $db = dbConn();
        $sql = "SELECT * FROM tbl_customerpayments WHERE PaymentId='$PaymentId'";
        //  print_r($sql);
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $resno = $row['ReservationNo'];
                $lastresprice = $row['LastReservationPrice'];
                $paymentcategory = $row['PaymentCategoryId'];
                $paidamount = $row['PaidAmount'];
                $balanceamount = $row['BalanceAmount'];
                $paymentmethod = $row['PaymentMethodId'];
                $paiddate = $row['PaidDate'];
                $slipimage = $row['PaymentSlipImage'];
                $PaymentId = $row['PaymentId'];

                if ($paymentmethod == 2) {
                    $paidbank = $row['PaidBank'];
                    $paidbranch = $row['PaidBranch'];
                    $referenceno = null;
                } elseif ($paymentmethod == 4) {
                    $paidbank = $row['PaidBank'];
                    $referenceno = $row['ReferenceNo'];
                    $paidbranch = null;
                }
            }
        }
    }

    extract($_POST);
    // var_dump($_FILES);
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
     //   var_dump($_POST);
        $message = array();

        if (empty($resno)) {
            $message['error_resno'] = "Reservation No should be selected..!";
        }

        if (empty($paymentcategory)) {
            $message['error_paymentcategory'] = "Payment Category should be selected..!";
        }

        if (empty($paymentmethod)) {
            $message['error_paymentmethod'] = "Payment Method should be selected..!";
        }

        if (!empty($paymentmethod) && $paymentmethod == 2) {
            if (empty($paidbank)) {
                $message['error_paidbank'] = "Paid Bank should be selected..!";
            }

            if (empty($paidbranch)) {
                $message['error_paidbranch'] = "Paid Branch should be Enter..!";
            }
        }

        if (!empty($paymentmethod) && $paymentmethod == 4) {
            if (empty($paidbank)) {
                $message['error_paidbank'] = "Paid Bank should be selected..!";
            }

            if (empty($referenceno)) {
                $message['error_referenceno'] = "Reference No should be Enter..!";
            }
        }


        if (empty($paymentstatus)) {
            $message['error_paymentstatus'] = "Payment Status should be selected..!";
        }





        if (empty($message) && !empty($_FILES['slipimage']['name'])) {
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
                        $file_destination = "../assets/img/payment/" . $file_name_new;

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
        } else {
            $file_name_new = $prv_image;
        }


        if (empty($message)) {

            $db = dbConn();
            $cdate = date('Y-m-d');
            $userid = $_SESSION['userid'];

            $sql = "UPDATE tbl_customerpayments SET PaymentStatusId='$paymentstatus',UpdateUser='$userid',UpdateDate='$cdate' WHERE PaymentId='$PaymentId'";
            $db->query($sql);

            // print_r($sql);

            if ($paymentstatus == 2) {
                if ($paymentcategory == 1) {
                    echo $sql = "UPDATE tbl_reservation SET ResPaymentStatusId=2,ReservationStatusId=2 WHERE ReservationNo='$resno'";
                } elseif ($paymentcategory != 1) {
                    echo $sql = "UPDATE tbl_reservation SET ResPaymentStatusId=3,ReservationStatusId=2 WHERE ReservationNo='$resno'";
                }

                $db->query($sql);
               if ($paymentcategory != 1) {
                    echo $sql = "UPDATE tbl_customerpayments SET PaymentStatusId=4 WHERE PaymentId='$PaymentId'";
                     $db->query($sql);
                } 
                
                
            } elseif($paymentstatus == 3){
                   echo $sql = "UPDATE tbl_reservation SET ResPaymentStatusId=1,ReservationStatusId=1 WHERE ReservationNo='$resno'";
                 $db->query($sql);
            }




            header('Location:editsuccess.php?PaymentId=' . $PaymentId);
        }
    }
    ?>



    <h2>Verify Customer Payment</h2>
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
            </div>
        </div>



        <div class="row mt-4">



            <input type="hidden" name="PaymentId" value="<?= $PaymentId ?>"> 


            <div class="col-md-6">

                <div class="row">

                    <div class="col-md-4">
                        <label for="resno" class="form-label">Reservation No</label>
                    </div>

                    <div class="col-md-5">


                        <input type="text" class="form-control" id="resno" name="resno" value="<?= @$resno ?>" readonly>
                        <div class="text-danger">
                            <?= @$message['error_resno'] ?>  
                        </div>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-4 mb-2">
                        <label for="lastresprice" class="form-label">Last Reservation Price (Rs)</label>
                    </div>

                    <div class="col-md-5 mb-2">

                        <?php
                        $db = dbConn();
                        $sql = "SELECT LastReservationPrice FROM tbl_reservation WHERE ReservationNo='$resno'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();

                        @$lastresprice = $row['LastReservationPrice'];
                        ?>


                        <input type="text" class="form-control" id="lastresprice" name="lastresprice" value="<?= @$lastresprice ?>" readonly>
                        <div class="text-danger">
                            <?= @$message['error_lastresprice'] ?>  
                        </div>

                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4 mb-2">
                        <label for="paymentcategory" class="form-label">Payment Category</label>
                    </div>
                    <div class="col-md-5 mb-2">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM tbl_paymentcategory WHERE PaymentCategoryId='$paymentcategory'";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                             $paymentcategory= $row['PaymentCategoryId'];
                                
                                ?>
                                <input type="text" class="form-control"  value="<?= $row['PaymentCategory'] ?>" readonly>
                                
                                     <input type="hidden" id="paymentcategory" name="paymentcategory" value="<?= $paymentcategory ?>">
                                <?php
                            }
                        }
                        
                        
                        ?>

                        
                        <div class="text-danger">
                            <?= @$message['error_paymentcategory'] ?>  
                        </div>  
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4 mb-2">
                        <label for="paidamount" class="form-label">Paid Amount (Rs)</label>
                    </div>
                    <div class="col-md-5 mb-2">

                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM tbl_paymentcategory";
                        $result = $db->query($sql);

                        $row = $result->fetch_assoc();

                        $paidamount = $lastresprice * $row['PaymentRatio'];
                        ?>

                        <input type="text" class="form-control" id="paidamount" name="paidamount" value="<?= @$paidamount ?>" readonly>
                        <div class="text-danger">
                            <?= @$message['error_paidamount'] ?>  
                        </div>

                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4 mb-2">

                        <label for="balanceamount" class="form-label">Balance Amount (Rs)</label>

                    </div> 

                    <div class="col-md-5 mb-2">
                        <?php
                        $balanceamount = $lastresprice - $paidamount;
                        ?>

                        <input type="text" class="form-control" id="balanceamount" name="balanceamount" value="<?= @$balanceamount ?>" readonly>
                        <div class="text-danger">
                            <?= @$message['error_balanceamount'] ?>  
                        </div>   

                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-4 mb-2">
                        <label for="paymentmethod" class="form-label">Payment Method</label>

                    </div> 

                    <div class="col-md-5 mb-2">

                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM tbl_paymentmethod WHERE PaymentMethodId='$paymentmethod'";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                             $paymentmethod= $row['PaymentMethodId'];
                                
                                ?>
                                <input type="text" class="form-control"  value="<?= $row['PaymentMethod'] ?>" readonly>
                                
                                     <input type="hidden" id="paymentmethod" name="paymentmethod" value="<?= $paymentmethod ?>">
                                <?php
                            }
                        }
                        
                        
                        ?>

                        
                        <div class="text-danger">
                            <?= @$message['error_paymentmethod'] ?>  
                        </div>
                    </div>
                </div>



                <?php
                if (@$paymentmethod == 2) {
                    ?>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="paidbank" class="form-label">Paid Bank</label>  
                        </div>

                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_bank_details WHERE BankId='$paidbank'";
                            $result = $db->query($sql);
                            
                            if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                             $paidbank = $row['BankId'];
                                
                                ?>
                                <input type="text" class="form-control"  value="<?= $row['BankName'] ?>" readonly>
                                
                                     <input type="hidden" id="paidbank" name="paidbank" value="<?= $paidbank ?>">
                                <?php
                            }
                        }
                            
                            
                            ?>

                            
                            <div class="text-danger">
                                <?= @$message['error_paidbank'] ?>  
                            </div>

                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label for="paidbranch" class="form-label">Paid Branch</label>

                        </div>

                        <div class="col-md-5 mb-2">
                            <input type="text" class="form-control" id="paidbranch" name="paidbranch" value="<?= @$paidbranch ?>" readonly>
                            <div class="text-danger">
                                <?= @$message['error_paidbranch'] ?>  
                            </div>  
                        </div>
                    </div>



                    <?php
                }
                ?>


                <?php
                if (@$paymentmethod == 4) {
                    ?>

                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <label for="paidbank" class="form-label">Paid Bank</label>  
                        </div> 

                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_bank_details WHERE BankId='$paidbank'";
                            $result = $db->query($sql);
                            
                            if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                             $paidbank = $row['BankId'];
                                
                                ?>
                                <input type="text" class="form-control"  value="<?= $row['BankName'] ?>" readonly>
                                
                                     <input type="hidden" id="paidbank" name="paidbank" value="<?= $paidbank ?>">
                                <?php
                            }
                        }
                            
                            
                            ?>
                            </select>
                            <div class="text-danger">
                                <?= @$message['error_paidbank'] ?>  
                            </div>

                        </div>






                    </div> 


                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="referenceno" class="form-label">Reference No</label>

                        </div>

                        <div class="col-md-5">
                            <input type="text" class="form-control" id="referenceno" name="referenceno" value="<?= @$referenceno ?>" readonly>
                            <div class="text-danger">
                                <?= @$message['error_referenceno'] ?>  
                            </div>  
                        </div>
                    </div>


                    <?php
                }
                ?> 









                <div class="row mt-2">
                    <div class="col-md-4 mb-2">
                        <label for="paiddate" class="form-label">Paid Date</label>

                    </div>

                    <div class="col-md-5 mb-2">
                        <input type="date" class="form-control" id="paiddate" name="paiddate" value="<?= @$paiddate ?>" readonly>
                        <div class="text-danger">
                            <?= @$message['error_paiddate'] ?>  
                        </div>  
                    </div>
                </div>



                <div class="row mt-2">
                    <div class="col-md-4 mb-2">
<!--                        <label for="image" class="form-label">Payment Slip Image</label>-->

                    </div>
                    <div class="col-md-5 mb-2">
                        <input type="hidden" class="form-control" id="image" name="slipimage" value="<?= @$slipimage ?>" readonly>
                        <div class="text-danger">
                            <?= @$message['error_slipimage'] ?>  
                        </div>

                        <input type="hidden" name="prv_image" value="<?= empty($slipimage) ? "noimage.jpg" : $slipimage ?>">


                    </div>
                </div>



            </div>

            <div class="col-md-6">
                <div class="row">
                    <img class="img-fluid" width="1000px" src="../../web2/assets/img/payment/<?= empty($slipimage) ? "noimage.jpg" : $slipimage ?>">
                </div>

                <div class="alert alert-secondary mt-4">
                    <div class="row mt-2">
                        <div class="col-md-5 mb-2">
                            <label for="paymentstatus" class="form-label">Payment Status <span class="text-danger"><strong>*</strong></span></label>

                        </div> 

                        <div class="col-md-7 mb-2">

                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_paymentstatus WHERE PaymentStatusId!=1 AND PaymentStatusId!=4 AND PaymentStatusId!=5";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="paymentstatus" name="paymentstatus">
                                <option value="">Select Payment Status</option>

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
                            <div class="text-danger">
                                <?= @$message['error_paymentstatus'] ?>  
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Submit</button>

                    </div>
                </div>


            </div>



        </div>

    </form>


</main>


<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>