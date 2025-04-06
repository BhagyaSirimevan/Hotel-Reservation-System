<?php ob_start(); ?>
<?php
include '../dashboardheader.php';
include '../dashboardsidebar.php';

?>

<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
    <section>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Make New Reservation</h1>

            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <?php
        
        if ($_SERVER['REQUEST_METHOD'] == "GET") {


            // use for previous button
            if (!empty($_SESSION['selected_items'])) {

                $item = array();
                $qty = array();
                $totalportionprice = array();

                foreach ($_SESSION['selected_items'] as $value) {
                    //   $_SESSION['selected_items'][1] = array('menuitemid' => 1, 'category' => 1, 'menuitemname' => Mixed Salad, 'portionprice' => 50.00, 'qty' => 10, 'totalportionprice' => 500.00);
                    //   $_SESSION['selected_items'][2] = array('menuitemid' => 2, 'category' => 1, 'menuitemname' => Pineapple Salad, 'portionprice' => 50.00, 'qty' => 10, 'totalportionprice' => 500.00);
                    // $value =  array ('menuitemid' => 1, 'category' => 1, 'menuitemname' => Mixed Salad, 'portionprice' => 50.00, 'qty' => 10, 'totalportionprice' => 500.00);       
                    $itemid = $value['menuitemid'];
                    $item[] = $itemid;
                    $qty[$itemid] = $value['qty'];
                    $totalportionprice[$itemid] = $value['totalportionprice'];
                }
            }
            // use for previous button
            if (!empty($_SESSION['reservation']['additemdetails'])) {
                
                @$totaladditional = $_SESSION['reservation']['additemdetails'];
              //  var_dump($_SESSION['reservation']['additemdetails']);
            }
        }

        //  var_dump($_SESSION['reservation']);
