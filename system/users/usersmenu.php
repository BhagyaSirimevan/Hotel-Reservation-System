<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- User Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            
        </div>
    </div>
    
    <div class="row mt-4">
        
        <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card text-center text-dark bg-warning">

            <div class="card-body text-center">
                <h3 class="card-title text-center"> Employee Users </h3>

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
                        <a href="employeeusers.php" class="btn btn-outline-dark" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div><!-- End Sales Card --> 
    
     <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-secondary text-center text-white">

            

            <div class="card-body text-center">
                <h3 class="card-title text-center"> Customer Users </h3>

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
                        <a href="customerusers.php" class="btn btn-outline-light" style="width: 200px">View</a> 
                </div>
                
                </div>
                
            </div>

        </div>
    </div>
    
    
        
        
    </div>
    
    
    
</main>    
  
<?php include '../footer.php'; ?> 
