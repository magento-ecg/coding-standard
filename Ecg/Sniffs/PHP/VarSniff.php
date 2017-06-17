<?php
namespace Ecg\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class VarSniff implements Sniff
{
    public function register()
    {
        return [
            T_VAR
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addWarning('Use of var class variables is discouraged.', $stackPtr, 'Found');
    }
}
