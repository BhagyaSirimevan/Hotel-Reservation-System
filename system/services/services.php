<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Service Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <?php
                if ($_SESSION['userrole'] == "Owner") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Service</a>

                    <?php
                } elseif ($_SESSION['userrole'] == "Manager") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Service</a>

                    <?php
                }
                ?>


            </div>

        </div>
    </div>

    <h2>Service List</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input
        $servicename = cleanInput($servicename);
        $serviceprice = cleanInput($serviceprice);
        $profitratio = cleanInput($profitratio);
        $servicelastprice = cleanInput($servicelastprice);
        $servicestatus = cleanInput($servicestatus);

        if (!empty($servicename)) {
            $where .= " ServiceName LIKE '%$servicename%' AND";
        }

        if (!empty($servicetype)) {
            $where .= " ServiceType LIKE '%$servicetype%' AND";
        }

        if (!empty($serviceprice)) {
            $where .= " ServicePrice LIKE '%$serviceprice%' AND";
        }

        if (!empty($profitratio)) {
            $where .= " ProfitRatio LIKE '%$profitratio%' AND";
        }

        if (!empty($servicelastprice)) {
            $where .= " ServiceLastPrice LIKE '%$servicelastprice%' AND";
        }

        if (!empty($servicestatus)) {
            $where .= " ServiceStatus LIKE '$servicestatus' AND";
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
                <input type="text" class="form-control" placeholder="Service Name" name="servicename">
            </div>

            <div class="col">

                <select class="form-select" id="servicetype" name="servicetype">
                    <option value="">Select Type</option>

                    <option>Payable</option>
                    <option>Free</option>

                </select>

            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="Service Price" name="serviceprice" >
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Profit Ratio" name="profitratio" >
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="Service Last Price" name="servicelastprice" >
            </div>

            <div class="col">

                <select class="form-select" id="item_status" name="servicestatus">
                    <option value="">Select Status</option>

                    <option>Available</option>
                    <option>Not Available</option>

                </select>

            </div>


            <div class="col-md-1">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px">Search</i> </button>
            </div>

        </div>

    </form>





    <div class="table-responsive">
        <?php
        $sql = "SELECT * FROM tbl_service $where";

        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Service Name</th>
                    <th scope="col">Service Type</th>
                    <?php
                    if ($_SESSION['userrole'] == "Owner") {
                        ?>
                        <th scope="col">Service Price (Rs)</th>
                        <?php
                    } elseif ($_SESSION['userrole'] == "Manager") {
                        ?>
                        <th scope="col">Service Price (Rs)</th>
                        <?php
                    }
                    ?>

                    <?php
                    if ($_SESSION['userrole'] == "Owner") {
                        ?>
                        <th scope="col">Profit Ratio (%)</th>
                        <?php
                    } elseif ($_SESSION['userrole'] == "Manager") {
                        ?>
                        <th scope="col">Profit Ratio (%)</th>
                        <?php
                    }
                    ?>



                    <th scope="col">Service Last Price (Rs) </th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>

                    <th></th>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>

                        <tr>
                            <td></td>

                            <td><?= $row['ServiceName'] ?></td>
                            <td><?= $row['ServiceType'] ?></td>
                            <?php
                            if ($_SESSION['userrole'] == "Owner") {
                                ?>
                                <td><?= $row['ServicePrice'] ?></td>
                                <?php
                            } elseif ($_SESSION['userrole'] == "Manager") {
                                ?>
                                <td><?= $row['ServicePrice'] ?></td>
                                <?php
                            }
                            ?>
                                
                             <?php
                            if ($_SESSION['userrole'] == "Owner") {
                                ?>
                                <td><?= $row['ProfitRatio'] ?></td>  
                                <?php
                            } elseif ($_SESSION['userrole'] == "Manager") {
                                ?>
                                <td><?= $row['ProfitRatio'] ?></td>  
                                <?php
                            }
                            ?>



                          
                            <td><?= $row['ServiceLastPrice'] ?></td>
                            <td><?= $row['ServiceStatus'] == "Available" ? "Available" : "Not Available" ?></td> 

                            <?php
                            if ($_SESSION['userrole'] == "Owner") {
                                ?>
                                <td><a href="edit.php?ServiceId=<?= $row['ServiceId'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit" style="font-size:15px"></i> </a></td>

                                <?php
                            } elseif ($_SESSION['userrole'] == "Manager") {
                                ?>
                                <td><a href="edit.php?ServiceId=<?= $row['ServiceId'] ?>" class="btn btn-warning btn-sm">
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