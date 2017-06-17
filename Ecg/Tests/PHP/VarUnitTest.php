<?php

namespace Ecg\Tests\PHP;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class VarUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [];
    }

    public function getWarningList()
    {
        return [
            9  => 1,
            10 => 1,
            11 => 2,
        ];
    }
}
