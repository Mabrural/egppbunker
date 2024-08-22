<?php 
session_name("EGPPBUNKER_SESSION");
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

if($_SESSION['is_admin'] != true){
    header("Location: index.php");
    exit;
}


    include "koneksi.php";
    $id_user = $_SESSION["id_user"];

    $nama = $_SESSION["nama"];
    $level = $_SESSION['is_admin'];


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
      <h1>Manage Users</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Manage Users</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <a href="tambah-user.php" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus fa-sm"></i> Add</a>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Manage Users</h5>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    $no = 1;
                    $query = "SELECT * FROM users";
                    $tampil = mysqli_query($koneksi, $query);

                    if (mysqli_num_rows($tampil) > 0) {
                        while ($data = mysqli_fetch_assoc($tampil)){
                
                ?>
                  <tr>
                    <td><?= $no++?></td>
                    <td><?= $data['nama']?></td>
                    <td><?= $data['email']?></td>
                    <td><span class="badge <?= ($data['is_admin'] == true) ? 'bg-success' : 'bg-warning'?>"><?= ($data['is_admin'] == true) ? 'Administrator' : 'General'?></span></td>
                    <td>
                        <a href="#" class="btn btn-danger btn-sm" onclick="return confirmRemove(<?= $data['id_user']?>);"><i class="fa fa-trash fa-sm"></i> Remove</a>
                        <a href="reset-password.php?id_user=<?= $data['id_user']?>" class="btn btn-warning btn-sm"><i class="fa fa-key fa-sm"></i> Reset Password</a>
                        
                        <?php
                            if($data['is_admin']==true){
                                echo '<a href="#" class="btn btn-success btn-sm" onclick="return confirmRemoveAdmin(' . $data['id_user'] . ');"><i class="fa fa-unlock-alt fa-sm"></i> Revoke Admin</a>';
                            } else {
                                echo '<a href="#" class="btn btn-primary btn-sm" onclick="return confirmMakeAdmin(' . $data['id_user'] . ');"><i class="fa fa-user-shield fa-sm"></i> Grant Admin</a>';
                            }
                        ?>
                    </td>
                  </tr>
                <script>
                    function confirmRemove(id_user) {
                        Swal.fire({
                            title: 'Confirmation',
                            text: 'Are you sure you want to remove?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, remove'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'remove-user.php?id_user=' + id_user;
                            }
                        });

                        return false;
                    }

                    function confirmRemoveAdmin(id_user) {
                        Swal.fire({
                            title: 'Confirmation',
                            text: 'Are you sure you want to revoke this user\'s admin privileges?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, Revoke'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'remove-admin.php?id_user=' + id_user;
                            }
                        });

                        return false;
                    }
                    function confirmMakeAdmin(id_user) {
                        Swal.fire({
                            title: 'Confirmation',
                            text: 'Are you sure you want to grant this user as admin?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, Sure'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'make-admin.php?id_user=' + id_user;
                            }
                        });

                        return false;
                    }

                </script>
            <?php 
                }
            } else {
            ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            <?php } ?> 
                  
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

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