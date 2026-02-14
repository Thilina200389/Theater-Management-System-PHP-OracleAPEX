<?php
// Controller/usercontroller.php
include_once __DIR__ . '/../Config/connector.php';

function getAllUsers() {
    $response = callAPI('GET', 'users');
    return $response['users'] ?? $response['items'] ?? [];
}

/**
 * Update an existing user
 * @param int $id
 * @param string $username
 * @param string $role
 * @param string $email
 */
function updateUser($id, $username, $role, $email) {
    $data = [
        'username' => $username,
        'role'     => $role,
        'email'    => $email
    ];
    // We use PUT for updates
    return callAPI('PUT', 'users/' . $id, $data);
}
function getUserById($id) {
    // Note: APEX usually returns the object directly or inside 'items'
    return callAPI('GET', 'users/' . $id);
}
function deleteUser($id) {
    return callAPI('DELETE', 'users/' . $id);
}
?>