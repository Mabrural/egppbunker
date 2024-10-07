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
              <div class="table-responsive">
                <!-- Table with stripped rows -->
                <table class="table datatable table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>DO Number</th>
                      <th>Customer</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Vessel/Fuel Truck</th>
                      <th>Loading Port</th>
                      <th>Discharging Port</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query = "SELECT * FROM delivery_order JOIN customer ON customer.id_customer=delivery_order.customer_id LEFT JOIN bdr ON bdr.do_id=delivery_order.id_do LEFT JOIN bunker_checklist ON bunker_checklist.do_id=delivery_order.id_do ORDER BY id_do DESC";
                    $tampil = mysqli_query($koneksi, $query);

                    if (mysqli_num_rows($tampil) > 0) {
                      while ($data = mysqli_fetch_assoc($tampil)) {

                        $id_do = $data['id_do'];

                        // Cek apakah ada data di tabel bdr dengan do_id yang sama dengan id_do
                        $bdrExists = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM bdr WHERE do_id = $id_do");
                        $bdrExists = mysqli_fetch_assoc($bdrExists)['count'] > 0;

                        // Cek apakah ada data di tabel bunker_checklist dengan do_id yang sama dengan id_do
                        $checklistExists = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM bunker_checklist WHERE do_id = $id_do");
                        $checklistExists = mysqli_fetch_assoc($checklistExists)['count'] > 0;

                    ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $data['do_number'] ?></td>
                          <td><?= $data['customer_name'] ?></td>
                          <td><?= $data['product'] ?></td>
                          <td><?= number_format($data['quantity'], 0, ',', '.') ?> Liters</td>
                          <td><?= $data['armada'] ?></td>
                          <td><?= $data['loading_port'] ?></td>
                          <td><?= $data['discharging_port'] ?></td>
                          <td>
                            <a href="#" class="btn btn-info btn-sm" onclick="printContent(<?= $data['id_do'] ?>);"><i class="fa fa-print fa-sm"></i> </a>
                            <a href="edit-delivery.php?id_do=<?= $data['id_do'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-pen fa-sm"></i> </a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="return confirmRemove(<?= $data['id_do'] ?>);"><i class="fa fa-trash fa-sm"></i> </a>
                            <div class="btn-group">
                              <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                              </button>
                              <ul class="dropdown-menu">
                                <li>
                                  <?php if (!$bdrExists): ?>
                                    <!-- Jika tidak ada data di tabel bdr, tampilkan tombol BDR -->
                                    <a class="dropdown-item" href="tambah-bdr.php?id_do=<?= $id_do ?>"><i class="fa fa-file-alt fa-sm"></i> BDR</a>
                                  <?php else: ?>
                                    <!-- Jika ada data di tabel bdr, tampilkan tombol View BDR -->
                                    <a class="dropdown-item" href="view-bdr.php?id_bdr=<?= $data['id_bdr'] ?>"><i class="fa fa-eye fa-sm"></i> View BDR</a>
                                  <?php endif; ?>
                                </li>
                                <li>
                                  <?php if($bdrExists): ?>
                                    <?php if(!$checklistExists): ?>
                                      <!-- Jika tidak ada data di tabel bunker_checklist, tampilkan tombol Checklist -->
                                      <a class="dropdown-item" href="tambah-checklist.php?id_do=<?= $data['id_do'] ?>"><i class="fa fa-clipboard-check fa-sm"></i> Checklist</a>
                                    <?php else: ?>
                                      <!-- Jika ada data di tabel bdr, tampilkan tombol View checklist -->
                                      <a class="dropdown-item" href="view-checklist.php?id_checklist=<?= $data['id_checklist'] ?>"><i class="fa fa-eye fa-sm"></i> View Checklist</a>
                                    <?php endif; ?>
                                  <?php else: ?>

                                  <?php endif; ?>
                                </li>
                                <li>
                                  <!-- <a class="dropdown-item" href="tambah-sample.php?id_do=<?= $data['id_do'] ?>"><i class="fa fa-box-open fa-sm"></i> Samp. Receive</a> -->
                                </li>
                              </ul>
                            </div>


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

          // Format data.quantity untuk menampilkan pemisah ribuan
          let formattedQuantity = Number(data.quantity).toLocaleString('id-ID'); // Ubah 'id-ID' sesuai dengan lokal yang Anda butuhkan

          // Bagian yang digeser ke kanan
          let rightAlignedContent = '';
          rightAlignedContent += `<div style="position: absolute; top: 30px; left: 755px;">${(data.po_number ? data.po_number : '&nbsp;')}</div>`;
          rightAlignedContent += `<div style="position: absolute; top: 95px; left: 755px;">${data.do_number}</div>`;
          // rightAlignedContent += `<div style="position: absolute; top: 158px; left: 755px;">${(data.do_date ? data.do_date : '&nbsp;')}</div>`;
          rightAlignedContent += `<div style="position: absolute; top: 158px; left: 755px;">${(data.do_date ? formatDate(data.do_date) : '&nbsp;')}</div>`;

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

          // Menggunakan CSS untuk menangani pemisahan alamat berdasarkan lebar
          let leftAlignedContent = '';
          leftAlignedContent += `<div style="position: absolute; top: 333px; left: 155px;">${data.customer_name}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: 395px; left: 155px; max-width: 500px; white-space: normal; overflow-wrap: break-word;">${data.address}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: 540px; left: 155px;">${data.product}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: 540px; left: 755px; width: 300px;">${data.armada}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: 600px; left: 155px;">${formattedQuantity}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: 600px; left: 755px; width: 300px;">${(data.driver ? data.driver : '&nbsp;')}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: 655px; left: 155px;">${(data.departure_time ? data.departure_time : '&nbsp;')}</div>`;

          // Tentukan posisi top untuk discharging_port berdasarkan width
          const dischargingPortWidth = data.discharging_port.length * 8; // Perkirakan lebar teks, 8px per karakter
          const dischargingPortTop = dischargingPortWidth > 300 ? 700 : 713;

          // Tentukan posisi top untuk loading_port berdasarkan width
          const loadingPortWidth = data.loading_port.length * 8; // Perkirakan lebar teks, 8px per karakter
          const loadingPortTop = loadingPortWidth > 340 ? 700 : 713;

          leftAlignedContent += `<div style="position: absolute; top: 655px; left: 755px; width: 300px;">${(data.arrival_time ? data.arrival_time : '&nbsp;')}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: ${loadingPortTop}px; left: 155px; width: 310px; white-space: normal; overflow-wrap: break-word;">${data.loading_port}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: ${dischargingPortTop}px; left: 755px; width: 300px; white-space: normal; overflow-wrap: break-word;">${data.discharging_port}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: 768px; left: 155px;">${(data.commence_pump ? data.commence_pump : '&nbsp;')}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: 768px; left: 755px; width: 300px;">${(data.finished_pump ? data.finished_pump : '&nbsp;')}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: 825px; left: 155px;">${(data.seal_number1 ? data.seal_number1 : '&nbsp;')}</div>`;
          leftAlignedContent += `<div style="position: absolute; top: 880px; left: 155px;">${(data.seal_number2 ? data.seal_number2 : '&nbsp;')}</div>`;

          content += rightAlignedContent + '<br>' + leftAlignedContent;

          // Buka jendela cetak dan tampilkan teks dengan gaya
          const printWindow = window.open('', '', 'height=800,width=1000');
          printWindow.document.write('<html><head><style>');
          printWindow.document.write('body { font-family: Arial Narrow, sans-serif; font-size:20px; line-height: 1.5; }'); // Pastikan font diatur untuk body
          printWindow.document.write('div { text-align: justify; }');
          printWindow.document.write('</style></head><body>');
          printWindow.document.write(content);

          // Menambahkan QR code untuk verifikasi
          // const qrCodeUrl = 'https://e-bunker.mitramaritim.com/verify_document.php?id_do=' + id_do;
          const qrCodeUrl = 'http://localhost/egppbunker/verify_document.php?id_do=' + id_do;
          printWindow.document.write('<img src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=' + encodeURIComponent(qrCodeUrl) + '" style="position: fixed; bottom: 140px; right: 20px;" />');

          printWindow.document.write('</body></html>');
          printWindow.document.close();
          printWindow.print();
        })
        .catch(error => console.error('Error:', error));
    }
  </script>



</body>

</html>