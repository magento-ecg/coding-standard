<?php

class Ecg_Tests_Security_LanguageConstructUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array('8'  => 1);

    }

    public function getWarningList()
    {
        return array(
            '7'  => 1,
            '10' => 1,
            '14' => 1,
            '15' => 1,

        );
    }
}
