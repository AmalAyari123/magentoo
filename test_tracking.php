<?php
require_once 'src/app/bootstrap.php';

$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

// Get the affiliate helper
$affiliateHelper = $objectManager->get('Mageplaza\Affiliate\Helper\Data');

echo "=== Affiliate Tracking Test ===\n\n";

// Test 1: Check if affiliate key is in cookie
echo "1. Testing affiliate key from cookie:\n";
$affiliateKey = $affiliateHelper->getAffiliateKeyFromCookie();
echo "Affiliate Key: " . ($affiliateKey ?: 'NOT FOUND') . "\n";

// Test 2: Check if campaign ID is in cookie
echo "\n2. Testing campaign ID from cookie:\n";
$campaignId = $affiliateHelper->getCampaignIdFromCookie();
echo "Campaign ID: " . ($campaignId ?: 'NOT FOUND') . "\n";

// Test 3: Test referral link generation
echo "\n3. Testing referral link generation:\n";
$url = 'https://magento.test/';
$result = $affiliateHelper->getSharingUrl($url);
echo "Referral Link: " . $result . "\n";

// Test 4: Test with campaign ID
echo "\n4. Testing referral link with campaign ID:\n";
$params = ['mp_campaign_id' => '123'];
$result = $affiliateHelper->getSharingUrl($url, $params);
echo "Referral Link with Campaign: " . $result . "\n";

// Test 5: Check if affiliate is enabled
echo "\n5. Testing affiliate module status:\n";
$isEnabled = $affiliateHelper->isEnabled();
echo "Affiliate Module Enabled: " . ($isEnabled ? 'YES' : 'NO') . "\n";

// Test 6: Check current affiliate
echo "\n6. Testing current affiliate:\n";
try {
    $currentAffiliate = $affiliateHelper->getCurrentAffiliate();
    if ($currentAffiliate && $currentAffiliate->getId()) {
        echo "Current Affiliate ID: " . $currentAffiliate->getId() . "\n";
        echo "Current Affiliate Code: " . $currentAffiliate->getCode() . "\n";
    } else {
        echo "No current affiliate found\n";
    }
} catch (Exception $e) {
    echo "Error getting current affiliate: " . $e->getMessage() . "\n";
}

echo "\n=== Test Completed ===\n"; 