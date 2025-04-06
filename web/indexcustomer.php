
<?php include 'dashboardheader.php'; ?>
<?php include 'dashboardsidebar.php'; ?>
<?php

if (!isset($_SESSION['userid'])){
    header('Location:login.php');
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
                 
                  <h5 class="card-title text-center">Your Booking History</h5>
        <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
<!--    <h2 class="card-title text-center">Your Booking History</h2>-->
    <div class="table-responsive">
        <?php
        
        $customerid = $_SESSION['customerid'] ;
       
        
        $sql = "SELECT * FROM tbl_reservation r "
                . "LEFT JOIN tbl_event e ON e.EventId=r.EventId LEFT JOIN tbl_hall h ON h.HallId=r.HallId LEFT JOIN tbl_reservationstatus s ON s.ResStatusId=r.ReservationStatusId WHERE CustomerId='$customerid'";
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
                    <th scope="col">Selected Hall</th>
                    <th scope="col">Status</th>

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
  <?php include 'dashboardfooter.php'; ?>