<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'my-profile.php' || basename($_SERVER['PHP_SELF']) == 'change-profile.php' || basename($_SERVER['PHP_SELF']) == 'change-password.php' ? '' : 'collapsed'?>" href="index.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->


  <li class="nav-heading">Pages</li>

  <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true): ?>
    <li class="nav-item ">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage-users.php' || basename($_SERVER['PHP_SELF']) == 'tambah-user.php' || basename($_SERVER['PHP_SELF']) == 'reset-password.php' ? '' : 'collapsed'?>" href="manage-users.php">
        <i class="bi bi-people"></i>
        <span>Manage Users</span>
      </a>
    </li><!-- End Profile Page Nav -->
  <?php endif; ?>

  <li class="nav-item">
    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage-delivery-order.php' || basename($_SERVER['PHP_SELF']) == 'tambah-delivery.php' || basename($_SERVER['PHP_SELF']) == 'edit-delivery.php' || basename($_SERVER['PHP_SELF']) == 'view-bdr.php' || basename($_SERVER['PHP_SELF']) == 'tambah-bdr.php' || basename($_SERVER['PHP_SELF']) == 'edit-bdr.php' || basename($_SERVER['PHP_SELF']) == 'tambah-checklist.php' || basename($_SERVER['PHP_SELF']) == 'edit-checklist.php' || basename($_SERVER['PHP_SELF']) == 'view-checklist.php' || basename($_SERVER['PHP_SELF']) == 'tambah-sample.php' || basename($_SERVER['PHP_SELF']) == 'edit-sample.php' || basename($_SERVER['PHP_SELF']) == 'view-sample.php' ? '' : 'collapsed'?>" href="manage-delivery-order.php">
      <i class="bi bi-truck"></i>
      <span>Delivery Order</span>
    </a>
  </li><!-- End Delivery Order Page Nav -->


  <li class="nav-heading">Master</li>

  <li class="nav-item">
    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage-customers.php' || basename($_SERVER['PHP_SELF']) == 'tambah-customer.php' || basename($_SERVER['PHP_SELF']) == 'edit-customer.php' ? '' : 'collapsed'?>" href="manage-customers.php">
      <i class="bi bi-person-lines-fill"></i>
      <span>Customers</span>
    </a>
  </li><!-- End Customers Page Nav -->



</ul>

</aside><!-- End Sidebar-->