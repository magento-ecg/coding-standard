<?php
namespace Ecg\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class GotoSniff implements Sniff
{
    public function register()
    {
        return [
            T_GOTO
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addWarning('Use of goto is discouraged.', $stackPtr, 'Found');
    }
}
