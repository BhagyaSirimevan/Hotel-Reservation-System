<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

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
        $where = "WHERE $where";
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Customer Payment Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">

                <?php
                if ($_SESSION['userrole'] == "Owner") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="pendingreservations.php"><span data-feather="plus-circle" class="align-text-bottom"></span>Make Payment</a>

                    <?php
                } elseif ($_SESSION['userrole'] == "Billingclerk") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="pendingreservations.php"><span data-feather="plus-circle" class="align-text-bottom"></span>Make Payment</a>

                    <?php
                }
                ?>



            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-xxl-4 col-md-4">
            <div class="card info-card sales-card bg-warning text-center text-white">



                <div class="card-body text-center">
                    <h4 class="card-title text-center">Pending Payments </h4>

                    <div class="row">

                        <div class="ps-3">
                            <?php
                            if (($_SESSION['userrole'] == "Billingclerk")) {
                                  $sql = "SELECT COUNT(PaymentId) FROM tbl_customerpayments WHERE PaymentStatusId=1 AND PaymentMethodId!=1";
                            } elseif ($_SESSION['userrole'] == "Manager") {
                                  $sql = "SELECT COUNT(PaymentId) FROM tbl_customerpayments WHERE PaymentStatusId=1 AND PaymentMethodId=1";
                            } elseif ($_SESSION['userrole'] == "Owner") {
                                  $sql = "SELECT COUNT(PaymentId) FROM tbl_customerpayments WHERE PaymentStatusId=1";
                            }


                            $db = dbConn();
                          
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                            }
                            ?>

                            <h1 class="text-center text-dark"><?= $row['COUNT(PaymentId)'] ?> </h1>

                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <a href="pendingpayment.php" class="btn btn-secondary" style="width: 200px">View</a> 
                        </div>

                    </div>

                </div>

            </div>
        </div><!-- End Sales Card --> 

        <div class="col-xxl-4 col-md-4">
            <div class="card info-card sales-card bg-success text-center text-white">



                <div class="card-body text-center">
                    <h4 class="card-title text-center">Successful Payments </h4>

                    <div class="row">

                        <div class="ps-3">
<?php
$db = dbConn();
$sql = "SELECT COUNT(PaymentId) FROM tbl_customerpayments WHERE PaymentStatusId=2 OR PaymentStatusId=4";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>




                            <h1 class="text-dark text-center"><?= $row['COUNT(PaymentId)'] ?> </h1>


                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <a href="verifiedpayment.php" class="btn btn-secondary" style="width: 200px">View</a> 
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="col-xxl-4 col-md-4">
            <div class="card info-card sales-card bg-danger text-center text-white">



                <div class="card-body text-center">
                    <h4 class="card-title text-center">Canceled Payments </h4>

                    <div class="row">

                        <div class="ps-3">
<?php
$db = dbConn();
$sql = "SELECT COUNT(PaymentId) FROM tbl_customerpayments WHERE PaymentStatusId=3 OR PaymentStatusId=5";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>


                            <h1 class="text-dark text-center"><?= $row['COUNT(PaymentId)'] ?> </h1>


                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <a href="unsuccessfulpayment.php" class="btn btn-secondary" style="width: 200px">View</a> 
                        </div>

                    </div>

                </div>

            </div>
        </div>


    </div>

    <div class="row mt-4">

        <h2 class="text-center">Payment History</h2>


        <div class="row mt-4">

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
$sql = "SELECT * FROM tbl_customerpayments c LEFT JOIN tbl_reservation r ON r.ReservationNo=c.ReservationNo LEFT JOIN tbl_customers t ON t.CustomerId=r.CustomerId LEFT JOIN tbl_paymentcategory p ON p.PaymentCategoryId=c.PaymentCategoryId LEFT JOIN tbl_paymentmethod m ON m.PaymentMethodId=c.PaymentMethodId LEFT JOIN tbl_bank_details b ON b.BankId=c.PaidBank LEFT JOIN tbl_paymentstatus s ON s.PaymentStatusId=c.PaymentStatusId $where";
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









</main>    

<?php include '../footer.php'; ?> 
