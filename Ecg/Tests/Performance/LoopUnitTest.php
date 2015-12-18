<?php

class Ecg_Tests_Performance_LoopUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array(
            '10' => 1,
            '11' => 2,
            '12' => 1,
            '13' => 1,
            '14' => 1,
            '20' => 1,
            '21' => 2,
            '22' => 1,
            '23' => 1,
            '24' => 1,
            '28' => 1,
            '29' => 2,
            '30' => 1,
            '31' => 1,
            '32' => 1,
            '37' => 1,
            '38' => 2,
            '39' => 1,
            '40' => 1,
            '41' => 1,
            '50' => 1,
        );
    }

    public function getWarningList()
    {
        return [];
    }
}
