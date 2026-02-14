<?php
// Controller/showcontroller.php
include_once __DIR__ . '/../Config/connector.php';

// Fetch all shows
function getAllShows() {
    $response = callAPI('GET', 'shows');
    return $response['shows'] ?? $response['items'] ?? [];
}

// Add a new show
function addShow($movie_id, $screen_id, $date, $time, $price) {
    // Combine Date & Time into Oracle Timestamp Format: YYYY-MM-DD HH:MM:SS
    $combined_datetime = date('Y-m-d H:i:s', strtotime("$date $time"));
    $data = [
        "movie_id"       => (int)$movie_id,
        "screen_id"      => (int)$screen_id,
        "start_datetime" => $combined_datetime,
        "base_price"     => (float)$price,
        "status"         => "Scheduled"
    ];
    return callAPI('POST', 'shows', $data);
}

// Update an existing show
function updateShow($id, $movie_id, $screen_id, $date, $time, $price, $status) {
    // Combine Date & Time again
    $combined_datetime = date('Y-m-d H:i:s', strtotime("$date $time"));
    
    $data = [
        "movie_id"       => (int)$movie_id,
        "screen_id"      => (int)$screen_id,
        "start_datetime" => $combined_datetime,
        "base_price"     => (float)$price,
        "status"         => $status
    ];
    // Use PUT
    return callAPI('PUT', 'shows/' . $id, $data);
}

// Delete a show
function deleteShow($id) {
    return callAPI('DELETE', 'shows/' . $id);
}

// Get single show by ID
function getShowById($id) {
    $all = getAllShows();
    foreach($all as $s) {
        if (($s['show_id'] ?? $s['SHOW_ID']) == $id) return $s;
    }
    return null;
}
?>