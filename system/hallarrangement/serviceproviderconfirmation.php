<?php
session_start();

include '../config.php';
include '../function.php';
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nectar Mount Resort - Dashboard</title>
        <link href="<?= SYSTEM_PATH ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= SYSTEM_PATH ?>assets/css/dashboard.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <header class="navbar navbar-dark sticky-top bg-success flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#"><h5>Nectar Mount Resort</h5></a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


        </header>
        <div class="container-fluid">
            <div class="row">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    extract($_GET);
                    //  var_dump($_GET);

                    $HallArrangementId = $_GET['HallArrangementId'];

                    $db = dbConn();
                    $sql = "SELECT * FROM tbl_hallarrangement a LEFT JOIN tbl_hallarrangerequest r ON r.RequestId=a.RequestId "
                            . "LEFT JOIN tbl_event e ON e.EventId=r.EventId "
                            . "LEFT JOIN tbl_reservation rv ON rv.ReservationNo=r.ReservationNo "
                            . "LEFT JOIN tbl_hall h ON h.HallId=rv.HallId "
                            . "WHERE HallArrangementId='$HallArrangementId'";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $resno = $row['ReservationNo'];
                            $event = $row['EventId'];
                            $hall = $row['HallId'];
                            $resdate = $row['ReservationDate'];
                            $HallArrangementId = $row['HallArrangementId'];
                        }
                    }
                }

                extract($_POST);
                // var_dump($_FILES);
                if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
                    //  var_dump($_POST);
                    $message = array();

                    if (empty($message)) {

                        $db = dbConn();
                        $cdate = date('Y-m-d');
                        $sql = "UPDATE tbl_hallarrangement SET $StatusColumn='$status',UpdateDate='$cdate' WHERE HallArrangementId='$HallArrangementId'";

                        //  print_r($sql);

                        $db->query($sql);
                        
                          header('Location:confirmsuccess.php');
                        
                    }
                }
                ?>


                <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                    <input type="hidden" name="HallArrangementId" value="<?= $HallArrangementId ?>"> 
                    <input type="hidden" name="StatusColumn" value="<?= $StatusColumn ?>"> 



                    <div class="row mt-4">
                        <h2 class="text-center">Service Confirmation</h2>
                    </div>


                    <div class="col-md-8">


                        <div class="row mt-4">

                            <div class="col-md-5"></div>
                            <div class="col-md-3">
                                <label for="resno" class="form-label">Reservation No</label>
                            </div>

                            <div class="col-md-4">


                                <input type="text" class="form-control" id="resno" name="resno" value="<?= @$resno ?>" readonly>
                                <div class="text-danger">
                                    <?= @$message['error_resno'] ?>  
                                </div>
                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="col-md-5"></div>
                            <div class="col-md-3 mb-2">
                                <label for="event" class="form-label">Event</label>
                            </div>

                            <div class="col-md-4 mb-2">

                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_event WHERE EventId='$event'";
                                $result = $db->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();

                                    $event = $row['EventId'];
                                }
                                ?>

                                <input type="text" class="form-control" id="event" name="event" value="<?= $row['EventName'] ?>" readonly>
                                <input type="hidden" id="event" name="event" value="<?= $event ?>"> 

                            </div>
                        </div>



                        <div class="row mt-2">
                            <div class="col-md-5"></div>
                            <div class="col-md-3 mb-2">
                                <label for="resdate" class="form-label">Reservation Date</label>
                            </div>
                            <div class="col-md-4 mb-2">

                                <input type="text" class="form-control" id="resdate" name="resdate" value="<?= @$resdate ?>" readonly>


                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-5"></div>
                            <div class="col-md-3 mb-2">
                                <label for="time" class="form-label">Reservation Time</label>
                            </div>

                            <div class="col-md-4 mb-2">

                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_reservation WHERE ReservationNo='$resno'";
                                $result = $db->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();

                                   
                                }
                                ?>

                                <input type="text" class="form-control" id="time" name="time" value="<?= $row['FunctionStartTime']." - ".$row['FunctionEndTime'] ?>" readonly>
                            

                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-5"></div>
                            <div class="col-md-3 mb-2">
                                <label for="hall" class="form-label">Hall</label>
                            </div>

                            <div class="col-md-4 mb-2">

                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hall WHERE HallId='$hall'";
                                $result = $db->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();

                                   
                                }
                                ?>

                                <input type="text" class="form-control" id="hall" name="hall" value="<?= $row['HallName'] ?>" readonly>
                              <input type="hidden" id="hall" name="hall" value="<?= $hall ?>"> 


                            </div>
                        </div>
                        
                        
                        

                        <div class="row mt-2">
                            <div class="col-md-5"></div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Select Status<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_hallarrangestatus WHERE ArrangeStatusId!=1 && ArrangeStatusId!=2";
                                $result = $db->query($sql);
                                ?>

                                <select class="form-select" id="status" name="status" onchange="form.submit()">
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


                                <div class="text-danger">
                                    <?= @$message['error_status'] ?>  
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-10"></div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Submit</button>

                            </div>
                        </div>


                    </div>
                    <div class="col-md-4"></div>





                </form>


            </div>
        </div>


        <?php include '../footer.php'; ?> 
