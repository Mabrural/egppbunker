<?php 
session_name("EGPPBUNKER_SESSION");
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}


    include "koneksi.php";
    $id_user = $_GET["id_user"];

    $nama = $_SESSION["nama"];
    $level = $_SESSION['is_admin'];

    $profile = query("SELECT * FROM users WHERE id_user='$id_user'")[0];
    

?>

<!DOCTYPE html>
<html lang="en">

<?php
    include "layouts/head-css.php";
?>

<body>

<?php
    include "layouts/header.php";
?>

<?php
    include "layouts/sidebar.php";
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>My Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">My Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
      <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="assets/img/profile.png" alt="Profile" class="rounded-circle">
                    <h2><?= $profile['nama']?></h2>
                    <h3><?= $profile['email']?></h3>
                    <div class="text-left">
                      <a href="change-profile.php?id_user=<?= $id_user?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Change</a>
                    </div>
                </div>
            </div>

        </div>
      </div>
    </section>

   

  </main><!-- End #main -->

<?php
    include "layouts/footer.php";
?>

<?php
    include "layouts/script-js.php";
?>
  

</body>

</html>