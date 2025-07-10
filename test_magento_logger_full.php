<?php
// Full Magento logger test
echo "=== FULL MAGENTO LOGGER TEST ===\n";

// Bootstrap Magento
require_once 'src/app/bootstrap.php';

try {
    $bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
    $objectManager = $bootstrap->getObjectManager();
    
    echo "✓ Magento bootstrapped successfully\n";
    
    // Get the logger
    $logger = $objectManager->get(\Psr\Log\LoggerInterface::class);
    echo "✓ Logger obtained: " . get_class($logger) . "\n";
    
    // Test different log levels
    $logger->info('TEST: This is an INFO message from Magento logger');
    echo "✓ INFO message logged\n";
    
    $logger->error('TEST: This is an ERROR message from Magento logger');
    echo "✓ ERROR message logged\n";
    
    $logger->debug('TEST: This is a DEBUG message from Magento logger');
    echo "✓ DEBUG message logged\n";
    
    $logger->warning('TEST: This is a WARNING message from Magento logger');
    echo "✓ WARNING message logged\n";
    
    $logger->critical('TEST: This is a CRITICAL message from Magento logger');
    echo "✓ CRITICAL message logged\n";
    
    echo "✓ All log messages sent\n";
    echo "Check var/log/system.log and var/log/debug.log for results\n";
    
} catch (Exception $e) {
    echo "✗ Test failed: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== FULL MAGENTO LOGGER TEST COMPLETE ===\n"; 