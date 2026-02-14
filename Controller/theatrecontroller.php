<?php
// Controller/theatrecontroller.php
include_once __DIR__ . '/../Config/connector.php';

// Fetch all theatres
function getAllTheatres() {
    $response = callAPI('GET', 'theatres');
    return $response['theatres'] ?? $response['items'] ?? [];
}

// Add a new theatre (Updated to match your form: Name & Location only)
function addTheatre($name, $location) {
    $data = [
        "name"     => $name,
        "location" => $location
    ];
    return callAPI('POST', 'theatres', $data);
}

// Update theatre
function updateTheatre($id, $name, $location) {
    $data = [
        "name"     => $name,
        "location" => $location
    ];
    return callAPI('PUT', 'theatres/' . $id, $data);
}

// Delete theatre
function deleteTheatre($id) {
    return callAPI('DELETE', 'theatres/' . $id);
}

// Get single theatre
function getTheatreById($id) {
    $all = getAllTheatres();
    foreach($all as $t) {
        if (($t['cinema_id'] ?? $t['CINEMA_ID']) == $id) return $t;
    }
    return null;
}
?>