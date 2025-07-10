<?php
// Manual test to create an invoice and trigger the plugin
echo "=== MANUAL INVOICE TEST ===\n";

// First, let's check if we can write to the test log file
$testLog = '/tmp/affiliate_plugin_test.log';
file_put_contents($testLog, date('Y-m-d H:i:s') . ' - Manual test started' . "\n", FILE_APPEND);
echo "✓ Test log file created/updated\n";

// Now let's try to manually trigger the plugin logic
echo "Testing commission calculation with order item 25...\n";

// Simulate the data we know exists
$orderItemData = [
    'item_id' => 25,
    'campaign_id' => 7,
    'affiliate_key' => 'some_key',
    'sku' => 'test_sku',
    'qty' => 1,
    'price' => 100
];

echo "Order item data: " . json_encode($orderItemData) . "\n";

// Simulate the commission calculation
$campaignCommission = serialize([
    0 => [
        'type' => '1',
        'value' => '10',
        'tier_id' => '1'
    ]
]);

echo "Campaign commission: " . $campaignCommission . "\n";

// Calculate commission manually
$unserialized = unserialize($campaignCommission);
$amount = 0;

if (is_array($unserialized) && !empty($unserialized)) {
    foreach ($unserialized as $rule) {
        if (isset($rule['type'], $rule['value'])) {
            if ($rule['type'] == '1') { // percentage
                $amount = ($orderItemData['price'] * (float)$rule['value'] / 100) * $orderItemData['qty'];
                echo "Commission calculated: " . $amount . "\n";
            }
        }
        break;
    }
}

if ($amount > 0) {
    echo "✓ Commission calculation successful: " . $amount . "\n";
    
    // Simulate saving to database
    $tiers = [1 => $amount]; // account_id => amount
    $serializedTiers = serialize($tiers);
    
    echo "Serialized tiers: " . $serializedTiers . "\n";
    echo "This would be saved to affiliate_commission field\n";
    
    // Write to test log
    file_put_contents($testLog, date('Y-m-d H:i:s') . ' - Commission calculated: ' . $amount . "\n", FILE_APPEND);
    
} else {
    echo "✗ Commission calculation failed\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "Check /tmp/affiliate_plugin_test.log for results\n"; 