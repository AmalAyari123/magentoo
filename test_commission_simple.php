<?php
// Simple test to check if the plugin file exists and can be loaded
echo "=== SIMPLE PLUGIN TEST ===\n";

// Check if plugin file exists
$pluginFile = 'src/app/code/Mageplaza/Affiliate/Plugin/InvoiceRepositoryPlugin.php';
if (file_exists($pluginFile)) {
    echo "✓ Plugin file exists: $pluginFile\n";
    
    // Check file contents
    $content = file_get_contents($pluginFile);
    if (strpos($content, 'class InvoiceRepositoryPlugin') !== false) {
        echo "✓ Plugin class found in file\n";
    } else {
        echo "✗ Plugin class NOT found in file\n";
    }
    
    if (strpos($content, 'afterSave') !== false) {
        echo "✓ afterSave method found in file\n";
    } else {
        echo "✗ afterSave method NOT found in file\n";
    }
    
} else {
    echo "✗ Plugin file does not exist: $pluginFile\n";
}

// Check if di.xml has the plugin registration
$diFile = 'src/app/code/Mageplaza/Affiliate/etc/di.xml';
if (file_exists($diFile)) {
    echo "✓ di.xml file exists: $diFile\n";
    
    $content = file_get_contents($diFile);
    if (strpos($content, 'InvoiceRepositoryInterface') !== false) {
        echo "✓ InvoiceRepositoryInterface found in di.xml\n";
    } else {
        echo "✗ InvoiceRepositoryInterface NOT found in di.xml\n";
    }
    
    if (strpos($content, 'InvoiceRepositoryPlugin') !== false) {
        echo "✓ InvoiceRepositoryPlugin found in di.xml\n";
    } else {
        echo "✗ InvoiceRepositoryPlugin NOT found in di.xml\n";
    }
    
} else {
    echo "✗ di.xml file does not exist: $diFile\n";
}

// Check if events.xml has the invoice events
$eventsFile = 'src/app/code/Mageplaza/Affiliate/etc/events.xml';
if (file_exists($eventsFile)) {
    echo "✓ events.xml file exists: $eventsFile\n";
    
    $content = file_get_contents($eventsFile);
    if (strpos($content, 'sales_order_invoice_save_after') !== false) {
        echo "✓ sales_order_invoice_save_after found in events.xml\n";
    } else {
        echo "✗ sales_order_invoice_save_after NOT found in events.xml\n";
    }
    
    if (strpos($content, 'sales_order_invoice_register') !== false) {
        echo "✓ sales_order_invoice_register found in events.xml\n";
    } else {
        echo "✗ sales_order_invoice_register NOT found in events.xml\n";
    }
    
    if (strpos($content, 'sales_order_invoice_pay') !== false) {
        echo "✓ sales_order_invoice_pay found in events.xml\n";
    } else {
        echo "✗ sales_order_invoice_pay NOT found in events.xml\n";
    }
    
} else {
    echo "✗ events.xml file does not exist: $eventsFile\n";
}

echo "\n=== TEST COMPLETE ===\n"; 