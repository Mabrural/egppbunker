<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="index.php" class="logo d-flex align-items-center">
    <img src="assets/img/logo-gpp-2.png" alt="">
    <span class="d-none d-lg-block">E-GppBunker</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->



<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <img src="assets/img/user-286.png" alt="Profile" class="rounded-circle">
        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $nama?></span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6><?= $nama?></h6>
          <span><?= ($level == true) ? 'Administrator' : 'General'?></span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="my-profile.php?id_user=<?= $id_user?>">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="change-password.php?id_user=<?= $id_user?>">
            <i class="bi bi-key"></i>
            <span>Change Password</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="logout.php" onclick="return confirmLogout();">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
          </a>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
          <script>
              function confirmLogout() {
                  Swal.fire({
                      title: 'Confirmation',
                      text: 'Are you sure you want to log out?',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, Log Out'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          // Redirect to logout.php when confirmed
                          window.location.href = 'logout.php';
                      }
                  });

                  // Prevent the default action of the link
                  return false;
              }
          </script>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->