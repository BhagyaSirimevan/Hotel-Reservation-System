<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center">  New Employee Added Successfully! </h1>
       

    </div>

    
    
    <div class="row">
        
        <div class="col-md-2"></div>
        <div class="col-md-8">
             <div class="table-responsive">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                extract($_GET);
                //  var_dump($_GET);

                $regno = $_GET['regno'];

                $sql = "SELECT * FROM tbl_employees e LEFT JOIN tbl_designation d ON d.DesignationId=e.DesignationId"
                        . "                          LEFT JOIN tbl_employees_title t ON t.TitleId=e.Title"
                        . "                          LEFT JOIN tbl_employee_status s ON s.StatusId=e.Status"
                        . "                          LEFT JOIN tbl_civil_status v ON v.CivilStatusId=e.CivilStatus "
                        . "                          LEFT JOIN tbl_district i ON i.DistrictId=e.DistrictId WHERE RegNo='$regno'";
              //  print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                
                    ?> 
            
            <h5 class="text-lg-center">New Employee Details</h1>
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
                                <td>Title</td>
                                <td><?= $row['TitleName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>First Name</td>
                                <td><?= $row['FirstName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Last Name</td>
                                <td><?= $row['LastName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Calling Name</td>
                                <td><?= $row['CallingName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Full Name</td>
                                <td><?= $row['FullName'] ?></td>

                            </tr>
                            
<!--                             <tr>
                                <td>Designation</td>
                                <td><?= $row['Name'] ?></td>

                            </tr>-->
                            
                             <tr>
                                <td>Nic</td>
                                <td><?= $row['NIC'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Gender</td>
                                <td><?= $row['Gender'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Date of Birth</td>
                                <td><?= $row['DOB'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Civil Status</td>
                                <td><?= $row['Name'] ?></td>

                            </tr>
                            
                            
                             <tr>
                                <td>Contact No (Mobile)</td>
                                <td><?= $row['ContactNo'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Contact No (Land)</td>
                                <td><?= $row['LandNo'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Email</td>
                                <td><?= $row['Email'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Assignment Date</td>
                                <td><?= $row['AssignmentDate'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>House No</td>
                                <td><?= $row['HouseNo'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Street Name</td>
                                <td><?= $row['StreetName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>City</td>
                                <td><?= $row['Area'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>District</td>
                                <td><?= $row['DistrictName'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Description</td>
                                <td><?= $row['Description'] ?></td>

                            </tr>
                            
                             <tr>
                                <td>Status</td>
                                <td><?= $row['StatusName'] ?></td>

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
       
        <div class="col-md-4"> <a href="employees.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>
           
          
        
        </main>

        <?php include '../footer.php'; ?> 
