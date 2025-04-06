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

            <h1 class="text-center">  Your Hall Arrangement Request has been Sent Successfully! </h1>

        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        extract($_GET);
                        //  var_dump($_GET);

                        $RequestId = $_GET['RequestId'];

                        $sql = "SELECT * FROM tbl_hallarrangerequest a LEFT JOIN tbl_event e ON e.EventId=a.EventId "
                                . "LEFT JOIN tbl_themecolor t ON t.ThemeColorId=a.ThemeColorId "
                                . "WHERE a.RequestId='$RequestId'";
                        //  print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        ?> 

                        <h3 class="text-lg-center text-success">Your Arrangement Request Details</h3>
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
                                        <td>Reservation No</td>
                                        <td><?= $row['ReservationNo'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Event Name</td>
                                        <td><?= $row['EventName'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Reservation Date</td>
                                        <td><?= $row['ReservationDate'] ?></td>

                                    </tr>


                                    <tr>
                                        <td>Theme Color</td>
                                        <td><?= $row['ColourName'] ?></td>

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
                <strong class="text-danger text-center">Arrangement request in progress... Please wait until the status changes.</strong>



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
