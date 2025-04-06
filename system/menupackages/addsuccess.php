<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center">  New Menu Package Added Successfully! </h1>
       

    </div>
    <div class="row">
        
        <div class="col-md-3"></div>
        <div class="col-md-6">
             <div class="table-responsive">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
             //   extract($_GET);
              //    var_dump($_GET);

                $MenuPackageId = $_GET['MenuPackageId'];

                $sql = "SELECT * FROM tbl_menupackage m LEFT JOIN tbl_packagetype t ON t.PackageTypeId=m.PackageTypeId WHERE MenuPackageId='$MenuPackageId'";
              //  print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                
                    ?> 
            
            <h5 class="text-lg-center">New Menu Package Details</h1>
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
                                <td>Menu Package Type</td>
                                <td><?= $row['PackageTypeName'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Menu Package Name</td>
                                <td><?= $row['MenuPackageName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Plate Price (Rs)</td>
                                <td><?= $row['PlatePrice'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Service Charge (%)</td>
                                <td><?= $row['ServiceCharge'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Plate Last Price (Rs)</td>
                                <td><?= $row['PlateLastPrice'] ?></td>

                            </tr>
                            
                            
                             <tr>
                                <td>Menu Package Status</td>
                                <td><?= $row['MenuPackageStatus'] ?></td>

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
       
        <div class="col-md-4"> <a href="menupackages.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>
    
    
   
    
   
    
    
     </main>

        <?php include '../footer.php'; ?> 

