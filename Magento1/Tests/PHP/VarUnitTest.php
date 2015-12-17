<?php

class Ecg_Tests_PHP_VarUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array();

    }

    public function getWarningList()
    {
        return array(
            9  => 1,
            10 => 1,
            11 => 2,
        );
    }
}
