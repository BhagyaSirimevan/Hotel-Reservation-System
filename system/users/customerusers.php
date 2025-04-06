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


    <h2>Customer Users List</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input

        $empregno = cleanInput($empregno);
        $fullname = cleanInput($fullname);
        $Ustatus = cleanInput($Ustatus);
        if ($Ustatus == 'Active') {
            $Ustatus = '1';
        } elseif ($Ustatus == 'Inactive') {
            $Ustatus = '0';
        }



        if (!empty($empregno)) {
            $where .= " c.RegNo LIKE '%$empregno%' AND";
        }

        if (!empty($fullname)) {
            $where .= " c.FirstName LIKE '%$fullname%' OR c.LastName LIKE '%$fullname%' AND";
        }
        
        if (!empty($username)) {
            $where .= " u.UserName LIKE '%$username%' AND";
        }


        if (isset($Ustatus)) {
            $where .= " u.Status = $Ustatus AND";
        }



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
                <input type="text" class="form-control" placeholder="User Name" name="username" >
            </div>

            <div class="col">
                <select class="form-select" id="user_status" name="Ustatus">
                    <option value="">Select Status</option>



                    <option value= '1'>Active</option>
                    <option value= '0'>Inactive</option>




                </select>
<!--                <input type="text" class="form-control" placeholder="Status" name="Ustatus" >-->
            </div>

            <div class="col-md-1">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px">Search</i> </button>
            </div>

        </div>

    </form>



    <div class="table-responsive">

        <?php
      echo   $sql= "SELECT * FROM tbl_users u LEFT JOIN tbl_customers c ON c.UserId = u.UserId "
                  . "                      LEFT JOIN tbl_customer_title ct ON ct.TitleId=c.TitleId "
                  . "                      LEFT JOIN tbl_user_roles r ON r.RoleId=u.RoleId WHERE r.RoleId=6 $where"
             ;

        
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Reg No</th>
                    <th scope="col">Full Name</th>
                      <th scope="col">User Name</th>
                    <th scope="col">User Role</th>
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
                            <td><?= $row['RegNo'] ?></td>
                            <td><?= $row['TitleName'] . " " . $row['FirstName'] . " " . $row['LastName'] ?></td>
                              <td><?=  $row['UserName'] ?></td>
                            <td><?=  $row['RoleName'] ?></td>
                            <td><?= $row['Status'] == 1 ? "Active":"Inactive" ?> </td>
                             
                            
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