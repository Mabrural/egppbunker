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
    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage-delivery-order.php' || basename($_SERVER['PHP_SELF']) == 'tambah-delivery.php' || basename($_SERVER['PHP_SELF']) == 'edit-delivery.php' || basename($_SERVER['PHP_SELF']) == 'view-bdr.php' || basename($_SERVER['PHP_SELF']) == 'tambah-bdr.php' || basename($_SERVER['PHP_SELF']) == 'edit-bdr.php' ? '' : 'collapsed'?>" href="manage-delivery-order.php">
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


  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-faq.html">
      <i class="bi bi-question-circle"></i>
      <span>F.A.Q</span>
    </a>
  </li><!-- End F.A.Q Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-contact.html">
      <i class="bi bi-envelope"></i>
      <span>Contact</span>
    </a>
  </li><!-- End Contact Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-register.html">
      <i class="bi bi-card-list"></i>
      <span>Register</span>
    </a>
  </li><!-- End Register Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-login.html">
      <i class="bi bi-box-arrow-in-right"></i>
      <span>Login</span>
    </a>
  </li><!-- End Login Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-error-404.html">
      <i class="bi bi-dash-circle"></i>
      <span>Error 404</span>
    </a>
  </li><!-- End Error 404 Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-blank.html">
      <i class="bi bi-file-earmark"></i>
      <span>Blank</span>
    </a>
  </li><!-- End Blank Page Nav -->

</ul>

</aside><!-- End Sidebar-->