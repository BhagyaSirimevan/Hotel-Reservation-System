<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center"> New Event Theme color Added Successfully! </h1>
       

    </div>
    
    
    <div class="row">
        
        <div class="col-md-3">
<!--             <img class="img-fluid" width="150" src="../assets/images/logo-Icon.jpg">-->
        </div>
        <div class="col-md-6">
             <div class="table-responsive">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                extract($_GET);
              //    var_dump($_GET);

                $newthemecolour = $_GET['ThemeColorId'];

                $sql = "SELECT * FROM tbl_themecolor t LEFT JOIN tbl_event e ON e.EventId=t.EventId WHERE ThemeColorId='$newthemecolour'";
              //  print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                
                    ?> 
            
            <h5 class="text-lg-center">New Event Theme Color Details</h1>
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
                                <td>Event</td>
                                <td><?= $row['EventName'] ?></td>

                            </tr>
                          
                            
                             <tr>
                                <td>Name</td>
                                <td><?= $row['ColourName'] ?></td>

                            </tr>
                            
                            <tr>
                                <td>Sample Image</td>
                                <td><?= $row['HallImage'] ?></td>

                            </tr>
                            
                           
                             <tr>
                                <td>Theme Status</td>
                                <td><?= $row['ThemeStatus'] ?></td>

                            </tr>
                            
                            
                             <?php
                            
            } } ?>
                            
                        </tbody>
                    </table>
                </div>

            
        </div>
        <div class="col-md-3"></div>
        
       

            </div>
    
    <div class="row">
        <div class="col-md-8"></div>
       
        <div class="col-md-4"> <a href="eventthems.php" class="btn btn-danger btn-sm">
                       Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>
    
    
    
     </main>

        <?php include '../footer.php'; ?> 

