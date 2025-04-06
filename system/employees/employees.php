<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard-Employee Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
              <a class="btn btn-sm btn-outline-success" href="add.php"><span data-feather="plus-circle" class="align-text-bottom"></span>New Employee</a>
          </div>
         
        </div>
      </div>

         <h2>Employee List</h2>
         
    <?php 
     $where=null;
      if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);
        
         // 3rd step- clean input
        $regno = cleanInput($regno);
        $empname = cleanInput($empname);
        $nic = cleanInput($nic);
        $contact = cleanInput($contact);
        $designation = cleanInput($designation);
        $assdate = cleanInput($assdate);
        $empstatus = cleanInput($empstatus);
        
        if(!empty($regno)){
           $where.=" RegNo LIKE '%$regno%' AND";
        }
        
        if(!empty($empname)){
           $where.=" FullName LIKE '%$empname%' AND";
        }
        
        if(!empty($nic)){
           $where.=" NIC LIKE '%$nic%' AND";
        }
        
        if(!empty($contact)){
           $where.=" ContactNo LIKE '%$contact%' AND";
        }
        
        if(!empty($designation)){
           $where.=" e.DesignationId = '$designation' AND";
        }
        
        if(!empty($assdate)){
           $where.=" AssignmentDate LIKE '%$assdate%' AND";
        }
        
         if(!empty($empstatus)){
           $where.=" e.Status = '$empstatus' AND";
        }
//        
//        if(!empty($minprice) && !empty($maxprice) ){
//              $where.=" Price BETWEEN '$minprice' AND '$maxprice' AND";
//
//        }
//        
       
        
        if(!empty($where)){
           $where= substr($where, 0, -3) ;
           $where = "WHERE $where" ;
        }
        
        
        

      }
    ?>     
    
         
     <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
         
         <div class="row mb-3"> 
          <div class="col">
                <input type="text" class="form-control" placeholder="Reg No" name="regno" >
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Employee Name" name="empname" >
            </div>
            
             <div class="col">
                <input type="text" class="form-control" placeholder="NIC" name="nic" >
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Contact No" name="contact" >
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
                <input type="date" class="form-control" placeholder="Assignment Date" name="assdate" >
            </div> 
             
             <div class="col">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_employee_status";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="employee_status" name="empstatus">
                    <option value="">Select Status</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['StatusId']; ?> <?php if ($row['StatusId'] == @$empstatus) { ?>selected <?php } ?>><?= $row['StatusName'] ?></option>

                            <?php
                        }
                    }
                    ?>


                </select>
            </div>
         
              <div class="col-md-1">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px">Search</i> </button>
            </div>
         
         </div>
         
     </form>
        
     
      <div class="table-responsive">
          <?php
          
          $sql= "SELECT * FROM tbl_employees e LEFT JOIN tbl_designation d ON d.DesignationId=e.DesignationId"
                  . "                          LEFT JOIN tbl_employees_title t ON t.TitleId=e.Title"
                  . "                          LEFT JOIN tbl_employee_status s ON s.StatusId=e.Status $where";
          
          $db= dbConn();
          $result=$db->query($sql);
          
          ?>
          
        <table class="table table-striped table-sm">
          <thead class="bg-secondary text-white">
            <tr>
              <th scope="col"></th>
              <th scope="col">Reg No</th>
              <th scope="col">Employee Name</th>
              <th scope="col">NIC</th>
               <th scope="col">Contact No</th>
                <th scope="col">Designation</th>
                  <th scope="col">Assignment Date</th>
              <th scope="col">Status</th>
                 <th scope="col">Edit</th>
            </tr>
          </thead>
          <tbody>
              
              <?php 
              
              if($result->num_rows>0){
               while ($row=$result->fetch_assoc()){
              ?>
              
            <tr>
              <td></td>
              <td><?= $row['RegNo'] ?></td>
              <td><?= $row['TitleName']." ".$row['FirstName']." ".$row['LastName'] ?></td>
              <td><?= $row['NIC'] ?></td>
              <td><?= $row['ContactNo'] ?></td>  
              <td><?= $row['Name'] ?></td>
              <td><?= $row['AssignmentDate'] ?></td>  
              <td><?= $row['StatusName'] ?></td>
              <td><a href="edit.php?EmployeeId=<?= $row['EmployeeId'] ?>" class="btn btn-warning btn-sm">
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