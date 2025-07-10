<?php
// Test logger functionality
echo "=== LOGGER TEST ===\n";

// Test 1: Direct file write
$testFile = '/tmp/logger_test.log';
file_put_contents($testFile, date('Y-m-d H:i:s') . ' - Direct file write test' . "\n", FILE_APPEND);
echo "✓ Direct file write test completed\n";

// Test 2: Check if we can write to Magento log directory
$magentoLogDir = 'var/log/';
$testMagentoLog = $magentoLogDir . 'test.log';
file_put_contents($testMagentoLog, date('Y-m-d H:i:s') . ' - Magento log directory test' . "\n", FILE_APPEND);
echo "✓ Magento log directory write test completed\n";

// Test 3: Check log file permissions
echo "Log directory permissions: " . substr(sprintf('%o', fileperms($magentoLogDir)), -4) . "\n";
echo "System log permissions: " . substr(sprintf('%o', fileperms($magentoLogDir . 'system.log')), -4) . "\n";

// Test 4: Try to write to system.log directly
file_put_contents($magentoLogDir . 'system.log', date('Y-m-d H:i:s') . ' - Direct system.log write test' . "\n", FILE_APPEND);
echo "✓ Direct system.log write test completed\n";

// Test 5: Check if files were created/updated
echo "Files created/updated:\n";
echo "- /tmp/logger_test.log: " . (file_exists('/tmp/logger_test.log') ? 'EXISTS' : 'MISSING') . "\n";
echo "- var/log/test.log: " . (file_exists('var/log/test.log') ? 'EXISTS' : 'MISSING') . "\n";
echo "- var/log/system.log: " . (file_exists('var/log/system.log') ? 'EXISTS' : 'MISSING') . "\n";

echo "\n=== LOGGER TEST COMPLETE ===\n"; 