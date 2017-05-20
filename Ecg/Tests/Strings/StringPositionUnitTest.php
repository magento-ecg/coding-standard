<?php

namespace Ecg\Tests\Strings;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class StringPositionUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [];
    }

    public function getWarningList()
    {
        return [
            '6'  => 1,
            '10' => 1,
            '14' => 1,
        ];
    }
}
