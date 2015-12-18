<?php

class TestGetFirstItem
{
    public function go()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $item = $collection->getFirstItem();

        $item2 = Mage::getModel('catalog/product')->getCollection()->getFirstItem();
    }
}