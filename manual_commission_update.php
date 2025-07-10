<?php
// Manual commission update test
echo "=== MANUAL COMMISSION UPDATE TEST ===\n";

// Calculate the commission that should be saved
$orderItemData = [
    'item_id' => 25,
    'campaign_id' => 7,
    'price' => 100,
    'qty' => 1
];

// Simulate commission calculation
$campaignCommission = serialize([
    0 => [
        'type' => '1',
        'value' => '10',
        'tier_id' => '1'
    ]
]);

$unserialized = unserialize($campaignCommission);
$amount = 0;

if (is_array($unserialized) && !empty($unserialized)) {
    foreach ($unserialized as $rule) {
        if (isset($rule['type'], $rule['value'])) {
            if ($rule['type'] == '1') { // percentage
                $amount = ($orderItemData['price'] * (float)$rule['value'] / 100) * $orderItemData['qty'];
            }
        }
        break;
    }
}

if ($amount > 0) {
    echo "Commission calculated: " . $amount . "\n";
    
    // Create the tiers array that would be saved
    $tiers = [1 => $amount]; // account_id => amount
    $serializedTiers = serialize($tiers);
    
    echo "Serialized tiers to save: " . $serializedTiers . "\n";
    
    // Show the SQL that would be executed
    echo "\n=== SQL TO EXECUTE ===\n";
    echo "-- Update order item commission\n";
    echo "UPDATE sales_order_item SET affiliate_commission = '" . addslashes($serializedTiers) . "' WHERE item_id = 25;\n";
    echo "\n";
    echo "-- Update order total commission\n";
    echo "UPDATE sales_order SET affiliate_commission = " . $amount . " WHERE entity_id = (SELECT order_id FROM sales_order_item WHERE item_id = 25);\n";
    
    // Write to test log
    file_put_contents('/tmp/affiliate_plugin_test.log', date('Y-m-d H:i:s') . ' - Manual commission update: ' . $amount . "\n", FILE_APPEND);
    
    echo "\n=== MANUAL UPDATE INSTRUCTIONS ===\n";
    echo "1. Run the SQL commands above in your database\n";
    echo "2. Check if affiliate_commission fields are updated\n";
    echo "3. Create an invoice for the order to test if transaction is created\n";
    
} else {
    echo "✗ Commission calculation failed\n";
}

echo "\n=== TEST COMPLETE ===\n"; 