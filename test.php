<?php
$reference = $_GET['reference'];
$url = "https://api.paystack.co/transaction/verify/" . $reference;
$key = "";

// Open connection
$ch = curl_init();

// Set the URL and headers
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer $key",
    "Cache-Control: no-cache",
));

// Execute GET request
$result = curl_exec($ch);

// Check for errors in the cURL request
if ($result === false) {
    die('cURL error: ' . curl_error($ch));
}

// Decode the JSON response
$response = json_decode($result, true);

// Echo the response as JSON
//echo json_encode($response, JSON_PRETTY_PRINT);

// Close the cURL connection
curl_close($ch);

// Handle the response
if ($response['status'] && $response['data']['status'] === 'success') {
    // Payment was successful
    echo "Payment verification successful!";
    // You can now use $response['data'] for further processing
} else {
    // Payment verification failed or encountered an error
    echo "Verification failed: " . $response['message'];
}
