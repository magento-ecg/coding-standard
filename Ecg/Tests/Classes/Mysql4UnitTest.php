<?php

class Ecg_Tests_Classes_Mysql4UnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array();

    }

    public function getWarningList()
    {
        return array(
            3  => 1,
            7  => 1,
            15 => 1,
        );
    }
}
