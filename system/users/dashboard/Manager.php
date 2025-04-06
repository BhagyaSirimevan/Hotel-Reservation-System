<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> <?= $_SESSION['title'] . " " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . " - " . $_SESSION['userrole'] ?>   </h1>

    </div>

    <h2>Dashboard</h2>
    <div class="row mt-4">
        
        <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-light">

            

            <div class="card-body">
                <h4 class="card-title">Reservations <span class="text-success">| This Year</span></h4>

              
                      <div class="row">
                            <div class="col-md-5">
                                  <span data-feather="calendar" class="align-text-bottom" style="width: 50;height: 50;"></span>
                       
                            </div>
                            <div class="col-md-4">
                                <div class="ps-3">
                        <?php
                        $firstdayofyear = date("Y-01-01");
                        $today = date("Y-m-d");
                      
                        $db = dbConn();
                        $sql = "SELECT COUNT(ReservationId) from tbl_reservation WHERE ReservationDate BETWEEN '$firstdayofyear' AND '$today' AND ReservationStatusId=4";
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                        }
                        ?>
                      
                     
                    
                        <h1 class="text-danger text-center"><?= $row['COUNT(ReservationId)'] ?></h1>
                     

                    </div>
                            </div>
                        </div>
                      
                    
                    
                
            </div>

        </div>
    </div><!-- End Sales Card --> 
    
    <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-light">

            

            <div class="card-body">
                <h4 class="card-title">Revenue <span class="text-success">| This Year</span></h4>

              
                   <div class="row">
                            <div class="col-md-2">
                                <span data-feather="plus" class="align-text-bottom" style="width: 50;height: 50;"></span>
                   
                            </div>
                            <div class="col-md-10">
                                <div class="ps-3">
                        <?php
                        // Get the current year and month
                        $firstDayOfYear = date("Y-01-01");
                        $today = date("Y-m-d");

                        $db = dbConn();
                        $sql = "SELECT SUM(PaidAmount) from tbl_customerpayments WHERE UpdateDate BETWEEN '$firstDayOfYear' AND '$today' AND PaymentStatusId=2";
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                        }
                        ?>
                      
                     
                    
                        <h1 class="text-danger text-center"><?= $row['SUM(PaidAmount)'] ?></h1>
                     

                    </div>
                            </div>
                        </div>
                        
                    
                
            </div>

        </div>
    </div><!-- End Sales Card --> 
        
      <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card bg-light">

            

            <div class="card-body">
                <h4 class="card-title">Customers <span class="text-success">| This Year</span></h4>

              
                  
                        <div class="row">
                            <div class="col-md-3">
                               <span data-feather="users" class="align-text-bottom" style="width: 50;height: 50;"></span>  
                            </div>
                            <div class="col-md-6">
                                <div class="ps-3">
                        <?php
                        
                        $firstDayOfYear = date("Y-01-01");
                        $today = date("Y-m-d");
                      

                        $db = dbConn();
                        $sql = "SELECT COUNT(CustomerId) from tbl_customers WHERE AddDate BETWEEN '$firstDayOfYear' AND '$today'";
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                        }
                        ?>
                      
                     
                    
                        <h1 class="text-danger text-center"><?= $row['COUNT(CustomerId)'] ?></h1>
                     

                    </div>
                            </div>
                        </div>
                        
                    
                    
                
            </div>

        </div>
    </div><!-- End Sales Card -->   
    </div>
    
    <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4 mt-4">
   


        <h2 class="text-center">Upcoming Events</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input
        $resno = cleanInput($resno);
       // $regno = cleanInput($regno);
        $cusname = cleanInput($cusname);
        $event = cleanInput($event);
        $resdate = cleanInput($resdate);
        $time = cleanInput($time);
        $guest = cleanInput($guest);
        $hall = cleanInput($hall);

        if (!empty($resno)) {
            $where .= " ReservationNo LIKE '%$resno%' AND";
        }


