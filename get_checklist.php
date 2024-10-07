<?php
include "koneksi.php";

$id_checklist = $_GET['id_checklist'];

// $query = "SELECT * FROM bdr JOIN delivery_order ON delivery_order.id_do=bdr.do_id WHERE id_bdr = ?";
$query = "SELECT * FROM bunker_checklist JOIN delivery_order ON delivery_order.id_do=bunker_checklist.do_id JOIN bdr ON bdr.do_id=delivery_order.id_do WHERE id_checklist = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_checklist);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();

echo json_encode($data);

$stmt->close();
$koneksi->close();
?>
