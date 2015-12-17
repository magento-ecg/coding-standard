<?php

class Magento_Tests_Performance_FetchAllUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [];
    }

    public function getWarningList()
    {
        return ['3' => 1];
    }
}
