<?php

class Good_Phoenix_Moneybookers_MoneybookersController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config/moneybookers');
    }
}

class Wrong_Phoenix_Moneybookers_MoneybookersController extends Mage_Adminhtml_Controller_Action
{
}
