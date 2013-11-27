<?php

class Ecg_Tests_Strings_StringPositionUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array();

    }

    public function getWarningList()
    {
        return array(
            '6'  => 1,
            '10' => 1,
            '14' => 1,
        );
    }
}
