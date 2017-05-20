<?php

namespace Ecg\Tests\Classes;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class Mysql4UnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [];
    }

    public function getWarningList()
    {
        return [
            3  => 1,
            7  => 1,
            15 => 1,
        ];
    }
}
