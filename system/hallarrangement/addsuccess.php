<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<?php include '../assets/phpmail/mail.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class='alert alert-secondary' role='alert'>

        <h1 class="text-center">  Hall Arrangement Added Successfully! </h1>


    </div>


    <div class="row">

        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <div class="table-responsive">


                <h5 class="text-lg-center">Hall Arrangement Details</h5>
                <table class="table table-striped table-sm">
                    <thead class="bg-secondary text-lg text-white" >
                        <tr>
                            <th scope="col">Field</th>
                            <th scope="col">Value</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                            extract($_GET);
                            //  var_dump($_GET);

                            $HallArrangementId = $_GET['HallArrangementId'];

                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_hallarrangement a LEFT JOIN tbl_hallarrangerequest r ON r.RequestId=a.RequestId "
                                    . "LEFT JOIN tbl_event e ON e.EventId=r.EventId "
                                    . "LEFT JOIN tbl_reservation rv ON rv.ReservationNo=r.ReservationNo "
                                    . "LEFT JOIN tbl_hall h ON h.HallId=rv.HallId "
                                    . "LEFT JOIN tbl_serviceprovider p ON p.ServiceProviderId=a.CateringProviderId "
                                    . "LEFT JOIN tbl_menupackage m ON m.MenuPackageId=rv.MenuPackageId "
                                    . "WHERE HallArrangementId='$HallArrangementId'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td>Reservation No</td>
                                        <td><?= $row['ReservationNo'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Reservation Date</td>
                                        <td><?= $row['ReservationDate'] ?></td>

                                    </tr>

                                    <tr>
                                        <td>Event</td>
                                        <td><?= $row['EventName'] ?></td>

                                    </tr>
                                    
                                    <tr>
                                        <td>Catering Service</td>
                                        <td><?= $row['BusinessName'] ?></td>
                                        <?php 
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row['BusinessName'];
                                        $subject = "Nectar Mount Resort - Catering Service Confirmation for " . " " . $row['ReservationDate'];

                                       
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;    
                                         $body .=  "<p>Menu Package : ". $row['MenuPackageName']. "</p></br></br>" ; 

                                        $body .= "<p>We kindly request your confirmation for the Catering Service assignment on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=DJProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        
                                        ?>
                                        

                                    </tr>


                                    <?php
                                    if ($row['DJProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.DJProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                           
                                        }

                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - DJ Confirmation for " . " " . $row['ReservationDate'];

                                       
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the DJ assignment on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=DJProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        ?>
                                        <tr>
                                            <td>DJ Music</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['BandProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.BandProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Band Group Confirmation for " . " " . $row['ReservationDate'];

                                       
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Band Group assignment on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=BandProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        
                                        
                                        
                                        ?>
                                        <tr>
                                            <td>Band Group</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['WeddingPhotoProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.WeddingPhotoProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                     

                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Wedding Photography Confirmation for " . " " . $row['ReservationDate'];

                                       
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Wedding Photography assignment on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=WeddingPhotoProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        
                                        ?>
                                        <tr>
                                            <td>Photographer</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['HallDecorationProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.HallDecorationProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Hall Decoration Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Hall Decoration on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=HallDecorationProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        ?>
                                        <tr>
                                            <td>Hall Decoration</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['PoruwaProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.PoruwaProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Wedding Poruwa Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Wedding Poruwa on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=PoruwaProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        
                                        
                                        ?>
                                        <tr>
                                            <td>Poruwa</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['AshtakaProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.AshtakaProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Ashtaka Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Ashtaka on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=AshtakaProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        
                                        
                                        ?>
                                        <tr>
                                            <td>Ashtaka</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['DancingGroupProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.DancingGroupProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Traditional Dancing Group Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Traditional Dancing Group on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=DancingGroupProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        
                                        ?>
                                        <tr>
                                            <td>Traditional Dancing Group</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['JayamangalaGathaProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.JayamangalaGathaProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Jayamangala Gatha Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Jayamangala Gatha on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=JayamangalaGathaProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        ?>
                                        <tr>
                                            <td>Jayamangala Gatha</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>

                                        <?php
                                    } if ($row['WeddingCakeProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.WeddingCakeProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Wedding Cake Structure Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Wedding Cake Structure on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=WeddingCakeProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        ?>
                                        <tr>
                                            <td>Wedding Cake Structure</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['HomeComingPhotoProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.HomeComingPhotoProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Home Coming Photography Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Home Coming Photography on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=HomeComingPhotoProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        ?>
                                        <tr>
                                            <td>Home Coming Cake Structure</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['EngagementPhotoProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.EngagementPhotoProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Engagement Photography Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Engagement Photography on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=EngagementPhotoProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        
                                        ?>
                                        <tr>
                                            <td>Photographer</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['BirthdayPhotoProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.BirthdayPhotoProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Birthday Photography Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Birthday Photography on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=BirthdayPhotoProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        ?>
                                        <tr>
                                            <td>Photographer</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['DefaultPhotoProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.DefaultPhotoProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Default Photography Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Default Photography on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=DefaultPhotoProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        ?>
                                        <tr>
                                            <td>Photographer</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['BirthdayCakeProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.BirthdayCakeProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Birthday Cake Structure Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Birthday Cake Structure on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=BirthdayCakeProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        
                                        ?>

                                        <tr>
                                            <td>Birthday Cake Structure</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>

                                        <?php
                                    } if ($row['HomeComingCakeProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.HomeComingCakeProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Home Coming Cake Structure Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Birthday Cake Structure on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=HomeComingCakeProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        ?>
                                        <tr>
                                            <td>Home Coming Cake Structure</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>
                                        <?php
                                    } if ($row['EngagementCakeProviderId'] != 0) {
                                        $sql = "SELECT * FROM tbl_hallarrangement h LEFT JOIN tbl_serviceprovider s ON s.ServiceProviderId=h.EngagementCakeProviderId WHERE HallArrangementId='$HallArrangementId'";
                                        //  print_r($sql);
                                        $db = dbConn();
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row2 = $result->fetch_assoc();
                                        }
                                        
                                        $to = "bhagyasirimevan@gmail.com";
                                        $toname = $row2['BusinessName'];
                                        $subject = "Nectar Mount Resort - Engagement Cake Structure Confirmation for " . " " . $row['ReservationDate'];
     
                                        $body = "<h4>Event Details:</h4></br>";
                                        
                                        $body .=  "<p>Date : ". $row['ReservationDate']. "</p></br>" ; 
                                        $body .=  "<p>Time : ". $row['FunctionStartTime']." - ".$row['FunctionEndTime']. "</p></br>" ;
                                        $body .=  "<p>Event : ". $row['EventName']. "</p></br>" ;  
                                        $body .=  "<p>Hall : ". $row['HallName']. "</p></br></br>" ;     

                                        $body .= "<p>We kindly request your confirmation for the Engagement Cake Structure on above event details.Please click the below link to confirm your availability for the event. Your timely confirmation will help us finalize the event schedule and make necessary arrangements.</p></br>";
   
                                        $body .= "<p>http://localhost/nectar_mount_resort/system/hallarrangement/serviceproviderconfirmation.php?HallArrangementId=$HallArrangementId&&StatusColumn=EngagementCakeProviderStatus"
                                                    . "</p></br>";
                                         
                                        $body .= "<p>If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event."
                                                . "</p></br>";
                                        
                                        $body .= "<p>Thank you for being a part of our celebration, and we eagerly await your confirmation."
                                                . "</p></br>";
                                         
                                        $body .= "<p>Best regards,"
                                                . "</p></br>";
                                        $body .= "<p>Nectar Mount Resort"
                                                . "</p></br>";
                                        
                                        
                                        
                                        $altbody = "You are successfully registered with our system";

                                        send_email($to, $toname, $subject, $body, $altbody)
                                        
                                        
                                        ?>

                                        <tr>
                                            <td>Engagement Cake Structure</td>
                                            <td><?= $row2['BusinessName'] ?></td>

                                        </tr>

                                        <?php
                                    }
                                    ?>

                                    <?php
                                }
                            }
                            ?>  



                        <?php }
                        ?>

                    </tbody>
                </table>
            </div>


        </div>
        <div class="col-md-3"></div>



    </div>

    <div class="row">
        <div class="col-md-8"></div>

        <div class="col-md-4"> <a href="hallarrangement.php" class="btn btn-danger btn-sm">
                Close <i class="fa fa-close" style="font-size:15px"></i> </a></div>
    </div>



</main>

<?php include '../footer.php'; ?> 



