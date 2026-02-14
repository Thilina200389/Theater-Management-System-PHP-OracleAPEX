<?php
// Controller/moviecontroller.php
include_once __DIR__ . '/../Config/connector.php';

// Fetch all movies
function getAllMovies() {
    $response = callAPI('GET', 'movies');
    return $response['movies'] ?? $response['items'] ?? [];
}

// Add a new movie
function addMovie($title, $language, $duration, $genre, $rating, $description) {
    $data = [
        "title"       => $title,
        "language"    => $language,
        "duration"    => (int)$duration,
        "genre"       => $genre,
        "rating"      => $rating,
        "description" => $description
    ];
    return callAPI('POST', 'movies', $data);
}

// Update existing movie
function updateMovie($id, $title, $language, $duration, $genre, $rating, $description) {
    $data = [
        "title"       => $title,
        "language"    => $language,
        "duration"    => (int)$duration,
        "genre"       => $genre,
        "rating"      => $rating,
        "description" => $description
    ];
    // Note: This uses PUT as per your original code
    return callAPI('PUT', 'movies/' . $id, $data);
}

// Delete a movie
function deleteMovie($id) {
    return callAPI('DELETE', 'movies/' . $id);
}

// Get single movie (Implements your "Fetch All & Search" logic)
function getMovieById($id) {
    // 1. Try direct fetch first (Optimization)
    // $response = callAPI('GET', 'movies/' . $id);
    // if (!empty($response['items'])) return $response['items'][0];
    
    // 2. Fallback: Fetch ALL and search (Your reliable method)
    $all_movies = getAllMovies();
    foreach ($all_movies as $m) {
        // Check both lowercase and uppercase keys just to be safe
        $current_id = $m['movie_id'] ?? $m['MOVIE_ID'];
        if ($current_id == $id) {
            return $m;
        }
    }
    return null; // Not found
}
?>