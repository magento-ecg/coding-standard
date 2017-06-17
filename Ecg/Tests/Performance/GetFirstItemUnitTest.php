<?php

namespace Ecg\Tests\Performance;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class GetFirstItemUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [];
    }

    public function getWarningList()
    {
        return [
            '8'  => 1,
            '10' => 1,
        ];
    }
}
