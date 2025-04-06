<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center"> Hall Updated Successfully! </h1>

    </div>
    
     <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
      //  var_dump($_GET);

        // ex : 8
        $HallId = $_GET['HallId'];

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
         $sql = "SELECT HallName as hallname,MinGuestCount as minguest,MaxGuestCount as maxguest,HallImage as file_name_new,AvailableFeatures as avafeatures,HallStatus as HallStatus FROM tbl_hall WHERE HallId='$HallId'";
             
                
      //  print_r($sql);
        $result = $db->query($sql);

        $row = $result->fetch_assoc();
        ?>

    <div class="row">
        
        

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <h5 class="text-lg-center">Updated Hall Details</h1>
                        <table class="table table-striped table-sm">
                            <thead class="bg-secondary text-lg" >
                                <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Updated Value</th>

                                </tr>
                            </thead>

                            <tbody>
                                
                                
                                
                                 <tr>
                                    <td>Hall Name</td>
                                    <td class="<?= in_array('hallname', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['hallname'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Minimum Guest Count</td>
                                    <td class="<?= in_array('minguest', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['minguest'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Maximum Guest Count</td>
                                    <td class="<?= in_array('maxguest', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['maxguest'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Hall Image</td>
                                    <td class="<?= in_array('file_name_new', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['file_name_new'] ?></td>

                                </tr>
                                
                                 <tr>
                                    <td>Available Features</td>
                                    <td class="<?= in_array('avafeatures', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['avafeatures'] ?></td>

                                </tr>
                                
                                
                               
                                
                                 <tr>
                                    <td>Hall Status</td>
                                    <td class="<?= in_array('HallStatus', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['HallStatus'] ?></td>

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
       
        <div class="col-md-4"> <a href="halls.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>


</main>



<?php include '../footer.php'; ?> 


  