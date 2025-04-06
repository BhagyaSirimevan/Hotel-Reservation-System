<?php ob_start(); ?>
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>


<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
    <section>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Hall Arrangement Request</h1>


            </div>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            extract($_GET);
            //    var_dump($_GET);

            $db = dbConn();
            $sql = "SELECT * FROM tbl_reservation WHERE ReservationNo='$ReservationNo'";
            //  print_r($sql);
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $resno = $row['ReservationNo'];
                    $event = $row['EventId'];
                    $resdate = $row['ReservationDate'];
                    $lastresprice = $row['LastReservationPrice'];
                }
            }
        }

        extract($_POST);
        // var_dump($_FILES);
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
            //  var_dump($_POST);
            $message = array();

            // Required Field Validation
            if (empty($themecolor)) {
                $message['error_themecolor'] = "Theme Color should be selected..!";
            }


            $db = dbConn();
            $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $resid = $row['ReservationId'];
            }

            $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='4' AND ReservationId='$resid'";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if (empty($halldeco)) {
                    $message['error_halldeco'] = "Hall Decoration Type should be selected..!";
                }
            }
            
            $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='9' AND ReservationId='$resid'";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if(empty($poruwa)){
                      $message['error_poruwa'] = "Poruwa Decoration should be selected..!"; 
                }
            }
            
            $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='14' AND ReservationId='$resid' OR ServiceId='37' AND ReservationId='$resid' OR ServiceId='38' AND ReservationId='$resid' OR ServiceId='39' AND ReservationId='$resid'";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                  if(empty($cakestructure)){
                      $message['error_cakestructure'] = "Cake Structure Type should be selected..!"; 
                }
            }
            
            $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='3' AND ReservationId='$resid' OR ServiceId='33' AND ReservationId='$resid' OR ServiceId='34' AND ReservationId='$resid' OR ServiceId='35' AND ReservationId='$resid' OR ServiceId='36' AND ReservationId='$resid'";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                   if(empty($photography)){
                      $message['error_photography'] = "Photography Package should be selected..!"; 
                }
            }
            
            
     
            if (empty($message)) {

                $db = dbConn();
                $cdate = date('Y-m-d');
                $userid = $_SESSION['userid'];

                $sql = "INSERT INTO tbl_hallarrangerequest(ReservationNo,EventId,ReservationDate,ThemeColorId,DecorationId,PhotographyId,PoruwaId,CakeStructureId,ArrangeStatusId,AddUser,AddDate) "
                        . "VALUES('$resno','$event','$resdate','$themecolor','$halldeco','$photography','$poruwa','$cakestructure','1','$userid','$cdate')";
                $db->query($sql);

                // print_r($sql);

                $RequestId = $db->insert_id;

                foreach ($item as $value) {
                    $sql = "INSERT INTO tbl_arrangefreeservice(RequestId,ServiceId) VALUES('$RequestId','$value') ";
                    //     print_r($sql);
                  $db->query($sql);
                }
                
                  header('Location:addsuccess.php?RequestId=' . $RequestId);
            }
        }
        ?>



        <div class="row">
            <div class="col-md-11"></div>
            <div class="col-md-1">
                <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
            </div>
        </div>
        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="row mt-4">
                <div class="col-md-2"></div>


                <input type="hidden" name="ReservationNo" value="<?= $ReservationNo ?>"> 


                <div class="col-md-6">

                    <div class="row">

                        <div class="col-md-4">
                            <label for="resno" class="form-label">Reservation No</label>
                        </div>

                        <div class="col-md-6">


                            <input type="text" class="form-control" id="resno" name="resno" value="<?= @$resno ?>" readonly>
                            <div class="text-danger">
                                <?= @$message['error_resno'] ?>  
                            </div>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label for="event" class="form-label">Event</label>
                        </div>

                        <div class="col-md-6 mb-2">

                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_event WHERE EventId='$event'";
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();

                                $event = $row['EventId'];
                            }
                            ?>

                            <input type="text" class="form-control" id="event" name="event" value="<?= $row['EventName'] ?>" readonly>
                            <input type="hidden" id="event" name="event" value="<?= $event ?>"> 

                        </div>
                    </div>



                    <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label for="resdate" class="form-label">Reservation Date</label>
                        </div>
                        <div class="col-md-6 mb-2">

                            <input type="text" class="form-control" id="resdate" name="resdate" value="<?= @$resdate ?>" readonly>


                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label for="lastresprice" class="form-label">Reservation Price</label>
                        </div>
                        <div class="col-md-6 mb-2">

                            <input type="text" class="form-control" id="lastresprice" name="lastresprice" value="<?= @$lastresprice ?>" readonly>


                        </div>
                    </div>
                    

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="themecolor" class="form-label">Theme Color <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_themecolor WHERE EventId='$event'";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="themecolor" name="themecolor" onchange="form.submit()">
                                <option value="">Select Theme Color</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ThemeColorId']; ?> <?php if ($row['ThemeColorId'] == @$themecolor) { ?>selected <?php } ?>><?= $row['ColourName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="text-danger">
                                <?= @$message['error_themecolor'] ?>  
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">


                        <?php
                        if (!empty($themecolor)) {

                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_themecolor WHERE ThemeColorId='$themecolor'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>   
                                <div class="col-md-4">
                                    <label for="hallimage" class="form-label">Sample Image</label>
                                </div>

                                <input type="hidden" class="form-control" id="hallimage" name="hallimage" value="<?= $row['HallImage'] ?>">
                                <div class="col-md-6">
                                    <img class="img-fluid" width="500" src="../../system/assets/images/eventthems/<?= $row['HallImage'] ?>">
                                </div>
                                <?php
                            }
                        }
                        ?>





                    </div>
                    
                    <div class="row mt-4">
                        <h4>Selected Other Services</h4>
                        </div>
                    
                    

                </div>

                <div class="col-md-4">
                    <div class="row">
                       
                         <h4>Available Free Services</h4>
                         
                        <div class="table-responsive">
                        <?php
                        $sql = "SELECT * FROM tbl_eventservice e LEFT JOIN tbl_service s ON s.ServiceId=e.ServiceId WHERE e.EventId='$event' AND s.ServiceType='Free'";
                        $db = dbConn();
                        $result = $db->query($sql);

                        $i = 1;
                        ?>

                        <table class="table table-sm">
                            <thead class="bg-transparent">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Service Name</th>
                                    <th scope="col">Select </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $row['ServiceName'] ?></td>
                                            <td> <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" onchange="form.submit()" id="<?= $row['ServiceId'] ?>" name="item[]" value="<?= $row['ServiceId'] ?>" <?php if (isset($item) && in_array($row['ServiceId'], $item)) { ?> checked <?php } ?> >
                                                    <label class="form-check-label" for="item"></label>
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
            
            <div class="card bg-white mt-4">
            <div class="row mt-4">
                    <div class="col-md-2"></div>
                         <div class="col-md-5">
                
                    <?php
                    $db = dbConn();
                    $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $resid = $row['ReservationId'];
                    }

                    // Hall Decoration
                    $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='4' AND ReservationId='$resid'";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        ?>
                        <div class="row mt-3">

                            <div class="col-md-5">
                                <label for="halldeco" class="form-label">Hall Decoration <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-7">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=4";
                                $result = $db->query($sql);
                                ?>

                                <select class="form-select" id="halldeco" name="halldeco" onchange="form.submit()">
                                    <option value="">Select Decoration Type</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>

                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$halldeco) { ?>selected <?php } ?>><?= $row['Name'] ?></option>


                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_halldeco'] ?>  
                                </div>
                            </div>
                        </div>                  


                        <?php
                    }
                    ?>
                    
                    
                    
                    
                    
                    
                    <div class="row mt-3">


                        <?php
                        if (!empty($halldeco)) {

                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceproviderservice WHERE ProviderServiceId='$halldeco'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>   
                                <div class="col-md-5">
                                    <label for="hallimage" class="form-label">Sample Image</label>
                                </div>
                        <div class="col-md-7">
                                <input type="hidden" class="form-control" id="hallimage" name="hallimage" value="<?= $row['SampleImage'] ?>">
                              
                                    <img width="250" src="../../system/assets/images/provideservices/<?= $row['SampleImage'] ?>">
                             </div>
                                <?php
                            }
                        }
                        ?>





                    </div>
                             
                             
                    <?php
                    $db = dbConn();
                    $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $resid = $row['ReservationId'];
                    }

                    // Photography
                    $sql = "SELECT ServiceId FROM tbl_resservicelist WHERE ReservationId='$resid'";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()){
                            if($row['ServiceId'] == 3 || $row['ServiceId'] == 33 || $row['ServiceId'] == 34 || $row['ServiceId'] == 35 || $row['ServiceId'] == 36){
                                ?>
                             
                             <div class="row mt-3">

                            <div class="col-md-5">
                                <label for="photography" class="form-label">Photography <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-7">
                                <?php
                                
                                if($row['ServiceId'] == 3){
                                    
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=3";
                                $result = $db->query($sql);   
                                ?>
                                
                                <select class="form-select" id="photography" name="photography" onchange="form.submit()">
                                    <option value="">Select Package</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                                ?>
                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$photography) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_photography'] ?>  
                                </div>
                                
                                
                                <?php
                                } elseif($row['ServiceId'] == 33){
                                    $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=33";
                                $result = $db->query($sql);   
                                ?>
                                
                                <select class="form-select" id="photography" name="photography" onchange="form.submit()">
                                    <option value="">Select Package</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                           
                                                ?>
                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$photography) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_photography'] ?>  
                                </div>
                                
                                
                                <?php
                                    
                                    
                                } elseif($row['ServiceId'] == 34){
                                    $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=34";
                                $result = $db->query($sql);   
                                ?>
                                
                                <select class="form-select" id="photography" name="photography" onchange="form.submit()">
                                    <option value="">Select Package</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                           
                                                ?>
                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$photography) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_photography'] ?>  
                                </div>
                                
                                
                                <?php
                                } elseif($row['ServiceId'] == 35){
                                    $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=35";
                                $result = $db->query($sql);   
                                ?>
                                
                                <select class="form-select" id="photography" name="photography" onchange="form.submit()">
                                    <option value="">Select Package</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                           
                                                ?>
                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$photography) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_photography'] ?>  
                                </div>
                                
                                
                                <?php
                                    
                                } elseif($row['ServiceId'] == 36){
                                    $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=36";
                                $result = $db->query($sql);   
                                ?>
                                
                                <select class="form-select" id="photography" name="photography" onchange="form.submit()">
                                    <option value="">Select Package</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                           
                                                ?>
                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$photography) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_photography'] ?>  
                                </div>
                                
                                
                                <?php
                                    
                                    
                                }
                                
                                ?>

                            </div>
                        </div>
                             
                             <?php
                            }
                            
                        }
                        
                            ?>
                        
                             <?php
                            
                        }
                        
                        
                        ?>
                        
                    <div class="row mt-3">


                        <?php
                        if (!empty($photography)) {

                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceproviderservice WHERE ProviderServiceId='$photography'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>   
                                <div class="col-md-5">
                                    <label for="hallimage" class="form-label">Sample Image</label>
                                </div>
                        <div class="col-md-7">
                                <input type="hidden" class="form-control" id="hallimage" name="hallimage" value="<?= $row['SampleImage'] ?>">
                              
                                    <img width="300" src="../../system/assets/images/provideservices/<?= $row['SampleImage'] ?>">
                             </div>
                                <?php
                            }
                        }
                        ?>





                    </div>
                             
                             
                    
                    
                    
                </div>
                    
                    <div class="col-md-5">
                    <?php
                    $db = dbConn();
                    $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $resid = $row['ReservationId'];
                    }
                    
                    // Wedding Poruwa
                    $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='9' AND ReservationId='$resid'";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        ?>
                        <div class="row mt-4">

                            <div class="col-md-5">
                                <label for="poruwa" class="form-label">Wedding Poruwa <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-7">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=9";
                               
                                $result = $db->query($sql);
                                ?>

                                <select class="form-select" id="poruwa" name="poruwa" onchange="form.submit()">
                                    <option value="">Select Design</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>

                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$poruwa) { ?>selected <?php } ?>><?= $row['Name'] ?></option>


                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_poruwa'] ?>  
                                </div>
                            </div>
                        </div>                  


                        <?php
                    }
                    ?>
                    
                    <div class="row mt-3">


                        <?php
                        if (!empty($poruwa)) {

                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceproviderservice WHERE ProviderServiceId='$poruwa'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>   
                                <div class="col-md-5">
                                    <label for="hallimage" class="form-label">Sample Image</label>
                                </div>
                        <div class="col-md-7">
                                <input type="hidden" class="form-control" id="hallimage" name="hallimage" value="<?= $row['SampleImage'] ?>">
                              
                                    <img width="130" src="../../system/assets/images/provideservices/<?= $row['SampleImage'] ?>">
                             </div>
                                <?php
                            }
                        }
                        ?>





                    </div>
                        
                        <?php
                    $db = dbConn();
                    $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $resid = $row['ReservationId'];
                    }

                    // Wedding Cake Structure
                    $sql = "SELECT ServiceId FROM tbl_resservicelist WHERE ReservationId='$resid'";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()){
                            if($row['ServiceId'] == 14 || $row['ServiceId'] == 37 || $row['ServiceId'] == 38 || $row['ServiceId'] == 39){
                                ?>
                             
                             <div class="row mt-3">

                            <div class="col-md-5">
                                <label for="cakestructure" class="form-label">Cake Structure <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-7">
                                <?php
                                
                                if($row['ServiceId'] == 14){
                                    
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=14";
                                $result = $db->query($sql);   
                                ?>
                                
                                <select class="form-select" id="cakestructure" name="cakestructure" onchange="form.submit()">
                                    <option value="">Select Design</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                                ?>
                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$cakestructure) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_cakestructure'] ?>  
                                </div>
                                
                                
                                <?php
                                } elseif($row['ServiceId'] == 37){
                                    $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=37";
                                $result = $db->query($sql);   
                                ?>
                                
                                <select class="form-select" id="cakestructure" name="cakestructure" onchange="form.submit()">
                                    <option value="">Select Design</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                           
                                                ?>
                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$cakestructure) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_cakestructure'] ?>  
                                </div>
                                
                                
                                <?php
                                    
                                    
                                } elseif($row['ServiceId'] == 38){
                                    $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=38";
                                $result = $db->query($sql);   
                                ?>
                                
                                <select class="form-select" id="cakestructure" name="cakestructure" onchange="form.submit()">
                                    <option value="">Select Design</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                           
                                                ?>
                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$cakestructure) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_cakestructure'] ?>  
                                </div>
                                
                                
                                <?php
                                } elseif($row['ServiceId'] == 39){
                                    $db = dbConn();
                                $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist p ON p.ProvideServiceListId=s.ProvideServiceListId WHERE p.ServiceId=39";
                                $result = $db->query($sql);   
                                ?>
                                
                                <select class="form-select" id="cakestructure" name="cakestructure" onchange="form.submit()">
                                    <option value="">Select Design</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                           
                                                ?>
                                            <option value=<?= $row['ProviderServiceId']; ?> <?php if ($row['ProviderServiceId'] == @$cakestructure) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>


                                <div class="text-danger">
                                    <?= @$message['error_cakestructure'] ?>  
                                </div>
                                
                                
                                <?php
                                    
                                }
                                
                                ?>

                            </div>
                        </div>
                             
                             <?php
                            }
                            
                        }
                        
                            ?>
                        
                             <?php
                            
                        }
                        
                        
                        ?>
                        
                    <div class="row mt-3">


                        <?php
                        if (!empty($cakestructure)) {

                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceproviderservice WHERE ProviderServiceId='$cakestructure'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>   
                                <div class="col-md-5">
                                    <label for="hallimage" class="form-label">Sample Image</label>
                                </div>
                        <div class="col-md-7">
                                <input type="hidden" class="form-control" id="hallimage" name="hallimage" value="<?= $row['SampleImage'] ?>">
                              
                                    <img width="150" src="../../system/assets/images/provideservices/<?= $row['SampleImage'] ?>">
                             </div>
                                <?php
                            }
                        }
                        ?>





                    </div>
                        
                      
                        
                   
                    
                    
                        
                    </div>
                    </div>
                </div>
            <div class="row mt-5">
                        <div class="col-md-10"></div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Submit</button>

                        </div>
                    </div>
            
                    </div>
           
            

        </form>
    </section>

</main>


<?php include '../dashboardfooter.php'; ?>
<?php ob_end_flush(); ?>