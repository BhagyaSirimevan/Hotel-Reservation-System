<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center"> Employee Updated Successfully! </h1>

    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
     //   var_dump($_GET);

        // ex : 8
        $empid = $_GET['EmployeeId'];

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
        echo "<br>";
        echo "<br>";

        $db = dbConn();
        $sql = "SELECT RegNo, e.Title as title,t.TitleName as titlename ,FirstName as fname,LastName as lname,FullName as fullname,CallingName as colname,"
                . "e.DesignationId as designation,d.Name as designationname, HouseNo as houseno,StreetName as streetname,Area as area,"
                . "e.DistrictId as district,i.DistrictName as districtname,ContactNo as contact,LandNo as landno,DOB as dob,NIC as nic,"
                . "e.Gender as Gender,"
                . "e.CivilStatus as civilstatus,v.Name as civilstatusname,EmpImage as file_name_new,Description as Edescription,Email as email,AssignmentDate as assdate,"
                . "e.Status as empstatus,s.StatusName as statusname FROM tbl_employees e "
                . "LEFT JOIN tbl_designation d ON d.DesignationId=e.DesignationId "
                . "LEFT JOIN tbl_employees_title t ON t.TitleId=e.Title "
                . "LEFT JOIN tbl_employee_status s ON s.StatusId=e.Status "
                . "LEFT JOIN tbl_civil_status v ON v.CivilStatusId=e.CivilStatus "
                . "LEFT JOIN tbl_district i ON i.DistrictId=e.DistrictId WHERE EmployeeId='$empid'";
      //  print_r($sql);
        $result = $db->query($sql);

        $row = $result->fetch_assoc();
        ?>


        <div class="row">

            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <h5 class="text-lg-center">Updated Employee Details</h1>
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
                                    <td class="<?= in_array('RegNo', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['RegNo'] ?></td>

                                </tr>

                                <tr>
                                    <td>Title</td>
                                    <td class="<?= in_array('title', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['titlename'] ?></td>

                                </tr>

                                <tr>
                                    <td>First Name</td>
                                    <td class="<?= in_array('fname', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['fname'] ?></td>

                                </tr>

                                <tr>
                                    <td>Last Name</td>
                                    <td class="<?= in_array('lname', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['lname'] ?></td>

                                </tr>

                                <tr>
                                    <td>Calling Name</td>
                                    <td class="<?= in_array('colname', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['colname'] ?></td>

                                </tr>

                                <tr>
                                    <td>Full Name</td>
                                    <td class="<?= in_array('fullname', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['fullname'] ?></td>

                                </tr>

                                <tr>
                                    <td>Designation</td>
                                    <td class="<?= in_array('designation', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['designationname'] ?></td>

                                </tr>

                                <tr>
                                    <td>Nic</td>
                                    <td class="<?= in_array('nic', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['nic'] ?></td>

                                </tr>

                                <tr>
                                    <td>Gender</td>
                                    <td class="<?= in_array('Gender', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['Gender'] ?></td>

                                </tr>

                                <tr>
                                    <td>Date of Birth</td>
                                    <td class="<?= in_array('dob', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['dob'] ?></td>

                                </tr>

                                <tr>
                                    <td>Civil Status</td>
                                    <td class="<?= in_array('civilstatus', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['civilstatusname'] ?></td>

                                </tr>


                                <tr>
                                    <td>Contact No (Mobile)</td>
                                    <td class="<?= in_array('contact', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['contact'] ?></td>

                                </tr>

                                <tr>
                                    <td>Contact No (Land)</td>
                                    <td class="<?= in_array('landno', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['landno'] ?></td>

                                </tr>

                                <tr>
                                    <td>Email</td>
                                    <td class="<?= in_array('email', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['email'] ?></td>

                                </tr>

                                <tr>
                                    <td>Assignment Date</td>
                                    <td class="<?= in_array('assdate', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['assdate'] ?></td>

                                </tr>

                                <tr>
                                    <td>House No</td>
                                    <td class="<?= in_array('houseno', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['houseno'] ?></td>

                                </tr>

                                <tr>
                                    <td>Street Name</td>
                                    <td class="<?= in_array('streetname', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['streetname'] ?></td>

                                </tr>

                                <tr>
                                    <td>City</td>
                                    <td class="<?= in_array('area', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['area'] ?></td>

                                </tr>

                                <tr>
                                    <td>District</td>
                                    <td class="<?= in_array('district', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['districtname'] ?></td>

                                </tr>

                                <tr>
                                    <td>Description</td>
                                    <td class="<?= in_array('Edescription', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['Edescription'] ?></td>

                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td class="<?= in_array('empstatus', $updatedfields_array) ? 'text-bg-secondary' : '' ?>"><?= $row['statusname'] ?></td>

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
       
        <div class="col-md-4"> <a href="employees.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>


</main>



<?php include '../footer.php'; ?> 
