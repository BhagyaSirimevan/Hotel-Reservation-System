
<?php ob_start(); ?>
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>



<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
    <section>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Make Payment</h1>


            </div>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            extract($_GET);
            //    var_dump($_GET);

            $resno = $_GET['ReservationNo'];
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


            if (empty($paiddate)) {
                $message['error_paiddate'] = "Paid Date should be selected..!";
            }





            if (empty($message)) {
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
            }


            //  echo $lastresprice;
            //     var_dump($message);
            if (empty($message)) {

                $db = dbConn();
                $cdate = date('Y-m-d');
                $userid = $_SESSION['userid'];

                $sql = "INSERT INTO tbl_customerpayments(ReservationNo,LastReservationPrice,PaymentCategoryId,PaidAmount,BalanceAmount,PaymentMethodId,PaidBank,PaidBranch,ReferenceNo,PaidDate,PaymentSlipImage,PaymentStatusId,AddUser,AddDate) "
                        . "VALUES('$resno','$lastresprice','$paymentcategory','$paidamount','$balanceamount','$paymentmethod','$paidbank','$paidbranch','$referenceno','$paiddate','$file_name_new','1','$userid','$cdate')";
                $db->query($sql);

                // print_r($sql);


                $paymentid = $db->insert_id;
                $billno = date('Y') . date('m') . date('d') . $paymentid;

                $sql = "UPDATE tbl_customerpayments SET BillNo='$billno' WHERE PaymentId='$paymentid'";

                $db->query($sql);
                
                $sql = "UPDATE tbl_customerpayments SET PaymentStatusId='4' WHERE ReservationNo='$resno' AND PaymentStatusId='2'";
                
                $db->query($sql);
                
                $sql = "UPDATE tbl_customerpayments SET PaymentStatusId='5' WHERE ReservationNo='$resno' AND PaymentStatusId='3'";
                
                $db->query($sql);
                
                header('Location:paymentaddsuccess.php?billno=' . $billno);
            }
        }
        ?>




        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-2">
                                    <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
                                </div>
                            </div>
            <div class="row mt-2">
                
                <div class="col-md-2"></div>
                <div class="col-md-3">
                    <img src="../assets/customer/assets/img/payment1.png" width="300px" height="250px" alt="alt"/>
                    
                    <!-- Button trigger modal -->
                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    View Bank Details
                    </a>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center text-danger" id="exampleModalLabel">Bank Details</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    
                       
                         <div class="card bg-danger-light text-center">
                         <strong>Sampath Bank</strong>
                          <strong>Pelmadulla Branch</strong> 
                           <strong>Acc No - 102035897</strong>
                           </div>
                         <div class="card bg-success-light text-center">
                         <strong>Bank of Ceylon</strong>
                          <strong>Pelmadulla Branch</strong> 
                           <strong>Acc No - 82580250</strong>
                           </div>
                         
                 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
                  <input type="hidden" name="ReservationNo" value="<?= $ReservationNo ?>">
                   
                </div>

                <div class="col-md-7">

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
                            if (!empty($resno)) {
                                $db = dbConn();
                                $sql = "SELECT LastReservationPrice FROM tbl_reservation WHERE ReservationNo='$resno' ";
                                $result = $db->query($sql);
                                $row = $result->fetch_assoc();

                                @$lastresprice = $row['LastReservationPrice'];
                            }
                            ?>


                            <input type="text" class="form-control" id="lastresprice" name="lastresprice" value="<?= @$lastresprice ?>" readonly>
                            <div class="text-danger">
                                <?= @$message['error_lastresprice'] ?>  
                            </div>

                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label for="paymentcategory" class="form-label">Payment Category <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5 mb-2">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT PaymentCategoryId FROM tbl_customerpayments WHERE ReservationNo='$resno' AND PaymentStatusId=2";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $sql2 = "SELECT * FROM tbl_paymentcategory WHERE PaymentCategoryId=2";
                            } else {
                                $sql2 = "SELECT * FROM tbl_paymentcategory WHERE PaymentCategoryId!=2";
                            }

                            $result2 = $db->query($sql2);
                            ?>

                            <select class="form-select" id="paymentcategory" name="paymentcategory" onchange="form.submit()">
                                <option value="">Select Payment Category</option>

                                <?php
                                if ($result2->num_rows > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['PaymentCategoryId']; ?> <?php if ($row['PaymentCategoryId'] == @$paymentcategory) { ?>selected <?php } ?>><?= $row['PaymentCategory'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>
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
                            if (!empty($paymentcategory) && !empty($lastresprice)) {

                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_paymentcategory WHERE PaymentCategoryId='$paymentcategory'";
                                $result = $db->query($sql);

                                $row = $result->fetch_assoc();

                                $paidamount = $lastresprice * $row['PaymentRatio'];
                            }
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
                            if (!empty($lastresprice) && !empty($paymentcategory)) {

                                $balanceamount = $lastresprice - $paidamount;
                            }
                            ?>

                            <input type="text" class="form-control" id="balanceamount" name="balanceamount" value="<?= @$balanceamount ?>" readonly>
                            <div class="text-danger">
                                <?= @$message['error_balanceamount'] ?>  
                            </div>   

                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label for="paymentmethod" class="form-label">Payment Method <span class="text-danger">*</span></label>

                        </div> 

                        <div class="col-md-5 mb-2">

                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_paymentmethod WHERE PaymentMethodId!=1";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="paymentmethod" name="paymentmethod" onchange="form.submit()">
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
                                <label for="paidbank" class="form-label">Paid Bank <span class="text-danger">*</span></label>  
                            </div>

                            <div class="col-md-5">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_bank_details";
                                $result = $db->query($sql);
                                ?>

                                <select class="form-select" id="paidbank" name="paidbank">
                                    <option value="">Select Bank</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>

                                            <option value=<?= $row['BankId']; ?> <?php if ($row['BankId'] == @$paidbank) { ?>selected <?php } ?>><?= $row['BankName'] ?></option>


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
                            <div class="col-md-4 mb-2">
                                <label for="paidbranch" class="form-label">Paid Branch <span class="text-danger">*</span></label>

                            </div>

                            <div class="col-md-5 mb-2">
                                <input type="text" class="form-control" id="paidbranch" name="paidbranch" value="<?= @$paidbranch ?>">
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
                                <label for="paidbank" class="form-label">Paid Bank <span class="text-danger">*</span></label>  
                            </div> 

                            <div class="col-md-5">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_bank_details";
                                $result = $db->query($sql);
                                ?>

                                <select class="form-select" id="paidbank" name="paidbank">
                                    <option value="">Select Bank</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>

                                            <option value=<?= $row['BankId']; ?> <?php if ($row['BankId'] == @$paidbank) { ?>selected <?php } ?>><?= $row['BankName'] ?></option>


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
                                <label for="referenceno" class="form-label">Reference No <span class="text-danger">*</span></label>

                            </div>

                            <div class="col-md-5">
                                <input type="text" class="form-control" id="referenceno" name="referenceno" value="<?= @$referenceno ?>">
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
                            <label for="paiddate" class="form-label">Paid Date <span class="text-danger">*</span></label>

                        </div>
                        
                        <?php 
                        
//                        $db = dbConn();
//                        $sql = "SELECT ReservationDate FROM tbl_reservation WHERE ReservationNo='$resno'";
//                        $result = $db->query($sql);
//                        
//                        if ($result->num_rows > 0) {
//                           $row = $result->fetch_assoc();
//                         
//                        $date = $row['ReservationDate'];
//                                    
//                           
//                        }
////                        
//                        $minresdate = date('Y-m-d', strtotime(- date($date)));
                        $minresdate = date('Y-m-d', strtotime('-1 years'));
                        $maxresdate = date('Y-m-d');   
                        
                       
                        ?>

                        <div class="col-md-5 mb-2">
                            <input type="date" min="<?= $minresdate ?>" max="<?= $maxresdate ?>" class="form-control" id="paiddate" name="paiddate" value="<?= @$paiddate ?>">
                            <div class="text-danger">
                                <?= @$message['error_paiddate'] ?>  
                            </div>  
                        </div>
                    </div>



                    <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label for="image" class="form-label">Payment Slip Image <span class="text-danger">*</span></label>

                        </div>
                        <div class="col-md-5 mb-2">
                            <input type="file" class="form-control" id="image" name="slipimage" value="<?= @$slipimage ?>">
                            <div class="text-danger">
                                <?= @$message['error_slipimage'] ?>  
                            </div>

                        </div>
                    </div>




                    <div class="row mt-2">
                        <div class="col-md-6"></div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Submit</button>

                        </div>
                    </div>

                </div>



            </div>

        </form>
    </section>

</main>


<?php include '../dashboardfooter.php'; ?>
<?php ob_end_flush(); ?>