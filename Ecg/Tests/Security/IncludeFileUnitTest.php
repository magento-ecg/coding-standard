<?php

namespace Ecg\Tests\Security;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class IncludeFileUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [];
    }

    public function getWarningList()
    {
        return [
            '3'  => 1,
            '4'  => 1,
            '6'  => 1,
            '7'  => 1,
            '9'  => 1,
            '10' => 1,
            '12' => 1,
            '13' => 1,
            '15' => 1,
            '17' => 1,
            '23' => 1,
            '24' => 1,
        ];
    }
}
