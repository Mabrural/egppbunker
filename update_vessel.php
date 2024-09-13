<?php
// update_vessel.php

header('Content-Type: application/json');

// Path to the JSON file
$json_file = 'vessel.json';

// Get the raw POST data
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

// Check if action is provided and determine the action type (add or remove)
$action = isset($data['action']) ? $data['action'] : '';
$vessel_name = isset($data['vessel']) ? trim($data['vessel']) : '';

// Validate input
if (empty($action) || empty($vessel_name)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

// Read the JSON file
if (!file_exists($json_file)) {
    echo json_encode(['status' => 'error', 'message' => 'File not found.']);
    exit;
}

$json_data = file_get_contents($json_file);
$vessels = json_decode($json_data, true);

if ($action === 'add') {
    // Add new vessel if it doesn't already exist
    if (!in_array($vessel_name, $vessels)) {
        $vessels[] = $vessel_name;

        // Save the updated list back to the JSON file
        if (file_put_contents($json_file, json_encode($vessels, JSON_PRETTY_PRINT))) {
            echo json_encode(['status' => 'success', 'message' => 'Vessel added successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Vessel already exists.']);
    }
} elseif ($action === 'remove') {
    // Remove vessel if it exists
    if (in_array($vessel_name, $vessels)) {
        // Remove the vessel from the array
        $vessels = array_filter($vessels, function($vessel) use ($vessel_name) {
            return $vessel !== $vessel_name;
        });

        // Re-index the array to maintain sequential keys
        $vessels = array_values($vessels);

        // Save the updated list back to the JSON file
        if (file_put_contents($json_file, json_encode($vessels, JSON_PRETTY_PRINT))) {
            echo json_encode(['status' => 'success', 'message' => 'Vessel removed successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Vessel not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
}
?>
