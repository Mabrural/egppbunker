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

$id_sample = mysqli_real_escape_string($koneksi, $_GET['id_sample']);

$sample = query("SELECT * FROM sample_receipt JOIN delivery_order ON delivery_order.id_do=sample_receipt.do_id WHERE id_sample=$id_sample")[0];


?>

<!DOCTYPE html>
<html lang="en">

<?php
include "layouts/head-css.php";
?>

<style>
    span#x {
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
            <h1>View Sample Receipt</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">View Sample Receipt</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <section class="section">
            <div class="row">
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">DO Number : <?= $sample['do_number'] ?></h5>

                            <!-- Horizontal Form -->
                            <form action="" method="post">

                                <input type="hidden" name="id_sample" value="<?= $id_sample ?>">
                                <input type="hidden" name="do_id" value="<?= $sample['do_id'] ?>">

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="mb-2">
                                            <label for="truck_or_vessel" class="form-label">Truck / Vessel <span id="x">*</span></label>
                                            <input type="text" name="truck_or_vessel" value="<?= $sample['truck_or_vessel'] ?>" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="mb-2">
                                            <label for="cargo" class="form-label">Cargo / <i>Muatan </i><span id="x">*</span></label>
                                            <input type="text" name="cargo" value="<?= $sample['cargo'] ?>" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="mb-2">
                                            <label for="port" class="form-label">Port / <i>Pelabuhan</i> <span id="x">*</span></label>
                                            <input type="text" name="port" value="<?= $sample['port'] ?>" class="form-control" required disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <a href="#" class="btn btn-info btn-sm" onclick="printSample(<?= $id_sample ?>);"><i class="fa fa-print fa-sm"></i> Print Sample</a>
                                    <a href="edit-sample.php?id_sample=<?= $id_sample ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-sm"></i> Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm" onclick="return confirmRemove(<?= $id_sample ?>);"><i class="fa fa-trash fa-sm"></i> Remove</a>
                                    <script>
                                        function confirmRemove(id_sample) {
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
                                                    window.location.href = 'remove-sample.php?id_sample=' + id_sample;
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
    function printSample(id_sample) {
        // Gunakan fetch untuk mengambil data dari server
        fetch('get_sample.php?id_sample=' + id_sample)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch sample data');
                }
                return response.json();
            })
            .then(data => {
                let content = '';

                // Bagian yang digeser ke kanan
                let rightAlignedContent = '';

                // Bagian yang digeser ke kiri
                let leftAlignedContent = '';
                leftAlignedContent += `<div style="position: absolute; top: 80px; left: 220px;">${data.truck_or_vessel}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 97px; left: 220px;">${data.cargo}</div>`;
                leftAlignedContent += `<div style="position: absolute; top: 114px; left: 220px;">${data.port}</div>`;

                content += rightAlignedContent + '<br>' + leftAlignedContent;

                // Membuka jendela cetak dan menampilkan teks dengan gaya yang diatur
                const printWindow = window.open('', '', 'height=800,width=1000');
                printWindow.document.write('<html><head><style>');
                printWindow.document.write('body { font-family: Arial Narrow, sans-serif; font-size:14px; line-height: 1.5; }'); // Pastikan font diatur untuk body
                printWindow.document.write('div { text-align: justify; }');
                printWindow.document.write('</style></head><body>');
                printWindow.document.write(content);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus(); // Pastikan window mendapatkan fokus sebelum mencetak
                printWindow.print();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load sample data. Please try again.');
            });
    }
</script>




</body>

</html>