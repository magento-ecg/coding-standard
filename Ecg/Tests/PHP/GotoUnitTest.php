<?php

namespace Ecg\Tests\PHP;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class GotoUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [];
    }

    public function getWarningList()
    {
        return [
            3 => 2,
            13 => 1,
        ];
    }
}