//        if (!empty($regno)) {
//            $where .= " RegNo LIKE '%$regno%' AND";
//        }

        if (!empty($cusname)) {
            $where .= " FirstName LIKE '%$cusname%' OR LastName LIKE '%$cusname%' AND";
        }

        if (!empty($event)) {
            $where .= " r.EventId = '$event' AND";
        }

        if (!empty($resdate)) {
            $where .= " ReservationDate = '$resdate' AND";
        }

        if (!empty($time)) {
            $where .= " FunctionStartTime = '$time' OR FunctionEndTime = '$time' AND";
        }

        if (!empty($guest)) {
            $where .= " GuestCount LIKE '%$guest%' AND";
        }

        if (!empty($hall)) {
            $where .= " h.HallId = '$hall' AND";
        }

        if (!empty($status)) {
            $where .= " s.ResStatusId = '$status' AND";
        }
//        
//        if(!empty($minprice) && !empty($maxprice) ){
//              $where.=" Price BETWEEN '$minprice' AND '$maxprice' AND";
//
//        }
//        


        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = "AND $where";
        }
    }
    ?>  

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

        <div class="row mt-4">
            <div class="col">
                <input type="text" class="form-control" placeholder="Res No" name="resno" >
            </div>
            <!--            <div class="col">
                            <input type="text" class="form-control" placeholder="Reg No" name="regno" >
                        </div>-->

            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Name" name="cusname" >
            </div>
            <div class="col">
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
            </div>


            <div class="col">
                <input type="date" class="form-control" placeholder="Date" name="resdate" >
            </div>

            <div class="col">
                <input type="time" class="form-control" placeholder="Start" name="time" >
            </div>



            <div class="col">
                <input type="text" class="form-control" placeholder="Guest" name="guest" >
            </div>

            <div class="col">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_hall";
                $result = $db->query($sql);
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


            </div>

            <div class="col">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_reservationstatus";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="status" name="status">
                    <option value="">Select Status</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['ResStatusId']; ?> <?php if ($row['ResStatusId'] == @$status) { ?>selected <?php } ?>><?= $row['ResStatusName'] ?></option>

                            <?php
                        }
                    }
                    ?>


                </select>
            </div>



            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px"> Search </i> </button>
            </div>



        </div>
            </form>



    <div class="table-responsive">
        <?php
        $today = date('Y-m-d');
        
        $sql = "SELECT * FROM tbl_reservation r "
                . "LEFT JOIN tbl_event e ON e.EventId=r.EventId LEFT JOIN tbl_hall h ON h.HallId=r.HallId LEFT JOIN tbl_reservationstatus s ON s.ResStatusId=r.ReservationStatusId LEFT JOIN tbl_customers c ON c.CustomerId=r.CustomerId LEFT JOIN tbl_customer_title t ON t.TitleId=c.TitleId WHERE ReservationDate>='$today' AND ReservationStatusId=2 $where";
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Res No</th>
<!--                    <th scope="col">Reg No</th>-->
                    <th scope="col">Customer Name</th>
                    <th scope="col">Event</th>
                    <th scope="col">Reservation Date</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Guest Count</th>
                    <th scope="col">Hall</th>
                    <th scope="col">Status</th>
                    <th></th>

                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>

                        <tr>
                            <td></td>
                            <td><?= $row['ReservationNo'] ?></td>
        <!--                            <td></td>-->
                            <td><?= $row['TitleName'] . " " . $row['FirstName'] . " " . $row['LastName'] ?></td>
                            <td><?= $row['EventName'] ?></td>
                            <td><?= $row['ReservationDate'] ?></td>
                            <td><?= $row['FunctionStartTime'] ?></td>
                            <td><?= $row['FunctionEndTime'] ?></td>  
                            <td><?= $row['GuestCount'] ?></td>
                            <td><?= $row['HallName'] ?></td>
                            <td><?= $row['ResStatusName'] ?></td>
                           



                        </tr>

                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>





</main>
    
    
    
    
    

</main>

