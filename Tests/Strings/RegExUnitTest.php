<?php

class Ecg_Tests_Strings_RegExUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array();

    }

    public function getWarningList()
    {
        return array(
            4  => 1,
            7  => 1,
            12 => 1,
            14 => 1,
        );
    }
}
