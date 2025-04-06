
<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Customer Payment Management </h1>

    </div>
 
      <div class="row">
       
        <div class="col-md-12">

      

                 
                 <h2>Your Pending Reservations</h2>
        <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
<!--    <h2 class="card-title text-center">Your Booking History</h2>-->
    <div class="table-responsive">
        <?php
        
    
       
        $sql = "SELECT r.ReservationNo,e.EventName,r.ReservationDate,r.FunctionStartTime,r.FunctionEndTime,r.GuestCount,h.HallName,s.ResStatusName,rp.ResPaymentStatusName,p.PaymentStatusId FROM tbl_reservation r "
             . "LEFT JOIN tbl_event e ON e.EventId=r.EventId "
             . "LEFT JOIN tbl_hall h ON h.HallId=r.HallId "
             . "LEFT JOIN tbl_reservationstatus s ON s.ResStatusId=r.ReservationStatusId "
             . "LEFT JOIN tbl_respayment_status rp ON rp.ResPaymentStatusId=r.ResPaymentStatusId "
             . "LEFT JOIN tbl_customerpayments p ON p.ReservationNo=r.ReservationNo "
             . "WHERE "
             . "((r.ResPaymentStatusId=1 AND r.ReservationStatusId=1 AND r.ReservationNo NOT IN (SELECT ReservationNo FROM tbl_customerpayments )) OR "
                . "(r.ResPaymentStatusId=1 AND r.ReservationStatusId=1 AND p.PaymentStatusId=3) OR"
             . "(r.ResPaymentStatusId=2 AND r.ReservationStatusId=2 AND p.PaymentStatusId=2) OR "
                . "(r.ResPaymentStatusId=2 AND r.ReservationStatusId=2 AND p.PaymentStatusId=3) OR "
                . "(r.ResPaymentStatusId=2 AND r.ReservationStatusId=2 AND p.PaymentStatusId=5))";
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
                                  Make Payment</a></td>

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
   
    
</main>
  

  
<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>