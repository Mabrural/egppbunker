<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['armada'])) {
        $newArmada = $data['armada'];

        // Path to the JSON file
        $jsonFilePath = 'armada.json';

        // Get existing data from the JSON file
        $existingData = json_decode(file_get_contents($jsonFilePath), true);

        // Append the new option if it doesn't already exist
        if (!in_array($newArmada, $existingData)) {
            $existingData[] = $newArmada;

            // Save the updated data back to the JSON file
            file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

            echo 'New option added successfully.';
        } else {
            echo 'Option already exists.';
        }
    } else {
        echo 'Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
?>
