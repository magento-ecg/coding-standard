<?php

namespace Ecg\Tests\Strings;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class StringConcatUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [
            3  => 2,
            5  => 1,
            9  => 1,
            10 => 1,
            13 => 1,
        ];
    }

    public function getWarningList()
    {
        return [];
    }
}
