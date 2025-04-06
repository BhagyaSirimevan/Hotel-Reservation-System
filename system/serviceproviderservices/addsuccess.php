<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center">  Service Provider New Service Added Successfully! </h1>
       

    </div>
    
    
    <div class="row">
        
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
             <div class="table-responsive">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                extract($_GET);
              //    var_dump($_GET);

                $providerserviceid = $_GET['ProviderServiceId'];

               $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist l ON l.ProvideServiceListId=s.ProvideServiceListId LEFT JOIN tbl_service v ON v.ServiceId=l.ServiceId WHERE ProviderServiceId='$providerserviceid'";
              //  print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                
                    ?> 
            
            <h5 class="text-lg-center">Service Provider New Service Details</h1>
                    <table class="table table-striped table-sm">
                        <thead class="bg-secondary text-lg text-white" >
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
                                <td>Reg No</td>
                                <td><?= $row['RegNo'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Business Name</td>
                                <td><?= $row['BusinessName'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Provide Service</td>
                                <td><?= $row['ServiceName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Name</td>
                                <td><?= $row['Name'] ?></td>

                            </tr>
                            
                              <tr>
                                <td>Image</td>
                                <td><?= $row['SampleImage'] ?></td>

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
       
        <div class="col-md-4"> <a href="serviceproviderservices.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>
    
    
    
     </main>

        <?php include '../footer.php'; ?> 



