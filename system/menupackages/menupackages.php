<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Menu Package Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <?php
                if ($_SESSION['userrole'] == "Owner") {
                    ?>

                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Menu Package</a>

                    <?php
                } elseif ($_SESSION['userrole'] == "Manager") {
                    ?>

                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Menu Package</a>

                    <?php
                }
                ?>




            </div>

        </div>
    </div>

    <h2>Menu Package List</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input
        $packagetype = cleanInput($packagetype);
        $packagename = cleanInput($packagename);
        $plateprice = cleanInput($plateprice);
        $servicecharge = cleanInput($servicecharge);
        $platelastprice = cleanInput($platelastprice);

        if (!empty($packagetype)) {
            $where .= " m.PackageTypeId = '$packagetype' AND";
        }

        if (!empty($packagename)) {
            $where .= " MenuPackageName LIKE '%$packagename%' AND";
        }

        if (!empty($plateprice)) {
            $where .= " PlatePrice LIKE '%$plateprice%' AND";
        }

        if (!empty($servicecharge)) {
            $where .= " ServiceCharge LIKE '%$servicecharge%' AND";
        }

        if (!empty($platelastprice)) {
            $where .= " PlateLastPrice LIKE '%$platelastprice%' AND";
        }

        if (!empty($MenuPackageStatus)) {
            $where .= " MenuPackageStatus LIKE '$MenuPackageStatus' AND";
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



                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_packagetype";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="packagetype" name="packagetype">
                    <option value="">Select Package Type</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['PackageTypeId']; ?> <?php if ($row['PackageTypeId'] == @$packagetype) { ?>selected <?php } ?>><?= $row['PackageTypeName'] ?></option>


                            <?php
                        }
                    }
                    ?>
                </select> 



            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Menu Package Name" name="packagename">
            </div>


            <div class="col">
                <input type="text" class="form-control" placeholder="Plate Price" name="plateprice" >
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="Service Charge" name="servicecharge" >
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="Plate Last Price" name="platelastprice" >
            </div>

            <div class="col-md-1">

                <select class="form-select" id="item_status" name="MenuPackageStatus">
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
        $sql = "SELECT * FROM tbl_menupackage m LEFT JOIN tbl_packagetype t ON t.PackageTypeId=m.PackageTypeId $where";
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Menu Package Type</th>
                    <th scope="col">Menu Package Name</th>
                    <?php
                    if ($_SESSION['userrole'] == "Owner") {
                        ?>
                        <th scope="col">Plate Price (Rs)</th>
                        <?php
                    } elseif ($_SESSION['userrole'] == "Manager") {
                        ?>
                        <th scope="col">Plate Price (Rs)</th>
                        <?php
                    }
                    ?>
                        
                    <?php
                    if ($_SESSION['userrole'] == "Owner") {
                        ?>
                        <th scope="col">Service Charge (%)</th>
                        <?php
                    } elseif ($_SESSION['userrole'] == "Manager") {
                        ?>
                       <th scope="col">Service Charge (%)</th>
                        <?php
                    }
                    ?>




                   
                    <th scope="col">Plate Last Price (Rs) </th>
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
                            <td><?= $row['PackageTypeName'] ?></td>
                            <td><?= $row['MenuPackageName'] ?></td>
                            <?php
                            if ($_SESSION['userrole'] == "Owner") {
                                ?>
                                <td><?= $row['PlatePrice'] ?></td>
                                <?php
                            } elseif ($_SESSION['userrole'] == "Manager") {
                                ?>
                                <td><?= $row['PlatePrice'] ?></td>
                                <?php
                            }
                            ?>
                                
                            <?php
                            if ($_SESSION['userrole'] == "Owner") {
                                ?>
                             <td><?= $row['ServiceCharge'] ?></td>  
                                <?php
                            } elseif ($_SESSION['userrole'] == "Manager") {
                                ?>
                               <td><?= $row['ServiceCharge'] ?></td>  
                                <?php
                            }
                            ?>


                           
                            <td><?= $row['PlateLastPrice'] ?></td>
                            <td><?= $row['MenuPackageStatus'] == "Available" ? "Available" : "Not Available" ?></td> 

                            <?php
                            if ($_SESSION['userrole'] == "Owner") {
                                ?>

                                <td><a href="edit.php?MenuPackageId=<?= $row['MenuPackageId'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit" style="font-size:15px"></i> </a></td>

                                <?php
                            } elseif ($_SESSION['userrole'] == "Manager") {
                                ?>

                                <td><a href="edit.php?MenuPackageId=<?= $row['MenuPackageId'] ?>" class="btn btn-warning btn-sm">
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