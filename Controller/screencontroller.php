<?php
// Controller/screencontroller.php
include_once __DIR__ . '/../Config/connector.php';

// Fetch all screens
function getAllScreens() {
    $response = callAPI('GET', 'screens');
    return $response['screens'] ?? $response['items'] ?? [];
}

// Add a new screen
function addScreen($name, $capacity, $cinema_id) {
    $data = [
        "name"      => $name,
        "capacity"  => (int)$capacity,
        "cinema_id" => (int)$cinema_id
    ];
    return callAPI('POST', 'screens', $data);
}

// Update a screen
function updateScreen($id, $name, $capacity, $cinema_id) {
    $data = [
        "name"      => $name,
        "capacity"  => (int)$capacity,
        "cinema_id" => (int)$cinema_id
    ];
    return callAPI('PUT', 'screens/' . $id, $data);
}

// Delete a screen
function deleteScreen($id) {
    return callAPI('DELETE', 'screens/' . $id);
}

// Get single screen
function getScreenById($id) {
    $all = getAllScreens();
    foreach ($all as $s) {
        if (($s['screen_id'] ?? $s['SCREEN_ID']) == $id) {
            return $s;
        }
    }
    return null;
}

// --- HELPER FOR DROPDOWN ---
// We fetch theatres here to populate the "Select Theater" box
function getTheatresForDropdown() {
    $response = callAPI('GET', 'theatres');
    return $response['theatres'] ?? $response['items'] ?? [];
}
?>