<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Reports</h1>

    </div>


    <h2>Reservation Report</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input
        $resno = cleanInput($resno);
        $cusname = cleanInput($cusname);
        $event = cleanInput($event);
        $guest = cleanInput($guest);
        $hall = cleanInput($hall);

        if (!empty($resno)) {
            $where .= " ReservationNo LIKE '%$resno%' AND";
        }

        if (!empty($cusname)) {
            $where .= " FirstName LIKE '%$cusname%' OR LastName LIKE '%$cusname%' AND";
        }
        
        if (!empty($regno)) {
            $where .= " RegNo LIKE '%$regno%' AND";
        }

        if (!empty($event)) {
            $where .= " r.EventId = '$event' AND";
        }

        if (!empty($resdatestart) && !empty($resdateend)) {
            $where .= " ReservationDate BETWEEN '$resdatestart' AND '$resdateend' AND";
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
            $where = "WHERE $where";
        }


        $sql2 = "SELECT * FROM tbl_reservation r "
                . "LEFT JOIN tbl_event e ON e.EventId=r.EventId LEFT JOIN tbl_hall h ON h.HallId=r.HallId LEFT JOIN tbl_reservationstatus s ON s.ResStatusId=r.ReservationStatusId LEFT JOIN tbl_customers c ON c.CustomerId=r.CustomerId LEFT JOIN tbl_customer_title t ON t.TitleId=c.TitleId $where";
        $db = dbConn();
        $result2 = $db->query($sql2);
    }
    ?>  

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

        <div class="row">
            
            <div class="col">
                <input type="text" class="form-control" placeholder="Reservation No" name="resno" >
            </div>

           

            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Customer Name" name="cusname" >
            </div>
            
             <div class="col">
                <input type="text" class="form-control" placeholder="Registration No" name="regno" >
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
                <input type="text" class="form-control" placeholder="Guest" name="guest" >
            </div>


           
            
        </div>
        
         
            
<div class="row mt-3">
    
    <div class="col">
                <input type="date" class="form-control" placeholder="Date" name="resdatestart" >
            </div>
    
            <div class="col">
                <input type="date" class="form-control" placeholder="Date" name="resdateend" >
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



            <div class="col-md-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px"> Search </i> </button>
            </div>



        </div>
            </form>



    <div class="table-responsive">


        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Res No</th>
<!--                    <th scope="col">Reg No</th>-->
                    <th scope="col">Customer Name</th>
                    <th scope="col">Customer Reg No</th>
                    <th scope="col">Event</th>
                    <th scope="col">Reservation Date</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Guest Count</th>
                    <th scope="col">Hall</th>
                    <th scope="col">Status</th>


                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST") {



                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                            ?>

                            <tr>
                                <td></td>
                                <td><?= $row['ReservationNo'] ?></td>
            <!--                            <td></td>-->
                                <td><?= $row['TitleName'] . " " . $row['FirstName'] . " " . $row['LastName'] ?></td>
                                <td><?= $row['RegNo'] ?></td>
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
                }
                ?>

            </tbody>
        </table>
    </div>





</main>


<?php include '../footer.php'; ?> 