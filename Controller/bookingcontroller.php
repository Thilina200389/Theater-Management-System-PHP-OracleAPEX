<?php
// Controller/bookingcontroller.php
include_once __DIR__ . '/../Config/connector.php';

function getAllBookings() {
    $response = callAPI('GET', 'bookings');
    return $response['bookings'] ?? $response['items'] ?? [];
}

// Add Booking (Updated to match your specific logic)
function addBooking($user_id, $show_id, $amount) {
    
    // 1. Prepare Data
    $data = [
        "user_id"      => (int)$user_id,
        "show_id"      => (int)$show_id,
        "total_amount" => (float)$amount
        // Note: We don't send 'booking_code' or 'date' because your PL/SQL likely handles that
    ];

    // 2. Call API
    $result = callAPI('POST', 'bookings', $data);

    // 3. Custom Success Check (Because your API returns { "status": "success" })
    if (isset($result['status']) && $result['status'] == 'success') {
        // Force HTTP code to 200 so our View knows it worked
        $result['http_code'] = 200;
    } 
    // Fallback: If it's a standard ORDS response (201 Created)
    elseif ($result['http_code'] == 201) {
        $result['status'] = 'success';
    }

    return $result;
}

// Update an existing booking
function updateBooking($id, $user_id, $show_id, $amount, $status) {
    $data = [
        "user_id"      => (int)$user_id,
        "show_id"      => (int)$show_id,
        "total_amount" => (float)$amount,
        "status"       => $status
    ];
    return callAPI('PUT', 'bookings/' . $id, $data);
}

// Get single booking by ID
function getBookingById($id) {
    $all = getAllBookings();
    foreach($all as $b) {
        // Check both Key cases just to be safe
        $bid = $b['booking_id'] ?? $b['BOOKING_ID'];
        if ($bid == $id) return $b;
    }
    return null;
}

function deleteBooking($id) {
    return callAPI('DELETE', 'bookings/' . $id);
}
?>