<?php
namespace Ecg\Sniffs\PHP;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class PrivateClassMemberSniff implements PHP_CodeSniffer_Sniff
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
