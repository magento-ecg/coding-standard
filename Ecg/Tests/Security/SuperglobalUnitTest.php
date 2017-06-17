<?php

namespace Ecg\Tests\Security;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class SuperglobalUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [
            '12' => 1,
            '15' => 1,
            '16' => 1,
            '17' => 1,
            '18' => 1,
            '19' => 1,
            '20' => 1,
            '21' => 1,
        ];
    }

    public function getWarningList()
    {
        return [];
    }
}
