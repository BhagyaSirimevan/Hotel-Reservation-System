<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>


<main id="main" class="main">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Refund Payment Report</h1>
        <div class="btn-toolbar mb-2 mb-md-0">

        </div>
    </div>
    <section class="section dashboard">
        <?php
        $where = null;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            extract($_POST);

            if (!empty($minpaiddate) && !empty($maxpaiddate)) {
                $where .= " i.AddDate BETWEEN '$minpaiddate' AND '$maxpaiddate' AND";
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


            $userid = $_SESSION['userid'];

            $sql2 = "SELECT r.RefundableAmount,r.ReservationNo,i.AddDate FROM tbl_refundpayment r LEFT JOIN tbl_issuerefundpayment i ON i.RefundNo=r.RefundNo WHERE r.AddUser='$userid' AND r.RefundStatusId='4' $where ";
            $db = dbConn();
            $result2 = $db->query($sql2);
        }
        ?>  

        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

            <div class="row">



                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-2">
                            <label>From </label>
                        </div>
                        <div class="col-md-10">
                            <input type="date" class="form-control" placeholder="Date" name="minpaiddate" >
                        </div>
                    </div>


                </div>

                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-2">
                            <label>To </label>
                        </div>
                        <div class="col-md-10">
                            <input type="date" class="form-control" placeholder="Date" name="maxpaiddate" >
                        </div>
                    </div>

                </div>


                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px"> Search </i> </button>
                </div>



            </div>
                </form>


        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">

                    <table class="table table-striped table-sm">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Reservation No</th>
                                <th scope="col">Released Date</th>
                                <th scope="col" style="text-align: right">Refunded Amount</th>


                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == "POST") {



                                if ($result2->num_rows > 0) {
                                    $total = 0;
                                    while ($row = $result2->fetch_assoc()) {
                                        ?>

                                        <tr>
                                            <td></td>

                                            <td><?= $row['ReservationNo'] ?></td>
                                            <td><?= $row['AddDate'] ?></td>
                                            <td style="text-align: right"><?= number_format($row['RefundableAmount'], 2) ?></td> 
                                            <?php $total += $row['RefundableAmount'] ?> 

                                        </tr>

                                        <?php
                                    }
                                }
                            }
                            ?>

                            <tr>
                                <td colspan="3"><h3 class="text-dark">Total Amount</h3></td>
                                <td style="text-align: right"><h3 class="text-dark"><?= number_format(@$total, 2) ?></h3></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>



    </section>

</main>


<?php include '../dashboardfooter.php'; ?>
