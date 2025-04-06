<?php ob_start(); ?>
<?php
include '../dashboardheader.php';
include '../dashboardsidebar.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    
     $event = $_SESSION['reservation']['eventdetails']['event'];
   
// use for previous button
if (!empty($_SESSION['selected_services'])) {
    // $service[0]="service1";
    // $service[1]="service2";
    // $value = "service1"
    $service = array();
    foreach ($_SESSION['selected_services'] as $value) {
        $service[] = $value['serviceid'];
    }
}
// use for previous button
if (!empty($_SESSION['reservation']['servicedetails'])) {
    $totalserviceprice = $_SESSION['reservation']['servicedetails'];
}

}

extract($_POST);
// var_dump($_POST);
if (!empty($service)) {
    foreach (@$service as $value) {
        $db = dbConn();
        $sql = "SELECT s.ServiceId,s.ServiceName,s.ServiceLastPrice FROM tbl_service s WHERE ServiceId='$value'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $_SESSION['selected_services'][$row['ServiceId']] = array('serviceid' => $row['ServiceId'], 'servicename' => $row['ServiceName'], 'serviceprice' => $row['ServiceLastPrice']);
    }
    // print_r($_SESSION['selected_services']);
}

if (!empty($service) && !empty($_SESSION['selected_services'])) {
    foreach ($_SESSION['selected_services'] as $value) {
        $ServiceId = $value['serviceid'];
        if (!in_array($ServiceId, $service)) {
            unset($_SESSION['selected_services'][$ServiceId]);
        }
    }
} elseif (empty($service)) {
    unset($_SESSION['selected_services']);
     @$totalserviceprice = 0;
}


if (!empty(@$service)) {
    @$totalserviceprice = 0;
    foreach (@$service as $value) {
        $sql = "SELECT ServiceLastPrice FROM tbl_service WHERE ServiceId='$value'";
        //   print_r($sql);
        $db = dbConn();
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        @$totalserviceprice = @$totalserviceprice + $row['ServiceLastPrice'];
    }
    //  print_r(@$plateprice); 
}



// Get Reservation Number 
// 2nd step- extact the form field 
// convert array keys to the seperate variable with the value(extract)
//  var_dump($_POST);
//  var_dump($_SESSION['reservation']);
// 1st step- check the request method  
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "servicesave") {


    // 3rd step- clean input
    //   $totalserviceprice = cleanInput($totalserviceprice);
    // Required Validation
    $message = array();

    //            if (empty($totalserviceprice)) {
    //                $message['error_totalserviceprice'] = "Total Service Price should not be blank..!";
    //            }
    //  var_dump($message);
    //  var_dump($message);




    if (empty($message)) {

        $totalserviceprice = str_replace(',','',$totalserviceprice);
        
        $_SESSION['reservation']['servicedetails'] = $totalserviceprice;
      
       
    
        header('Location:additemdetails.php');
        // print_r($sql); 
    }
}
?>  

<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
   <?php 
   
//   echo "service array";
//   print_r(@$service);
//    
//   echo '<br>';
//   echo "session";
//print_r(@$_SESSION['selected_services']);
//echo '<br>';
// echo "totalserviceprice";
//        print_r($totalserviceprice);
//        echo '<br>';
//        echo "session";
//        print_r(@$_SESSION['reservation']['servicedetails']);


   
   ?> 
    

    
    <section>
      
        <div class="row">
            
            <div class="col-md-2"></div>
            <div class="col-md-10 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Make New Reservation</h1>
                  <?php 
        //  var_dump($_SESSION['reservation']['servicedetails']);
        //  var_dump($_SESSION['selected_services']);
        ?>
            </div>
        </div>
        <br>






        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <div class="row">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#eventdetails">Event Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#menupackagedetails">Menu Package Details</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#servicedetails">Service Details</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#additemdetails">Additional Item Details</a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php
//  var_dump($_SESSION);
                        ?>
                        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 
                            <div class="row mt-3">
                                <!--                                <div class="col-md-3">
                                                                     <img src="../customers/assets/img/cake.jpg" width="260px" height="350px" alt="alt"/>
                                                                </div>-->
                                <div class="col-md-8">

                                    <div class="row mt-3 mb-2">
                                        <div class="table-responsive">
                                            <?php
                                            $event = $_SESSION['reservation']['eventdetails']['event'];
                                            
                                            
                                            $sql = "SELECT * FROM tbl_eventservice e LEFT JOIN tbl_service s ON s.ServiceId=e.ServiceId WHERE EventId='$event' AND ServiceType='Payable'";
                                            $db = dbConn();
                                            $result = $db->query($sql);
                                            ?>

                                            <table class="table table-sm">
                                                <thead class="bg-transparent">
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col">Service Name</th>
                                                        <th scope="col">Service Price (Rs) </th>
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
                                                                <td><?= $row['ServiceName'] ?></td>
                                                                <td><?= number_format($row['ServiceLastPrice'],2,'.') ?></td> 
                                                                <td> <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" onchange="form.submit()" id="<?= $row['ServiceId'] ?>" name="service[]" value="<?= $row['ServiceId'] ?>" <?php if (isset($service) && in_array($row['ServiceId'], $service)) { ?> checked <?php } ?> >
                                                                        <label class="form-check-label" for="service"></label>
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
                                        <div class="col-md-12 mb-2 mt-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="totalserviceprice" class="form-label">Total Service Price (Rs)</label>



                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="totalserviceprice" name="totalserviceprice" onchange="form.submit()" value="<?= number_format(@$totalserviceprice,2,'.') ?>" readonly>
                                                    <div class="text-danger">
                                                        <?= @$message['error_totalserviceprice'] ?>  
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>  



                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <a href="menupackagedetails.php" class="btn btn-secondary" style="width: 150px" name="action" value="previous">Previous</a>

                                </div>

                                <div class="col-md-2">

                                    <button type="submit" class="btn btn-primary" style="width: 150px" name="action" value="servicesave">Next</button>

                                </div>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>


    </section>
</main>



<?php
include '../dashboardfooter.php';
?>

<?php ob_end_flush(); ?>

