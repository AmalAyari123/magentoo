<?php
// Test the commission calculation logic directly
echo "=== COMMISSION CALCULATION TEST ===\n";

// Simulate the campaign data structure based on what we know
$campaignData = [
    'campaign_id' => 7,
    'status' => 1,
    'commission' => 'a:1:{i:0;a:3:{s:4:"type";s:1:"1";s:5:"value";s:2:"10";s:6:"tier_id";s:1:"1";}}'
];

echo "Campaign data: " . json_encode($campaignData) . "\n";

// Test with a simpler serialized format
$simpleCommission = serialize([
    0 => [
        'type' => '1',
        'value' => '10',
        'tier_id' => '1'
    ]
]);

echo "Simple serialized commission: " . $simpleCommission . "\n";

// Test unserialize
$unserialized = unserialize($simpleCommission);
echo "Unserialized commission: " . json_encode($unserialized) . "\n";

// Test calculation logic
if (is_array($unserialized) && !empty($unserialized)) {
    foreach ($unserialized as $ruleIndex => $rule) {
        echo "Processing rule $ruleIndex: " . json_encode($rule) . "\n";
        
        $amount = 0;
        $qty = 1; // Simulate quantity
        $price = 100; // Simulate price
        
        echo "Rule type: " . (isset($rule['type']) ? $rule['type'] : 'NOT SET') . "\n";
        echo "Rule value: " . (isset($rule['value']) ? $rule['value'] : 'NOT SET') . "\n";
        
        if (isset($rule['type'], $rule['value'])) {
            if ($rule['type'] == '3') { // fixed amount
                $amount = (float)$rule['value'] * $qty;
                echo "Fixed commission calculation: " . $rule['value'] . " * " . $qty . " = " . $amount . "\n";
            } elseif ($rule['type'] == '1') { // percentage
                $amount = ($price * (float)$rule['value'] / 100) * $qty;
                echo "Percentage commission calculation: (" . $price . " * " . $rule['value'] . " / 100) * " . $qty . " = " . $amount . "\n";
            }
        }
        
        if ($amount > 0) {
            echo "✓ Commission amount calculated: " . $amount . "\n";
        } else {
            echo "✗ Commission amount is 0 or negative\n";
        }
        break; // Only process first tier
    }
} else {
    echo "✗ No commission rules found\n";
}

echo "\n=== TEST COMPLETE ===\n"; 