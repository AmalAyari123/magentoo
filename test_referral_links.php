<?php
require_once 'src/app/bootstrap.php';

$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

// Get the affiliate helper
$affiliateHelper = $objectManager->get('Mageplaza\Affiliate\Helper\Data');

// Test the getSharingParam method
echo "Testing getSharingParam method:\n";
$params = [];
$result = $affiliateHelper->getSharingParam($params);
echo "Result: " . $result . "\n";

// Test with campaign ID
echo "\nTesting getSharingParam with campaign ID:\n";
$params = ['mp_campaign_id' => '123'];
$result = $affiliateHelper->getSharingParam($params);
echo "Result: " . $result . "\n";

// Test getSharingUrl method
echo "\nTesting getSharingUrl method:\n";
$url = 'https://magento.test/';
$result = $affiliateHelper->getSharingUrl($url);
echo "Result: " . $result . "\n";

echo "\nTest completed!\n"; 