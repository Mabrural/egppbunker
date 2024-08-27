<?php
include "koneksi.php";

$id_bdr = $_GET['id_bdr'];

$query = "SELECT * FROM delivery_order JOIN bdr ON bdr.do_id=delivery_order.id_do WHERE id_bdr = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_bdr);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();

echo json_encode($data);

$stmt->close();
$koneksi->close();
?>
