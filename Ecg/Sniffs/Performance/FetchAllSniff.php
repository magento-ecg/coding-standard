<?php
namespace Ecg\Sniffs\Performance;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class FetchAllSniff implements Sniff
{
    public $methods = [
        'fetchAll',
    ];

    public function register()
    {
        return [
            T_STRING
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (!in_array($tokens[$stackPtr]['content'], $this->methods)) {
            return;
        }

        $prevToken = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
        if ($tokens[$prevToken]['code'] !== T_OBJECT_OPERATOR) {
            return;
        }

        $phpcsFile->addWarning('fetchAll() can be memory inefficient for large data sets.', $stackPtr, 'Found');
    }
}
