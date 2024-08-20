<?php
session_name("EGPPBUNKER_SESSION");
session_start();

// Periksa jika pengguna sudah login
if (isset($_SESSION["login"])) {

    header("Location: index.php");
    exit;
}

require 'koneksi.php';

if (isset($_POST['login'])) {
  $email = mysqli_real_escape_string($koneksi, $_POST["email"]);
  $password = mysqli_real_escape_string($koneksi, $_POST["password"]);

  $result = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");

  // Cek apakah email ada
  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    // Cek password
    if (password_verify($password, $row["password"])) {
      // Set session
      $_SESSION["login"] = true;
      $_SESSION["email"] = $email;
      $_SESSION["nama"] = $row["nama"];
      $_SESSION["id_user"] = $row["id_user"];
      $_SESSION["is_admin"] = $row["is_admin"];

      // Mengarahkan berdasarkan level pengguna
      echo '<link rel="stylesheet" href="css/app.css"></script>';
      echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
      echo '<script src="./sweetalert2.min.js"></script>';
      echo "<script>
      setTimeout(function () { 
          swal.fire({
              title: 'Login Successful',
              text: 'Redirecting to your dashboard...',
              icon: 'success',
              timer: 2000,
              showConfirmButton: false
          });  
      }, 10);   
      setTimeout(function () {
          window.location.href = 'index.php'; // Redirect to index.php
      }, 2000);
      </script>";
      exit;
    } else {
      $error = true;
    }
  } else {
    $error = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
    include "layouts/head-css.php";
?>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.php" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo-gpp-2.png" alt="">
                  <span class="d-none d-lg-block">E-GppBunker</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email & password to login</p>
                  </div>

                  <?php if(isset($error)) :?>
                      <?php
                          echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
                          echo '<script src="./sweetalert2.min.js"></script>';
                          echo "<script>
                          setTimeout(function () { 
                              swal.fire({
                                  
                                  title               : 'Login Failed',
                                  text                : 'Incorrect Email or Password',
                                  icon                : 'error',
                                  timer               : 2000,
                                  showConfirmButton   : true
                              });  
                          },10);   setTimeout(function () {
                              window.location.href = 'index.php'; //will redirect to your blog page (an ex: blog.html)
                          }, 2000); //will call the function after 2 secs
                          </script>";    
                      ?>

                  <?php endif; ?>

                  <form action="" method="post" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                      <div class="invalid-feedback">Please enter your email!</div>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="login">Login</button>
                    </div>
                  </form>

                </div>
              </div>


            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

    <?php
        include "layouts/script-js.php";
    ?>

</body>

</html>