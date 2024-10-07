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

    $id_checklist = mysqli_real_escape_string($koneksi, $_GET['id_checklist']);

    $customer = query("SELECT * FROM customer");
    $checklist = query("SELECT * FROM bunker_checklist JOIN delivery_order ON delivery_order.id_do=bunker_checklist.do_id JOIN bdr ON bdr.do_id=delivery_order.id_do WHERE id_checklist=$id_checklist")[0];


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
      <h1>View Bunker Procedure Checklist</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">View Bunker Procedure Checklist</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">DO Number : <?= $checklist['do_number']?></h5>
        
                    <!-- Horizontal Form -->
                    <form action="" method="post">

                        <input type="hidden" name="do_id" value="<?= $id_do?>">

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="port_of_supply" class="form-label">Port of Supply <span id="x">*</span></label>
                                    <input type="text" name="port_of_supply" value="<?= $checklist['port_of_supply']?>" class="form-control" required disabled>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="mb-2">
                                    <label for="date" class="form-label">Date </label>
                                    <input type="text" name="date" value="<?= $checklist['date']?>" class="form-control" disabled>
                                </div>
                                <div class="text-right">
                                    <i>(When the transfer started)</i>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="mb-2">
                                    <label for="time" class="form-label">Time </label>
                                    <input type="text" name="time" value="<?= $checklist['time']?>" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="mb-2">
                                    <label for="type_of_fuel" class="form-label">Type of Fuel <span id="x">*</span></label>
                                    <input type="text" name="type_of_fuel" value="<?= $checklist['type_of_fuel']?>" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="mb-2">
                                    <label for="quantity" class="form-label">Quantity (L)<span id="x">*</span></label>
                                    <input type="text" name="quantity" value="<?= $checklist['quantity_checklist']?>" class="form-control" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="sender" class="form-label">Sender <i>(Name of Vessel)</i><span id="x">*</span></label>
                                    <input type="text" name="sender" value="<?= $checklist['sender']?>" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="receiver" class="form-label">Receiver <i>(Name of Vessel)</i></label>
                                    <input type="text" name="receiver" value="<?= $checklist['receiver']?>" class="form-control" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="text-left">
                            <a href="#" class="btn btn-info btn-sm" onclick="printChecklist(<?= $id_checklist?>);"><i class="fa fa-print fa-sm"></i> Print Checklist</a>
                            <a href="edit-checklist.php?id_checklist=<?= $id_checklist?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-sm"></i> Edit</a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="return confirmRemove(<?= $id_checklist?>);"><i class="fa fa-trash fa-sm"></i> Remove</a>
                            <script>
                                function confirmRemove(id_checklist) {
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
                                            window.location.href = 'remove-checklist.php?id_checklist=' + id_checklist;
                                        }
                                    });
            
                                    return false;
                                }
                            </script>
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

<script>
    function printChecklist(id_checklist) {
        // Gunakan AJAX untuk mengambil data dari server
        fetch('get_checklist.php?id_checklist=' + id_checklist)
            .then(response => response.json())
            .then(data => {
                let content = '';
    
                // Bagian yang digeser ke kanan
                let rightAlignedContent = '';

                rightAlignedContent += `<div style="position: absolute; top: 118px; left: 470px;">${(data.date ? data.date : '&nbsp;')}</div>`;
                rightAlignedContent += `<div style="position: fixed; top: 118px; left: 633px;">${(data.date ? data.time : '&nbsp;')}</div>`;

    
                let leftAlignedContent = '';
                leftAlignedContent += `<div style="position: absolute; top: 119px; left: 175px;">${data.port_of_supply}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 135px; left: 175px;">${data.product}, ${data.quantity.toLocaleString('id-ID')} Liter</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 150px; left: 175px;">${data.sender}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 165px; left: 175px;">${data.receiver}</div>`;

    
                content += rightAlignedContent + '<br>' + leftAlignedContent;
    
                // Buka jendela cetak dan tampilkan teks dengan gaya
                const printWindow = window.open('', '', 'height=800,width=1000');
                printWindow.document.write('<html><head><style>');
                printWindow.document.write('body { font-family: Arial Narrow, sans-serif; font-size:14px; line-height: 1.5; }'); // Pastikan font diatur untuk body
                printWindow.document.write('div { text-align: justify; }');
                printWindow.document.write('</style></head><body>');
                printWindow.document.write(content);
    
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            })
            .catch(error => console.error('Error:', error));
    }
</script>

    

</body>

</html>