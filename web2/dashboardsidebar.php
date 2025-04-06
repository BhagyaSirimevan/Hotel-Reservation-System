
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <div class="card">
            <div class="card-header bg-secondary text-light text-sm-center font-monospace">
                <h4> <?= $_SESSION['title']." ". $_SESSION['firstname']." ".$_SESSION['lastname'] ?>   </h4>

            </div>
            
        </div>
        
         <li class="nav-item">
            <a class="nav-link " href="<?= WEB_PATH?>customerdashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#reservations-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar-event"></i><span>Reservation</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="reservations-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
         
         
          <li>
            <a href="<?= WEB_PATH?>checkavailability/checkavailability.php">
              <i class="bi bi-circle"></i><span>New Reservation</span>
            </a>
          </li>
          <li>
            <a href="<?= WEB_PATH?>reservation/reservationmenu.php">
              <i class="bi bi-circle"></i><span>View Reservation</span>
            </a>
          </li>
         
        
         
        </ul>
      </li><!-- End Components Nav -->  
      
      
      
      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#payments-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-cash-coin"></i><span>Payment</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="payments-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
         
         
          <li>
            <a href="<?= WEB_PATH?>payment/indexcustomer.php">
              <i class="bi bi-circle"></i><span>Make Payment</span>
            </a>
          </li>
          <li>
            <a href="<?= WEB_PATH?>payment/payment.php">
              <i class="bi bi-circle"></i><span>View Payment</span>
            </a>
          </li>
         
        
         
        </ul>
      </li><!-- End Components Nav --> 
      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#hallarrangement-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bookmark-check"></i><span>Hall Arrangement</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="hallarrangement-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
         
         
          <li>
            <a href="<?= WEB_PATH?>hallarrangement/confirmedreservations.php">
              <i class="bi bi-circle"></i><span>New Arrangement</span>
            </a>
          </li>
          <li>
            <a href="<?= WEB_PATH?>hallarrangement/hallarrangement.php">
              <i class="bi bi-circle"></i><span>View Arrangement</span>
            </a>
          </li>
         
        
         
        </ul>
      </li><!-- End Components Nav -->
      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#refundpayments-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-currency-exchange"></i><span>Refund Payment</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="refundpayments-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
         
         
          <li>
            <a href="<?= WEB_PATH?>refundpayment/cancelledreservations.php">
              <i class="bi bi-circle"></i><span>New Refund Request</span>
            </a>
          </li>
          <li>
            <a href="<?= WEB_PATH?>refundpayment/refundpayment.php">
              <i class="bi bi-circle"></i><span>View Refund</span>
            </a>
          </li>
         
        
         
        </ul>
      </li><!-- End Components Nav --> 
      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#viewreservations-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar-event"></i><span>View Reservation</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="viewreservations-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
         
         
          <li>
            <a href="<?= WEB_PATH?>viewreservation/reservationhistory.php">
              <i class="bi bi-circle"></i><span>Your Reservation History</span>
            </a>
          </li>
       
         
        
         
        </ul>
      </li>
      
      
        
        <li class="nav-heading">Pages</li>
        
        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#profile-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>My Profile</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="profile-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
         
         
          <li>
            <a href="<?= WEB_PATH?>customers/userprofile.php">
              <i class="bi bi-circle"></i><span>View Profile</span>
            </a>
          </li>
          <li>
            <a href="<?= WEB_PATH?>customers/editprofile.php">
              <i class="bi bi-circle"></i><span>Edit Profile</span>
            </a>
          </li>
          
           <li>
            <a href="components-pagination.html">
              <i class="bi bi-circle"></i><span>Change Password</span>
            </a>
          </li>
         
        
         
        </ul>
      </li><!-- End Components Nav -->

       



        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= WEB_PATH?>logout.php">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Sign Out</span>
            </a>
        </li><!-- End Blank Page Nav --> 
        
         

    </ul>

</aside><!-- End Sidebar-->