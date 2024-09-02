<?php
// Path to the JSON file
$jsonFilePath = 'armada.json';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

// Check action type
$action = $data['action'] ?? '';
$armada = $data['armada'] ?? '';

// Create the file if it does not exist
if (!file_exists($jsonFilePath)) {
    file_put_contents($jsonFilePath, json_encode([]));
}

$armadas = json_decode(file_get_contents($jsonFilePath), true);

if ($action === 'add' && $armada) {
    // Add armada if not already in the list
    if (!in_array($armada, $armadas)) {
        $armadas[] = $armada;
        file_put_contents($jsonFilePath, json_encode($armadas, JSON_PRETTY_PRINT));
        echo "Armada added successfully.";
    } else {
        echo "Armada already exists.";
    }
} elseif ($action === 'remove' && $armada) {
    // Remove armada if it exists in the list
    if (($key = array_search($armada, $armadas)) !== false) {
        unset($armadas[$key]);
        $armadas = array_values($armadas); // Re-index array
        file_put_contents($jsonFilePath, json_encode($armadas, JSON_PRETTY_PRINT));
        echo "Armada removed successfully.";
    } else {
        echo "Armada not found.";
    }
} else {
    echo "Invalid action or armada name.";
}
?>
