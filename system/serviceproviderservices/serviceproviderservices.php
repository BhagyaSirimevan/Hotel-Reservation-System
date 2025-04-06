<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Service Provider Services Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <?php
                if ($_SESSION['userrole'] == "Owner") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Service Provider Service</a>

                    <?php
                } elseif ($_SESSION['userrole'] == "Receptionist") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Service Provider Service</a>

                    <?php
                }
                ?>


            </div>

        </div>
    </div>

    <h2>Service Provider Services List</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input

        if (!empty($regno)) {
            $where .= " RegNo LIKE '%$regno%' AND";
        }

        if (!empty($brname)) {
            $where .= " BusinessName LIKE '%$brname%' AND";
        }

        if (!empty($provideservice)) {
            $where .= " v.ServiceName LIKE '%$provideservice%' AND";
        }

        if (!empty($name)) {
            $where .= " Name LIKE '%$name%' AND";
        }

    
        if (!empty($status)) {
            $where .= " Status LIKE '%$status%' AND";
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
                <input type="text" class="form-control" placeholder="Reg No" name="regno">
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="Business Name" name="brname">
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="Provide Service" name="provideservice">
            </div>


            <div class="col">
                <input type="text" class="form-control" placeholder="Name" name="name">
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

    <div class="table-responsive mt-3">
        <?php
        
        $sql = "SELECT * FROM tbl_serviceproviderservice s LEFT JOIN tbl_providerservicelist l ON l.ProvideServiceListId=s.ProvideServiceListId LEFT JOIN tbl_service v ON v.ServiceId=l.ServiceId $where";
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Reg No</th>
                    <th scope="col">Business Name</th>
                    <th scope="col">Provide Service</th>
                    <th scope="col">Name</th>
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
                            <td><?= $row['RegNo'] ?></td>
                            <td><?= $row['BusinessName'] ?></td>
                            <td><?= $row['ServiceName'] ?></td>
                            <td><?= $row['Name'] ?></td>
                         
                            <td><img class="img-fluid" width="100" src="<?= SYSTEM_PATH ?>assets/images/provideservices/<?= $row['SampleImage'] ?>"></td>
                           
                          
                            <td><?= $row['Status'] == "Available" ? "Available" : "Not Available" ?></td> 

                            <?php
                            if ($_SESSION['userrole'] == "Owner") {
                                ?>
                                <td><a href="edit.php?ProviderServiceId=<?= $row['ProviderServiceId'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit" style="font-size:15px"></i> </a></td>

                                <?php
                            } elseif ($_SESSION['userrole'] == "Receptionist") {
                                ?>
                                <td><a href="edit.php?ProviderServiceId=<?= $row['ProviderServiceId'] ?>" class="btn btn-warning btn-sm">
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
