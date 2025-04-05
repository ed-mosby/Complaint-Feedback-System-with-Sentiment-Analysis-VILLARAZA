<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
      <img src="../assets/img/logo.png"  alt="">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    
<style>
        .header {
        background-color: #030303 !important;
      }

      .header-nav .nav-item a,
      .header .logo a,
      .header .nav-link {
        color: #ffffff !important; 

      .header .nav-link img {
        border: 2px solid #ffffff; 
      }

  </style>
</style>
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img1/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2 text-capitalize"><?php echo $_SESSION['fullName']; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
           
            <a class="dropdown-item d-flex align-items-center" href="profile.php">
            <i class="bi bi-person"></i>
            <span style="color: black;">Profile</span>
        </a>

              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span style="color: black;">Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->