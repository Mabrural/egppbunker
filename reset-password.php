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

    $resetpass = query("SELECT * FROM users WHERE id_user='$id_user'")[0];
    // cek apakah tombol reset sudah ditekan atau belum
    if (isset($_POST["reset"])) {
        
        // cek apakah data berhasil ditambahkan atau tidak
        if(resetPassword($_POST) > 0 ) {
            echo '<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"></script>';
            echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
            echo '<script src="./sweetalert2.min.js"></script>';
            echo "<script>
            setTimeout(function () { 
                swal.fire({
                    
                    title               : 'Success',
                    text                :  'Password successfully updated!',
                    //footer              :  '',
                    icon                : 'success',
                    timer               : 2000,
                    showConfirmButton   : false
                });  
            },10);   setTimeout(function () {
                window.location.href = 'manage-users.php'; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs
            </script>"; 
            exit;

        } else{
            echo '<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"></script>';
            echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
            echo '<script src="./sweetalert2.min.js"></script>';
            echo "<script>
            setTimeout(function () { 
                swal.fire({
                    
                    title               : 'Failed',
                    text                :  'Password reset failed! Passwords do not match.',
                    //footer              :  '',
                    icon                : 'error',
                    timer               : 2000,
                    showConfirmButton   : false
                });  
            },10);   setTimeout(function () {
                window.location.href = 'manage-users.php'; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs
            </script>";
            exit;

        }

    }

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
      <h1>Reset Password</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Reset Password</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
      <div class="row">
        <div class="col-lg-6">

            <div class="card">
                <div class="card-body">
                  <h5 class="card-title"><?= $resetpass['nama']?></h5>
    
                  <!-- Horizontal Form -->
                  <form action="" method="post">
                    <input type="hidden" name="id_user" value="<?= $id_user?>">
                    <div class="row mb-3">
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" placeholder="New password" required>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm New Password" required>
                      </div>
                    </div>

                    <div class="text-left">
                      <button type="submit" class="btn btn-primary btn-sm" name="reset">Reset</button>
                    </div>
                  </form><!-- End Horizontal Form -->
    
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