<?php

class Ecg_Tests_Classes_ObjectInstantiationUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return array();

    }

    public function getWarningList()
    {
        return array(
            9  => 1,
            12 => 1,
        );
    }
}
