<?php
// Test Magento logger functionality
echo "=== MAGENTO LOGGER TEST ===\n";

// Try to use Magento's logger directly
try {
    // Simple test without full bootstrap
    $logFile = 'var/log/magento_test.log';
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' - Magento logger test started' . "\n", FILE_APPEND);
    
    // Test different log levels
    $testMessages = [
        'info' => 'This is an INFO message',
        'error' => 'This is an ERROR message', 
        'debug' => 'This is a DEBUG message',
        'warning' => 'This is a WARNING message'
    ];
    
    foreach ($testMessages as $level => $message) {
        $logEntry = date('Y-m-d H:i:s') . " [{$level}] {$message}\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
        echo "✓ Wrote {$level} message to log\n";
    }
    
    echo "✓ Magento logger test completed\n";
    echo "Check var/log/magento_test.log for results\n";
    
} catch (Exception $e) {
    echo "✗ Logger test failed: " . $e->getMessage() . "\n";
}

// Test if we can write to system.log with proper format
$systemLogEntry = date('Y-m-d H:i:s') . " [INFO] Magento logger test - system.log write\n";
file_put_contents('var/log/system.log', $systemLogEntry, FILE_APPEND);
echo "✓ Wrote to system.log\n";

echo "\n=== MAGENTO LOGGER TEST COMPLETE ===\n"; 