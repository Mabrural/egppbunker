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

    $customer = query("SELECT * FROM customer");

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
      <h1>New Delivery Order</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">New Delivery Order</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
      <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                  <h5 class="card-title"></h5>
    
                  <!-- Horizontal Form -->
                  <form action="" method="post">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="emp_no" class="form-label">Purchase Order No <span id="x">*</span></label>
                                <input type="text" class="form-control" name="emp_no" id="emp_no" min="0" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="emp_name" class="form-label">Delivery Order No <span id="x">*</span></label>
                                <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="emp_name" class="form-label">Delivery Order Date <span id="x">*</span></label>
                                <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="customer_id" class="form-label">Customer <span id="x">*</span></label>
                        <select name="customer_id" id="customer_id" class="form-select" required>
                            <?php foreach($customer as $row) : ?>
                                <option value="<?= $row['id_customer']?>"><?= $row['customer_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Customer </label>
                        <textarea id="" class="form-control" disabled></textarea>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="product" class="form-label">Product <span id="x">*</span></label>
                                <select name="product" id="product" class="form-select" required>
                                    
                                </select>
                            </div>

                            <script>
                                fetch('product.json')
                                .then(response => response.json())
                                .then(data => {
                                    const productSelect = document.getElementById('product');
                                    data.forEach(product => {
                                        const option = document.createElement('option');
                                        option.value = product;
                                        option.textContent = product;
                                        productSelect.appendChild(option);
                                    });
                                })
                                .catch(error => console.error('Error fetching product data:', error));

                            </script>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="armada" class="form-label">Vessel / Fuel Truck <span id="x">*</span></label>
                                <select name="armada" id="armada" class="form-select" required>
                                    
                                </select>
                            </div>

                            <script>
                                fetch('armada.json')
                                .then(response => response.json())
                                .then(data => {
                                    const armadaSelect = document.getElementById('armada');
                                    data.forEach(armada => {
                                        const option = document.createElement('option');
                                        option.value = armada;
                                        option.textContent = armada;
                                        armadaSelect.appendChild(option);
                                    });
                                })
                                .catch(error => console.error('Error fetching product data:', error));

                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="product" class="form-label">Quantity <span id="x">*</span></label>
                                <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="product" class="form-label">Master / Driver </label>
                                <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="product" class="form-label">Departure Time </label>
                                <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="product" class="form-label">Arrival Time </label>
                                <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="product" class="form-label">Loading Port </label>
                                <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="product" class="form-label">Discharging Port </label>
                                <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="product" class="form-label">Commence Pump </label>
                                <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="product" class="form-label">Finished Pump </label>
                                <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="product" class="form-label">Seal Number 1 </label>
                        <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                    </div>
                    <div class="mb-2">
                        <label for="product" class="form-label">Seal Number 2 </label>
                        <input type="text" class="form-control" name="emp_name" id="emp_name" required>
                    </div>

                    
                    
                   

                    <div class="text-left">
                      <button type="submit" class="btn btn-primary btn-sm" name="register"><i class="fa fa-file-invoice fa-sm"></i> Create</button>
                      <a href="manage-delivery-order.php" class="btn btn-danger btn-sm"><i class="fa fa-times fa-sm"></i> Cancel</a>
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