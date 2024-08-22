<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['product'])) {
        $newProduct = $data['product'];

        // Path to the JSON file
        $jsonFilePath = 'product.json';

        // Get existing data from the JSON file
        $existingData = json_decode(file_get_contents($jsonFilePath), true);

        // Append the new product if it doesn't already exist
        if (!in_array($newProduct, $existingData)) {
            $existingData[] = $newProduct;

            // Save the updated data back to the JSON file
            file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

            echo 'New product added successfully.';
        } else {
            echo 'Product already exists.';
        }
    } else {
        echo 'Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
?>
