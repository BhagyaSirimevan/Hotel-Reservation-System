<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Hall Arrangement</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="arrangementrequest.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Arrangement</a>
            </div>

        </div>
    </div>

    <h2>Hall Arrangement List</h2>

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
            $where = "WHERE $where";
        }
    }
    ?>


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





    <div class="table-responsive">
        <?php
        $sql = "SELECT * FROM tbl_hallarrangerequest a LEFT JOIN tbl_event e ON e.EventId=a.EventId "
                . "LEFT JOIN tbl_themecolor t ON t.ThemeColorId=a.ThemeColorId "
                . "                LEFT JOIN tbl_reservation r ON r.ReservationNo=a.ReservationNo "
                . "                LEFT JOIN tbl_hallarrangestatus s ON s.ArrangeStatusId=a.ArrangeStatusId "
                . " $where";
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
</main>

<?php include '../footer.php'; ?> 