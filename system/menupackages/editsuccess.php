<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center"> Menu Package Updated Successfully! </h1>

    </div>
    
     <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
      //  var_dump($_GET);

        // ex : 8
        $MenuPackageId = $_GET['MenuPackageId'];

//        echo $MenuItemId;
//       echo "<br>";
//      echo "<br>";

        // fullname,colname,designation,district,Edescription
        $updatedfields = $_GET['UpdatedFieldsString'];

//        echo $updatedfields;
//      echo "<br>";
//      echo "<br>";

        // array(5) { [0]=> string(8) "fullname" [1]=> string(7) "colname" [2]=> string(11) "designation" [3]=> string(8) "district" [4]=> string(12) "Edescription" }
        $updatedfields_array = explode(",", $updatedfields);

        
//        var_dump($updatedfields_array);
//        echo "<br>";
//        echo "<br>";

        $db = dbConn();
       
         $sql = "SELECT t.PackageTypeId as packagetype,t.PackageTypeName as packagetypename,m.MenuPackageName as packagename,m.PlatePrice as plateprice,m.ServiceCharge as servicecharge,m.PlateLastPrice as platelastprice,m.MenuPackageStatus as MenuPackageStatus FROM tbl_menupackage m LEFT JOIN tbl_packagetype t ON t.PackageTypeId=m.PackageTypeId WHERE MenuPackageId='$MenuPackageId'";
        //  print_r($sql);
        $result = $db->query($sql);

        $row = $result->fetch_assoc();
        ?>

    <div class="row">
        
        

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <h5 class="text-lg-center">Updated Menu Package Details</h1>
                        <table class="table table-striped table-sm">
                            <thead class="bg-secondary text-lg" >
                                <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Updated Value</th>

                                </tr>
                            </thead>

                            <tbody>
                                
                                 <tr>
                                    <td>Menu Package Type</td>
                                    <td class="<?= in_array('packagetype', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['packagetypename'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Menu Package Name</td>
                                    <td class="<?= in_array('packagename', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['packagename'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Plate Price (Rs)</td>
                                    <td class="<?= in_array('plateprice', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['plateprice'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Service Charge (%)</td>
                                    <td class="<?= in_array('servicecharge', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['servicecharge'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Plate Last Price (Rs)</td>
                                    <td class="<?= in_array('platelastprice', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['platelastprice'] ?></td>

                                </tr>
                                
                                
                                 <tr>
                                    <td>Status</td>
                                    <td class="<?= in_array('MenuPackageStatus', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['MenuPackageStatus'] ?></td>

                                </tr>


                             
                               

                            </tbody>

                        </table>

                </div>


            </div>
            <div class="col-md-3"></div>

            
        </div>


     <?php
    } 
    ?>


<div class="row">
        <div class="col-md-8"></div>
       
        <div class="col-md-4"> <a href="menupackages.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>


</main>



<?php include '../footer.php'; ?> 


  