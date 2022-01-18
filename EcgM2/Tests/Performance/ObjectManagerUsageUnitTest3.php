<?php

use Magento\Customer\Model\Session;
use Magento\Framework\App\ObjectManager;

class ObjectManagerUsageUnitTest3
{
    public function __construct(
        Session $session = null
    ) {
        if (null === $session) {
            $session = ObjectManager::getInstance()->get(Session::class);
        }
    }

    public function getCustomerSession()
    {
        return ObjectManager::getInstance()->get(Session::class);
    }
}
