<?php
require_once 'src/app/bootstrap.php';

$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

// Set area code
$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('adminhtml');

echo "=== MANUAL COMMISSION CALCULATION TEST ===\n";

try {
    // Get the calculation helper
    $calcHelper = $objectManager->get('Mageplaza\Affiliate\Helper\Calculation');
    $logger = $objectManager->get('Psr\Log\LoggerInterface');
    
    echo "Helper loaded successfully\n";
    
    // Get a specific order item (let's use order item ID 25 from your data)
    $orderItem = $objectManager->create('Magento\Sales\Model\Order\Item')->load(25);
    
    if (!$orderItem->getId()) {
        echo "Order item 25 not found\n";
        exit;
    }
    
    echo "Order Item ID: " . $orderItem->getId() . "\n";
    echo "Order Item SKU: " . $orderItem->getSku() . "\n";
    echo "Campaign ID: " . $orderItem->getAffiliateCampaign() . "\n";
    echo "Affiliate Key: " . $orderItem->getAffiliateKey() . "\n";
    
    // Test the commission calculation
    echo "\n=== Testing Commission Calculation ===\n";
    $tiers = $calcHelper->calculateCommissionForOrderItem($orderItem);
    
    echo "Calculation result: " . json_encode($tiers) . "\n";
    
    if (!empty($tiers)) {
        echo "Commission calculated successfully!\n";
        
        // Test saving to database
        echo "\n=== Testing Database Save ===\n";
        $orderItem->setAffiliateCommission($calcHelper->serialize($tiers));
        $orderItem->save();
        
        echo "Commission saved to order item\n";
        
        // Update order total
        $order = $orderItem->getOrder();
        $orderTotal = array_sum($tiers);
        $order->setAffiliateCommission($orderTotal);
        $order->save();
        
        echo "Order total commission updated: " . $orderTotal . "\n";
        
    } else {
        echo "No commission calculated\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== TEST COMPLETE ===\n"; 