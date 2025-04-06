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
        if(!empty($_SESSION['reservation']['eventdetails'])){
                $event = $_SESSION['reservation']['eventdetails']['event'];
                $resdate = $_SESSION['reservation']['eventdetails']['resdate'];
                $stime = $_SESSION['reservation']['eventdetails']['stime'];
                $endtime = $_SESSION['reservation']['eventdetails']['endtime'];
                $duration = $_SESSION['reservation']['eventdetails']['duration'];
                $hall = $_SESSION['reservation']['eventdetails']['hall'];
                $guest = $_SESSION['reservation']['eventdetails']['guest']; 
        }
        
//     
        // 2nd step- extact the form field 
        // convert array keys to the seperate variable with the value(extract)
        extract($_POST);

        //  var_dump($_POST);
        //  var_dump($_SESSION['reservation']);
        // 1st step- check the request method  
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "reservationsave") {


            // 3rd step- clean input
            $event = cleanInput($event);
            $resdate = cleanInput($resdate);
            $stime = cleanInput($stime);
            $endtime = cleanInput($endtime);
            $duration = cleanInput($duration);
            $hall = cleanInput($hall);
            $guest = cleanInput($guest);

            // Required Validation
            $message = array();

            if (empty($event)) {
                $message['error_event'] = "Should be Select Event..!";
            }

            if (empty($resdate)) {
                $message['error_resdate'] = "Should be Select Reservation Date..!";
            }

            if (empty($stime)) {
                $message['error_stime'] = "Should be Select Reservation Start Time..!";
            }


            if (empty($endtime)) {
                $message['error_endtime'] = "Should be Select Reservation End Time..!";
            } else {
                if ($stime == $endtime) {
                    $message['error_endtime'] = "Reservation Start Time and End Time Not Equal..!";
                }
            }


            if (empty($duration)) {
                $message['error_duration'] = "Duration should not be blank..!";
            }

            if (empty($hall)) {
                $message['error_hall'] = "Should be Select Hall..!";
            }


            if (empty($guest)) {
                $message['error_guest'] = "Guest Count should not be blank..!";
            } elseif ($guest < 50) {
                $message['error_guest'] = "Minimum Guest Count is 50..!";
            } elseif ($guest > 300) {
                $message['error_guest'] = "Maximum Guest Count is 300..!";
            }



            //  var_dump($message);
            //  var_dump($message);

            if (empty($message)) {

                $_SESSION['reservation']['eventdetails'] = array('event' => $event, 'resdate' => $resdate, 'stime' => $stime, 'endtime' => $endtime, 'duration' => $duration, 'hall' => $hall, 'guest' => $guest);
               // var_dump($_SESSION);

//                $db = dbConn();
//
//                $userid = $_SESSION['userid'];
//
//                $cdate = date('Y-m-d');
//                $sql = "INSERT INTO tbl_reservation(EventId,ReservationDate,FunctionStartTime,FunctionEndTime,Duration,HallId,GuestCount,AddDate,AddUser)"
//                        . "VALUES('$event','$resdate','$stime','$endtime','$duration','$hall','$guest','$cdate','$userid')";
//                print_r($sql);
//                $db->query($sql);
//
//                $newreservationid = $db->insert_id;
//
//                // generate reservation no 
//                $resno = date('Y') . date('m') . date('d') . $newreservationid;
//
//               
//                $sql = "UPDATE tbl_reservation SET ReservationNo='$resno' WHERE ReservationId='$newreservationid'";
//                $db->query($sql);
//                
//                $_SESSION['ReservationNo'] = $resno;

                header('Location:menupackagedetails.php');
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
                            <a class="nav-link active" data-bs-toggle="tab" href="#eventdetails">Event Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="">Menu Package Details</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="">Service Details</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="">Additional Item Details</a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


                            <div class="row mt-4">



                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="event" class="form-label">Event</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <?php
                                                    $db = dbConn();
                                                    $sql = "SELECT * FROM tbl_event";
                                                    $result = $db->query($sql);
                                                    ?>

                                                    <select class="form-select" id="event" name="event">
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
                                                    <label for="resdate" class="form-label">Reservation Date</label>
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


                                        <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="stime" class="form-label">Function Start Time</label>
                                                </div>
                                                <div class="col-md-7">

                                                    <?php
                                                    $mintime = date('H:i', strtotime('07:00 AM'));
                                                    $maxtime = date('H:i', strtotime('12:00 AM'));
                                                    ?>
                                                    <input type="time" min="<?= $mintime ?>" max="<?= $maxtime ?>" class="form-control" id="stime" name="stime" value="<?= @$stime ?>">
                                                    <div class="text-danger">
                                                        <?= @$message['error_stime'] ?>  
                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="endtime" class="form-label">Function End Time</label>
                                                </div>
                                                <div class="col-md-7">

                                                    <?php
                                                    $mintime = date('H:i', strtotime('07:00 AM'));
                                                    $maxtime = date('H:i', strtotime('12:00 AM'));
                                                    ?>
                                                    <input type="time" min="<?= $mintime ?>" max="<?= $maxtime ?>" class="form-control" id="endtime" name="endtime" value="<?= @$endtime ?>">
                                                    <div class="text-danger">
                                                        <?= @$message['error_endtime'] ?>  
                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="duration" class="form-label">Duration</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="duration" name="duration" value="<?= @$duration ?>">
                                                    <div class="text-danger">
                                                        <?= @$message['error_duration'] ?>  
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                        
                                        <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="guest" class="form-label">Guest Count</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="guest" name="guest" value="<?= @$guest ?>" onchange="form.submit()">
                                                    <div class="text-danger">
                                                        <?= @$message['error_guest'] ?>  
                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="hall" class="form-label">Hall</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <?php
                                                    $db = dbConn();
                                                    if(!empty($guest) && !empty($stime) && !empty($endtime) && !empty($resdate)){
                                                    $sql = "SELECT * FROM tbl_hall WHERE MinGuestCount<='$guest' AND MaxGuestCount>='$guest' "
                                                            . "AND HallId NOT IN (SELECT HallId FROM tbl_reservation "
                                                            . "WHERE ReservationStatusId=1 AND ReservationDate='$resdate' AND (FunctionStartTime='$stime' OR "
                                                            . "FunctionEndTime='$stime' OR FunctionStartTime='$endtime' "
                                                            . "OR FunctionEndTime='$endtime' OR (FunctionStartTime BETWEEN '$stime' AND '$endtime') "
                                                            . "OR (FunctionEndTime BETWEEN '$stime' AND '$endtime') "
                                                            . "OR (FunctionStartTime<'$stime' AND FunctionEndTime>'$endtime')) )";
                                                    $result = $db->query($sql);
                                                    }
                                                   // print_r($sql);
                                                    ?>

                                                    <select class="form-select" id="hall" name="hall">
                                                        <option value="">Select Hall</option>

                                                        <?php
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                ?>

                                                                <option value=<?= $row['HallId']; ?> <?php if ($row['HallId'] == @$hall) { ?>selected <?php } ?>><?= $row['HallName'] ?></option>


                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger">
                                                        <?= @$message['error_hall'] ?>  
                                                    </div>
                                                </div>
                                            </div>



                                        </div>


                                        




                                    </div>

                                </div>

                                <div class="col-md-5">
                                    <img src="../assets/customer/assets/img/hotel.jpg" width="500px" height="320px" alt="alt"/>
                                </div>



                            </div>  
                            <div class="row mt-4">
                                <div class="col-md-4"></div>

                                <div class="col-md-8">

                                    <button type="submit" class="btn btn-primary" style="width: 150px" name="action" value="reservationsave">Next</button>


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
