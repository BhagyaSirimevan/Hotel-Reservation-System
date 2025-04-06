<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Service Management </h1>
        
    </div>

    <?php
    
     if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
    //    var_dump($_GET);
        $db = dbConn();
      $sql = "SELECT * FROM tbl_service WHERE ServiceId='$ServiceId'";
    //  print_r($sql);
        $result = $db->query($sql);
        
         
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               
                $servicename = $row['ServiceName'];
                $ServiceStatus = $row['ServiceStatus'];
                $ServiceId = $row['ServiceId'];
                $ServiceType = $row['ServiceType'];
                
                if($ServiceType == 'Payable'){
                $serviceprice = $row['ServicePrice'];
                $profitratio = $row['ProfitRatio'];
                $servicelastprice = $row['ServiceLastPrice'];  
                    
                }
                 
            }
        }
        
        $sql = "SELECT * FROM tbl_eventservice WHERE ServiceId='$ServiceId'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $size = array();
            while ($row = $result->fetch_assoc()) {
                $event[] = $row['EventId'];
            }
        }
        
        
       
    }
//     
    // ignore spaces (trim)     
    //  $Pname=trim($Pname);  
    // remove backslash \
    //  $Pname=stripcslashes($Pname);   
    // 
    //  $Pname= htmlspecialchars($Pname); 
    //  echo $Pname; 
    //  echo $pQty;
    //  echo $Pprice;
    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST") {


        // 2nd step- extact the form field 
        // convert array keys to the seperate variable with the value(extract)
        extract($_POST);

        //  var_dump($_POST);
        // 3rd step- clean input
        
        $servicename = cleanInput($servicename);
     //   $serviceprice = cleanInput($serviceprice);
      //  $profitratio = cleanInput($profitratio);
      //  $servicelastprice = cleanInput($servicelastprice);

        // Required Validation
        $message = array();


        if (empty($servicename)) {
            $message['error_servicename'] = "Service Name should not be blank..!";
        }


        if (empty($ServiceType)) {
            $message['error_servicetype'] = "Should be select Service Type..!";
        } 
        
        if(isset($ServiceType) && $ServiceType == 'Payable') {
        
        if (empty($serviceprice)) {
            $message['error_serviceprice'] = "Service Price should not be blank..!";
        } elseif (!is_numeric($serviceprice)) {
            $message['error_serviceprice'] = "Service Price is Invalid..!";
        } elseif ($serviceprice < 0) {
            $message['error_serviceprice'] = "Service Price cannot be Negative..!";
        }
        
        if (empty($profitratio)) {
            $message['error_profitratio'] = "Profit Ratio should not be blank..!";
        } elseif (!is_numeric($profitratio)) {
            $message['error_profitratio'] = "Profit Ratio is Invalid..!";
        } elseif ($profitratio < 0) {
            $message['error_profitratio'] = "Profit Ratio cannot be Negative..!";
        }
        
        
        if (empty($servicelastprice)) {
            $message['error_servicelastprice'] = "Service Last Price should not be blank..!";
        } elseif (!is_numeric($servicelastprice)) {
            $message['error_servicelastprice'] = "Service Last Price is Invalid..!";
        } elseif ($servicelastprice < 0) {
            $message['error_servicelastprice'] = "Service Last Price cannot be Negative..!";
        }
        
         }



        if (empty($ServiceStatus)) {
            $message['error_status'] = "Should be select Status..!";
        }


        //  var_dump($message);

        if (empty($message)) {
            
            $db = dbConn();
            
           // get existiog values in database
           // $sql = "SELECT * FROM tbl_menuitem WHERE MenuItemId='$MenuItemId'";
              $sql = "SELECT ServiceName as servicename,ServicePrice as serviceprice,ProfitRatio as profitratio,ServiceLastPrice as servicelastprice,ServiceStatus as ServiceStatus FROM tbl_service WHERE ServiceId='$ServiceId'";
              //  print_r($sql);
            
          //   print_r($sql);
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            
             // get updated field values
            // ex : array(5) { [0]=> string(8) "fullname" [1]=> string(7) "colname" [2]=> string(11) "designation" [3]=> string(8) "district" [4]=> string(12) "Edescription" }

            $updatedfieldnames = updatedFields($row,$_POST) ;
            
             // convert updated field values to string 
            // ex: fullname,colname,designation,district,Edescription
            $updatedfieldname_string = implode(",", $updatedfieldnames) ;

            $userid = $_SESSION['userid'];

            $cdate = date('Y-m-d');
            
            if($ServiceType == 'Payable'){
             $sql = "UPDATE tbl_service SET ServiceName='$servicename',ServiceType='$ServiceType',ServicePrice='$serviceprice',ProfitRatio='$profitratio',ServiceLastPrice='$servicelastprice',ServiceStatus='$ServiceStatus',UpdateDate='$cdate',UpdateUser='$userid' WHERE ServiceId='$ServiceId' ";
                        
            } else{
              $sql = "UPDATE tbl_service SET ServiceName='$servicename',ServiceType='$ServiceType',ServiceStatus='$ServiceStatus',UpdateDate='$cdate',UpdateUser='$userid' WHERE ServiceId='$ServiceId' ";
                   
            }
            
           
              //  print_r($sql);

            $db->query($sql);
            
            $sql = "DELETE FROM tbl_eventservice WHERE ServiceId='$ServiceId'";
            $db->query($sql);

            foreach ($event as $value) {
                $sql = "INSERT INTO tbl_eventservice(ServiceId,EventId) VALUES('$ServiceId','$value')";
                $db->query($sql);
            }
            
            
            header('Location:editsuccess.php?ServiceId='.$ServiceId.'&UpdatedFieldsString='. urlencode($updatedfieldname_string));

           
            
            
         
        }
    }
    ?>


    <h2>Update Service</h2>
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


        <div class="row">

         
            <div class="col-md-6">

                <div class="row">


                    <div class="col-md-12 mb-2">
                        <label for="service" class="form-label">Service Name</label>
                        <input type="text" class="form-control" id="service" name="servicename" value="<?= @$servicename ?>">
                        <div class="text-danger">
                            <?= @$message['error_servicename'] ?>  
                        </div>



                    </div>
                    
                    <div class="col-md-12 mt-3">

                            <label>Select Service Type</label>  
                            <br>


                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="ServiceType" id="payable" value="Payable"<?php if (isset($ServiceType) && $ServiceType == 'Payable') { ?> checked <?php } ?> onchange="form.submit()">
                                <label class="form-check-label" for="payable">Payable</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="ServiceType" id="free" value="Free"<?php if (isset($ServiceType) && $ServiceType == 'Free') { ?> checked <?php } ?> onchange="form.submit()">
                                <label class="form-check-label" for="free">Free</label>
                                          </div>




                            <div class="text-danger">
                                <?= @$message['error_servicetype'] ?>  
                            </div>

                        </div>
                    
                   <?php
                        if(isset($ServiceType) && $ServiceType == 'Payable') {
                            ?> 
                            <div class = "col-md-12 mb-2">
                            <label for = "sprice" class = "form-label">Service Price (Rs)</label>
                            <input type = "text" class = "form-control" id = "sprice" name = "serviceprice" value = "<?= @$serviceprice ?>">
                            <div class = "text-danger">
                          
                                <?= @$message['error_serviceprice']
                            ?>  
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="profit" class="form-label">Profit Ratio (%)</label>
                        <input type="text" class="form-control" id="profit" name="profitratio" value="<?= @$profitratio ?>" onchange="form.submit()">
                        <div class="text-danger">
                            <?= @$message['error_profitratio'] ?>  
                        </div>

                    </div> 

                    <div class="col-md-12 mb-2">
                        <label for="slastprice" class="form-label">Service Last Price (Rs)</label>

                        <?php
                        if (!empty(@$serviceprice && @$profitratio)) {
                            @$servicelastprice = @$serviceprice + (@$serviceprice * @$profitratio / 100);
                        }
                        ?>

                        <input type="text" class="form-control" id="slastprice" name="servicelastprice" value="<?= @$servicelastprice ?>" readonly>
                        <div class="text-danger">
                            <?= @$message['error_servicelastprice'] ?>  
                        </div>

                    </div>
                        <?php
                    }


                    ?> 

                    
                   
                   


                    <div class="col-md-12 mb-2">

                        <label>Select Service Status</label>  
                        <br>


                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" name="ServiceStatus" id="available" value="Available" <?php if (isset($ServiceStatus) && $ServiceStatus == 'Available') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="available">Available</label>
                        </div>
                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="radio" name="ServiceStatus" id="notavailable" value="Not Available" <?php if (isset($ServiceStatus) && $ServiceStatus == 'Not Available') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="notavailable">Not Available</label>
                                      </div>




                        <div class="text-danger">
                            <?= @$message['error_status'] ?>  
                        </div>

                    </div>
                    
                    <div class="col-md-12">
                        <div class="row">
          

            <div class="col-md-5">
                
                    <input type="hidden" name="ServiceId" value="<?= $ServiceId ?>"> 
                
                <a href="add.php" class="btn btn-secondary">Cancel </a>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
                    </div>




                </div>

            </div>
       <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-secondary text-white text-center">Event List</div>
                <div class="table-responsive">
