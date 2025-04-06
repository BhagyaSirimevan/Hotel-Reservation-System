<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Reports</h1>

    </div>


    <h2>Total Profit Report</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        if (!empty($resdatestart) && !empty($resdateend)) {
            $where .= " PaidDate BETWEEN '$resdatestart' AND '$resdateend' AND AddDate BETWEEN '$resdatestart' AND '$resdateend' AND ";
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

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >




        <div class="row mt-3">

            <div class="col-md-3">
                <input type="date" class="form-control" placeholder="Date" name="resdatestart" >
            </div>

            <div class="col-md-3">
                <input type="date" class="form-control" placeholder="Date" name="resdateend" >
            </div>



            <div class="col-md-4">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px"> Search </i> </button>
            </div>



        </div>
            </form>



   



<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {


    $db = dbConn();
    $sql = "SELECT SUM(PaidAmount) FROM tbl_customerpayments WHERE PaymentStatusId=2 AND PaidDate BETWEEN '$resdatestart' AND '$resdateend'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $income = $row['SUM(PaidAmount)'];
    }

    $db = dbConn();
    $sql = "SELECT SUM(rp.RefundableAmount) FROM tbl_refundpayment rp LEFT JOIN tbl_issuerefundpayment ip ON ip.RefundNo=rp.RefundNo WHERE rp.RefundStatusId=4 AND ip.AddDate BETWEEN '$resdatestart' AND '$resdateend' ";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $expenses = $row['SUM(rp.RefundableAmount)'];
    }

    $profit = $income - $expenses;
    ?>

            <div class="row">
                <div class="col-md-6">
                     <div class="table-responsive">
                    <table class="table table-striped table-sm">

                        <tbody>
                           <tr>
                               <td><h4>Total Income</h4></td>
                               <td><h4><?= $income ?></h4></td>
            </tr>

            <tr>
                <td><h4>Total Expenses</h4></td>
                <td><h4><?= $expenses ?></h4></td>
            </tr>

            <tr>
                <td><h4>Total Profit</h4></td>
                <td><h4><?= $profit ?></h4></td>
            </tr> 
                            
                        </tbody>
                    </table>
  </div>

                </div>
               
            </div>

            



    <?php
}
?>




  




</main>


        <?php include '../footer.php'; ?> 