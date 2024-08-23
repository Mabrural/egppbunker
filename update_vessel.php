<?php
// update_vessel.php

header('Content-Type: application/json');

// Path ke file JSON
$json_file = 'vessel.json';

// Ambil data POST
$new_vessel_name = isset($_POST['vessel_name']) ? trim($_POST['vessel_name']) : '';

// Validasi input
if (empty($new_vessel_name)) {
    echo json_encode(['status' => 'error', 'message' => 'Vessel name cannot be empty.']);
    exit;
}

// Baca file JSON
if (!file_exists($json_file)) {
    echo json_encode(['status' => 'error', 'message' => 'File not found.']);
    exit;
}

$json_data = file_get_contents($json_file);
$vessels = json_decode($json_data, true);

// Tambahkan vessel baru jika belum ada
if (!in_array($new_vessel_name, $vessels)) {
    $vessels[] = $new_vessel_name;

    // Simpan kembali ke file JSON
    if (file_put_contents($json_file, json_encode($vessels, JSON_PRETTY_PRINT))) {
        echo json_encode(['status' => 'success', 'message' => 'Vessel added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Vessel already exists.']);
}
?>
