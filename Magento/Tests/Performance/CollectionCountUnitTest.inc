<?php

class TestCollectionCount
{
    public function go()
    {
        $productCollection = Mage::getModel('catalog/product')->getCollection();
        $count = $productCollection->count();

        $count2 = Mage::getModel('catalog/product')->getCollection()->count();
    }
}