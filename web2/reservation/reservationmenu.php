
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>




<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="customerdashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>


            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                 <a href="../checkavailability/checkavailability.php" class="btn btn-success"><i class="bi bi-plus">New Reservation</i></a> 
        
            </div>
        </div>
       
        
        <div class="row mt-4">

            <div class="col-md-3">

                <div class="card bg-warning-light">
                    <div class="card-body pt-3">

                        <div class="row">
                            <h1 class="card-title text-center">Your Pending <br>Reservations</h1>
                            <?php
                            $customerid = $_SESSION['customerid'];

                            $db = dbConn();
                            $sql = "SELECT COUNT(ReservationId) FROM `tbl_reservation` WHERE ReservationStatusId=1 AND CustomerId='$customerid'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                            }
                            ?>

                            <h1 class="text-center"><?= $row['COUNT(ReservationId)'] ?></h1>
                            <a href="pendingreservations.php" class="btn btn-outline-warning">View</a> 

                        </div>

                    </div>
                </div>

            </div> 

            <div class="col-md-3">

                <div class="card bg-success-light">
                    <div class="card-body pt-3">

                        <div class="row">
                            <h1 class="card-title text-center">Your Confirmed Reservations</h1>
                            <?php
                            $customerid = $_SESSION['customerid'];

                            $db = dbConn();
                            $sql = "SELECT COUNT(ReservationId) FROM `tbl_reservation` WHERE ReservationStatusId=2 AND CustomerId='$customerid'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                            }
                            ?>
                            <h1 class="text-center"><?= $row['COUNT(ReservationId)'] ?></h1>
                            <a href="confirmedreservations.php" class="btn btn-outline-success">View</a> 

                        </div>

                    </div>
                </div>

            </div> 

            <div class="col-md-3">

                <div class="card bg-primary-light">
                    <div class="card-body pt-3">

                        <div class="row">
                            <h1 class="card-title text-center">Your Completed Reservations</h1>
                             <?php
                            $customerid = $_SESSION['customerid'];

                            $db = dbConn();
                            $sql = "SELECT COUNT(ReservationId) FROM `tbl_reservation` WHERE ReservationStatusId=4 AND CustomerId='$customerid'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                            }
                            ?>
                            <h1 class="text-center"><?= $row['COUNT(ReservationId)'] ?></h1>
                            <a href="completedreservations.php" class="btn btn-outline-primary">View</a> 

                        </div>

                    </div>
                </div>

            </div> 
            <div class="col-md-3">

                <div class="card bg-danger-light">
                    <div class="card-body pt-3">

                        <div class="row">
                            <h1 class="card-title text-center">Your Cancelled Reservations</h1>
                             <?php
                            $customerid = $_SESSION['customerid'];

                            $db = dbConn();
                            $sql = "SELECT COUNT(ReservationId) FROM `tbl_reservation` WHERE ReservationStatusId=3 AND CustomerId='$customerid'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                            }
                            ?>
                            <h1 class="text-center"><?= $row['COUNT(ReservationId)'] ?></h1>
                            <a href="cancelledreservations.php" class="btn btn-outline-danger">View</a> 


                        </div>

                    </div>
                </div>

            </div>

        </div> 
        
        
        
    
        
        
        
       
        
    </section>    

</main>




<!-- ======= Footer ======= -->
<?php include '../dashboardfooter.php'; ?>