<?php

$baseUrl = 'http://127.0.0.1:8000/api';

function makeRequest($endpoint, $data) {
    global $baseUrl;
    $url = $baseUrl . $endpoint;
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
                         "Accept: application/json\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
            'ignore_errors' => true // Fetch content even on failure status codes
        ]
    ];
    
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    // Get HTTP status code
    $status_line = $http_response_header[0];
    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
    $status = $match[1];
    
    echo "Endpoint: $endpoint\n";
    echo "Status: $status\n";
    echo "Response: $result\n\n";
}

$testEmail = 'test_' . time() . '@example.com';
echo "Testing Register with $testEmail...\n";
makeRequest('/register', [
    'name' => 'Test User',
    'email' => $testEmail,
    'password' => 'password123'
]);

echo "Testing Login with $testEmail...\n";
makeRequest('/login', [
    'email' => $testEmail,
    'password' => 'password123'
]);
