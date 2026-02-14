<?php
// View/delete_booking.php
include_once '../Controller/bookingcontroller.php';

if (isset($_GET['id'])) {
    $result = deleteBooking($_GET['id']);
    
    if ($result['http_code'] == 200 || $result['http_code'] == 204) {
        echo "<script>alert('Booking deleted successfully'); window.location.href='bookings.php';</script>";
    } else {
        echo "<script>alert('Failed to delete booking'); window.location.href='bookings.php';</script>";
    }
} else {
    header("Location: bookings.php");
}
?>