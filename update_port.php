<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $action = $data['action'] ?? '';
    $port = $data['port'] ?? '';

    // Path to the JSON file
    $jsonFilePath = 'ports.json';

    // Create the file if it does not exist
    if (!file_exists($jsonFilePath)) {
        file_put_contents($jsonFilePath, json_encode([]));
    }

    // Get existing data from the JSON file
    $ports = json_decode(file_get_contents($jsonFilePath), true);

    if ($action === 'add' && $port) {
        // Add port if not already in the list
        if (!in_array($port, $ports)) {
            $ports[] = $port;
            file_put_contents($jsonFilePath, json_encode($ports, JSON_PRETTY_PRINT));
            echo "Port added successfully.";
        } else {
            echo "Port already exists.";
        }
    } elseif ($action === 'remove' && $port) {
        // Remove port if it exists in the list
        if (($key = array_search($port, $ports)) !== false) {
            unset($ports[$key]);
            $ports = array_values($ports); // Re-index array
            file_put_contents($jsonFilePath, json_encode($ports, JSON_PRETTY_PRINT));
            echo "Port removed successfully.";
        } else {
            echo "Port not found.";
        }
    } else {
        echo "Invalid action or port name.";
    }
} else {
    echo 'Invalid request method.';
}
?>
