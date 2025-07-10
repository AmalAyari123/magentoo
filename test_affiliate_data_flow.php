<?php
require_once 'vendor/autoload.php';

use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\ObjectManager;

// Initialize Magento
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

try {
    echo "=== AFFILIATE DATA FLOW DEBUG ===\n";
    
    // Get the order repository
    $orderRepository = $objectManager->get('Magento\Sales\Api\OrderRepositoryInterface');
    
    // Test with a specific order (you can change this order ID)
    $orderId = 153; // Based on the log showing order_increment_id: 000000153
    
    echo "Testing order ID: $orderId\n";
    
    try {
        $order = $orderRepository->get($orderId);
        echo "Order found: " . $order->getIncrementId() . "\n";
        
        // Check order-level affiliate data
        echo "Order affiliate_key: " . ($order->getAffiliateKey() ?: 'NULL') . "\n";
        echo "Order affiliate_campaign: " . ($order->getAffiliateCampaign() ?: 'NULL') . "\n";
        echo "Order affiliate_commission: " . ($order->getAffiliateCommission() ?: 'NULL') . "\n";
        
        // Check order items
        echo "\n=== ORDER ITEMS ===\n";
        foreach ($order->getAllItems() as $orderItem) {
            echo "Order Item ID: " . $orderItem->getId() . "\n";
            echo "  SKU: " . $orderItem->getSku() . "\n";
            echo "  affiliate_key: " . ($orderItem->getData('affiliate_key') ?: 'NULL') . "\n";
            echo "  affiliate_campaign: " . ($orderItem->getData('affiliate_campaign') ?: 'NULL') . "\n";
            echo "  affiliate_commission: " . ($orderItem->getData('affiliate_commission') ?: 'NULL') . "\n";
            echo "  ---\n";
        }
        
        // Check invoices
        echo "\n=== INVOICES ===\n";
        foreach ($order->getInvoiceCollection() as $invoice) {
            echo "Invoice ID: " . $invoice->getId() . "\n";
            echo "Invoice Increment ID: " . $invoice->getIncrementId() . "\n";
            echo "  affiliate_key: " . ($invoice->getData('affiliate_key') ?: 'NULL') . "\n";
            echo "  affiliate_campaign: " . ($invoice->getData('affiliate_campaign') ?: 'NULL') . "\n";
            echo "  affiliate_commission: " . ($invoice->getData('affiliate_commission') ?: 'NULL') . "\n";
            
            echo "  === INVOICE ITEMS ===\n";
            foreach ($invoice->getAllItems() as $invItem) {
                echo "  Invoice Item ID: " . $invItem->getId() . "\n";
                echo "  Order Item ID: " . $invItem->getOrderItemId() . "\n";
                echo "    affiliate_key: " . ($invItem->getData('affiliate_key') ?: 'NULL') . "\n";
                echo "    affiliate_campaign: " . ($invItem->getData('affiliate_campaign') ?: 'NULL') . "\n";
                echo "    affiliate_commission: " . ($invItem->getData('affiliate_commission') ?: 'NULL') . "\n";
                echo "    ---\n";
            }
            echo "  ---\n";
        }
        
    } catch (\Exception $e) {
        echo "Error loading order: " . $e->getMessage() . "\n";
    }
    
    echo "\n=== END DEBUG ===\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 