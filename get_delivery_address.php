<?php
// Pastikan koneksi ke database sudah dibuka
include 'koneksi.php'; // Ubah sesuai dengan file koneksi database Anda

if (isset($_POST['customer_id'])) {
    $customer_id = $_POST['customer_id'];

    // Query untuk mengambil alamat pengiriman berdasarkan customer_id
    $query = "SELECT address FROM customer WHERE id_customer = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $stmt->bind_result($address);
    $stmt->fetch();

    // Tampilkan alamat atau pesan jika tidak ada data
    echo $address ? $address : 'No address available';

    $stmt->close();
    $koneksi->close();
}
?>
