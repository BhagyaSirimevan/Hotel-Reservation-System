
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>

<?php
$where = null;
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    extract($_POST);

    // 3rd step- clean input
    // $resno = cleanInput($resno);
    // $regno = cleanInput($regno);
//        $cusname = cleanInput($cusname);
//        $event = cleanInput($event);
//        $resdate = cleanInput($resdate);
//        $time = cleanInput($time);
//        $guest = cleanInput($guest);
//        $hall = cleanInput($hall);

    

    if (!empty($resno)) {
        $where .= " r.ReservationNo LIKE '%$resno%' AND";
    }


    if (!empty($event)) {
        $where .= " e.EventId = '$event' AND";
    }

    if (!empty($resdate)) {
        $where .= " r.ReservationDate = '$resdate' AND";
    }


    if (!empty($themecolor)) {
        $where .= " t.ThemeColorId = '$themecolor' AND";
    }
    
  

    if (!empty($status)) {
        $where .= " s.ArrangeStatusId = '$status' AND";
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
        <h1>Payment</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="indexcustomer.php">Home</a></li>
                <li class="breadcrumb-item active">Hall Arrangement</li>


            </ol>
        </nav>
    </div>

    <section class="section dashboard">

        <div class="row mt-4">

            <div class="col-md-12">

                <div class="card">
                    <div class="row mt-4">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <a href="confirmedreservations.php" class="btn btn-success"><i class="bi bi-plus">Hall Arrangement Request</i></a> 

                        </div>
                    </div>

                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->

                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                <div class="card-title text-center"><h3>Your Hall Arrangement Request</h3></div>
                                <div class="row">

                                    <!-- Left side columns -->
                                    <div class="col-lg-12">
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

                                            <div class="row">

                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" placeholder="Reservation No" name="resno" >
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
                                                    <?php
                                                    $db = dbConn();
                                                    $sql = "SELECT * FROM tbl_themecolor";
                                                    $result = $db->query($sql);
                                                    ?>

                                                    <select class="form-select" id="themecolor" name="themecolor">
                                                        <option value="">Select Theme Color</option>

                                                        <?php
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                ?>

                                                                <option value=<?= $row['ThemeColorId']; ?> <?php if ($row['ThemeColorId'] == @$themecolor) { ?>selected <?php } ?>><?= $row['ColourName'] ?></option>


                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                               
                                                </div>
                                                
                                                

                                                <div class="col">
                                                    <?php
                                                    $db = dbConn();
                                                    $sql = "SELECT * FROM tbl_hallarrangestatus";
                                                    $result = $db->query($sql);
                                                    ?>

                                                    <select class="form-select" id="status" name="status">
                                                        <option value="">Select Status</option>

                                                        <?php
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                ?>

                                                                <option value=<?= $row['ArrangeStatusId']; ?> <?php if ($row['ArrangeStatusId'] == @$status) { ?>selected <?php } ?>><?= $row['ArrangeStatusName'] ?></option>

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
                                            <div class="table-responsive">
                                                <?php
                                                $customerid = $_SESSION['customerid'];

                                                $sql = "SELECT * FROM tbl_hallarrangerequest a LEFT JOIN tbl_event e ON e.EventId=a.EventId "
                                                        . "LEFT JOIN tbl_themecolor t ON t.ThemeColorId=a.ThemeColorId "
                                                        . "                LEFT JOIN tbl_reservation r ON r.ReservationNo=a.ReservationNo "
                                                        . "                LEFT JOIN tbl_hallarrangestatus s ON s.ArrangeStatusId=a.ArrangeStatusId "
                                                        . "WHERE r.CustomerId='$customerid' $where";
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
                                                            <th scope="col">Theme Color</th>
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
                                                                    <td><?= $row['ColourName'] ?></td>  
                                                                
                                                                   
                                                                    <td><?= $row['ArrangeStatusName'] ?></td>





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