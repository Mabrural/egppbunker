<?php
include "koneksi.php";

$id_do = $_GET['id_do'];

$query = "SELECT * FROM delivery_order JOIN customer ON customer.id_customer=delivery_order.customer_id WHERE id_do = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_do);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();

echo json_encode($data);

$stmt->close();
$koneksi->close();
?>
