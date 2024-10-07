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

    $id_bdr = mysqli_real_escape_string($koneksi, $_GET['id_bdr']);

    $customer = query("SELECT * FROM customer");
    $bdr = query("SELECT * FROM bdr JOIN delivery_order ON delivery_order.id_do=bdr.do_id WHERE id_bdr=$id_bdr")[0];

    $selectedProduct = $bdr['product'];

    // Ambil nilai vessel_cust dari array $bdr
    $selectedVessel = isset($bdr['vessel_cust']) ? $bdr['vessel_cust'] : '';

    $selectedDischargingPort = $bdr['discharging_port'];


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
      <h1>View Bunker Delivery Receipt</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">View Bunker Delivery Receipt</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">DO Number : <?= $bdr['do_number']?></h5>
        
                    <!-- Horizontal Form -->
                    <form action="" method="post">

                        <input type="hidden" name="do_id" value="<?= $id_do?>">
                        <div class="mb-2">
                            <label for="bdr_no" class="form-label">BDR No <span id="x">*</span></label>
                            <input type="text" class="form-control" name="bdr_no" id="bdr_no" value="<?= $bdr['bdr_no'] ?>" disabled>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="discharging_port" class="form-label">Delivered at <span id="x">*</span></label>
                                    <input type="text" value="<?= $bdr['discharging_port']?>" class="form-control" disabled>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="do_date" class="form-label">Date </label>
                                    <input type="date" class="form-control" id="do_date" value="<?= $bdr['do_date']?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="mb-2">
                                    <label for="delivered_by" class="form-label">Delivered by </label>
                                    <input type="text" class="form-control" name="delivered_by" id="delivered_by" value="<?= $bdr['delivered_by']?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="mb-2">
                                    <label for="vessel_cust" class="form-label">Vessel's Name </label>
                                    <input type="text" value="<?= $selectedVessel?>" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="mb-2">
                                    <label for="new_vessel" class="form-label">Add New Vessel</label>
                                    <div class="d-flex">
                                        <input type="text" id="new_vessel" class="form-control" placeholder="Enter new vessel" disabled>
                                        <button id="add_vessel" class="btn btn-primary btn-sm ms-2 disabled" disabled>Add</button>
                                    </div>
                                </div>
                            </div>
  
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="product" class="form-label">Product <span id="x">*</span></label>
                                    <select id="product" class="form-select" required disabled>
                                        <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                                    </select>
                                </div>
                            </div>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const productSelect = document.getElementById('product');
                                
                                    // Ambil data PHP untuk product yang sudah dipilih
                                    const selectedProduct = '<?= $selectedProduct ?>'; // PHP variable for selected product
                                
                                    // Fetch options from the JSON file and populate select dropdown
                                    fetch('product.json') // Assuming you have a JSON file named 'products.json'
                                        .then(response => response.json())
                                        .then(data => {
                                            data.forEach(product => {
                                                const optionProduct = document.createElement('option');
                                                optionProduct.value = product;
                                                optionProduct.textContent = product;
                                
                                                // Mark as selected if it matches the current value from the database
                                                if (product === selectedProduct) {
                                                    optionProduct.selected = true;
                                                }
                                                productSelect.appendChild(optionProduct);
                                            });
                                        })
                                        .catch(error => console.error('Error fetching product data:', error));
                                });
                            </script>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="next_port" class="form-label">Next Port </label>
                                    <input type="text" class="form-control" name="next_port" id="next_port" value="<?= $bdr['next_port']?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="commence_pump" class="form-label">Commence Pump </label>
                                    <input type="text" class="form-control" id="commence_pump" value="<?= $bdr['commence_pump']?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="etd" class="form-label">E.T.D </label>
                                    <input type="text" class="form-control" id="etd" value="<?= $bdr['departure_time']?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="finished_pump" class="form-label">Finished Pump </label>
                                    <input type="text" class="form-control" id="finished_pump" value="<?= $bdr['finished_pump']?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <hr>
                            <p>PRODUCT SUPPLIED</p>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <b>Fuel Characteristic</b>/<i>Karakteristik bahan bakar</i>
                                <div class="mb-2">
                                    <label for="visc" class="form-label">Visc. cSt @40&deg;C <br/><i>(ASTM D445/ISO 3104)</i> <span id="x">*</span></label>
                                    <input type="text" name="visc" id="visc" value="<?= $bdr['visc']?>" class="form-control" required disabled>
                                </div>
                            
                                <div class="mb-2">
                                    <label for="density" class="form-label">Density @ 15&deg;C <br/><i>(ASTM D1298-D4052)</i> <span id="x">*</span></label>
                                    <input type="text" id="density" name="density" class="form-control" value="<?= $bdr['density']?>" required disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="flashpoint" class="form-label">Flashpoint &deg;C <br/><i>(ASTM D93)</i> <span id="x">*</span></label>
                                    <input type="text" id="flashpoint" name="flashpoint" class="form-control" value="<?= $bdr['flashpoint']?>" required disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="sulphur" class="form-label">Sulphur wt% <br/><i>(ASTM D2622/D4294/D5453)</i> <span id="x">*</span></label>
                                    <input type="text" id="sulphur" name="sulphur" class="form-control" value="<?= $bdr['sulphur']?>" required disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="water_content" class="form-label">Water Content % Vol. <br/><i>(ASTM D6304/ISO 3733:1999)</i> <span id="x">*</span></label>
                                    <input type="text" id="water_content" name="water_content" class="form-control" value="<?= $bdr['water_content']?>" required disabled>
                                </div>
                            </div>
                            
                            <?php
                                $quantity = $bdr['quantity']; // Asumsikan $bdr['quantity'] sudah didefinisikan
                                $wcf = 0.8479; // Nilai default dari W.C.F
                            ?>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <b>Quantity</b>/<i>Jumlah</i>

                                <div class="mb-2">
                                    <label for="quantity" class="form-label">Gross Vol. Litres <span id="x">*</span></label>
                                    <input type="text" class="form-control" value="<?= number_format($quantity, 0, ',', '.') ?>" disabled>
                                </div>                                

                                <div class="mb-2">
                                    <label for="cubic_meter" class="form-label">Cubic Meter (KL)</label>
                                    <input type="text" id="cubic_meter" class="form-control" value="<?= number_format($quantity / 1000, 0, ',', '.') ?>" disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="net_metric_ton" class="form-label">Net Metric Tons</label>
                                    <input type="text" id="net_metric_ton" name="net_metric_ton" class="form-control" value="<?= number_format(($quantity * $wcf / 1000), 3, '.', '.') ?>" disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="vcf" class="form-label">V.C.F (ASTM tab. 54)</label>
                                    <input type="text" id="vcf" name="vcf" class="form-control" value="<?= $bdr['vcf']?>" disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="wcf" class="form-label">W.C.F (ASTM tab. 56)</label>
                                    <input type="text" id="wcf" name="wcf" class="form-control" value="<?= $bdr['wcf'] ?>"disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="temp" class="form-label">Temperature &deg;C</label>
                                    <input type="text" id="temp" name="temp" class="form-control" value="<?= $bdr['temp']?>" disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="table_52" class="form-label">Table 52 &deg;C</label>
                                    <input type="text" id="table_52" name="table_52" class="form-control" value="<?= $bdr['table_52']?>" disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="table_1" class="form-label">Table 1 (MT/LT)</label>
                                    <input type="text" id="table_1" name="table_1" class="form-control" value="<?= $bdr['table_1']?>" disabled>
                                </div>
                            </div>
                        </div>


                        <div class="text-left">
                            <a href="#" class="btn btn-info btn-sm" onclick="printBDR(<?= $id_bdr?>);"><i class="fa fa-print fa-sm"></i> Print BDR</a>
                            <a href="edit-bdr.php?id_bdr=<?= $id_bdr?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-sm"></i> Edit</a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="return confirmRemove(<?= $id_bdr?>);"><i class="fa fa-trash fa-sm"></i> Remove</a>
                            <script>
                                function confirmRemove(id_bdr) {
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
                                            window.location.href = 'remove-bdr.php?id_bdr=' + id_bdr;
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
                rightAlignedContent += `<div style="position: absolute; top: 220px; left: 805px;">${(data.do_date ? data.do_date : '&nbsp;')}</div>`;
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
                const qrCodeUrl = 'https://e-bunker.mitramaritim.com/verify_bdr.php?id_bdr=' + id_bdr;
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