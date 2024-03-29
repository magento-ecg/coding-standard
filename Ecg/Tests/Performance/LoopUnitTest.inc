<?php

namespace Ecg\Tests\Performance;

class TestLoop
{
    public function go()
    {
        $data = [1, 2, 3];
        $collection = Mage::getModel('catalog/product')->getCollection();
        do {
            $product = Mage::getModel('catalog/product')->load($id);
            $c = count($data) == sizeof($data);
            $product2 = $collection->getFirstItem();
            $product2->save();
            Mage::getModel('catalog/product')->setId($id)->delete();

            $id--;
        } while ($id);

        $array = [];
        for ($i = 1; $i <= count($array); $i++) {
            $product = Mage::getModel('catalog/product')->load($id);
            $c = count($data) == sizeof($data);
            $product2 = $collection->getFirstItem();
            $product2->save();
            Mage::getModel('catalog/product')->setId($id)->delete();
        }

        foreach($collection as $product) {
            $product = Mage::getModel('catalog/product')->load($id);
            $c = count($data) == sizeof($data);
            $product2 = $collection->getFirstItem();
            $product2->save();
            Mage::getModel('catalog/product')->setId($id)->delete();
        }


        while ($id) {
            $product = Mage::getModel('catalog/product')->load($id);
            $c = count($data) == sizeof($data);
            $product2 = $collection->getFirstItem();
            $product2->save();
            Mage::getModel('catalog/product')->setId($id)->delete();

            $id--;
        }
    }
}

foreach ($collection as $item) {
    foreach ($item->getData() as $product) {
        $product = Mage::getModel('catalog/product')->load($id);
    }
}
