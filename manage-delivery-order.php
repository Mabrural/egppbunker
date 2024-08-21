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
      <h1>Delivery Order</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Delivery Order</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <a href="tambah-delivery.php" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus fa-sm"></i> Add</a>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Delivery Order</h5>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>DO Number</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    $no = 1;
                    $query = "SELECT * FROM delivery_order JOIN customer ON customer.id_customer=delivery_order.customer_id";
                    $tampil = mysqli_query($koneksi, $query);

                    if (mysqli_num_rows($tampil) > 0) {
                        while ($data = mysqli_fetch_assoc($tampil)){
                
                ?>
                  <tr>
                    <td><?= $no++?></td>
                    <td><?= $data['do_number']?></td>
                    <td><?= $data['customer_name']?></td>
                    <td><?= $data['product']?></td>
                    <td>
                      <!-- <a href="print-do.php?id_do=<?= $data['id_do']?>" class="btn btn-info btn-sm"><i class="fa fa-print fa-sm"></i> </a> -->
                      <a href="#" class="btn btn-info btn-sm" onclick="printContent(<?= $data['id_do']?>);"><i class="fa fa-print fa-sm"></i> Print</a>
                      <a href="edit-delivery.php?id_do=<?= $data['id_do']?>" class="btn btn-warning btn-sm"><i class="fa fa-pen fa-sm"></i> Edit</a>
                      <a href="#" class="btn btn-danger btn-sm" onclick="return confirmRemove(<?= $data['id_do']?>);"><i class="fa fa-trash fa-sm"></i> Remove</a>
                    </td>
                  </tr>
                  <script>
                    function confirmRemove(id_do) {
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
                                window.location.href = 'remove-delivery.php?id_do=' + id_do;
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script>
function printContent(id_do) {
    // Gunakan AJAX untuk mengambil data dari server
    fetch('get_delivery_order.php?id_do=' + id_do)
        .then(response => response.json())
        .then(data => {
            let content = '';

            // Bagian yang digeser ke kanan
            const spaces = '&nbsp;';
            let rightAlignedContent = '';
            rightAlignedContent += `<div style="margin-top:20px;">${spaces} ${(data.po_number ? data.po_number : '&nbsp;')}<br>`;
            rightAlignedContent += `<div style="margin-top:20px;">${spaces} ${data.do_number}<br>`;
            rightAlignedContent += `<div style="margin-top:20px;">${spaces} ${(data.do_date ? data.do_date : '&nbsp;')}<br>`;

            const splitAddress = data.address.match(/.{1,50}/g).join('<br>');
            let leftAlignedContent = '<br><br><br>';
            leftAlignedContent += `<div style="margin-left: 120px; margin-top:2px;">${data.customer_name}<br>`;
            leftAlignedContent += `<div style="margin-top:15px;">${splitAddress}<br><br><br>`;
            leftAlignedContent += `<div style="display: flex; margin-top: 6px;">`;
            leftAlignedContent += `<div>${data.product}</div>`;
            leftAlignedContent += `<div style="margin-left: 330px; text-align: left; width: 300px;">${data.armada}</div>`;
            leftAlignedContent += `</div><br>`;
            leftAlignedContent += `<div style="display: flex; margin-top: -8px;">`;
            leftAlignedContent += `<div>${data.quantity}</div>`;
            leftAlignedContent += `<div style="margin-left: 340px; text-align: left; width: 300px;">${(data.driver ? data.driver : '')}</div>`;
            leftAlignedContent += `</div><br>`;
            leftAlignedContent += `<div style="display: flex; margin-top: -8px;">`;
            leftAlignedContent += `<div>${(data.departure_time ? data.departure_time : '&nbsp;')}</div>`;
            leftAlignedContent += `<div style="margin-left: 390px; text-align: left; width: 300px;">${(data.arrival_time ? data.arrival_time : '&nbsp;')}</div>`;
            leftAlignedContent += `</div><br>`;
            leftAlignedContent += `<div style="display: flex; margin-top: -13px;">`;
            leftAlignedContent += `<div>${data.loading_port}</div>`;
            leftAlignedContent += `<div style="margin-left: 320px; text-align: left; width: 300px;">${data.discharging_port}</div>`;
            leftAlignedContent += `</div><br>`;
            leftAlignedContent += `<div style="display: flex; margin-top: -10px;">`;
            leftAlignedContent += `<div>${(data.commence_pump ? data.commence_pump : '&nbsp;')}</div>`;
            leftAlignedContent += `<div style="margin-left: 380px; text-align: left; width: 300px;">${(data.finished_pump ? data.finished_pump : '&nbsp;')}</div>`;
            leftAlignedContent += `</div><br>`;
            leftAlignedContent += `<div style="display: relative; margin-top: -8px;">${(data.seal_number1 ? data.seal_number1 : '&nbsp;')}<br>`;
            leftAlignedContent += `<div style="display: relative; margin-top: 12px;">${(data.seal_number2 ? data.seal_number2 : '&nbsp;')}<br>`;
            leftAlignedContent += `</div>`;

            content += rightAlignedContent + '<br>' + leftAlignedContent;

            // Buka jendela cetak dan tampilkan teks dengan gaya
            const printWindow = window.open('', '', 'height=800,width=1000');
            printWindow.document.write('<html><head><style>');
            printWindow.document.write('pre { font-family: Arial, sans-serif; line-height: 1.5; text-align: justify; }');
            printWindow.document.write('pre.right-aligned { text-align: left; padding-left: 500px; }');
            printWindow.document.write('pre.left-aligned { text-align: left; padding-left: 0px; }');
            printWindow.document.write('</style></head><body>');
            printWindow.document.write('<pre class="right-aligned">' + rightAlignedContent + '</pre>');
            printWindow.document.write('<pre class="left-aligned">' + leftAlignedContent + '</pre>');

            // Menambahkan QR code untuk verifikasi
            const qrCodeUrl = 'http://localhost/egppbunker/verify_document.php?id_do=' + id_do;
            printWindow.document.write('<img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=' + encodeURIComponent(qrCodeUrl) + '" style="position: fixed; bottom: 100px; right: 10px;" />');

            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        })
        .catch(error => console.error('Error:', error));
}

</script>
</body>
</html>
