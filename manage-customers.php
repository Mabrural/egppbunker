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
      <h1>Customers</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Customers</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <a href="tambah-customer.php" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus fa-sm"></i> Add</a>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Customers</h5>
                <div class="table-responsive">
                    <!-- Table with stripped rows -->
                    <table class="table datatable table table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Customer</th>
                          <th>Address</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                          $no = 1;
                          $query = "SELECT * FROM customer";
                          $tampil = mysqli_query($koneksi, $query);
      
                          if (mysqli_num_rows($tampil) > 0) {
                              while ($data = mysqli_fetch_assoc($tampil)){
                      
                      ?>
                        <tr>
                          <td><?= $no++?></td>
                          <td><?= $data['customer_name']?></td>
                          <td><?= $data['address']?></td>
                          <td>
                            <a href="edit-customer.php?id_customer=<?= $data['id_customer']?>" class="btn btn-warning btn-sm"><i class="fa fa-pen fa-sm"></i> Edit</a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="return confirmRemove(<?= $data['id_customer']?>);"><i class="fa fa-trash fa-sm"></i> Remove</a>
                          </td>
                        </tr>
                        <script>
                          function confirmRemove(id_customer) {
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
                                      window.location.href = 'remove-customer.php?id_customer=' + id_customer;
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
