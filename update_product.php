<?php
// Path to the JSON file
$jsonFilePath = 'product.json';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

// Check action type
$action = $data['action'] ?? '';
$product = $data['product'] ?? '';

// Create the file if it does not exist
if (!file_exists($jsonFilePath)) {
    file_put_contents($jsonFilePath, json_encode([]));
}

$products = json_decode(file_get_contents($jsonFilePath), true);

if ($action === 'add' && $product) {
    // Add product if not already in the list
    if (!in_array($product, $products)) {
        $products[] = $product;
        file_put_contents($jsonFilePath, json_encode($products, JSON_PRETTY_PRINT));
        echo "Product added successfully.";
    } else {
        echo "Product already exists.";
    }
} elseif ($action === 'remove' && $product) {
    // Remove product if it exists in the list
    if (($key = array_search($product, $products)) !== false) {
        unset($products[$key]);
        $products = array_values($products); // Re-index array
        file_put_contents($jsonFilePath, json_encode($products, JSON_PRETTY_PRINT));
        echo "Product removed successfully.";
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid action or product name.";
}
?>