<?php
//                                   if(!empty(@$itemcategory)){
//    $sql = "SELECT * FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE m.MenuItemCategoryId='$itemcategory'";
//   print_r($sql);
//                                    } else  {
//    echo 'table';
//  print_r($_SESSION['selecteditems']);
$sql = "SELECT * FROM tbl_event";
//  } 
$db = dbConn();
$result = $db->query($sql);
?>

                    <table class="table table-sm">
                        <thead class="bg-transparent">
                            <tr>
                                <th scope="col"></th>
                              
                                <th scope="col">Event Name</th>
                                <th scope="col">Select </th>

                            </tr>
                        </thead>
                        <tbody>

<?php
if ($result->num_rows > 0) {
    //  $totalmenuprice = 0;
    while ($row = $result->fetch_assoc()) {
        // floatval(@$plateprice) += floatval($row['PortionPrice']);
        ?>

                                    <tr>
                                        <td></td>
                                        <td><?= $row['EventName'] ?></td>
                                      
                                        <td> <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="<?= $row['EventId'] ?>" name="event[]" value="<?= $row['EventId'] ?>" <?php if (isset($event) && in_array($row['EventId'], $event)) { ?> checked <?php } ?> >
                                                <label class="form-check-label" for="event"></label>
                                            </div>

                                        </td> 


                                    </tr>

        <?php
        // $db = dbConn();
        // if(!empty(@$item)){
        //   $sql2= "SELECT SUM(m.PortionPrice) FROM `tbl_mpitemlist` l INNER JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId WHERE MenuPackageId='" . @$MenuPackageId . "'";
        //   @$plateprice = $db->query($sql2);
    }
}

//}
?>


                        </tbody>
                    </table>
                </div>
</div>

            </div>
        </div>


        


    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 