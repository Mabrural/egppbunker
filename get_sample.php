<?php
include "koneksi.php";

$id_sample = $_GET['id_sample']; // Correct variable name

$query = "SELECT * FROM sample_receipt JOIN delivery_order ON delivery_order.id_do=sample_receipt.do_id WHERE id_sample = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_sample); // Corrected variable name
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();

echo json_encode($data); // Return data as JSON

$stmt->close();
$koneksi->close();
?>
