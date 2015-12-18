<?php
namespace Ecg\Sniffs\PHP;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class VarSniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
            T_VAR
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addWarning('Use of var class variables is discouraged.', $stackPtr, 'Found');
    }
}
