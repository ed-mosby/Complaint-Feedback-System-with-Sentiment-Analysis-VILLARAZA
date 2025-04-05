<?php 
    $dashboard = 'collapsed';
    $category = 'collapsed';

    $pageName = basename($_SERVER['PHP_SELF']);

    if($pageName == "index.php"){ 
      $dashboard = '';
    } else if($pageName == "category.php"){ 
      $category = '';
    }
?>
  <style>
    .sidebar {
  background-color: #030303 !important;
}

.sidebar-nav .nav-item {
  background-color: #030303 !important;
}

.sidebar-nav .nav-item a, i{
  color: #f5f5f5 !important; /* Para maputi ang text */
  background-color: #030303 !important;
}

    </style>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link <?php echo $dashboard; ?>" href="index.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
  <a class="nav-link <?php echo $category; ?>" href="category.php">
    <i class="bi bi-exclamation-triangle-fill"></i> <!-- Updated icon -->
    <span>Complaint</span>
  </a>
</li>




  </ul>

</aside><!-- End Sidebar -->
