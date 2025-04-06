<?php ob_start();
// session_start();
?>

<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>


<main id="main">

    <?php
    extract($_POST);
    //   var_dump($_POST);
    $actionarray = explode('.', @$action);
    // @$action = @$hall[0] ;
    $hall = @$actionarray[1];

    if (!empty($hall)) {
        $_SESSION['checkavailability'] = array('event' => @$event, 'resdate' => @$resdate, 'eventmode' => $eventmode, 'guest' => @$guest, 'hall' => $hall);
        //  var_dump($_SESSION['checkavailability']);
        header('Location:../reservation/eventdetails.php');
    }

    // 2nd step- extact the form field 
    // convert array keys to the seperate variable with the value(extract)
    //var_dump($_POST);
    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
       //  var_dump($_POST);
        // 3rd step- clean input

        $event = cleanInput($event);
        $resdate = cleanInput($resdate);
        // $stime = cleanInput($stime);
        // $endtime = cleanInput($endtime);
        $guest = cleanInput($guest);

        // Required Validation
        $message = array();

        if (empty($event)) {
            $message['error_event'] = "Should be Select Event..!";
        }

        if (empty($resdate)) {
            $message['error_resdate'] = "Should be Select Reservation Date..!";
        }

//        if (empty($stime)) {
//            $message['error_stime'] = "Should be Select Reservation Start Time..!";
//        }
//
//        if (empty($endtime)) {
//            $message['error_endtime'] = "Should be Select Reservation End Time..!";
//        } else {
//            if ($stime == $endtime) {
//                $message['error_endtime'] = "Reservation Start Time and End Time Not Equal..!";
//            }
//        }

        if (empty($eventmode)) {
            $message['error_eventmode'] = "Should be Select Event Mode..!";
        }

        if (empty($guest)) {
            $message['error_guest'] = "Guest Count should not be blank..!";
        } elseif (!empty ($guest)) {
            if($guest<=0){
             $message['error_guest'] = "Guest Count Cannot be 0 or Negative..!";
            }
    }
    }
    ?>




    <section id="book-a-table" class="book-a-table">
        <div class="section-title text-center">
            <br>
            <h1>Check <span>Hall Availability</span></h1>
            <br>
            <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
                </div>
        </div>



            <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 

              
                <div class="row">

                    <div class="col-md-6">
                        <div class="container">

                            <div class="row">

                                <div class="col-md-2"></div>

                                <div class="col-md-10">

                                    <div class="row">


                                        <div class="col-md-12 mb-2 mt-5">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="event" class="form-label">Event <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-7">
                                                    <?php
                                                    $db = dbConn();
                                                    $sql = "SELECT * FROM tbl_event";
                                                    $result = $db->query($sql);
                                                    ?>

                                                    <select class="form-select" id="event" name="event" onchange="form.submit()">
                                                        <option value="">Select Event</option>

                                                        <?php
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                ?>

                                                                <option value=<?= $row['EventId']; ?> <?php if ($row['EventId'] == @$event) { ?>selected <?php } ?>><?= $row['EventName'] ?></option>


                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger">
                                                        <?= @$message['error_event'] ?>  
                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="resdate" class="form-label">Reservation Date <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-7">
                                                    <?php
                                                    $minresdate = date('Y-m-d', strtotime('+14 days'));
                                                    $maxresdate = date('Y-m-d', strtotime('+1 years'));
                                                    ?>

                                                    <input type="date" min="<?= $minresdate ?>" max="<?= $maxresdate ?>" class="form-control" id="resdate" name="resdate" value="<?= @$resdate ?>">
                                                    <div class="text-danger">
                                                        <?= @$message['error_resdate'] ?>  
                                                    </div>
                                                </div>
                                            </div>





                                        </div>


                                    </div>

                                </div>

                            </div>


                            








                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row mt-5">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="eventmode" class="form-label">Event Mode <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-7">

                                                    <?php
                                                    if (empty($event)) {

                                                        $db = dbConn();
                                                        $sql = "SELECT * FROM tbl_event_mode";
                                                        $result = $db->query($sql);
                                                        ?>

                                                        <select class="form-select" id="eventmode" name="eventmode">
                                                            <option value="">Select Event Mode</option>

                                                            <?php
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    ?>

                                                                    <option value=<?= $row['EventModeId']; ?> <?php if ($row['EventModeId'] == @$eventmode) { ?>selected <?php } ?>><?= $row['EventModeName'] ?></option>


                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger">
                                                            <?= @$message['error_eventmode'] ?>  
                                                        </div>  

                                                        <?php
                                                    } else {
                                                        $db = dbConn();
                                                        $sql = "SELECT t.TimeSlotId,t.EventModeId,t.StartTime,t.EndTime,e.EventModeId,e.EventModeName FROM tbl_event_timeslot t LEFT JOIN tbl_event_mode e ON t.EventModeId=e.EventModeId WHERE EventId=$event";
                                                        $result = $db->query($sql);
                                                        ?>

                                                        <select class="form-select" id="eventmode" name="eventmode">
                                                            <option value="">Select Event Mode</option>

                                                            <?php
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    ?>

                                                                    <option value=<?= $row['TimeSlotId']; ?> <?php if ($row['TimeSlotId'] == @$eventmode) { ?>selected <?php } ?>><?= $row['EventModeName'] . " (" . $row['StartTime'] . " - " . $row['EndTime'] . ")" ?></option>


                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger">
                                                            <?= @$message['error_eventmode'] ?>  
                                                        </div>   


                                                        <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                        </div>
                                    
                                    <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="guest" class="form-label">Guest Count <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-7">
                                                    <?php 
                                                    $db = dbConn();
                                                    $sql = "SELECT MIN(MinGuestCount) as min, MAX(MaxGuestCount) as max FROM tbl_hall";
                                                    $result = $db->query($sql);

                                                    if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                 
                                                    $min = $row['min'];
                                                    $max = $row['max'];
                                                    
                                                    }
                                                   
                                                    
                                                    
                                                    ?>
                                                    
                                                    
                                                    
                                                    <input type="text" min="<?= $min ?>" max="<?= $max ?>" class="form-control" id="guest" name="guest" value="<?= @$guest ?>">
                                                    <div class="text-danger">
                                                        <?= @$message['error_guest'] ?>  
                                                    </div>

                                                </div>
                                            </div>


                                        </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                                <div class="col-md-8"></div>

                                <div class="col-md-4">

                                    <button type="submit" class="btn btn-warning text-dark" name="action" value="save">Check Availability</button>
                                </div>
                            </div>

                    
                    

                </div>
                   
                    
                <div class="row mt-3">
                   
                        <?php
                        if (!empty($resdate) && !empty($guest)) {

                            $db = dbConn();

                            $sql = "SELECT StartTime,EndTime FROM tbl_event_timeslot WHERE TimeSlotId=$eventmode";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $stime = $row['StartTime'];
                                    $endtime = $row['EndTime'];
                                }
                            }

                            $sql = "SELECT * FROM tbl_hall WHERE HallStatus='Available' AND MinGuestCount<='$guest' AND MaxGuestCount>='$guest' "
                                    . "AND HallId NOT IN (SELECT HallId FROM tbl_reservation "
                                    . "WHERE ReservationStatusId=2 AND ReservationDate='$resdate' AND (FunctionStartTime='$stime' OR "
                                    . "FunctionEndTime='$stime' OR FunctionStartTime='$endtime' "
                                    . "OR FunctionEndTime='$endtime' OR (FunctionStartTime BETWEEN '$stime' AND '$endtime') "
                                    . "OR (FunctionEndTime BETWEEN '$stime' AND '$endtime') "
                                    . "OR (FunctionStartTime<'$stime' AND FunctionEndTime>'$endtime')) )";
                            //   print_r($sql);
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                ?>
                                 <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>

                                        <div class="col-md-4">
                                            <div class='alert bg-white' role='alert'>


                                                <h5 class="text-danger"> Hall <?= $row['HallName'] ?> - Available</h5>
                                                <div class="row mt-3">
                                                    
                                                        <img class="img-fluid" width="200" src="../../system/assets/images/hall/<?= $row['HallImage'] ?>">
                                                        
                                                        <strong style="text-align: left">Minimum Guest Count - <?= $row['MinGuestCount'] ?></strong>
                                                        <br>
                                                        <strong style="text-align: left">Maximum Guest Count - <?= $row['MaxGuestCount'] ?></strong>
                                                        <br>
                                                        <strong style="text-align: left">Available Features - <?php
                                                        $featureslist = explode(",", $row['AvailableFeatures']);
                                                        echo '<ul>';
                                                        foreach ($featureslist as $value) {
                                                            echo '<li>' . $value . '</li>';
                                                        }
                                                        echo '</ul>';
                                                        ?></strong>
                                                       
                                                           
                                                   
                                                </div>



                                                <div class="row mt-3">
                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-6">

                                                        <button class="btn btn-outline-success" name="action" value="hall.<?= $row['HallId'] ?>">Book Now</button>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        
                                   

                                    <?php
                                }
                               ?>   
                        <?php    } else {

                                echo "<div class='alert bg-white' role='alert'><h5 class='text-center text-danger'>Not Available</h5></div>";
                            }
                        }
                        ?>
                  
                </div>
            </form>
        </div>


    </section><!-- End Book A Table Section -->
</main>

<?php include '../dashboardfooter.php'; ?>
<?php ob_end_flush(); ?>