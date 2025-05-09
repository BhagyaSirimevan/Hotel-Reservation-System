
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>
<?php

if (!isset($_SESSION['userid'])){
    header('Location:login.php');
}

?>

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




<main id="main" class="main">
    
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="indexcustomer.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
         
        
        </ol>
      </nav>
    </div>
 
 <section class="section dashboard">
      <div class="row">
       
        <div class="col-md-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                 
                    <div class="card-title text-center"><h3>Your Confirmed Reservations</h3></div>
        <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

        <div class="row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Res No" name="resno" >
            </div>
            <!--            <div class="col">
                            <input type="text" class="form-control" placeholder="Reg No" name="regno" >
                        </div>-->

           
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
                $sql = "SELECT * FROM tbl_hall WHERE HallStatus='Available'";
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
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px"> Search </i> </button>
            </div>



        </div>
            </form>
          <div class="row">
<!--    <h2 class="card-title text-center">Your Booking History</h2>-->
    <div class="table-responsive">
        <?php
        
        $customerid = $_SESSION['customerid'] ;
       
        $sql = "SELECT * FROM tbl_reservation r "
                . "LEFT JOIN tbl_event e ON e.EventId=r.EventId LEFT JOIN tbl_hall h ON h.HallId=r.HallId LEFT JOIN tbl_reservationstatus s ON s.ResStatusId=r.ReservationStatusId LEFT JOIN tbl_respayment_status ps ON ps.ResPaymentStatusId=r.ResPaymentStatusId WHERE r.ReservationStatusId=2 AND CustomerId='$customerid' $where";
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Reservation No</th>
                     <th scope="col">Event</th>
                    <th scope="col">Reservation Date</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Guest Count</th>
                    <th scope="col">Hall</th>
                    <th scope="col">Reservation Status</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col"></th>
                    <th scope="col"></th>

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
                            <td><?= $row['EventName'] ?></td>
                            <td><?= $row['ReservationDate'] ?></td>
                            <td><?= $row['FunctionStartTime'] ?></td>
                            <td><?= $row['FunctionEndTime'] ?></td>  
                            <td><?= $row['GuestCount'] ?></td>
                            <td><?= $row['HallName'] ?></td>
                            <td><?= $row['ResStatusName'] ?></td>
                            <td><?= $row['ResPaymentStatusName'] ?></td>
                            <td><a href="add.php?ReservationNo=<?= $row['ReservationNo'] ?>" class="btn btn-success btn-sm">
                                                                            Hall Arrangement Request </a></td>
                           


                        </tr>

                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
        
          </div>
        </div>
      </div>
              
                </div>


              </div>

            </div>
          </div>

        </div>
      </div>
    </section>    
    
</main>
  

  

  <!-- ======= Footer ======= -->
  <?php include '../dashboardfooter.php'; ?>