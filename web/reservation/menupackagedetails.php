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





        <?php
        if(!empty($_SESSION['reservation']['packagedetails'])){
        $menupackage = $_SESSION['reservation']['packagedetails']['menupackage'];
        $totalmenuprice = $_SESSION['reservation']['packagedetails']['totalmenuprice'];  
        }
      
        // Get Reservation Number 
        // 2nd step- extact the form field 
        // convert array keys to the seperate variable with the value(extract)
        extract($_POST);

        $db = dbConn();
        $sql = "SELECT * FROM tbl_menupackage WHERE MenuPackageId='" . @$menupackage . "'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        if ($result->num_rows > 0) {
            $menuprice = $row['PlateLastPrice'];
        }

        $guest = $_SESSION['reservation']['eventdetails']['guest'];

        @$totalmenuprice = $menuprice * $guest;

        //    var_dump($_POST);
        //  var_dump($_POST);
        //  var_dump($_SESSION['reservation']);
        // 1st step- check the request method  
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "menupackagesave") {


            // 3rd step- clean input

            $menupackage = cleanInput($menupackage);
//            $menuprice = cleanInput($menuprice);
//            $totalmenuprice = cleanInput($totalmenuprice);
            // Required Validation
            $message = array();

            if (empty($menupackage)) {
                $message['error_menupackage'] = "Should be select Menu Package..!";
            }

//            if (empty($menuprice)) {
//                $message['error_menuprice'] = "Menu Price should not be blank..!";
//            }
//
//            if (empty($totalmenuprice)) {
//                $message['error_totalmenuprice'] = "Total Menu Price should not be blank..!";
//            }
            //  var_dump($message);
            //  var_dump($message);

            if (empty($message)) {

                $_SESSION['reservation']['packagedetails'] = array('menupackage' => $menupackage, 'menuprice' => $menuprice, 'totalmenuprice' => $totalmenuprice);
                var_dump($_SESSION);
//                $db = dbConn();
//                
//                
//
//                $sql = "UPDATE tbl_reservation SET MenuPackageId='$menupackage',TotalMenuPackagePrice='$totalmenuprice' WHERE ReservationNo='$resno'";
//                print_r($sql);
//
//                $db->query($sql);
                header('Location:servicedetails.php');
                // print_r($sql); 
            }
        }
        ?>    





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
                            <a class="nav-link active" data-bs-toggle="tab" href="#menupackagedetails">Menu Package Details</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#servicedetails">Service Details</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#additemdetails">Additional Item Details</a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 

                            <div class="row">
                                <div class="col-md-4">

                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="menupackage" class="col-form-label">Menu Package Name</label>

                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT * FROM tbl_menupackage";
                                            $result = $db->query($sql);
                                            ?>

                                            <select class="form-select" id="menupackage" name="menupackage" onchange="form.submit()">
                                                <option value="">Select Menu Package</option>

                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>

                                                        <option value=<?= $row['MenuPackageId']; ?> <?php if ($row['MenuPackageId'] == @$menupackage) { ?>selected <?php } ?>><?= $row['MenuPackageName'] ?></option>


                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="text-danger">
                                                <?= @$message['error_menupackage'] ?>  
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2 mt-3">
                                            <label for="menuprice" class="form-label">Menu Package Price (Rs)</label>



                                            <input type="text" class="form-control" id="menuprice" name="menuprice" value="<?= @$menuprice ?>" readonly>
                                            <div class="text-danger">
                                                <?= @$message['error_menuprice'] ?>  
                                            </div>

                                        </div>

                                        <div class="col-md-12 mb-2 mt-3">
                                            <label for="totalmenuprice" class="form-label">Total Menu Package Price (Rs)</label>


                                            <input type="text" class="form-control" id="totalmenuprice" name="totalmenuprice" onchange="form.submit()" value="<?= @$totalmenuprice ?>" readonly>
                                            <div class="text-danger">
                                                <?= @$message['error_totalmenuprice'] ?>  
                                            </div>

                                        </div>

                                    </div>










                                </div>

                                <div class="col-md-1">
                                    <h1></h1>
                                </div>

                                <div class="col-md-6 mt-4">
                                    <div class="card">
                                        <div class="card-header bg-secondary text-white text-center">

                                            <?php
                                            if (!empty($menupackage)) {
                                                $db = dbConn();
                                                $sql = "SELECT MenuPackageName FROM tbl_menupackage WHERE MenuPackageId='$menupackage'";
                                                //  print_r($sql);
                                                $result = $db->query($sql);
                                                $row = $result->fetch_assoc();
                                                echo $row['MenuPackageName'];
                                            }
                                            ?>

                                        </div>
                                        <div class="card-body mt-4">
                                            <div class="table-responsive">
                                               

                                                <table class="table table-sm">
                                                    
                                                    <thead class="bg-transparent">
                                                        
                                                        <?php
                                  
                                              //  $sql = "SELECT * FROM tbl_mpitemlist l LEFT JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE MenuPackageId='" . @$menupackage . "'";

                                                 $sql = "SELECT * FROM tbl_mpitemlist l LEFT JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE MenuPackageId='" . @$menupackage . "' AND c.MenuItemCategoryId=1";
 
                                                $db = dbConn();
                                                $result = $db->query($sql);
                                                ?>
                                                        
                                                        <tr>
                                                            <th scope="col"></th>
                                                            <th>Salad</th>
                                                          



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
                                                                   
                                                                    <td><?= $row['MenuItemName'] ?></td>




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
                                                    
                                                    <thead class="bg-transparent">
                                                        
                                                        <?php
                                  
                                              //  $sql = "SELECT * FROM tbl_mpitemlist l LEFT JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE MenuPackageId='" . @$menupackage . "'";

                                                 $sql = "SELECT * FROM tbl_mpitemlist l LEFT JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE MenuPackageId='" . @$menupackage . "' AND c.MenuItemCategoryId=2";
 
                                                $db = dbConn();
                                                $result = $db->query($sql);
                                                ?>
                                                        
                                                        <tr>
                                                            <th scope="col"></th>
                                                            <th>Main Dishes</th>
                                                          
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
                                                                   
                                                                    <td><?= $row['MenuItemName'] ?></td>




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
                                                    
                                                    <thead class="bg-transparent">
                                                        
                                                        <?php
                                  
                                              //  $sql = "SELECT * FROM tbl_mpitemlist l LEFT JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE MenuPackageId='" . @$menupackage . "'";

                                                 $sql = "SELECT * FROM tbl_mpitemlist l LEFT JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE MenuPackageId='" . @$menupackage . "' AND c.MenuItemCategoryId=6";
 
                                                $db = dbConn();
                                                $result = $db->query($sql);
                                                ?>
                                                        
                                                        <tr>
                                                            <th scope="col"></th>
                                                            <th>Sri Lankan Corner</th>
                                                          
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
                                                                   
                                                                    <td><?= $row['MenuItemName'] ?></td>




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
                                                    <thead class="bg-transparent">
                                                        
                                                        <?php
                                  
                                              //  $sql = "SELECT * FROM tbl_mpitemlist l LEFT JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE MenuPackageId='" . @$menupackage . "'";

                                                 $sql = "SELECT * FROM tbl_mpitemlist l LEFT JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE MenuPackageId='" . @$menupackage . "' AND c.MenuItemCategoryId=4";
 
                                                $db = dbConn();
                                                $result = $db->query($sql);
                                                ?>
                                                        
                                                        <tr>
                                                            <th scope="col"></th>
                                                            <th>Desserts</th>
                                                          
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
                                                                   
                                                                    <td><?= $row['MenuItemName'] ?></td>




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

                            </div>

                            <div class="row mt-4">
                                <div class="col-md-10">
                                    <a href="eventdetails.php" class="btn btn-secondary" style="width: 150px" name="action" value="previous">Previous</a>

                                </div>

                                <div class="col-md-2">

                                    <button type="submit" class="btn btn-primary" style="width: 150px" name="action" value="menupackagesave">Next</button>


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

<?php ob_end_flush(); ?>

