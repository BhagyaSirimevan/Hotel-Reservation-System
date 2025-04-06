<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Reports</h1>
        
    </div>


    <h2>Customer Report</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input
        $regno = cleanInput($regno);
        $cusname = cleanInput($cusname);
        $nic = cleanInput($nic);
        $contact = cleanInput($contact);
        $email = cleanInput($email);
        $cstatus = cleanInput($cstatus);

        if (!empty($regno)) {
            $where .= " RegNo LIKE '%$regno%' AND";
        }

        if (!empty($cusname)) {
            $where .= " FirstName LIKE '%$cusname%' OR LastName LIKE '%$cusname%' AND";
        }

        if (!empty($nic)) {
            $where .= " NIC LIKE '%$nic%' AND";
        }

        if (!empty($contact)) {
            $where .= " ContactNo LIKE '%$contact%' AND";
        }


        if (!empty($email)) {
            $where .= " Email LIKE '%$email%' AND";
        }
        
       
        
        if (!empty($regdatestart) && !empty($regdateend)) {
            $where .= " AddDate BETWEEN '$regdatestart' AND '$regdateend' AND";
        }

        if (!empty($cstatus)) {
            $where .= " c.StatusId = '$cstatus' AND";
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
        
        $sql2 = "SELECT * FROM tbl_customers c LEFT JOIN tbl_customer_title t ON t.TitleId=c.TitleId"
                . "                           LEFT JOIN tbl_customer_status s ON s.StatusId=c.StatusId $where";
        $db = dbConn();
        $result2 = $db->query($sql2);
        
        
        
    }
    ?>     

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

        <div class="row">
            <div class="col">
                <input type="text" class="form-control" placeholder="RegNo" name="regno" >
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Customer Name" name="cusname" >
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="NIC" name="nic" >
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Contact No" name="contact" >
            </div>

            <!--             <div class="col">
                            <input type="text" class="form-control" placeholder="Contact 2" name="maxprice" >
                        </div>-->

            <div class="col">
                <input type="text" class="form-control" placeholder="Email" name="email" >
            </div>
            
            <div class="col">
                <input type="date" class="form-control" placeholder="Reg Date" name="regdatestart" >
            </div>
            
             <div class="col">
                <input type="date" class="form-control" placeholder="Reg Date" name="regdateend" >
            </div>

            <div class="col-md-1">
                  <?php
                $db = dbConn();
                $sql = "SELECT * FROM tbl_customer_status";
                $result = $db->query($sql);
                ?>

                <select class="form-select" id="customer_status" name="cstatus">
                    <option value="">Select Status</option>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value=<?= $row['StatusId']; ?> <?php if ($row['StatusId'] == @$cstatus) { ?>selected <?php } ?>><?= $row['StatusName'] ?></option>

                            <?php
                        }
                    }
                    ?>


                </select>
                
            
            </div>



            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px"> Search </i> </button>
            </div>



        </div>
            </form>

    <div class="table-responsive">
      

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Reg No</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">NIC</th>
                    <th scope="col">Contact No</th>
     <!--               <th scope="col">Contact No 2</th>-->
                    <th scope="col">Email Address</th>
                     <th scope="col">Registered Date</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>

                <?php
                 if ($_SERVER['REQUEST_METHOD'] == "POST") {
                     
                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        ?>



                        <tr>
                            <td></td>
                            <td><?= $row['RegNo'] ?></td>
                            <td><?= $row['TitleName'] . " " . $row['FirstName'] . " " . $row['LastName'] ?></td>
                            <td><?= $row['NIC'] ?></td>
                            <td><?= $row['ContactNo'] ?></td>
                            <td><?= $row['Email'] ?></td>
                             <td><?= $row['AddDate'] ?></td>
                            <td><?= $row['StatusId'] == 1? "Active":"Inactive" ?></td>
                        </tr>
                        <?php
                    }
                }
                }
                ?>

            </tbody>
        </table>
    </div>
</main>

<?php include '../footer.php'; ?> 