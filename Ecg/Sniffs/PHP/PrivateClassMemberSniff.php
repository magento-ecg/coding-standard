<?php
namespace Ecg\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class PrivateClassMemberSniff implements Sniff
{
    public function register()
    {
        return [
            T_PRIVATE
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addWarning('Private class member detected.', $stackPtr, 'PrivateClassMemberError');
    }
}
