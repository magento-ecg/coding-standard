<?php
namespace Ecg\Sniffs\PHP;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class GotoSniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
            T_GOTO
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addWarning('Use of goto is discouraged.', $stackPtr, 'Found');
    }
}
