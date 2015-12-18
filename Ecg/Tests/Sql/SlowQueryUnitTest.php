<?php

class Ecg_Tests_Sql_SlowQueryUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array();

    }

    public function getWarningList()
    {
        return array(
            '7'  => 1,
            '12' => 1,
            '22' => 1,
        );
    }
}