//  $where = null;
        extract($_POST);

        if (!empty($item)) {

            $_SESSION['reservation']['additemdetails'] = 0;

            foreach (@$item as $value) {
                $db = dbConn();
                $sql = "SELECT m.MenuItemId,m.MenuItemCategoryId,m.MenuItemName,m.PortionPrice FROM tbl_menuitem m WHERE MenuItemId='$value'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();

                $portionqty = @$qty[$value];
                @$totalportionprice[$value] = $row['PortionPrice'] * intval($portionqty);
                $_SESSION['selected_items'][$row['MenuItemId']] = array('menuitemid' => $row['MenuItemId'], 'category' => $row['MenuItemCategoryId'], 'menuitemname' => $row['MenuItemName'], 'portionprice' => $row['PortionPrice'], 'qty' => $portionqty, 'totalportionprice' => @$totalportionprice[$value]);

                $_SESSION['reservation']['additemdetails'] = $_SESSION['reservation']['additemdetails'] + @$totalportionprice[$value];
            }
        }

        if (!empty($item) && !empty($_SESSION['selected_items'])) {
            foreach ($_SESSION['selected_items'] as $value) {
                $ItemId = $value['menuitemid'];
                if (!in_array($ItemId, $item)) {
                    unset($_SESSION['selected_items'][$ItemId]);
                }
            }
        } elseif (empty($item)) {
            unset($_SESSION['selected_items']);
            @$totaladditional = 0;
        }




        //   print_r(@$_SESSION['selected_items']);
        //    print_r(@$_SESSION['reservation']['additemdetails']);
        //   echo '<br>';
        //  var_dump($_POST);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
         //   var_dump($_POST);
            if (!empty(@$item)) {
                @$totaladditional = 0;
                foreach (@$item as $value) {
                    $sql = "SELECT PortionPrice FROM tbl_menuitem WHERE MenuItemId='$value'";
                    // print_r($sql);
                    $db = dbConn();
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();

                    if (in_array($value, $item)) {
                        $portionqty = @$qty[$value];
                        @$totalportionprice[$value] = ($row['PortionPrice'] * 125 / 100) * intval($portionqty);
                        @$totaladditional = @$totaladditional + @$totalportionprice[$value];
                    }
                }

                //  print_r(@$plateprice); 
            }
        }






        // Get Reservation Number 
        // 2nd step- extact the form field 
        // convert array keys to the seperate variable with the value(extract)
        //  var_dump($_POST);
        //  var_dump($_SESSION['reservation']);
        // 1st step- check the request method  
       // $where = null;
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
           //   var_dump($_POST);
            // 3rd step- clean input
            //  $totaladditional = cleanInput($totaladditional);
            // Required Validation
            $message = array();
            
            $guest = $_SESSION['reservation']['eventdetails']['guest'];
         //   print_r($guest);
          
            // var_dump($message);

         if(!empty($item)){
             foreach ($item as $value){
                 $item_id = $value;
                 
                if(empty($qty[$item_id])){
                      $message['error_qty'.$item_id] = "Portion Qty should not be null..!";
                      
                      }
                     
                  else {
                 if($qty[$item_id] < 0){
                      $message['error_qty'.$item_id] = "Portion Qty should not be negative..!";
                      
                 } elseif($qty[$item_id] > $guest){
                     $message['error_qty'.$item_id] = "Maximum Portion Qty is $guest..!";
                 }
             }
                 
                 
             }
         }
            


            if (empty($message)) {

                $event = $_SESSION['reservation']['eventdetails']['event'];
                $resdate = $_SESSION['reservation']['eventdetails']['resdate'];
//                $stime = $_SESSION['reservation']['eventdetails']['stime'];
//                $endtime = $_SESSION['reservation']['eventdetails']['endtime'];
                //     $duration = $_SESSION['reservation']['eventdetails']['duration'];
                $eventmodeid = $_SESSION['reservation']['eventdetails']['eventmode'];
                $hall = $_SESSION['reservation']['eventdetails']['hall'];
                $guest = $_SESSION['reservation']['eventdetails']['guest'];
                $starttime = $_SESSION['reservation']['eventdetails']['starttime'];
                $endtime = $_SESSION['reservation']['eventdetails']['endtime'];

                $menupackage = $_SESSION['reservation']['packagedetails']['menupackage'];
                $totalmenuprice = $_SESSION['reservation']['packagedetails']['totalmenuprice'];
             //   $totalmenuprice = number_format($totalmenuprice,'2','.');
             //    $totalmenuprice = str_replace(',','',$totalmenuprice);
             //   var_dump($totalmenuprice);

                $totalserviceprice = $_SESSION['reservation']['servicedetails'];
             //   $totalserviceprice = number_format($totalserviceprice,'2','.');
           //     $totalserviceprice = str_replace(',','',$totalserviceprice);
             //   var_dump($totalserviceprice);
                
                $userid = $_SESSION['userid'];
                $customerid = $_SESSION['customerid'];
                $cdate = date('Y-m-d');
                
          //      $totaladditional = number_format($totaladditional,'2','.');
                $totaladditional = str_replace(',','',$totaladditional);
             //   var_dump($totaladditional);
                $totalreservation = str_replace(',', '', $totalreservation);
                $tax = str_replace(',', '', $tax);
                $discount = str_replace(',', '', $discount);
                $lastresprice = str_replace(',', '', $lastresprice);

                $db = dbConn();
                
                // event mode vidiyta save wenne time slot id eka
             echo   $sql = "INSERT INTO tbl_reservation(CustomerId,EventId,ReservationDate,FunctionStartTime,FunctionEndTime,EventModeId,HallId,GuestCount,MenuPackageId,TotalMenuPackagePrice,TotalServicePrice,TotalMenuItemPrice,TotalReservationPrice,Tax,Discount,LastReservationPrice,ReservationStatusId,ResPaymentStatusId,AddDate,AddUser)"
                        . "VALUES('$customerid','$event','$resdate','$starttime','$endtime','$eventmodeid','$hall','$guest','$menupackage','$totalmenuprice','$totalserviceprice','$totaladditional','$totalreservation','$tax','$discount','$lastresprice','1','1','$cdate','$userid')";
                 // print_r($sql);
                $db->query($sql);

                $newreservationid = $db->insert_id;
              //   var_dump($newreservationid);

                // generate reservation no 
                $resno = date('Y') . date('m') . date('d') . $newreservationid;

                $sql = "UPDATE tbl_reservation SET ReservationNo='$resno' WHERE ReservationId='$newreservationid'";
                $db->query($sql);

                foreach ($_SESSION['selected_services'] as $value) {
                    $serviceid = $value['serviceid'];
                    $sql = "INSERT INTO tbl_resservicelist(ReservationId,ServiceId) VALUES('$newreservationid','$serviceid') ";
                    //   print_r($sql);
                    $db->query($sql);
                }

                if (isset($item)) {
                    foreach (@$item as $value) {
                        $db = dbConn();
                        $sql = "SELECT PortionPrice FROM tbl_menuitem WHERE MenuItemId='$value'";

                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        $portionprice = $row['PortionPrice'];

                        if (in_array($value, $item)) {
                            $portionqty = @$qty[$value];
                            @$totalportionprice[$value] = ($row['PortionPrice'] * 125 / 100) * intval($portionqty);
                            $totalportion = @$totalportionprice[$value];
                        }

                        $sql = "INSERT INTO tbl_resadditemlist(ReservationId,MenuItemId,PortionPrice,Qty,TotalPortionPrice) VALUES('$newreservationid','$value','$portionprice','$portionqty','$totalportion') ";
                        //  print_r($sql);
                        $db->query($sql);
                    }
                }
               
                unset($_SESSION['reservation']);
                unset($_SESSION['selected_services']);
                unset($_SESSION['selected_items']);

                
                header('Location:addsuccess.php?ReservationId=' . $newreservationid);
                // print_r($sql); 
            }







            // print_r($sql); 
        } 
        
