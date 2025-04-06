<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Hall Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">

                <?php
                if ($_SESSION['userrole'] == "Owner") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>
                        New Hall</a>

                    <?php
                }
                ?>

            </div>

        </div>
    </div>

    <h2>Hall List</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input

        $hallname = cleanInput($hallname);
        $minguest = cleanInput($minguest);
        $maxguest = cleanInput($maxguest);
        $avafeatures = cleanInput($avafeatures);
        $hallstatus = cleanInput($hallstatus);

        if (!empty($hallname)) {
            $where .= " HallName LIKE '%$hallname%' AND";
        }

        if (!empty($minguest)) {
            $where .= " MinGuestCount LIKE '%$minguest%' AND";
        }

        if (!empty($maxguest)) {
            $where .= " MaxGuestCount LIKE '%$maxguest%' AND";
        }

        if (!empty($avafeatures)) {
            $where .= " AvailableFeatures LIKE '%$avafeatures%' AND";
        }

        if (!empty($hallstatus)) {
            $where .= " HallStatus LIKE '$hallstatus' AND";
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

            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Hall Name" name="hallname">
            </div>

            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Minimum Guest" name="minguest" >
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Maximum Guest" name="maxguest" >
            </div>

            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Available Features" name="avafeatures" >
            </div>

            <div class="col-md-2">


                <select class="form-select" id="item_status" name="hallstatus">
                    <option value="">Select Status</option>

                    <option>Available</option>
                    <option>Not Available</option>

                </select>

            </div>


            <div class="col-md-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px"> Search</i> </button>
            </div>

        </div>

    </form>





    <div class="table-responsive">
<?php
$sql = "SELECT * FROM tbl_hall $where";

$db = dbConn();
$result = $db->query($sql);
?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Hall Name</th>
                    <th scope="col">Minimum Guest</th>
                    <th scope="col">Maximum Guest</th>
                    <th scope="col">Available Features</th>
                    <th scope="col">Hall Status</th>
                    <th scope="col">Hall Image</th>


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
                            <td><?= $row['HallName'] ?></td>
                            <td><?= $row['MinGuestCount'] ?></td>
                            <td><?= $row['MaxGuestCount'] ?></td> 
                            <td><?php
                $featureslist = explode(",", $row['AvailableFeatures']);
                echo '<ul>';
                foreach ($featureslist as $value) {
                    echo '<li>' . $value . '</li>';
                }
                echo '</ul>';
        ?>
                            </td>
                            <td><?= $row['HallStatus'] == "Available" ? "Available" : "Not Available" ?></td>  
                            <td><img class="img-fluid" width="100" src="<?= SYSTEM_PATH ?>assets/images/hall/<?= $row['HallImage'] ?>"></td>

                                <?php
                                if ($_SESSION['userrole'] == "Owner") {
                                    ?>
                         <td><a href="edit.php?HallId=<?= $row['HallId'] ?>" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit" style="font-size:15px"></i> </a></td>

                                <?php
                            }
                            ?>


                  


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