<?php

class Ecg_Tests_Sql_RawQueryUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array();

    }

    public function getWarningList()
    {
        return array(
            '8'  => 1,
            '26' => 1,
            '35' => 1,
            '43' => 1,
            '49' => 1,
            '64' => 1,
            '86' => 1,
            '90' => 1,
            '93' => 1,
        );
    }
}
