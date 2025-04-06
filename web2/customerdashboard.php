
<?php include 'dashboardheader.php'; ?>
<?php include 'dashboardsidebar.php'; ?>




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

            <div class="col-md-4">

                <div class="card bg-success-light">
                    <div class="card-body pt-3 pb-4">

                        <div class="row">
                            <div class="card-title text-center"><h2>Reservation</h2></div>
                          

                            <h1 class="text-center text-dark"><i class="bi bi-calendar"></i> </h1> 
                            <br>
                            <div class="row mt-4">
                              
                                <a href="reservation/reservationmenu.php" class="btn btn-outline-success" style="width: 510px">View</a> 
                                
                            </div>
                        </div>

                    </div>
                </div>

            </div> 

            <div class="col-md-4">

                <div class="card bg-primary-light">
                    <div class="card-body pt-3 pb-4">

                        <div class="row">
                            <div class="card-title text-center"><h2>Payment</h2></div>
                             <h1 class="text-center text-dark"><i class="bi bi-cash-coin"></i> </h1> 
                            <br>
                            <div class="row mt-4">
                            <a href="payment/payment.php" class="btn btn-outline-primary">View</a> 
                            </div>
                        </div>

                    </div>
                </div>

            </div> 

             
            
            <div class="col-md-4">

                <div class="card bg-dark-light">
                    <div class="card-body pt-3 pb-4">

                        <div class="row">
                            <div class="card-title text-center"><h2>Hall Arrangement</h2></div>
                            <h1 class="text-center text-dark"><i class="bi bi-bookmark-check"></i> </h1> 
                            <div class="row mt-4">
                            <a href="hallarrangement/hallarrangement.php" class="btn btn-outline-secondary">View</a> 
                            </div>
                        </div>

                    </div>
                </div>

            </div> 
            
            <div class="col-md-4">

                <div class="card bg-danger-light">
                    <div class="card-body pt-3 pb-4">

                        <div class="row">
                            <div class="card-title text-center"><h2>Refund Payment</h2></div>
                            <h1 class="text-center text-dark"><i class="bi bi-currency-exchange"></i> </h1> 
                            <div class="row mt-4">
                            <a href="refundpayment/refundpayment.php" class="btn btn-outline-danger">View</a> 
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            
            <div class="col-md-4">

                <div class="card bg-warning-light">
                    <div class="card-body pt-3 pb-4">

                        <div class="row">
                            <div class="card-title text-center"><h2>My Profile</h2></div>
                            <h1 class="text-center text-dark"><i class="bi bi-person"></i> </h1> 
                            <div class="row mt-4">
                            <a href="customers/userprofile.php" class="btn btn-outline-warning">View</a> 
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            
            <div class="col-md-4">

                <div class="card bg-info-light">
                    <div class="card-body pt-3 pb-4">

                        <div class="row">
                            <div class="card-title text-center"><h2>Reports</h2></div>
                            <h1 class="text-center text-dark"><i class="bi bi-bar-chart-line"></i> </h1> 
                            <div class="row mt-4">
                            <a href="reports/reportsmenu.php" class="btn btn-outline-info">View</a> 
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            
            

        </div>
    </section>    

</main>




<!-- ======= Footer ======= -->
<?php include 'dashboardfooter.php'; ?>