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

    $id_do = mysqli_real_escape_string($koneksi, $_GET['id_do']);

    $delivery = query("SELECT * FROM delivery_order JOIN bdr ON bdr.do_id=delivery_order.id_do WHERE id_do=$id_do")[0];


    // cek apakah tombol submit sudah ditekan atau belum
    if (isset($_POST['tambahChecklist']) ) {
	
        // cek apakah data berhasil update atau tidak
        if(tambahChecklist($_POST) > 0 ) {
            echo '<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"></script>';
            echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
            echo '<script src="./sweetalert2.min.js"></script>';
            echo "<script>
            setTimeout(function () { 
                swal.fire({
                    
                    title               : 'Success',
                    text                : 'Bunker Procedure Checklist successfully created!',
                    icon                : 'success',
                    timer               : 2000,
                    showConfirmButton   : false
                });  
            },10);   setTimeout(function () {
                window.location.href = 'manage-delivery-order.php'; //will redirect to your blog page (an ex: blog.html)
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
                    text                : 'Failed to create Bunker Procedure Checklist!',
                    icon                : 'error',
                    timer               : 2000,
                    showConfirmButton   : false
                });  
            },10);   setTimeout(function () {
                window.location.href = 'manage-delivery-order.php'; //will redirect to your blog page (an ex: blog.html)
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

<style>
    span#x{
        color: red;
    }

    .remove-button {
    display: inline-flex;
    align-items: center;
    background-color: transparent;
    border: none;
    color: red;
    cursor: pointer;
    font-size: 12px;
}

.remove-buttons-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.remove-button {
    display: flex;
    align-items: center;
    background-color: transparent;
    border: none;
    color: red;
    cursor: pointer;
    font-size: 12px;
    text-align: left;
}
</style>

<body>

<?php
    include "layouts/header.php";
?>

<?php
    include "layouts/sidebar.php";
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>New Bunker Procedure Checklist</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">New Bunker Procedure Checklist</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">DO Number : <?= $delivery['do_number']?></h5>
        
                    <!-- Horizontal Form -->
                    <form action="" method="post">

                        <input type="hidden" name="do_id" value="<?= $id_do?>">

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="port_of_supply" class="form-label">Port of Supply <span id="x">*</span></label>
                                    <input type="text" name="port_of_supply" value="<?= $delivery['discharging_port']?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="mb-2">
                                    <label for="date" class="form-label">Date </label>
                                    <input type="text" name="date" value="" class="form-control">
                                </div>
                                <div class="text-right">
                                    <i>(When the transfer started)</i>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="mb-2">
                                    <label for="time" class="form-label">Time </label>
                                    <input type="text" name="time" value="" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="mb-2">
                                    <label for="type_of_fuel" class="form-label">Type of Fuel <span id="x">*</span></label>
                                    <input type="text" name="type_of_fuel" value="<?= $delivery['product']?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="mb-2">
                                    <label for="quantity_checklist" class="form-label">Quantity (L)<span id="x">*</span></label>
                                    <input type="text" name="quantity_checklist" value="<?= $delivery['quantity']?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="sender" class="form-label">Sender <i>(Name of Vessel)</i><span id="x">*</span></label>
                                    <input type="text" name="sender" value="<?= $delivery['armada']?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="receiver" class="form-label">Receiver <i>(Name of Vessel)</i></label>
                                    <input type="text" name="receiver" value="<?= $delivery['vessel_cust']?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="text-left">
                        <button type="submit" class="btn btn-primary btn-sm" name="tambahChecklist"><i class="fa fa-file-invoice fa-sm"></i> Create</button>
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