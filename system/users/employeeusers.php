<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard-User Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New User</a>
              
            </div>
            
        </div>
    </div>


    <h2>Employee Users List</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input

        $empregno = cleanInput($empregno);
        $fullname = cleanInput($fullname);
        $designation = cleanInput($designation);
        $userrole = cleanInput($userrole);
        $Ustatus = cleanInput($Ustatus);
        if ($Ustatus == 'Active') {
            $Ustatus = '1';
        } elseif ($Ustatus == 'Inactive') {
            $Ustatus = '0';
        }

        if (!empty($empregno)) {
            $where .= " e.RegNo LIKE '%$empregno%' AND";
        }

        if (!empty($fullname)) {
            $where .= " e.FullName LIKE '%$fullname%' AND";
        }


        if (!empty($designation)) {

            $where .= " e.DesignationId = '$designation' AND";
        }

        if (!empty($userrole)) {
            $where .= " u.RoleId = '$userrole' AND";
        }

        if (isset($Ustatus)) {
            $where .= " u.Status = $Ustatus AND";
        }
        
//        if (!empty($Ustatus)) {
//            $where .= " u.Status LIKE '$Ustatus' AND";
//        }




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

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

        <div class="row mb-3"> 
            <div class="col">
                <input type="text" class="form-control" placeholder="Reg No" name="empregno" >
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Name" name="fullname" >
            </div>


            <div class="col">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_designation";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="designation" name="designation">
                    <option value="">Select Designation</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['DesignationId']; ?> <?php if ($row['DesignationId'] == @$designation) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                            <?php
                        }
                    }
                    ?>


                </select>

            </div>

            <div class="col">
                <select class="form-select" id="user_role" name="userrole">
                    <option value="">Select User Role</option>

                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM tbl_user_roles";
                    $result = $db->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        ?>


                        <option value=<?= $row['RoleId']; ?> <?php if ($row['RoleId'] == @$userrole) { ?>selected <?php } ?>><?= $row['RoleName'] ?></option>
                        <?php
                    }
                    ?>    

                </select>
            </div> 

            <div class="col">
                <select class="form-select" id="user_status" name="Ustatus">
                    <option value="">Select Status</option>



                    <option value= '1'>Active</option>
                    <option value= '0'>Inactive</option>




                </select>

            </div>

            <div class="col-md-1">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px">Search</i> </button>
            </div>

        </div>

    </form>



    <div class="table-responsive">

        <?php
        $sql= "SELECT * FROM tbl_users u LEFT JOIN tbl_employees e ON e.UserId=u.UserId "
                  . "                      LEFT JOIN tbl_employees_title t ON t.TitleId=e.Title "
                  . "                      LEFT JOIN tbl_designation d ON d.DesignationId=e.DesignationId "
                  . "                      LEFT JOIN tbl_user_roles r ON r.RoleId=u.RoleId WHERE u.RoleId !=6 $where" ;


        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Reg No</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Designation</th>
                    <th scope="col">User Role</th>
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
                            <td><?= $row['TitleName'] . " " . $row['FirstName'] . " " . $row['LastName'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['RoleName'] ?></td>
                            <td><?= $row['Status'] == 1 ? "Active" : "Inactive" ?> </td>
                             
                            <td>
                                <a href="edit.php?UserId=<?= $row['UserId'] ?>" class="btn btn-warning btn-sm">
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