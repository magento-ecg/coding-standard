<?php

class Ecg_Tests_Strings_StringConcatUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array(
            3  => 2,
            5  => 1,
            9  => 1,
            10 => 1,
            13 => 1,
        );

    }

    public function getWarningList()
    {
        return array();
    }
}
