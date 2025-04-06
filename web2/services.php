
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>
<section id="services" class="services">
    <div class="container">

        <div class="section-title">
            <h2>Services</h2>
               <h3>Check Our Services</h3>
             </div>

        <div class="row">
            <div class="col-md-6">
                <h4 class="text-center text-success">Free Services</h4>
                <?php

                $sql = "SELECT * FROM tbl_service WHERE ServiceType='Free' ORDER BY ServiceName ASC";
                $db = dbConn();
                $result = $db->query($sql);
                ?>

                <table class="table table-responsive table-sm mt-4">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Service Name</th>
                      

                        </tr>
                    </thead> 
                    
                    <tbody>

                    <th></th>

                <?php
                   $i=0;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                        ?>

                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row['ServiceName'] ?></td>
                       
                        </tr>

                        <?php
                       
                    }
                }
                ?>

            </tbody>
                    
                </table>
            </div>
            <div class="col-md-6">
                <h4 class="text-center text-success">Payable Services</h4>
                <?php

                $sql = "SELECT * FROM tbl_service WHERE ServiceType='Payable' ORDER BY ServiceName ASC";
                $db = dbConn();
                $result = $db->query($sql);
                ?>

                <table class="table table-responsive table-sm mt-4">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Service Name</th>
                            <th scope="col">Service Last Price (Rs) </th>

                        </tr>
                    </thead> 
                    
                    <tbody>

                    <th></th>

                <?php
                   $i=0;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                        ?>

                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row['ServiceName'] ?></td>
                            <td><?= $row['ServiceLastPrice'] ?></td>
                        </tr>

                        <?php
                       
                    }
                }
                ?>

            </tbody>
                    
                </table>
            </div>
          



        </div>

    </div>
</section><!-- End Services Section -->

<?php include 'footer.php'; ?>