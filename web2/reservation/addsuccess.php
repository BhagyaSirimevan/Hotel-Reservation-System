<?php
include '../dashboardheader.php';
include '../dashboardsidebar.php';
?>

<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
    <section>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <div class='alert alert-secondary' role='alert'>
                    <div class="row">
                        <div class='col-md-5'></div>
                        <div class='col-md-6'>
                            <img src="../assets/customer/assets/img/regsuccess.png" width="150px" height="150px" alt="alt"/>
                        </div>
                    </div>

                    <h1 class="text-center">Your Reservation Added Successfully..!</h1>


                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="row">

            <div class="col-md-4"></div>
            <div class="col-md-6">

                <div class="table-responsive">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        extract($_GET);
                     //     var_dump($_GET);

                        $newreservationid = $_GET['ReservationId'];

                        $sql = "SELECT * FROM tbl_reservation r LEFT JOIN tbl_event e ON e.EventId=r.EventId LEFT JOIN tbl_hall h ON h.HallId=r.HallId LEFT JOIN tbl_menupackage m ON m.MenuPackageId=r.MenuPackageId LEFT JOIN tbl_event_mode em ON em.EventModeId=r.EventModeId LEFT JOIN tbl_event_timeslot t ON t.EventModeId=em.EventModeId WHERE ReservationId='$newreservationid'";
                        //  print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        ?> 

                        <h4 class="text-lg-center text-danger">Your Reservation Details</h4>
                        <table class="table table-striped table-sm">
                            <thead class="bg-secondary text-lg text-white" >
                                <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Value</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    ?>  
                                    <tr>
                                        <td>Reservation No</td>
                                        <td><?= $row['ReservationNo'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Event</td>
                                        <td><?= $row['EventName'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Reservation Date</td>
                                        <td><?= $row['ReservationDate'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Function Start Time</td>
                                        <td><?= $row['FunctionStartTime'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Function End Time</td>
                                        <td><?= $row['FunctionEndTime'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Event Mode</td>
                                        <td><?= $row['EventModeName'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Hall</td>
                                        <td><?= $row['HallName'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Guest Count</td>
                                        <td><?= $row['GuestCount'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Menu Package</td>
                                        <td><?= $row['MenuPackageName'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Total Menu Package Price (Rs)</td>
                                        <td><?= number_format($row['TotalMenuPackagePrice'],2,'.') ?></td>

                                    </tr>

                                    <tr>
                                        <td>Total Service Price (Rs)</td>
                                        <td><?= number_format($row['TotalServicePrice'],2,'.') ?></td>

                                    </tr>

                                    <tr>
                                        <td>Total Additional Menu Item Price (Rs)</td>
                                        <td><?= number_format($row['TotalMenuItemPrice'],2,'.') ?></td>

                                    </tr>


                                    <tr>
                                        <td>Total Reservation Price (Rs)</td>
                                        <td><?= number_format($row['TotalReservationPrice'],2,'.') ?></td>

                                    </tr>

                                    <tr>
                                        <td>Tax (%)</td>
                                        <td><?= number_format($row['Tax'],2,'.') ?></td>

                                    </tr>

                                    <tr>
                                        <td>Discount (%)</td>
                                        <td><?= number_format($row['Discount'],2,'.') ?></td>

                                    </tr>



                                    <tr>
                                        <td>Last Reservation Price (Rs)</td>
                                        <td><?= number_format($row['LastReservationPrice'],2,'.') ?></td>

                                    </tr>


                                    <?php }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>


            </div>
            <div class="col-md-2"></div>

            



        </div>
        
        
         <div class="row mt-3">
                <div class="col-md-4"></div>
                <div class="col-md-8">
                     <strong class="text-danger">To confirm your reservation, please make your advance payment immediately..!</strong>

                </div>
               
         </div>
        
        <div class="row mt-3">
             <div class="col-md-4"></div>
            <div class="col-md-4">
            <a href="../customerdashboard.php" class="btn btn-warning">Make Payment Later</a>
                
            </div>
            <div class="col-md-4">
            <a href="../payment/add.php?ReservationNo=<?= $row['ReservationNo'] ?>" class="btn btn-success">Make Payment Now</a>
                
                
            </div>
            
        </div>



    </section>
</main>




<?php include '../dashboardfooter.php'; ?>