//        if (!empty($itemcategory)) {
//                $where .= " m.MenuItemCategoryId = '$itemcategory' AND";
//            }
//
//            if (!empty($where)) {
//                $where = substr($where, 0, -3);
//                $where = "WHERE $where";
//            }
        
        
        ?>
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
                            <a class="nav-link" data-bs-toggle="tab" href="#servicedetails">Service Details</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#additemdetails">Additional Item Details</a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


                            <div class="row mt-3 mb-2">
                                <div class="col-md-11">
                                    <div class="table-responsive">
                                        <?php
                                        
                                        $menupackage = $_SESSION['reservation']['packagedetails']['menupackage'];
                                        
                                      //  $sql = "SELECT * FROM tbl_mpitemlist l LEFT JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE l.MenuPackageId!='$menupackage' ORDER BY c.MenuItemCategoryId";
                                        $sql = "SELECT * FROM tbl_menuitem m "
                                                . "LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId "
                                                . "WHERE MenuItemId NOT IN (SELECT MenuItemId FROM tbl_mpitemlist WHERE MenuPackageId='$menupackage') "
                                                . "ORDER BY c.MenuItemCategoryId";
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        ?>

                                        <table class="table table-sm">
                                            <thead class="bg-transparent">
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col">Item Category</th>
                                                    <th scope="col">Menu Item Name</th>
                                                    <th scope="col">Portion Price (Rs) </th>
                                                    <th scope="col">Select </th>
                                                    <th scope="col">Qty </th>
                                                    <th scope="col">Total Price </th>



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
                                                            <td><?= $row['CategoryName'] ?></td>
                                                            <td><?= $row['MenuItemName'] ?></td>
                                                            <td> 
                                                                <?=
                                                                $portionvalue = $row['PortionPrice'] * 125 / 100;
                                                             //   number_format($portionvalue, 2, '.')
                                                                ?></td> 
                                                            <td> <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" onchange="form.submit()" id="<?= $row['MenuItemId'] ?>" name="item[]" value="<?= $row['MenuItemId'] ?>" <?php if (isset($item) && in_array($row['MenuItemId'], $item)) { ?> checked <?php } ?> >
                                                                    <label class="form-check-label" for="item"></label>
                                                                </div>

                                                            </td>

                                                            <td>
                                                                <?php
                                                                if (isset($item)) {
                                                                    $item_id = $row['MenuItemId'];
                                                                   // print_r($item_id);
                                                                }
                                                                
                                                            
                                                                
                                                                ?>
                                                                
                                                                
                                                                

                                                                <input type="number" class="form-control" id="qty" name="qty[<?= $row['MenuItemId'] ?>]" value="<?= @$qty[$item_id] ?>" onchange="form.submit()">
                                                                <div class="text-danger">
                                                                    <?= @$message['error_qty'.$item_id] ?>  
                                                                </div>
                                                            </td> 
                                                            <td>
                                                             <?=    number_format(@$totalportionprice[$row['MenuItemId']], 2, '.') ?>
                                                               
                                                            </td> 




                                                        </tr>

                                                        <?php
                                                    }
                                                }

