<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center"> Service Updated Successfully! </h1>

    </div>
    
     <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
      //  var_dump($_GET);

        // ex : 8
        $ServiceId = $_GET['ServiceId'];

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
          $sql = "SELECT ServiceName as servicename,ServicePrice as serviceprice,ProfitRatio as profitratio,ServiceLastPrice as servicelastprice,ServiceStatus as ServiceStatus FROM tbl_service WHERE ServiceId='$ServiceId'";
                
      //  print_r($sql);
        $result = $db->query($sql);

        $row = $result->fetch_assoc();
        ?>

    <div class="row">
        
        

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <h5 class="text-lg-center">Updated Service Details</h1>
                        <table class="table table-striped table-sm">
                            <thead class="bg-secondary text-lg" >
                                <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Updated Value</th>

                                </tr>
                            </thead>

                            <tbody>
                                
                                
                                
                                 <tr>
                                    <td>Service Name</td>
                                    <td class="<?= in_array('servicename', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['servicename'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Service Price (Rs)</td>
                                    <td class="<?= in_array('serviceprice', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['serviceprice'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Profit Ratio (%)</td>
                                    <td class="<?= in_array('profitratio', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['profitratio'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Service Last Price (Rs)</td>
                                    <td class="<?= in_array('servicelastprice', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['servicelastprice'] ?></td>

                                </tr>
                                
                                
                               
                                
                                 <tr>
                                    <td>Status</td>
                                    <td class="<?= in_array('ServiceStatus', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['ServiceStatus'] ?></td>

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
       
        <div class="col-md-4"> <a href="services.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>


</main>



<?php include '../footer.php'; ?> 


  