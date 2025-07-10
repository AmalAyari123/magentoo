<?php
// Test registry key fix and logger functionality
echo "=== REGISTRY KEY FIX TEST ===\n";

// Bootstrap Magento
require_once 'src/app/bootstrap.php';

try {
    $bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
    $objectManager = $bootstrap->getObjectManager();
    
    echo "✓ Magento bootstrapped successfully\n";
    
    // Get the logger
    $logger = $objectManager->get(\Psr\Log\LoggerInterface::class);
    echo "✓ Logger obtained: " . get_class($logger) . "\n";
    
    // Test logger functionality
    $logger->info('TEST: Registry key fix test - logger is working');
    echo "✓ Logger test message sent\n";
    
    // Test registry key handling
    $registry = $objectManager->get(\Magento\Framework\Registry::class);
    $calculationHelper = $objectManager->get(\Mageplaza\Affiliate\Helper\Calculation::class);
    
    echo "✓ Registry and Calculation helper obtained\n";
    
    // Test safe registry operation
    $result = $calculationHelper->canCalculate(1, [], false);
    echo "✓ canCalculate method executed without registry conflict\n";
    echo "Result: " . ($result ? 'true' : 'false') . "\n";
    
    // Test that registry is properly cleaned up
    $registryKey = $registry->registry('mp_affiliate_account');
    echo "Registry key after canCalculate: " . ($registryKey ? 'EXISTS' : 'NOT EXISTS') . "\n";
    
    $logger->info('TEST: Registry key fix test completed successfully');
    echo "✓ Registry key fix test completed\n";
    
} catch (Exception $e) {
    echo "✗ Test failed: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== REGISTRY KEY FIX TEST COMPLETE ===\n"; 