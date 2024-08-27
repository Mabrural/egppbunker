<?php
// verify_bdr.php

// Memanggil file koneksi
include "koneksi.php"; // Pastikan koneksi.php berisi variabel $koneksi

// Mendapatkan ID BDR dari parameter URL
$id_bdr = isset($_GET['id_bdr']) ? intval($_GET['id_bdr']) : 0;

// Fungsi untuk menampilkan nilai atau '-' jika NULL atau kosong
function displayValue($value) {
    return !empty($value) ? $value : '-';
}

// Fungsi untuk format angka dengan pemisah ribuan
function formatNumber($number) {
    return number_format($number, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDR Verification</title>
    <link href="assets/img/favicon-gpp.png" rel="icon">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .document-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .document-details .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.25rem;
        }
        .document-details .table th, .document-details .table td {
            vertical-align: middle;
        }
        .alert {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <?php
        if ($id_bdr > 0) {
            // Query untuk memeriksa apakah ID BDR ada di database dan mengambil detail lainnya
            $sql = "
                SELECT bdr.id_bdr, bdr.bdr_no, bdr.delivered_by, bdr.vessel_cust, bdr.visc, 
                       bdr.density, bdr.flashpoint, bdr.sulphur, bdr.water_content, bdr.net_metric_ton, 
                       bdr.vcf, bdr.wcf, bdr.temp, bdr.table_52, bdr.table_1, bdr.next_port
                FROM bdr 
                WHERE bdr.id_bdr = ?
            ";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("i", $id_bdr);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // ID BDR ditemukan dan detail lainnya diambil
                $row = $result->fetch_assoc();

                echo "<div class='alert alert-success text-center' role='alert'>";
                echo "<h1 class='display-4'>BDR Valid</h1>";
                echo "<p class='lead'>The BDR with BDR Number: <strong>{$row['bdr_no']}</strong> is valid.</p>";
                echo "</div>";

                // Tampilkan detail tambahan dengan layout modern
                echo "<div class='document-details mt-4'>";
                echo "<div class='card'>";
                echo "<div class='card-header'>BDR Details</div>";
                echo "<div class='card-body'>";
                echo "<table class='table table-striped table-bordered'>";
                echo "<tbody>";
                echo "<tr><th>BDR Number</th><td>" . displayValue($row['bdr_no']) . "</td></tr>";
                echo "<tr><th>Delivered By</th><td>" . displayValue($row['delivered_by']) . "</td></tr>";
                echo "<tr><th>Vessel Customer</th><td>" . displayValue($row['vessel_cust']) . "</td></tr>";
                echo "<tr><th>Viscosity</th><td>" . displayValue($row['visc']) . "</td></tr>";
                echo "<tr><th>Density</th><td>" . displayValue($row['density']) . "</td></tr>";
                echo "<tr><th>Flash Point</th><td>" . displayValue($row['flashpoint']) . "</td></tr>";
                echo "<tr><th>Sulphur</th><td>" . displayValue($row['sulphur']) . "</td></tr>";
                echo "<tr><th>Water Content</th><td>" . displayValue($row['water_content']) . "</td></tr>";
                echo "<tr><th>Net Metric Ton</th><td>" . formatNumber($row['net_metric_ton']) . "</td></tr>";
                echo "<tr><th>VCF</th><td>" . displayValue($row['vcf']) . "</td></tr>";
                echo "<tr><th>WCF</th><td>" . displayValue($row['wcf']) . "</td></tr>";
                echo "<tr><th>Temperature</th><td>" . displayValue($row['temp']) . "</td></tr>";
                echo "<tr><th>Table 52</th><td>" . displayValue($row['table_52']) . "</td></tr>";
                echo "<tr><th>Table 1</th><td>" . displayValue($row['table_1']) . "</td></tr>";
                echo "<tr><th>Next Port</th><td>" . displayValue($row['next_port']) . "</td></tr>";
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

            } else {
                // ID BDR tidak ditemukan
                echo "<div class='alert alert-danger text-center' role='alert'>";
                echo "<h1 class='display-4'>BDR Invalid</h1>";
                echo "<p class='lead'>The BDR with ID BDR: <strong>$id_bdr</strong> is not found in our records.</p>";
                echo "</div>";
            }
            
            $stmt->close();
        } else {
            // Parameter ID BDR tidak valid
            echo "<div class='alert alert-danger text-center' role='alert'>";
            echo "<h1 class='display-4'>Invalid BDR</h1>";
            echo "<p class='lead'>The BDR ID is not valid.</p>";
            echo "</div>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
