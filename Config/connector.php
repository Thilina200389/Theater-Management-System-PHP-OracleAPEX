<?php
// Config/connector.php
define('API_BASE_URL', 'https://oracleapex.com/ords/uovt_de/TMS/');

function callAPI($method, $endpoint, $data = null) {
    $url = API_BASE_URL . $endpoint;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    if ($data !== null) {
        $json_data = json_encode($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data)
        ]);
    }

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    $result = json_decode($response, true);
    if (!is_array($result)) $result = [];
    $result['http_code'] = $http_code; // Store HTTP code for checking success
    
    return $result;
}
?>