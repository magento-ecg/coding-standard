<?php

namespace Ecg\Tests\Sql;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class RawQueryUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [];
    }

    public function getWarningList()
    {
        return [
            '8'  => 1,
            '26' => 1,
            '35' => 1,
            '43' => 1,
            '49' => 1,
            '64' => 1,
            '86' => 1,
            '90' => 1,
            '93' => 1,
        ];
    }
}
