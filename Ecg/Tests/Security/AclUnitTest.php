<?php

class Ecg_Tests_Security_AclUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return array();
    }

    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return array(
            '11' => 1
        );
    }
}
