
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>
<?php

//if (!isset($_SESSION['userid'])){
//    header('Location:login.php');
//}

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
                 
                    <div class="card-title text-center"><h3>Your Pending Reservations</h3></div>
        <div class="row">

      
        <div class="col-lg-12">
          <div class="row">
<!--    <h2 class="card-title text-center">Your Booking History</h2>-->
    <div class="table-responsive">
        <?php
        
       $customerid = $_SESSION['customerid'] ;
       
       $sql = "SELECT r.ReservationNo,e.EventName,r.ReservationDate,r.FunctionStartTime,r.FunctionEndTime,r.GuestCount,h.HallName,s.ResStatusName,rp.ResPaymentStatusName,p.PaymentStatusId FROM tbl_reservation r "
             . "LEFT JOIN tbl_event e ON e.EventId=r.EventId "
             . "LEFT JOIN tbl_hall h ON h.HallId=r.HallId "
             . "LEFT JOIN tbl_reservationstatus s ON s.ResStatusId=r.ReservationStatusId "
             . "LEFT JOIN tbl_respayment_status rp ON rp.ResPaymentStatusId=r.ResPaymentStatusId "
             . "LEFT JOIN tbl_customerpayments p ON p.ReservationNo=r.ReservationNo "
             . "WHERE CustomerId='$customerid' AND "
             . "((r.ResPaymentStatusId=1 AND r.ReservationStatusId=1 AND r.ReservationNo NOT IN (SELECT ReservationNo FROM tbl_customerpayments )) OR "
                . "(r.ResPaymentStatusId=1 AND r.ReservationStatusId=1 AND p.PaymentStatusId=3) OR"
             . "(r.ResPaymentStatusId=2 AND r.ReservationStatusId=2 AND p.PaymentStatusId=2) OR "
                . "(r.ResPaymentStatusId=2 AND r.ReservationStatusId=2 AND p.PaymentStatusId=3 )) ";
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

            </div>
          </div>

        </div>
      </div>
    </section>    
    
</main>
  

  

  <!-- ======= Footer ======= -->
  <?php include '../dashboardfooter.php'; ?>