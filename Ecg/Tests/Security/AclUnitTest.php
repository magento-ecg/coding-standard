<?php

namespace Ecg\Tests\Security;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class AclUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            '11' => 1
        ];
    }
}
