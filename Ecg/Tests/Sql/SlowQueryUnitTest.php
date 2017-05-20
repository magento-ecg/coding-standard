<?php

namespace Ecg\Tests\Sql;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class SlowQueryUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [];
    }

    public function getWarningList()
    {
        return [
            '7'  => 1,
            '12' => 1,
            '22' => 1,
        ];
    }
}
