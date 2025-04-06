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
        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="row mt-4">
            <div class="col-md-2"></div>
                        <div class="col-md-4">
                             <img src="../assets/customer/assets/img/payment1.png" width="420px" height="350px" alt="alt"/>
                        </div>

                        <div class="col-md-4">

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="resno" class="form-label">Reservation No</label>

                                    <?php
                                    $customerid = $_SESSION['customerid'];
                                    $db = dbConn();
                                    $sql = "SELECT ReservationNo FROM `tbl_reservation` WHERE CustomerId='$customerid'";
                                    $result = $db->query($sql);
                                    ?>

                                    <select class="form-select" id="resno" name="resno">
                                        <option value="">Select Reservation No</option>

                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>

                                                <option value=<?= $row['ReservationNo']; ?> <?php if ($row['ReservationNo'] == @$resno) { ?>selected <?php } ?>><?= $row['ReservationNo'] ?></option>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger">
                                        <?= @$message['error_paymentcategory'] ?>  
                                    </div>
                                </div>
                                
                                
                                
                                 <div class="col-md-12 mb-2">
                                    <label for="totalreservation" class="form-label">Total Reservation Price (Rs)</label>
                                    <input type="text" class="form-control" id="totalreservation" name="totalreservation" value="<?= @$totalreservation ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_totalreservation'] ?>  
                                    </div>

                                </div>
                                
                                <div class="col-md-12 mb-2">
                                    <label for="paymentcategory" class="form-label">Payment Category</label>

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
                                    <div class="text-danger">
                                        <?= @$message['error_paymentcategory'] ?>  
                                    </div>
                                </div>

                               

                                <div class="col-md-12 mb-2">
                                    <label for="paidamount" class="form-label">Paid Amount (Rs)</label>
                                    <input type="text" class="form-control" id="paidamount" name="paidamount" value="<?= @$paidamount ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_paidamount'] ?>  
                                    </div>

                                </div>
                                
                                <div class="col-md-12 mb-2">
                                    <label for="balanceamount" class="form-label">Balance Amount (Rs)</label>
                                    <input type="text" class="form-control" id="balanceamount" name="balanceamount" value="<?= @$balanceamount ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_balanceamount'] ?>  
                                    </div>

                                </div>
                                
                                  <div class="col-md-12 mb-2">
                                    <label for="paymentmethod" class="form-label">Payment Method</label>

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
                                    <div class="text-danger">
                                        <?= @$message['error_paymentmethod'] ?>  
                                    </div>
                                </div>

                                 <div class="col-md-12 mb-2">
                                    <label for="paiddate" class="form-label">Paid Date</label>
                                    <input type="date" class="form-control" id="paiddate" name="paiddate" value="<?= @$paiddate ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_paiddate'] ?>  
                                    </div>



                                </div>

                               

                                <div class="col-md-12 mb-2">
                                    <label for="image" class="form-label">Payment Slip Image</label>
                                    <input type="file" class="form-control" id="image" name="slipimage" value="<?= @$slipimage ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_slipimage'] ?>  
                                    </div>



                                </div>
                                
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                     <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Submit</button>

                                </div>
                               
                             

                            </div>

                        </div>
                        
                         <div class="col-md-3">
                           
                        </div>
                     
                    </div>
        
        </form>
    </section>
    
</main>


<?php include '../dashboardfooter.php'; ?>
