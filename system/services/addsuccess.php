<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center">  New Service Added Successfully! </h1>
       

    </div>
    
    
    <div class="row">
        
        <div class="col-md-3">
<!--             <img class="img-fluid" width="150" src="../assets/images/logo-Icon.jpg">-->
        </div>
        <div class="col-md-6">
             <div class="table-responsive">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                extract($_GET);
              //    var_dump($_GET);

                $newserviceid = $_GET['ServiceId'];

                $sql = "SELECT * FROM tbl_service WHERE ServiceId='$newserviceid'";
              //  print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                
                    ?> 
            
            <h5 class="text-lg-center">New Service Details</h1>
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
                               $row = $result->fetch_assoc() ;
                        ?>  
                           
                            
                            <tr>
                                <td>Service Name</td>
                                <td><?= $row['ServiceName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Service Price (Rs)</td>
                                <td><?= $row['ServicePrice'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Profit Ratio (%)</td>
                                <td><?= $row['ProfitRatio'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Service Last Price (Rs)</td>
                                <td><?= $row['ServiceLastPrice'] ?></td>

                            </tr>
                            
                            
                             <tr>
                                <td>Service Status</td>
                                <td><?= $row['ServiceStatus'] ?></td>

                            </tr>
                            
                            
                             <?php
                            
            } } ?>
                            
                        </tbody>
                    </table>
                </div>

            
        </div>
        <div class="col-md-3"></div>
        
       

            </div>
    
    <div class="row">
        <div class="col-md-8"></div>
       
        <div class="col-md-4"> <a href="services.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>
    
    
    
     </main>

        <?php include '../footer.php'; ?> 

