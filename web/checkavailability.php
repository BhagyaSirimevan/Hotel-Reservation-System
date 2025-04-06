<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>


<main id="main">

    <?php
    // 2nd step- extact the form field 
    // convert array keys to the seperate variable with the value(extract)
    extract($_POST);
    //var_dump($_POST);
    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {


        // 3rd step- clean input

        $event = cleanInput($event);
        $resdate = cleanInput($resdate);
        $stime = cleanInput($stime);
        $endtime = cleanInput($endtime);
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
            if ($stime == $endtime){
              $message['error_endtime'] = "Reservation Start Time and End Time Not Equal..!";  
            }
        }

        if (empty($guest)) {
            $message['error_guest'] = "Guest Count should not be blank..!";
        }
    }
    
    
    
    
    ?>


    


    <section id="book-a-table" class="book-a-table">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="container bg-light">

                    <div class="section-title">
                        <br>
                        <h2>Check <span>Hall Availability</span></h2>
                    </div>



                    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 


                        <div class="row">

                            <div class="col-md-2"></div>

                            <div class="col-md-8">

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
                                                
                                                <input type="date" min="<?=$minresdate?>" max="<?=$maxresdate?>" class="form-control" id="resdate" name="resdate" value="<?= @$resdate ?>">
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
                                                <input type="time" min="<?= $mintime ?>" max="<?= $maxtime?>" class="form-control" id="stime" name="stime" value="<?= @$stime ?>">
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
                                                <input type="time" min="<?= $mintime ?>" max="<?= $maxtime?>" class="form-control" id="endtime" name="endtime" value="<?= @$endtime ?>">
                                                <div class="text-danger">
                                                    <?= @$message['error_endtime'] ?>  
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
                                                <input type="text" class="form-control" id="guest" name="guest" value="<?= @$guest ?>">
                                                <div class="text-danger">
                                                    <?= @$message['error_guest'] ?>  
                                                </div>

                                            </div>
                                        </div>


                                    </div>




                                </div>

                            </div>
                            <div class="col-md-2"></div>
                        </div>


                        <div class="row mt-3">
                            <div class="col-md-6"></div>

                            <div class="col-md-6">

                                <button type="submit" class="btn btn-warning text-dark" name="action" value="save">Check Availability</button>
                            </div>
                        </div>


                    </form>

                    <?php
                    if (!empty($resdate) && !empty($stime) && !empty($endtime) && !empty($guest)) {

                        $db = dbConn();

                        $sql = "SELECT * FROM tbl_hall WHERE MinGuestCount<='$guest' AND MaxGuestCount>='$guest' AND HallId NOT IN (SELECT HallId FROM tbl_reservation "
                                . "WHERE ReservationStatusId=1 AND ReservationDate='$resdate' AND (FunctionStartTime='$stime' OR "
                                . "FunctionEndTime='$stime' OR FunctionStartTime='$endtime' "
                                . "OR FunctionEndTime='$endtime' OR (FunctionStartTime BETWEEN '$stime' AND '$endtime') "
                                . "OR (FunctionEndTime BETWEEN '$stime' AND '$endtime') "
                                . "OR (FunctionStartTime<'$stime' AND FunctionEndTime>'$endtime')) )";
                        print_r($sql);
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                <div class="row mt-5">

                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div class='alert alert-dark' role='alert'>


                                            <h2 class="text-center text-danger"> Hall <?= $row['HallName'] ?> - Available</h2>

                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>

                                </div>

                                <?php
                            }
                        }
                    } 
                    ?>



                </div>
            </div>
            <div class="col-md-3"></div>
        </div>

    </section><!-- End Book A Table Section -->
</main>

<?php include 'footer.php'; ?>