
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>

  <!-- ======= Sidebar ======= -->
  

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
       
        <div class="col-md-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">View Profile</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                   
                  <h5 class="card-title">Profile Details         <a href="editprofile.php" class="btn btn-warning btn-sm">Edit Profile</a></h5> 
                   
                
                  
                 
                  
        <?php
        
        $userid = $_SESSION['userid'];
        
        $sql = "SELECT * FROM tbl_customers c LEFT JOIN tbl_customer_title t ON t.TitleId=c.TitleId"
                . "                           LEFT JOIN tbl_customer_status s ON s.StatusId=c.StatusId"
                . "                           LEFT JOIN tbl_gender g ON g.GenderId=c.GenderId"
                . "                           LEFT JOIN tbl_district d ON d.DistrictId=c.DistrictId WHERE UserId='$userid'";

        $db = dbConn();
        $result = $db->query($sql);
        ?>

       
            

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                         <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Reg No</div>
                    <div class="col-lg-9 col-md-8"><?= $row['RegNo'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Name</div>
                    <div class="col-lg-9 col-md-8"><?= $row['TitleName'] . " " . $row['FirstName'] . " " . $row['LastName'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">NIC</div>
                    <div class="col-lg-9 col-md-8"><?= $row['NIC'] ?></div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Gender</div>
                    <div class="col-lg-9 col-md-8"><?= $row['Name'] ?></div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">District</div>
                    <div class="col-lg-9 col-md-8"><?= $row['DistrictName'] ?></div>
                  </div>
                  
                   <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"><?= $row['HouseNo'] . ", " . $row['StreetName'] . ", " . $row['Area'] ?></div>
                  </div>


                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Contact No</div>
                    <div class="col-lg-9 col-md-8"><?= $row['ContactNo'] ?></div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Contact No (Optional)</div>
                    <div class="col-lg-9 col-md-8"><?= $row['Contact2'] ?></div>
                  </div>


                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?= $row['Email'] ?></div>
                  </div>
                  
                 

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Status</div>
                    <div class="col-lg-9 col-md-8"><?= $row['StatusId'] == 1? "Active":"Inactive" ?></div>
                  </div>


                        <?php
                    }
                }
                ?>

     
                </div>


              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

 
<?php include '../dashboardfooter.php'; ?> 