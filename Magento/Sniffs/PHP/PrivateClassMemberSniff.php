<?php
/**
 *
 */

class Magento_Sniffs_PHP_PrivateClassMemberSniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
            T_PRIVATE
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addWarning('Private class member detected.', $stackPtr);
    }
}
