<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center">  New User Added Successfully! </h1>
       

    </div>
    
    
    <div class="row">
        
        <div class="col-md-2"></div>
        <div class="col-md-8">
             <div class="table-responsive">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                extract($_GET);
               //   var_dump($_GET);

                $newuserid = $_GET['UserId'];

                $sql = "SELECT * FROM tbl_users u LEFT JOIN tbl_user_roles r ON u.RoleId=r.RoleId "
                        . "                       LEFT JOIN tbl_employees e ON u.UserId=e.UserId "
                        . "                       LEFT JOIN tbl_designation d ON e.DesignationId=d.DesignationId"
                      
                        . "                       WHERE u.UserId='$newuserid'";
           //    print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                
                    ?> 
            
            <h5 class="text-lg-center">New User Details</h1>
                    <table class="table table-striped table-sm">
                        <thead class="bg-secondary text-lg" >
                            <tr>
                                <th scope="col">Field</th>
                                <th scope="col">Value</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                             if ($result->num_rows > 0) {
                               $row = $result->fetch_assoc() ;
                        ?>  
                           
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
                                <td><?= $row['RoleName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Status</td>
                                <td><?= $row['Status']?"Active":"InActive" ?></td>

                            </tr>
                            
                             
                             <?php
                            
            } } ?>
                            
                        </tbody>
                    </table>
                </div>

            
        </div>
        <div class="col-md-2"></div>
        
       

            </div>
    
        
    <div class="row">
        <div class="col-md-8"></div>
       
        <div class="col-md-4"> <a href="users.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>

    
    
</main>

    <?php include '../footer.php'; ?> 