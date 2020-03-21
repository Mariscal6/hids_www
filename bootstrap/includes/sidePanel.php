<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <img src="img/ossec.png" width="50px" height="50px">
        </div>
        <div class="sidebar-brand-text mx-2">OSSEC Admin</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading justify-content-center">
        Navigate
      </div>

      <!-- Nav Item -->
      <li class="nav-item">
        <a class="nav-link" href="index.php" aria-expanded="true" aria-controls="collapseTwo">
          <span>Main</span>
        </a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item">
        <a class="nav-link" href="search.php" aria-expanded="true" aria-controls="collapseTwo">
          <span>Search</span>
        </a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item">
        <a class="nav-link" href="integrity.php" aria-expanded="true" aria-controls="collapseTwo">
          <span>Integrity Checking</span>
        </a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item">
        <a class="nav-link" href="stats.php" aria-expanded="true" aria-controls="collapseTwo">
          <span>Stats</span>
        </a>
      </li>

      <?php
      if (isset($_SESSION['login'])) {
        if (isset($_SESSION['role'])) {
          if ($_SESSION['role'] == 'admin') {
            echo '<!-- Nav Item -->
                  <li class="nav-item">
                    <a class="nav-link" href="viewReports" aria-expanded="true" aria-controls="collapseTwo">
                      <span>Reports</span>
                    </a>
                  </li>';
          } elseif($_SESSION['role'] == 'user') {
            echo '<!-- Nav Item -->
                  <li class="nav-item">
                    <a class="nav-link" href="sendReport" aria-expanded="true" aria-controls="collapseTwo">
                      <span>Send Report</span>
                    </a>
                  </li>';
          }
        }
      }
      ?>

      <?php
      if (isset($_SESSION['login'])) {
        if (isset($_SESSION['role'])) {
          if ($_SESSION['role'] == 'admin') {
            echo '<!-- Nav Item -->
                  <li class="nav-item">
                    <a class="nav-link" href="manageUsers" aria-expanded="true" aria-controls="collapseTwo">
                      <span>Manage Users</span>
                    </a>
                  </li>';
          }
        }
      }
      ?>
      

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item  -->
      <li class="nav-item">
        <a class="nav-link" href="about.php" aria-expanded="true" aria-controls="collapseTwo">
          <span>About</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>