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
        
        // Set input field values from check availability
        if($_SERVER['REQUEST_METHOD'] == "GET"){
        
        if (!empty($_SESSION['checkavailability'])) {
            $event = $_SESSION['checkavailability']['event'];
            $resdate = $_SESSION['checkavailability']['resdate'];
            
            // event mode ekta enne time slot id eka
            $eventmode = $_SESSION['checkavailability']['eventmode'];
            $hall = $_SESSION['checkavailability']['hall'];
            $guest = $_SESSION['checkavailability']['guest'];
        }
            
        }
        //  var_dump($_SESSION['checkavailability']);
      
        // 2nd step- extact the form field 
        // convert array keys to the seperate variable with the value(extract)
        extract($_POST);
        
       //   var_dump($_POST);
      
        // 1st step- check the request method  
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "reservationsave") {
            
            // 3rd step- clean input
            $guest = cleanInput($guest);

            // Required Validation
            $message = array();

            $db = dbConn();
            $sql = "SELECT MinGuestCount,MaxGuestCount FROM tbl_hall WHERE HallId='$hall'";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $minguest = $row['MinGuestCount'];
                $maxguest = $row['MaxGuestCount'];
            }

            if (empty($guest)) {
                $message['error_guest'] = "Guest Count should not be blank..!";
            } elseif ($guest < $minguest) {
                $message['error_guest'] = "Minimum Guest Count is $minguest..!";
            } elseif ($guest > $maxguest) {
                $message['error_guest'] = "Maximum Guest Count is $maxguest..!";
            }
            
           
            // post eke ena guest count eka check avalability eke ena guest count ekta asmana unoth check availability 
            // session ekata e post eke ena value eka set kranna
            if (empty($message)) {
                
                if($_SESSION['checkavailability']['guest'] != $guest){
                    $_SESSION['checkavailability']['guest'] = $guest;
                }
                
                
            // get start time and end time from the database
                if (!empty($eventmode)) {
                    $db = dbConn();
                    $sql = "SELECT StartTime,EndTime,EventModeId FROM tbl_event_timeslot WHERE TimeSlotId=$eventmode";
                    $result = $db->query($sql);
                    ?>

                    <?php
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();

                        $starttime = $row['StartTime'];
                        $endtime = $row['EndTime'];
                        $eventmodeid = $row['EventModeId'];
                    }
                }


                // use for next button
                // if not change guest count then create session according to check availability guest count 
                if ($_SESSION['checkavailability']['guest'] == $guest) {
                    $_SESSION['reservation']['eventdetails'] = array('event' => @$event, 'resdate' => @$resdate, 'eventmode' => $eventmodeid, 'guest' => @$guest, 'hall' => $hall, 'starttime' => $starttime, 'endtime' => $endtime);
                } elseif ($guest >= $minguest && $guest <= $maxguest) {
                    $_SESSION['reservation']['eventdetails'] = array('event' => @$event, 'resdate' => @$resdate, 'eventmode' => $eventmodeid, 'guest' => @$guest, 'hall' => $hall, 'starttime' => $starttime, 'endtime' => $endtime);
                }

                //   var_dump($_SESSION['checkavailability']);
                //  echo   "</br>";
         //       var_dump($_SESSION['reservation']['eventdetails']);

             
                header('Location:menupackagedetails.php');
              
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

                            <div class="row mt-3">
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
                                </div>
                            </div>


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
                                                    $sql = "SELECT EventName FROM tbl_event WHERE EventId='$event'";
                                                    $result = $db->query($sql);
                                                    ?>

                                                    <?php
                                                    if ($result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        ?> 
                                                    <!-- use the display of event name-->
                                                      <input type="text" class="form-control" value="<?= $row['EventName'] ?>" readonly>
                                                      <?php 
                                                    }
                                                    ?>

                                                   
                                                    <!--  set value from the session [EventId]-->
                                                    <input type="hidden" id="event" name="event" value="<?= @$event ?>">
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

                                                    <input type="date" min="<?= $minresdate ?>" max="<?= $maxresdate ?>" class="form-control" id="resdate" name="resdate" value="<?= @$resdate ?>" readonly>
                                                    <div class="text-danger">
                                                        <?= @$message['error_resdate'] ?>  
                                                    </div>
                                                </div>
                                            </div>





                                        </div>


                                        <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="eventmode" class="form-label">Event Mode</label>
                                                </div>
                                                <div class="col-md-7">

                                                    <?php
                                                    $db = dbConn();
                                                    //event mode kiyla enne time slot id eka
                                                    $sql = "SELECT t.TimeSlotId,t.EventModeId,t.StartTime,t.EndTime,e.EventModeId,e.EventModeName FROM tbl_event_timeslot t LEFT JOIN tbl_event_mode e ON t.EventModeId=e.EventModeId WHERE t.TimeSlotId=$eventmode";
                                                    $result = $db->query($sql);
                                                    ?>

                                                    <?php
                                                    if ($result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        ?> 
                                                        <input type="text" class="form-control" value="<?= $row['EventModeName'] . " (" . $row['StartTime'] . " - " . $row['EndTime'] . ")" ?>" readonly>
                                                   <?php 
                                                    }
                                                    ?>


                                                    <input type="hidden" id="eventmode" name="eventmode" value="<?= $eventmode ?>">
                                                    <div class="text-danger">
                                                        <?= @$message['error_eventmode'] ?>  
                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="guest" class="form-label">Guest Count <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-7">


                                                    <input type="number" class="form-control" id="guest" name="guest" value="<?= @$guest ?>">
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
                                                    $sql = "SELECT HallName FROM tbl_hall WHERE HallId='$hall'";
                                                    $result = $db->query($sql);
                                                    
                                                    if ($result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        ?>
                                                         <input type="text" class="form-control"  value="<?= $row['HallName'] ?>" readonly>
                                                         <?php
                                                      
                                                    }
                                                    
                                                    ?>

                                                    
                                                   
                                                    <input type="hidden" id="hall" name="hall" value="<?= @$hall ?>">
                                                    <div class="text-danger">
                                                        <?= @$message['error_hall'] ?>  
                                                    </div>

                                                </div>
                                            </div>


                                        </div>



                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-md-8"></div>

                                        <div class="col-md-4">

                                            <button type="submit" class="btn btn-primary" style="width: 150px" name="action" value="reservationsave">Next</button>

                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-5">
                                    <img src="../assets/customer/assets/img/hotel.jpg" width="500px" height="320px" alt="alt"/>
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
