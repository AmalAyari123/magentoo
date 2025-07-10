<?php
require_once 'vendor/autoload.php';

use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\ObjectManager;

// Initialize Magento
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

try {
    // Get the calculation helper
    $calcHelper = $objectManager->get('Mageplaza\Affiliate\Helper\Calculation');
    
    // Create a mock order item for testing
    $orderItem = $objectManager->create('Magento\Sales\Model\Order\Item');
    $orderItem->setId(1);
    $orderItem->setQtyOrdered(2);
    $orderItem->setBasePrice(50.00);
    $orderItem->setAffiliateKey('TEST123');
    $orderItem->setAffiliateCampaign(1);
    
    echo "Testing commission calculation...\n";
    echo "Order Item ID: " . $orderItem->getId() . "\n";
    echo "Qty: " . $orderItem->getQtyOrdered() . "\n";
    echo "Price: " . $orderItem->getBasePrice() . "\n";
    echo "Affiliate Key: " . $orderItem->getAffiliateKey() . "\n";
    echo "Affiliate Campaign: " . $orderItem->getAffiliateCampaign() . "\n";
    
    // Test the commission calculation
    $tiers = $calcHelper->calculateCommissionForOrderItem($orderItem);
    
    echo "Raw tiers result: " . json_encode($tiers) . "\n";
    echo "Tiers type: " . gettype($tiers) . "\n";
    
    if (is_array($tiers)) {
        $commission = array_sum($tiers);
        echo "Commission after array_sum: " . $commission . "\n";
        echo "Commission type: " . gettype($commission) . "\n";
        
        // Test setting it on an object
        $testObject = $objectManager->create('Magento\Framework\DataObject');
        $testObject->setData('affiliate_commission', $commission);
        
        $retrieved = $testObject->getData('affiliate_commission');
        echo "Retrieved commission: " . $retrieved . "\n";
        echo "Retrieved type: " . gettype($retrieved) . "\n";
        
        echo "✓ Test passed: Commission is properly handled as scalar\n";
    } else {
        echo "✗ Test failed: Expected array, got " . gettype($tiers) . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 