<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Reports</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            
        </div>
    </div>
    
    <div class="row mt-4">
        
         <?php 
                        
                        if ($_SESSION['userrole'] == "Owner" || $_SESSION['userrole'] == "Manager" || $_SESSION['userrole'] == "Billingclerk") {
                                  ?>
        <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card text-center text-white bg-success">

            <div class="card-body text-center">
                <h3 class="card-title text-center">Income Report</h3>

                <div class="row">
                     <div class="col-md-3"></div>  
                    <div class="col-md-6">
                        <span data-feather="bar-chart" class="align-text-bottom" style="width: 100;height: 100;"></span>
                      
                    </div>
                    
                    <div class="col-md-2"></div>  
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                       
                        
                        
                        <a href="totalincomereport.php" class="btn btn-outline-light" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card --> 
        <?php
                              }
                        
                        ?>
        
        
        <?php 
         if ($_SESSION['userrole'] == "Owner" || $_SESSION['userrole'] == "Manager" || $_SESSION['userrole'] == "Billingclerk") {
             ?>
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-danger text-center text-white">

            <div class="card-body text-center">
                <h3 class="card-title text-center">Expenses Report</h3>

                <div class="row">
                     <div class="col-md-3"></div>  
                    <div class="col-md-6">
                        <span data-feather="bar-chart-2" class="align-text-bottom" style="width: 100;height: 100;"></span>
                      
                    </div>
                    
                    <div class="col-md-2"></div>  
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="totalexpensesreport.php" class="btn btn-outline-light" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div>
    <?php
         }
        
        ?>
    
     <?php 
     
       if ($_SESSION['userrole'] == "Owner" || $_SESSION['userrole'] == "Manager") {
           ?> 
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-secondary text-center text-white">

            

            <div class="card-body text-center">
                <h3 class="card-title text-center">Profit Report</h3>

                <div class="row">
                     <div class="col-md-3"></div>  
                    <div class="col-md-6">
                        <span data-feather="percent" class="align-text-bottom" style="width: 100;height: 100;"></span>
                      
                    </div>
                    
                    <div class="col-md-2"></div>  
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="totalprofitreport.php" class="btn btn-outline-light" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div>
    <?php
       }
     ?>
    
    
    </div>
    
    <div class="row mt-4">
        
        <?php 
         if ($_SESSION['userrole'] == "Owner" || $_SESSION['userrole'] == "Manager" || $_SESSION['userrole'] == "Billingclerk" || $_SESSION['userrole'] == "Receptionist" || $_SESSION['userrole'] == "Supervisor") {
             ?> 
        <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card text-center text-dark bg-warning">

            

            <div class="card-body text-center">
                <h3 class="card-title text-center"> Reservation Report </h3>

                <div class="row">
                     <div class="col-md-3"></div>  
                    <div class="col-md-6">
                        <span data-feather="calendar" class="align-text-bottom" style="width: 100;height: 100;"></span>
                      
                    </div>
                    
                    <div class="col-md-2"></div>  
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="totalreservationreport.php" class="btn btn-outline-dark" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card --> 
        <?php
         }
        
        ?>
        
        <?php 
         if ($_SESSION['userrole'] == "Owner" || $_SESSION['userrole'] == "Manager" || $_SESSION['userrole'] == "Billingclerk" || $_SESSION['userrole'] == "Receptionist" || $_SESSION['userrole'] == "Supervisor") {
             ?> 
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-primary text-center text-white">

            

            <div class="card-body text-center">
                <h3 class="card-title text-center"> Customer Report </h3>

                <div class="row">
                     <div class="col-md-3"></div>  
                    <div class="col-md-6">
                        <span data-feather="users" class="align-text-bottom" style="width: 100;height: 100;"></span>
                      
                    </div>
                    
                    <div class="col-md-2"></div>  
                </div>
                <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="totalcustomerreport.php" class="btn btn-outline-light" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div>
    <?php
         }
             
        
        ?>
        
    
     
    
    
        
        
    </div>
    
    
    
</main>    
  
<?php include '../footer.php'; ?> 
