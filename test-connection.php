<?php
/**
 * Aetheric to ViserMart Connection Tester
 * Save as: /var/www/aetheric/test-connection.php
 */

$viserMartUrl = 'https://decorworld.gt.tc';
$apiKey = 'd8ce954733b01215a425eec9c8fce2f01f8c68f6691cb4ee747e59f16fb359ea';

echo "--- Testing SolidNew -> ViserMart Connection ---\n";

// Test 1: Simple Connectivity
echo "[Test 1] Checking if ViserMart is reachable...\n";
$ch = curl_init($viserMartUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypassing SSL for test
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "cURL Error: " . ($error ?: 'None') . "\n\n";

// Test 2: API Authentication & Initiation
echo "[Test 2] Testing API Payment Initiation (Critical)...\n";
$postData = [
    'external_reference' => 'TEST_' . time(),
    'amount' => 10,
    'currency' => 'KES',
    'customer_email' => 'test@aetheric.live',
    'callback_url' => 'https://aetheric.live/ipn/visermart',
    'return_url' => 'https://aetheric.live/user/deposit/log'
];

$jsonData = json_encode($postData);
$apiUrl = $viserMartUrl . '/api/external/payment/initiate';

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Aetheric-Key: ' . $apiKey,
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "API Endpoint: $apiUrl\n";
echo "HTTP Code: $httpCode\n";
echo "cURL Error: " . ($error ?: 'None') . "\n";
echo "--- RAW RESPONSE START ---\n";
print_r(json_decode($response, true) ?: $response);
echo "\n--- RAW RESPONSE END ---\n";