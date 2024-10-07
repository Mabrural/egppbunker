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
                            <a href="#" class="btn btn-info btn-sm" onclick="printBDR(<?= $id_bdr?>);"><i class="fa fa-print fa-sm"></i> Print BDR</a>
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
    function printBDR(id_bdr) {
        // Gunakan AJAX untuk mengambil data dari server
        fetch('get_bdr.php?id_bdr=' + id_bdr)
            .then(response => response.json())
            .then(data => {
                let content = '';
    
                // Format data.net_metric_ton untuk menampilkan pemisah ribuan
                let formattedNetMetricTon = Number(data.net_metric_ton).toLocaleString('id-ID'); // Ubah 'id-ID' sesuai dengan lokal yang Anda butuhkan
    
                // Bagian yang digeser ke kanan
                let rightAlignedContent = '';
                // Ubah CSS bdr_no menjadi center
                rightAlignedContent += `<div style="position: absolute; top: 155px; left: 50%; transform: translateX(-50%); font-weight: bold;">${data.bdr_no}</div>`;
                // rightAlignedContent += `<div style="position: absolute; top: 220px; left: 805px;">${(data.do_date ? data.do_date : '&nbsp;')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 220px; left: 805px;">${(data.do_date ? formatDate(data.do_date) : '&nbsp;')}</div>`;
                function formatDate(dateString) {
                    const date = new Date(dateString);
                    if (!isNaN(date)) {
                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = date.getFullYear();
                        return `${day}-${month}-${year}`;
                    } else {
                        return '&nbsp;'; // Jika tidak valid, tampilkan spasi kosong
                    }
                }
                rightAlignedContent += `<div style="position: absolute; top: 250px; left: 805px;">${(data.vessel_cust ? data.vessel_cust : '&nbsp;')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 280px; left: 805px;">${(data.next_port ? data.next_port : '&nbsp;')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 320px; left: 805px;">${(data.departure_time ? data.departure_time : '&nbsp;')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 490px; left: 920px; text-align: right; width: 100px;">${data.quantity.toLocaleString('id-ID')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 520px; left: 920px; text-align: right; width: 100px;">${(data.quantity / 1000).toLocaleString('id-ID')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 550px; left: 920px; text-align: right; width: 100px;">${data.net_metric_ton.toLocaleString('id-ID')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 615px; left: 920px; font-style:italic; color: blue; text-align: right; width: 100px;">${data.vcf.toLocaleString('id-ID')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 645px; left: 920px; font-style:italic; color: blue; text-align: right; width: 100px;">${data.wcf.toLocaleString('id-ID')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 675px; left: 920px; font-style:italic; color: blue; text-align: right; width: 100px;">${data.temp.toLocaleString('id-ID')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 705px; left: 920px; font-style:italic; color: blue; text-align: right; width: 100px;">${data.table_52.toLocaleString('id-ID')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 735px; left: 920px; font-style:italic; color: blue; text-align: right; width: 100px;">${data.table_1.toLocaleString('id-ID')}</div>`;

                rightAlignedContent += `<div style="position: absolute; top: 1035px; left: 805px;">${(data.vessel_cust ? data.vessel_cust : '&nbsp;')}</div>`;
                rightAlignedContent += `<div style="position: absolute; top: 1068px; left: 805px;">${data.delivered_by}</div>`;

    
                let leftAlignedContent = '';
                leftAlignedContent += `<div style="position: absolute; top: 220px; left: 295px;">${data.discharging_port}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 250px; left: 295px;">${data.delivered_by}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 280px; left: 295px;">${data.product}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 320px; left: 295px;">${(data.commence_pump ? data.commence_pump : '&nbsp;')}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 365px; left: 295px;">${(data.finished_pump ? data.finished_pump : '&nbsp;')}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 500px; left: 395px;">${data.visc}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 560px; left: 395px;">${data.density}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 623px; left: 400px;">${data.flashpoint}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 683px; left: 395px;">${data.sulphur}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 747px; left: 395px;">${data.water_content}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 540px; left: 755px; width: 300px;">&nbsp;</div>`;

    
                content += rightAlignedContent + '<br>' + leftAlignedContent;
    
                // Buka jendela cetak dan tampilkan teks dengan gaya
                const printWindow = window.open('', '', 'height=800,width=1000');
                printWindow.document.write('<html><head><style>');
                printWindow.document.write('body { font-family: Arial Narrow, sans-serif; font-size:20px; line-height: 1.5; }'); // Pastikan font diatur untuk body
                printWindow.document.write('div { text-align: justify; }');
                printWindow.document.write('</style></head><body>');
                printWindow.document.write(content);
    
                // Menambahkan QR code untuk verifikasi
                // const qrCodeUrl = 'https://e-bunker.mitramaritim.com/verify_bdr.php?id_bdr=' + id_bdr;
                const qrCodeUrl = 'http://localhost/egppbunker/verify_bdr.php?id_bdr=' + id_bdr;
                printWindow.document.write('<img src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=' + encodeURIComponent(qrCodeUrl) + '" style="position: fixed; bottom: 70px; right: 20px;" />');
    
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            })
            .catch(error => console.error('Error:', error));
    }
</script>

    

</body>

</html>