<?php

class Ecg_Tests_PHP_GotoUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array();

    }

    public function getWarningList()
    {
        return array(
            3 => 2,
            13 => 1,
        );
    }
}
