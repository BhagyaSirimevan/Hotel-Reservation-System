<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hall Arrangement </h1>

    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        //    var_dump($_GET);

        $db = dbConn();
        $sql = "SELECT * FROM tbl_hallarrangerequest WHERE ReservationNo='$ReservationNo'";
        //  print_r($sql);
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $resno = $row['ReservationNo'];
                $event = $row['EventId'];
                $resdate = $row['ReservationDate'];
                $themecolor = $row['ThemeColorId'];
                $reqdate = $row['AddDate'];
                $requestid = $row['RequestId'];
            }
        }
    }

    extract($_POST);
    // var_dump($_FILES);
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
        //  var_dump($_POST);
        $message = array();

        $db = dbConn();
        $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $resid = $row['ReservationId'];
        }

        // DJ Music
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='1' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($djmusic)) {
                $message['error_djmusic'] = "Service Provider should be selected..!";
            }
        }

        // Band Group
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='2' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($bandgroup)) {
                $message['error_bandgroup'] = "Service Provider should be selected..!";
            }
        }

        // Photography (Wedding Package)
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='3' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($weddingphotography)) {
                $message['error_weddingphotography'] = "Service Provider should be selected..!";
            }
        }

        // Hall Decoration
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='4' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($halldecoration)) {
                $message['error_halldecoration'] = "Service Provider should be selected..!";
            }
        }

        // Poruwa
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='9' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($poruwa)) {
                $message['error_poruwa'] = "Service Provider should be selected..!";
            }
        }

        // Ashtaka
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='10' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($ashtaka)) {
                $message['error_ashtaka'] = "Service Provider should be selected..!";
            }
        }

        // Dancing Group
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='11' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($dancinggroup)) {
                $message['error_dancinggroup'] = "Service Provider should be selected..!";
            }
        }

        // Dancing Group
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='12' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($jayamangalagatha)) {
                $message['error_jayamangalagatha'] = "Service Provider should be selected..!";
            }
        }

        // Wedding Cake Structure
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='14' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($weddingcakestructure)) {
                $message['error_weddingcakestructure'] = "Service Provider should be selected..!";
            }
        }

        // Home Coming Photography
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='33' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($homecomingphotography)) {
                $message['error_homecomingphotography'] = "Service Provider should be selected..!";
            }
        }

        // Engagement Photography
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='34' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($engagementphotography)) {
                $message['error_engagementphotography'] = "Service Provider should be selected..!";
            }
        }

        // Birthday Photography
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='35' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($birthdayphotography)) {
                $message['error_birthdayphotography'] = "Service Provider should be selected..!";
            }
        }

        // Default Photography
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='36' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($defaultphotography)) {
                $message['error_defaultphotography'] = "Service Provider should be selected..!";
            }
        }

        // Birthday Cake Structure
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='37' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($birthdaycakestructure)) {
                $message['error_birthdaycakestructure'] = "Service Provider should be selected..!";
            }
        }

        // Home Coming Cake Structure
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='38' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($homecomingcakestructure)) {
                $message['error_homecomingcakestructure'] = "Service Provider should be selected..!";
            }
        }

        // Engagement Cake Structure
        $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId='39' AND ReservationId='$resid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (empty($engagementcakestructure)) {
                $message['error_engagementcakestructure'] = "Service Provider should be selected..!";
            }
        }


        if (empty($message)) {

            $db = dbConn();
            $cdate = date('Y-m-d');
            $userid = $_SESSION['userid'];

            $sql = "INSERT INTO tbl_hallarrangement(RequestId,CateringProviderId,CateringProviderStatus,DJProviderId,DJProviderStatus,BandProviderId,BandProviderStatus,WeddingPhotoProviderId,WeddingPhotoProviderStatus,HallDecorationProviderId,HallDecorationProviderStatus,PoruwaProviderId,PoruwaProviderStatus,AshtakaProviderId,AshtakaProviderStatus,DancingGroupProviderId,DancingGroupProviderStatus,JayamangalaGathaProviderId,JayamangalaGathaProviderStatus,WeddingCakeProviderId,WeddingCakeProviderStatus,HomeComingPhotoProviderId,HomeComingPhotoProviderStatus,EngagementPhotoProviderId,EngagementPhotoProviderStatus,BirthdayPhotoProviderId,BirthdayPhotoProviderStatus,DefaultPhotoProviderId,DefaultPhotoProviderStatus,BirthdayCakeProviderId,BirthdayCakeProviderStatus,HomeComingCakeProviderId,HomeComingCakeProviderStatus,EngagementCakeProviderId,EngagementCakeProviderStatus,AddUser,AddDate) "
                    . "VALUES('$requestid','$cateringservice','$cateringstatus','$djmusic','$djstatus','$bandgroup','$bandgroupstatus','$weddingphotography','$weddingphotographystatus','$halldecoration','$halldecorationstatus','$poruwa','$poruwastatus','$ashtaka','$ashtakastatus','$dancinggroup','$dancinggroupstatus','$jayamangalagatha','$jayamangalagathastatus','$weddingcakestructure','$weddingcakestructurestatus','$homecomingphotography','$homecomingphotographystatus','$engagementphotography','$engagementphotographystatus','$birthdayphotography','$birthdayphotographystatus','$defaultphotography','$defaultphotographystatus','$birthdaycakestructure','$birthdaycakestructurestatus','$homecomingcakestructure','$homecomingcakestructurestatus','$engagementcakestructure','$engagementcakestructurestatus','$userid','$cdate')";
            $db->query($sql);

            //  print_r($sql);

            $HallArrangementId = $db->insert_id;

            $sql = "UPDATE tbl_hallarrangerequest SET ArrangeStatusId='2',UpdateDate='$cdate',UpdateUser='$userid' WHERE RequestId='$requestid'";

            //  print_r($sql);

            $db->query($sql);

            header('Location:addsuccess.php?HallArrangementId=' . $HallArrangementId);
        }
    }
    ?>


    <h2>Add New Arrangement Plan</h2>
    <div class="row">
        <div class="col-md-11"></div>
        <div class="col-md-1">
            <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
        </div>
    </div>
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="row mt-4">


            <input type="hidden" name="ReservationNo" value="<?= $ReservationNo ?>"> 


            <div class="col-md-6">
                <div class="alert alert-secondary">
                    <h4>Hall Arrangement Request Details</h4>

                    <div class="row mt-4">

                        <div class="col-md-4">
                            <label for="resno" class="form-label">Reservation No</label>
                        </div>

                        <div class="col-md-7">


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

                        <div class="col-md-7 mb-2">

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
                        <div class="col-md-7 mb-2">

                            <input type="text" class="form-control" id="resdate" name="resdate" value="<?= @$resdate ?>" readonly>


                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="themecolor" class="form-label">Theme Color</label>
                        </div>
                        <div class="col-md-7">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_themecolor WHERE ThemeColorId='$themecolor'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $themecolor = $row['ThemeColorId'];
                                ?>
                                <input type="text" class="form-control" id="themecolor" name="themecolor" value="<?= $row['ColourName'] ?>" readonly>
                                <input type="hidden" id="themecolor" name="themecolor" value="<?= $themecolor ?>"> 


                                <?php
                            }
                            ?>



                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label for="reqdate" class="form-label">Request Date</label>
                        </div>
                        <div class="col-md-7 mb-2">

                            <input type="text" class="form-control" id="reqdate" name="reqdate" value="<?= @$reqdate ?>" readonly>


                        </div>
                    </div>




                    <div class="row mt-2">
                        <div class="col-md-6">
                            <h4>Selected Free Services</h4> 
                            <div class="table-responsive">
                                <?php
                                $sql = "SELECT * FROM tbl_arrangefreeservice e LEFT JOIN tbl_service s ON s.ServiceId=e.ServiceId WHERE e.RequestId='$requestid'";
                                $db = dbConn();
                                $result = $db->query($sql);

                                $i = 1;
                                ?>

                                <table class="table table-sm">
                                    <thead class="bg-transparent">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Service Name</th>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $requestid = $row['RequestId'];
                                                ?>
                                            <input type="hidden" id="requestid" name="requestid" value="<?= $requestid ?>"> 

                                            <tr>
                                                <td><?= $i++ ?></td>

                                                <td><?= $row['ServiceName'] ?></td>



                                            </tr>

                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h4>Selected Other Services</h4>
                            <div class="table-responsive">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $resid = $row['ReservationId'];
                                }


                                $sql = "SELECT * FROM tbl_resservicelist e LEFT JOIN tbl_service s ON s.ServiceId=e.ServiceId WHERE e.ReservationId='$resid'";
                                $db = dbConn();
                                $result = $db->query($sql);

                                $i = 1;
                                ?>

                                <table class="table table-sm">
                                    <thead class="bg-transparent">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Service Name</th>


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


            <div class="col-md-6">
                
                
                <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label for="cateringservice" class="form-label">Catering Service</label>
                        </div>

                        <div class="col-md-5 mb-2">

                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist s ON s.ServiceProviderId=p.ServiceProviderId WHERE s.ServiceId='40'";
                            $result = $db->query($sql);
                           
                            ?>
                            
                            <select class="form-select" id="cateringservice" name="cateringservice" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$cateringservice) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            

                          
                        </div>
                    
                    <div class="col-md-3">
                            <?php
                            if (!empty($cateringservice)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $cateringstatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="cateringstatus" name="cateringstatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="cateringstatus" name="cateringstatus" value="<?= $cateringstatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    
                    </div>

                <h4 class="text-danger">Selected Other Services Arrangement</h4>
                <!--DJ Music-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=1 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="djmusic" class="form-label">DJ Music <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=1";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="djmusic" name="djmusic" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$djmusic) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_djmusic'] ?>  
                            </div>
                        </div>

                        <div class="col-md-3">
                            <?php
                            if (!empty($djmusic)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $djstatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="djstatus" name="djstatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="djstatus" name="djstatus" value="<?= $djstatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>



                    </div>   



                    <?php
                }
                ?>

                <!--                Band Group-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=2 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="bandgroup" class="form-label">Band Group <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=2";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="bandgroup" name="bandgroup" onchange="form.submit()">
                                <option value="">Select Service Provider Name</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$bandgroup) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_bandgroup'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($bandgroup)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $bandgroupstatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="bandgroupstatus" name="bandgroupstatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="bandgroupstatus" name="bandgroupstatus" value="<?= $bandgroupstatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--            Wedding Photography-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=3 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="weddingphotography" class="form-label">Photography <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=3";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="weddingphotography" name="weddingphotography" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$weddingphotography) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_weddingphotography'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($weddingphotography)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $weddingphotographystatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="weddingphotographystatus" name="weddingphotographystatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="weddingphotographystatus" name="weddingphotographystatus" value="<?= $weddingphotographystatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--                Hall Decoration with Entrance Arch-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=4 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="halldecoration" class="form-label">Hall Decoration <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=4";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="halldecoration" name="halldecoration" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$halldecoration) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_halldecoration'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($halldecoration)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $halldecorationstatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="halldecorationstatus" name="halldecorationstatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="halldecorationstatus" name="halldecorationstatus" value="<?= $halldecorationstatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>

                    </div>                  


                    <?php
                }
                ?>

                <!--                Poruwa-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=9 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="poruwa" class="form-label">Poruwa <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=9";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="poruwa" name="poruwa" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$poruwa) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_poruwa'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($poruwa)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $poruwastatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="poruwastatus" name="poruwastatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="poruwastatus" name="poruwastatus" value="<?= $poruwastatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--                Ashtaka-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=10 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="ashtaka" class="form-label">Ashtaka <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=10";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="ashtaka" name="ashtaka" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$ashtaka) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_ashtaka'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($ashtaka)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $ashtakastatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="ashtakastatus" name="ashtakastatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="ashtakastatus" name="ashtakastatus" value="<?= $ashtakastatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--                Traditional Dancing Group-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=11 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="dancinggroup" class="form-label">Traditional Dancing Group <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=11";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="dancinggroup" name="dancinggroup" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$dancinggroup) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_dancinggroup'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($dancinggroup)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $dancinggroupstatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="dancinggroupstatus" name="dancinggroupstatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="dancinggroupstatus" name="dancinggroupstatus" value="<?= $dancinggroupstatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--Jayamangala Gatha-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=12 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="jayamangalagatha" class="form-label">Jayamangala Gatha <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=12";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="jayamangalagatha" name="jayamangalagatha" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$jayamangalagatha) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_jayamangalagatha'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($jayamangalagatha)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $jayamangalagathastatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="jayamangalagathastatus" name="jayamangalagathastatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="jayamangalagathastatus" name="jayamangalagathastatus" value="<?= $jayamangalagathastatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--              Wedding Cake Structure-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=14 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="weddingcakestructure" class="form-label">Cake Structure <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=14";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="weddingcakestructure" name="weddingcakestructure" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$weddingcakestructure) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_weddingcakestructure'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($weddingcakestructure)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $weddingcakestructurestatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="weddingcakestructurestatus" name="weddingcakestructurestatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="weddingcakestructurestatus" name="weddingcakestructurestatus" value="<?= $weddingcakestructurestatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--                Photography (Home Coming Package)-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=33 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="homecomingphotography" class="form-label">Photography <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=33";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="homecomingphotography" name="homecomingphotography" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$homecomingphotography) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_homecomingphotography'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($homecomingphotography)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $homecomingphotographystatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="homecomingphotographystatus" name="homecomingphotographystatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="homecomingphotographystatus" name="homecomingphotographystatus" value="<?= $homecomingphotographystatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--                Photography (Engagement Package)-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=34 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="engagementphotography" class="form-label">Photography <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=34";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="engagementphotography" name="engagementphotography" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$engagementphotography) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_engagementphotography'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($engagementphotography)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $engagementphotographystatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="engagementphotographystatus" name="engagementphotographystatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="engagementphotographystatus" name="engagementphotographystatus" value="<?= $engagementphotographystatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--                Photography (Birthday Package)-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=35 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="birthdayphotography" class="form-label">Photography <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=35";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="birthdayphotography" name="birthdayphotography" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$birthdayphotography) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_birthdayphotography'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($birthdayphotography)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $birthdayphotographystatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="birthdayphotographystatus" name="birthdayphotographystatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="birthdayphotographystatus" name="birthdayphotographystatus" value="<?= $birthdayphotographystatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--                Photography (Default Package)-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=36 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="defaultphotography" class="form-label">Photography <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=36";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="defaultphotography" name="defaultphotography" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$defaultphotography) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_defaultphotography'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($defaultphotography)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $defaultphotographystatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="defaultphotographystatus" name="defaultphotographystatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="defaultphotographystatus" name="defaultphotographystatus" value="<?= $defaultphotographystatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--                Birthday Cake Structure-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=37 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="birthdaycakestructure" class="form-label">Cake Structure <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=37";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="birthdaycakestructure" name="birthdaycakestructure" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$birthdaycakestructure) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_birthdaycakestructure'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($birthdaycakestructure)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $birthdaycakestructurestatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="birthdaycakestructurestatus" name="birthdaycakestructurestatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="birthdaycakestructurestatus" name="birthdaycakestructurestatus" value="<?= $birthdaycakestructurestatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--                Home Coming Cake Structure-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=38 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="homecomingcakestructure" class="form-label">Cake Structure <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=38";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="homecomingcakestructure" name="homecomingcakestructure" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$homecomingcakestructure) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_homecomingcakestructure'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($homecomingcakestructure)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $homecomingcakestructurestatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="homecomingcakestructurestatus" name="homecomingcakestructurestatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="homecomingcakestructurestatus" name="homecomingcakestructurestatus" value="<?= $homecomingcakestructurestatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

                <!--                Engagement Cake Structure-->
                <?php
                $db = dbConn();
                $sql = "SELECT ReservationId FROM tbl_reservation WHERE ReservationNo='$resno'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resid = $row['ReservationId'];
                }

                $sql = "SELECT * FROM tbl_resservicelist WHERE ServiceId=39 AND ReservationId='$resid'";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label for="engagementcakestructure" class="form-label">Cake Structure <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_serviceprovider p LEFT JOIN tbl_providerservicelist l ON p.ServiceProviderId=l.ServiceProviderId WHERE ServiceId=39";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="engagementcakestructure" name="engagementcakestructure" onchange="form.submit()">
                                <option value="">Select Service Provider</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['ServiceProviderId']; ?> <?php if ($row['ServiceProviderId'] == @$engagementcakestructure) { ?>selected <?php } ?>><?= $row['BusinessName'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>


                            <div class="text-danger">
                                <?= @$message['error_engagementcakestructure'] ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($engagementcakestructure)) {
                                ?>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId=2";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $engagementcakestructurestatus = $row['ArrangeStatusId'];
                                        ?>

                                        <input type="text" class="form-control" id="engagementcakestructurestatus" name="engagementcakestructurestatus" value="<?= $row['ArrangeStatusName'] ?>" readonly>
                                        <input type="hidden" id="engagementcakestructurestatus" name="engagementcakestructurestatus" value="<?= $engagementcakestructurestatus ?>" readonly>
                                        <?php
                                    }
                                }
                                ?>   
                                <?php
                            }
                            ?>
                        </div>
                    </div>                  


                    <?php
                }
                ?>

            </div>

        </div>
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Submit</button>

            </div>
        </div>


    </form>

</main>


<?php include '../footer.php'; ?> 
<?php ob_end_flush() ?> 