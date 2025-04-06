<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>

<main id="main" class="main">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Reports</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>
    <section class="section dashboard bg-white">
    
    <div class="row mt-4">
        
        <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-success-light text-center text-white">

            <div class="card-body text-center">
                <h3 class="card-title text-center"> Reservation Report </h3>

                <div class="row">
                     <div class="col-md-3"></div>  
                    <div class="col-md-6">
                       <h1 class="text-center text-dark"><i class="bi bi-calendar"></i> </h1> 
                    </div>
                    
                    <div class="col-md-2"></div>  
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="reservationreport.php" class="btn btn-outline-dark" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div>
        
        
    
     <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-danger-light text-center text-white">

            <div class="card-body text-center">
                <h3 class="card-title text-center"> Payment Report </h3>

                <div class="row">
                     <div class="col-md-3"></div>  
                    <div class="col-md-6">
                       <h1 class="text-center text-dark"><i class="bi bi-coin"></i> </h1> 
                    </div>
                    
                    <div class="col-md-2"></div>  
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="paymentreport.php" class="btn btn-outline-dark" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div>
    
    
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-primary-light text-center text-white">

            <div class="card-body text-center">
                <h3 class="card-title text-center">Refund Payment Report </h3>

                <div class="row">
                     <div class="col-md-3"></div>  
                    <div class="col-md-6">
                       <h1 class="text-center text-dark"><i class="bi bi-currency-exchange"></i> </h1> 
                    </div>
                    
                    <div class="col-md-2"></div>  
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="refundpaymentreport.php" class="btn btn-outline-dark" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div>
    
    
        
        
    </div>
    
    </section>
    
</main>    
  


<!-- ======= Footer ======= -->
<?php include '../dashboardfooter.php'; ?>
