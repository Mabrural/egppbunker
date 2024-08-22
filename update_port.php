<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPort = json_decode(file_get_contents('php://input'), true);

    if (!empty($newPort)) {
        // Path to the JSON file
        $jsonFilePath = 'ports.json';

        // Get existing data from the JSON file
        $existingData = json_decode(file_get_contents($jsonFilePath), true);

        // Append the new port if it doesn't already exist in the array
        if (!in_array($newPort, $existingData)) {
            $existingData[] = $newPort;

            // Save the updated data back to the JSON file
            file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

            echo 'New port added successfully.';
        } else {
            echo 'Port already exists.';
        }
    } else {
        echo 'Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
?>
