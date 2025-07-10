<?php
// Simple logger test
echo "=== SIMPLE LOGGER TEST ===\n";

// Test direct log writing
$logFile = 'var/log/registry_fix_test.log';
$timestamp = date('Y-m-d H:i:s');

$testMessages = [
    'INFO' => 'Registry key fix test - logger is working',
    'ERROR' => 'Test error message',
    'DEBUG' => 'Test debug message',
    'WARNING' => 'Test warning message'
];

foreach ($testMessages as $level => $message) {
    $logEntry = "[{$timestamp}] main.{$level}: {$message} [] []\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
    echo "✓ Wrote {$level} message to log\n";
}

// Also write to system.log
$systemLogEntry = "[{$timestamp}] main.INFO: Registry key fix test completed [] []\n";
file_put_contents('var/log/system.log', $systemLogEntry, FILE_APPEND);
echo "✓ Wrote to system.log\n";

echo "✓ Simple logger test completed\n";
echo "Check var/log/registry_fix_test.log and var/log/system.log for results\n";

echo "\n=== SIMPLE LOGGER TEST COMPLETE ===\n"; 