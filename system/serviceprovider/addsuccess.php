<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center">  New Service Provider Added Successfully! </h1>
       

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

                $newserviceproviderid = $_GET['ServiceProviderId'];

               $sql = "SELECT * FROM tbl_serviceprovider s LEFT JOIN tbl_district d ON d.DistrictId=s.DistrictId WHERE ServiceProviderId='$newserviceproviderid'";
              //  print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                
                    ?> 
            
            <h5 class="text-lg-center">New Service Provider Details</h1>
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
                                <td>Title</td>
                                <td><?= $row['Title'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>First Name</td>
                                <td><?= $row['FirstName'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Last Name</td>
                                <td><?= $row['LastName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>NIC</td>
                                <td><?= $row['NIC'] ?></td>

                            </tr>
                            
                              <tr>
                                <td>Email</td>
                                <td><?= $row['Email'] ?></td>

                            </tr>
                            
                            
                              <tr>
                                <td>Business Name</td>
                                <td><?= $row['BusinessName'] ?></td>

                            </tr> 
                            
                              <tr>
                                <td>Business Registration Number</td>
                                <td><?= $row['BRNumber'] ?></td>

                            </tr> 
                            
                             <tr>
                                <td>District</td>
                                <td><?= $row['DistrictName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>House No</td>
                                <td><?= $row['HouseNo'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Street Name</td>
                                <td><?= $row['StreetName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>City</td>
                                <td><?= $row['City'] ?></td>

                            </tr>
                            
                            
                            
                            
                             <tr>
                                <td>Contact No</td>
                                <td><?= $row['ContactNo'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Alternative Contact No</td>
                                <td><?= $row['ContactNo2'] ?></td>

                            </tr>
                            
                            
                         
                            
                          
                           
                            
                            <tr>
                                <td>Agreement Start Date</td>
                                <td><?= $row['AgreementStartDate'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Agreement End Date</td>
                                <td><?= $row['AgreementEndDate'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Status</td>
                                <td><?= $row['Status'] ?></td>

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
       
        <div class="col-md-4"> <a href="serviceprovider.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>
    
    
    
     </main>

        <?php include '../footer.php'; ?> 



