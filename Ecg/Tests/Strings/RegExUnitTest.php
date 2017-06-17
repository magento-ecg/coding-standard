<?php

namespace Ecg\Tests\Strings;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class RegExUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [];
    }

    public function getWarningList()
    {
        return [
            4  => 1,
            7  => 1,
            12 => 1,
            14 => 1,
        ];
    }
}
