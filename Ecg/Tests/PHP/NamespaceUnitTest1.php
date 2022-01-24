<?php

namespace N1;

use Magento\Framework\Exception\LocalizedException;

class NSException extends LocalizedException
{
    public function checkFalsePositiveNamespaceIssue()
    {
        $checked = true;
        try {
            throw new NSException(__('Check false positive NS sniffer'));
        } catch (Exception $e) {
            $checked = false;
        }

        return $checked;
    }
}

try {
    throw new \N1\NSException('Check falsepositive');
} catch (\N1\NSException $e) {
    $error = $e->getMessage();
}
