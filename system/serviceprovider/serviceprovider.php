<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Service Provider Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <?php
                if ($_SESSION['userrole'] == "Owner") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Service Provider</a>

                    <?php
                } elseif ($_SESSION['userrole'] == "Receptionist") {
                    ?>
                    <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Service Provider</a>

                    <?php
                }
                ?>


            </div>

        </div>
    </div>

    <h2>Service Provider List</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input
        
        if (!empty($regno)) {
            $where .= " RegNo LIKE '%$regno%' AND";
        }

        if (!empty($serviceprovider)) {
            $where .= " FirstName LIKE '%$serviceprovider%' OR LastName LIKE '%$serviceprovider%' AND";
        }
        
        if (!empty($brname)) {
            $where .= " BusinessName LIKE '%$brname%' AND";
        }


        if (!empty($brnumber)) {
            $where .= " BRNumber LIKE '%$brnumber%' AND";
        }

        if (!empty($contactno)) {
            $where .= " ContactNo LIKE '%$contactno%' AND";
        }

        if (!empty($email)) {
            $where .= " Email LIKE '%$email%' AND";
        }
        
        

       
        if (!empty($agreementstart)) {
            $where .= " AgreementStartDate = '$agreementstart' AND";
        }

        if (!empty($agreementend)) {
            $where .= " AgreementEndDate = '$agreementend' AND";
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
                <input type="text" class="form-control" placeholder="Service Provider Name" name="serviceprovider">
            </div>
            
            <div class="col">
                <input type="text" class="form-control" placeholder="Business Name" name="brname">
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="BR Number" name="brnumber">
            </div>

           


            <div class="col">
                <input type="text" class="form-control" placeholder="Contact No" name="contactno">
            </div>

           
        </div>

        <div class="row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Email" name="email">
            </div>


            <div class="col">
                <input type="date" class="form-control" placeholder="Start Date" name="agreementstart" >
            </div>
            <div class="col">
                <input type="date" class="form-control" placeholder="End Date" name="agreementend" >
            </div>



            <div class="col">

                <select class="form-select" id="item_status" name="status">
                    <option value="">Select Status</option>

                    <option>Active</option>
                    <option>In Active</option>

                </select>

            </div>


            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px">Search</i> </button>
            </div>

        </div>

    </form>





    <div class="table-responsive mt-3">
        <?php
        $sql = "SELECT * FROM tbl_serviceprovider $where";
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Reg No</th>
                    <th scope="col">Service Provider Name</th>
                      <th scope="col">Business Name</th>
                    <th scope="col">BR Number</th>
                    
                    <th scope="col">Contact No</th>
                    <th scope="col">Email</th>
                    <th scope="col">Agreement Start Date</th>
                    <th scope="col">Agreement End Date</th>
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
                            <td><?= $row['Title'] . " " . $row['FirstName'] . " " . $row['LastName'] ?></td>
                            <td><?= $row['BusinessName'] ?></td>
                             <td><?= $row['BRNumber'] ?></td>
                          
                            <td><?= $row['ContactNo'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['AgreementStartDate'] ?></td>
                            <td><?= $row['AgreementEndDate'] ?></td>
                            <td><?= $row['Status'] == "Active" ? "Active" : "In Active" ?></td> 

                            <?php
                            if ($_SESSION['userrole'] == "Owner") {
                                ?>
                                <td><a href="edit.php?ServiceProviderId=<?= $row['ServiceProviderId'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit" style="font-size:15px"></i> </a></td>

                                <?php
                            } elseif ($_SESSION['userrole'] == "Receptionist") {
                                ?>
                                <td><a href="edit.php?ServiceProviderId=<?= $row['ServiceProviderId'] ?>" class="btn btn-warning btn-sm">
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