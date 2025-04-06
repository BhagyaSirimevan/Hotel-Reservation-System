<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center"> User Updated Successfully! </h1>

    </div>
    
     <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
      //  var_dump($_GET);

        // ex : 8
        $UserId = $_GET['UserId'];

//        echo $empid;
//        echo "<br>";
//        echo "<br>";

        // fullname,colname,designation,district,Edescription
        $updatedfields = $_GET['UpdatedFieldsString'];

//        echo $updatedfields;
//        echo "<br>";
//        echo "<br>";

        // array(5) { [0]=> string(8) "fullname" [1]=> string(7) "colname" [2]=> string(11) "designation" [3]=> string(8) "district" [4]=> string(12) "Edescription" }
        $updatedfields_array = explode(",", $updatedfields);

   //     var_dump($updatedfields_array);
     //   echo "<br>";
      //  echo "<br>";

        $db = dbConn();
        $sql = "SELECT u.RoleId as userrole,r.RoleName as rolename,u.Status as Ustatus,e.RegNo,e.FullName,e.DesignationId as desId,d.Name,u.UserName,u.Password FROM tbl_users u "
                . "                                                                     LEFT JOIN tbl_user_roles r ON r.RoleId=u.RoleId"
                . "                                                                     LEFT JOIN tbl_employees e ON u.UserId=e.UserId "
                . "                                                                     LEFT JOIN tbl_designation d ON e.DesignationId=d.DesignationId WHERE u.UserId='$UserId'";
       // print_r($sql);
        $result = $db->query($sql);

        $row = $result->fetch_assoc();
        ?>

    <div class="row">

            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <h5 class="text-lg-center">Updated User Details</h1>
                        <table class="table table-striped table-sm">
                            <thead class="bg-secondary text-lg" >
                                <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Updated Value</th>

                                </tr>
                            </thead>

                            <tbody>
                                
                                <tr>
                                <td>Reg No</td>
                                <td><?= $row['RegNo'] ?></td>

                            </tr>
                            
                            
                             <tr>
                                <td>Employee Name</td>
                                <td><?= $row['FullName'] ?></td>
                                

                            </tr>
                            
                             <tr>
                                <td>Designation</td>
                                <td><?= $row['Name'] ?></td>

                            </tr>
                            
                            
                            <tr>
                                <td>User Name</td>
                                <td><?= $row['UserName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Password</td>
                                <td><?= $row['Password'] ?></td>

                            </tr>
                                
                                <tr>
                                    <td>User Role</td>
                                    <td class="<?= in_array('userrole', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['rolename'] ?></td>

                                </tr>


                               <tr>
                                <td>Status</td>
                                <td class="<?= in_array('Ustatus', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['Ustatus']?"Active":"InActive" ?></td>

                            </tr>
                               

                                



                            </tbody>

                        </table>

                </div>


            </div>
            <div class="col-md-2"></div>

            
        </div>


     <?php
    } 
    ?>


<div class="row">
        <div class="col-md-8"></div>
       
        <div class="col-md-4"> <a href="employeeusers.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>


</main>



<?php include '../footer.php'; ?> 


  