//}
                                                ?>


                                            </tbody>
                                        </table>
                                    </div> 
                                </div>




                                <div class="col-md-12 mb-2 mt-3">
                                    <div class="row">


                                        <div class="col-md-4">
                                            <label for="totaladditional" class="form-label">Total Additional Item Price (Rs)</label>



                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="totaladditional" name="totaladditional" value="<?= number_format(@$totaladditional,2,'.') ?>" readonly>
                                            <div class="text-danger">
                                                <?= @$message['error_totaladditional'] ?>  
                                            </div>
                                        </div>




                                        <div class="card mt-4">
                                            <div class="card-body">
                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <label for="totalreservation" class="form-label">Total Reservation Price (Rs)</label>
                                                        <?php
                                                        If (!empty($totaladditional)) {
                                                            $totalmenuprice = $_SESSION['reservation']['packagedetails']['totalmenuprice'];
                                                            $totalserviceprice = $_SESSION['reservation']['servicedetails'];
                                                            @$totalreservation = 0;

                                                            $totalreservation = $totalreservation + ($totalmenuprice + $totalserviceprice + @$totaladditional);
                                                        } else {
                                                            $totalmenuprice = $_SESSION['reservation']['packagedetails']['totalmenuprice'];
                                                            $totalserviceprice = $_SESSION['reservation']['servicedetails'];
                                                            @$totalreservation = 0;

                                                            $totalreservation = $totalreservation + ($totalmenuprice + $totalserviceprice);
                                                        }
                                                        ?>
                                                        <input type="text" class="form-control" id="totalreservation" name="totalreservation" value="<?= number_format($totalreservation,2,'.') ?>" readonly>
                                                        <div>

                                                        </div>

                                                        <div class="text-danger">
                                                            <?= @$message['error_totalreservation'] ?>  
                                                        </div>

                                                    </div> 

                                                    <div class="col-md-3">
                                                        <?php
                                                        $db = dbConn();
                                                        $sql = "SELECT * FROM tbl_tax WHERE TaxStatus='Active'";
                                                        $result = $db->query($sql);
                                                        $row = $result->fetch_assoc();
                                                        ?>
                                                        <label for="tax" class="form-label">Tax <?= $row['TaxPercentage'] . '%' ?></label> 

                                                        <?php
                                                        $tax = $totalreservation * $row['TaxPercentage'] / 100;
                                                        ?>


                                                        <input type="text" class="form-control" id="tax" name="tax" value="<?= number_format($tax,2,'.') ?>" readonly>
                                                        <div class="text-danger">
                                                            <?= @$message['error_tax'] ?>  
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <?php
                                                        $db = dbConn();
                                                        $sql = "SELECT * FROM tbl_discount WHERE DiscountStatus='Active'";
                                                        $result = $db->query($sql);
                                                        $row = $result->fetch_assoc();
                                                        ?>
                                                        <label for="discount" class="form-label">Discount (<?= $row['DiscountReason'] . ' - ' . $row['DiscountRatio'] . '%' ?>)</label> 

                                                        <?php
                                                        $discount = $totalreservation * $row['DiscountRatio'] / 100;
                                                        ?>


                                                        <input type="text" class="form-control" id="discount" name="discount" value="<?= number_format($discount,2,'.') ?>" readonly>
                                                        <div class="text-danger">
                                                            <?= @$message['error_discount'] ?>  
                                                        </div>
                                                    </div>



                                                    <div class="col-md-3">
                                                        <label for="lastresprice" class="form-label">Last Reservation Price (Rs)</label>
                                                        <?php
                                                        @$lastresprice = 0;

                                                        @$lastresprice = ($totalreservation + $tax) - $discount;
                                                        ?>
                                                        <input type="text" class="form-control" id="lastresprice" name="lastresprice" value="<?= number_format(@$lastresprice,2,'.') ?>" readonly>
                                                        <div class="text-danger">
                                                            <?= @$message['error_lastresprice'] ?>  
                                                        </div>
                                                    </div>





                                                </div>
                                            </div>










                                        </div>




                                    </div>



                                </div>

                            </div>    


                            <div class="row">
                                <div class="col-md-10">
                                    <a href="servicedetails.php" class="btn btn-secondary" style="width: 150px" name="action" value="previous">Previous</a>
                                </div>

                                <div class="col-md-2">

                                    <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Save</button>


                                    <!--//                                if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == "reservation") {
                                    //                                    $_SESSION['reservation']['reservationdetails'] = array('Event' => $event, 'ResDate' => $resdate, 'StartTime' => $stime, 'EndTime' => $endtime, 'Duration' => $duration, 'Hall' => $hall, 'Guest' => $guest);
                                    //                                    var_dump($_SESSION['reservation']);
                                    //                                }-->


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

