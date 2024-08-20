<?php 
session_name("EGPPBUNKER_SESSION");
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}


    include "koneksi.php";
    $id_user = $_SESSION["id_user"];
    $nama = $_SESSION["nama"];
    $level = $_SESSION['is_admin'];

    // cek apakah tombol reset sudah ditekan atau belum
    if (isset($_POST['register']) ) {
	
        if(registrasi($_POST) > 0 ){
    
            echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
            echo '<script src="./sweetalert2.min.js"></script>';
            echo "<script>
            setTimeout(function () { 
                swal.fire({
                    
                    title               : 'Registration Successful',
                    text                :  'Your new account has been created!',
                    //footer              :  '',
                    icon                : 'success',
                    timer               : 2000,
                    showConfirmButton   : true
                });  
            },10);   setTimeout(function () {
                window.location.href = 'manage-users.php'; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs
            </script>";
    
        } else {
            echo mysqli_error($koneksi);
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
      <h1>New User</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">New User</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
      <div class="row">
        <div class="col-lg-6">

            <div class="card">
                <div class="card-body">
                  <h5 class="card-title"></h5>
    
                  <!-- Horizontal Form -->
                  <form action="" method="post">
                    <div class="row mb-3">
                      <label for="nama" class="col-sm-2 col-form-label">Full Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" required>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="email" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" required>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="password" class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" required>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="password2" class="col-sm-2 col-form-label">Confirm New Password</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="password2" name="password2" required>
                      </div>
                    </div>

                    <div class="text-left">
                      <button type="submit" class="btn btn-primary btn-sm" name="register"><i class="fa fa-user-plus fa-sm"></i> Register</button>
                      <a href="manage-users.php" class="btn btn-danger btn-sm"><i class="fa fa-times fa-sm"></i> Cancel</a>
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