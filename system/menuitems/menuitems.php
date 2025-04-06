<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Menu Item Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">

                <?php
                if ($_SESSION['userrole'] == "Owner") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Menu Item</a>

                    <?php
                } elseif ($_SESSION['userrole'] == "Manager") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Menu Item</a>

                    <?php
                }
                ?>



            </div>

        </div>
    </div>

    <h2>Menu Item List</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input
        $itemcategory = cleanInput($itemcategory);
        $itemname = cleanInput($itemname);
        $itemcost = cleanInput($itemcost);
        $profitratio = cleanInput($profitratio);
        $portionprice = cleanInput($portionprice);

        if (!empty($itemcategory)) {
            $where .= " m.MenuItemCategoryId = '$itemcategory' AND";
        }

        if (!empty($itemname)) {
            $where .= " MenuItemName LIKE '%$itemname%' AND";
        }

        if (!empty($itemcost)) {
            $where .= " MenuItemCost LIKE '%$itemcost%' AND";
        }

        if (!empty($profitratio)) {
            $where .= " ProfitRatio LIKE '%$profitratio%' AND";
        }

        if (!empty($portionprice)) {
            $where .= " PortionPrice LIKE '%$portionprice%' AND";
        }

        if (!empty($MenuItemStatus)) {
            $where .= " MenuItemStatus LIKE '$MenuItemStatus' AND";
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
                $sql = "SELECT * FROM tbl_menuitem_category";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="itemcategory" name="itemcategory">
                    <option value="">Select Category</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['MenuItemCategoryId']; ?> <?php if ($row['MenuItemCategoryId'] == @$itemcategory) { ?>selected <?php } ?>><?= $row['CategoryName'] ?></option>


                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Menu Item Name" name="itemname">
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="Item Cost" name="itemcost" >
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Profit Ratio" name="profitratio" >
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="Portion Price" name="portionprice" >
            </div>

            <div class="col-md-1">

                <select class="form-select" id="item_status" name="MenuItemStatus">
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
        $sql = "SELECT * FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId $where";
//print_r($sql);
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Item Category</th>
                    <th scope="col">Menu Item Name</th>
                    <?php
                    if ($_SESSION['userrole'] == "Owner") {
                        ?>
                       <th scope="col">Item Cost (Rs)</th>
                        <?php
                    } elseif ($_SESSION['userrole'] == "Manager") {
                        ?>
                       <th scope="col">Item Cost (Rs)</th>
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


                  
                   
                    <th scope="col">Portion Price (Rs) </th>
                    <th scope="col">Item Image</th>
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
                            <td><?= $row['CategoryName'] ?></td>
                            <td><?= $row['MenuItemName'] ?></td>

                            <?php
                            if ($_SESSION['userrole'] == "Owner") {
                                ?>
                                <td><?= $row['MenuItemCost'] ?></td>
                                <?php
                            } elseif ($_SESSION['userrole'] == "Manager") {
                                ?>
                                <td><?= $row['MenuItemCost'] ?></td>
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



                           
                            <td><?= $row['PortionPrice'] ?></td>
                            <td><img class="img-fluid" width="100" src="<?= SYSTEM_PATH ?>assets/images/menuitem/<?= $row['MenuItemImage'] ?>"></td>
                            <td><?= $row['MenuItemStatus'] == "Available" ? "Available" : "Not Available" ?></td> 

                            <?php
                            if ($_SESSION['userrole'] == "Owner") {
                                ?>
                                <td><a href="edit.php?MenuItemId=<?= $row['MenuItemId'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit" style="font-size:15px"></i> </a></td>
                                <?php
                            } elseif ($_SESSION['userrole'] == "Manager") {
                                ?>
                                <td><a href="edit.php?MenuItemId=<?= $row['MenuItemId'] ?>" class="btn btn-warning btn-sm">
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