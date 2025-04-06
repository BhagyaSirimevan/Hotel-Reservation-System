<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Event Theme Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Theme Color</a>

            </div>

        </div>
    </div>

    <h2>Event Theme List</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input


        if (!empty($event)) {
            $where .= " e.EventId = '$event' AND";
        }
        
        if (!empty($themecolor)) {
            $where .= " ColourName LIKE '%$themecolor%' AND";
        }

        if (!empty($status)) {
            $where .= " ThemeStatus LIKE '%$status%' AND";
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

        <div class="row mb-3"> 

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
                <input type="text" class="form-control" placeholder="Theme Color" name="themecolor">
            </div>

            <div class="col">

                <select class="form-select" id="status" name="status">
                    <option value="">Select Status</option>

                    <option>Available</option>
                    <option>Not Available</option>

                </select>

            </div>

            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px">Search</i> </button>
            </div>



        </div>



    </form>



    <div class="table-responsive mt-4">
        <?php
        $sql = "SELECT * FROM tbl_themecolor t LEFT JOIN tbl_event e ON e.EventId=t.EventId $where";
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Event</th>
                    <th scope="col">Theme Color Name</th>
                    <th scope="col">Sample Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>

                        <tr>
                            <td></td>
                            <td><?= $row['EventName'] ?></td>
                            <td><?= $row['ColourName'] ?></td>
                            <td><img class="img-fluid" width="200" src="<?= SYSTEM_PATH ?>assets/images/eventthems/<?= $row['HallImage'] ?>"></td>
                            <td><?= $row['ThemeStatus'] == "Available" ? "Available" : "Not Available" ?></td>  
                            <td><a href="edit.php?ThemeColorId=<?= $row['ThemeColorId'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit" style="font-size:15px"></i> </a></td>


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

