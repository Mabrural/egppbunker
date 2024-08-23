<?php
// verify_document.php

// Memanggil file koneksi
include "koneksi.php"; // Pastikan koneksi.php berisi variabel $koneksi

// Mendapatkan ID DO dari parameter URL
$id_do = isset($_GET['id_do']) ? intval($_GET['id_do']) : 0;

// Fungsi untuk menampilkan nilai atau '-' jika NULL atau kosong
function displayValue($value) {
    return !empty($value) ? $value : '-';
}

// Fungsi untuk format angka dengan pemisah ribuan
function formatQuantity($quantity) {
    return number_format($quantity, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Verification</title>
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
        if ($id_do > 0) {
            // Query untuk memeriksa apakah ID DO ada di database dan mengambil detail lainnya
            $sql = "
                SELECT do.id_do, do.do_number, do.do_date, do.quantity, do.product, do.armada, do.loading_port, 
                       do.discharging_port, do.driver, do.departure_time, do.arrival_time, do.seal_number1, 
                       do.seal_number2, c.customer_name
                FROM delivery_order do
                JOIN customer c ON do.customer_id = c.id_customer
                WHERE do.id_do = ?
            ";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("i", $id_do);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // ID DO ditemukan dan detail lainnya diambil
                $row = $result->fetch_assoc();

                echo "<div class='alert alert-success text-center' role='alert'>";
                echo "<h1 class='display-4'>Document Valid</h1>";
                echo "<p class='lead'>The document with Document Number: <strong>{$row['do_number']}</strong> is valid.</p>";
                echo "</div>";

                // Tampilkan detail tambahan dengan layout modern
                echo "<div class='document-details mt-4'>";
                echo "<div class='card'>";
                echo "<div class='card-header'>Document Details</div>";
                echo "<div class='card-body'>";
                echo "<table class='table table-striped table-bordered'>";
                echo "<tbody>";
                echo "<tr><th>Customer Name</th><td>" . displayValue($row['customer_name']) . "</td></tr>";
                echo "<tr><th>Product</th><td>" . displayValue($row['product']) . "</td></tr>";
                echo "<tr><th>Quantity</th><td>" . formatQuantity($row['quantity']) . " liters</td></tr>";
                echo "<tr><th>Armada</th><td>" . displayValue($row['armada']) . "</td></tr>";
                echo "<tr><th>Loading Port</th><td>" . displayValue($row['loading_port']) . "</td></tr>";
                echo "<tr><th>Discharging Port</th><td>" . displayValue($row['discharging_port']) . "</td></tr>";
                echo "<tr><th>Driver</th><td>" . displayValue($row['driver']) . "</td></tr>";
                echo "<tr><th>Departure Time</th><td>" . displayValue($row['departure_time']) . "</td></tr>";
                echo "<tr><th>Arrival Time</th><td>" . displayValue($row['arrival_time']) . "</td></tr>";
                echo "<tr><th>Seal Number 1</th><td>" . displayValue($row['seal_number1']) . "</td></tr>";
                echo "<tr><th>Seal Number 2</th><td>" . displayValue($row['seal_number2']) . "</td></tr>";
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

            } else {
                // ID DO tidak ditemukan
                echo "<div class='alert alert-danger text-center' role='alert'>";
                echo "<h1 class='display-4'>Document Invalid</h1>";
                echo "<p class='lead'>The document with ID DO: <strong>$id_do</strong> is not found in our records.</p>";
                echo "</div>";
            }
            
            $stmt->close();
        } else {
            // Parameter ID DO tidak valid
            echo "<div class='alert alert-danger text-center' role='alert'>";
            echo "<h1 class='display-4'>Invalid Document</h1>";
            echo "<p class='lead'>The document ID is not valid.</p>";
            echo "</div>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
