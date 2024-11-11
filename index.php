<?php
$url = "https://api.paystack.co/transaction/initialize";
$key = "";

$fields = [
    'email' => "customer@email.com",
    'amount' => "20000",
    'callback_url' => "http://localhost/paystack/test.php",
    'metadata' => ["cancel_action" => "http://localhost/paystack/what.php"]
];

$fields_string = http_build_query($fields);

// Open connection
$ch = curl_init();

// Set the URL, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer $key",
    "Cache-Control: no-cache",
));

// So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute post
$result = curl_exec($ch);

// Check if the cURL call was successful
if ($result === false) {
    die('cURL error: ' . curl_error($ch));
}

// Decode the JSON response
$response = json_decode($result, true);

// Close the cURL connection
curl_close($ch);

// Redirect to the authorization URL if it exists
if ($response['status'] && isset($response['data']['authorization_url'])) {
    $authorization_url = $response['data']['authorization_url'];
    header("Location: $authorization_url");
    exit();
} else {
    // Handle any errors or issues in the response
    echo "Error: " . $response['message'];
}
