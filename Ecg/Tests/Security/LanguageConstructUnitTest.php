<?php

namespace Ecg\Tests\Security;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class LanguageConstructUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList()
    {
        return [
            '8'  => 1
        ];
    }

    public function getWarningList()
    {
        return [
            '7'  => 1,
            '10' => 1,
            '14' => 1,
            '15' => 1,
        ];
    }
}
