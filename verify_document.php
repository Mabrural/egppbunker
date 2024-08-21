<?php
// verify_document.php

// Memanggil file koneksi
include "koneksi.php"; // Pastikan koneksi.php berisi variabel $koneksi

// Mendapatkan ID DO dari parameter URL
$id_do = isset($_GET['id_do']) ? intval($_GET['id_do']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Verification</title>
    <link href="assets/img/favicon-gpp.png" rel="icon">
    <style>
        /* CSS langsung di dalam file PHP */

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .status {
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .status.valid {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status.invalid {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
        }

        .details {
            text-align: left;
            margin-top: 20px;
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
        }

        .details p {
            margin: 5px 0;
            font-size: 16px;
        }

        .details strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($id_do > 0) {
            // Query untuk memeriksa apakah ID DO ada di database dan mengambil detail lainnya
            $sql = "SELECT id_do, do_number FROM delivery_order WHERE id_do = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("i", $id_do);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // ID DO ditemukan dan detail lainnya diambil
                $row = $result->fetch_assoc();

                echo "<div class='status valid'><h1>Document Valid</h1>";
                echo "<p>The document with Document Number: <strong>{$row['do_number']}</strong> is valid.</p></div>";

            } else {
                // ID DO tidak ditemukan
                echo "<div class='status invalid'><h1>Document Invalid</h1>";
                echo "<p>The document with ID DO: <strong>$id_do</strong> is not found in our records.</p></div>";
            }
            
            $stmt->close();
        } else {
            // Parameter ID DO tidak valid
            echo "<div class='status invalid'><h1>Invalid Document</h1>";
            echo "<p>The document ID is not valid.</p></div>";
        }
        ?>
    </div>
</body>
</html>
