<?php
namespace Ecg\Sniffs\Performance;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class CollectionCountSniff implements Sniff
{
    public $methods = [
        'count',
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

        $prevPrevToken = $phpcsFile->findPrevious(
            [T_WHITESPACE, T_OPEN_PARENTHESIS, T_CLOSE_PARENTHESIS],
            $prevToken - 1,
            null,
            true
        );
        if (($tokens[$prevPrevToken]['code'] === T_VARIABLE || $tokens[$prevPrevToken]['code'] === T_STRING)
            && stripos($tokens[$prevPrevToken]['content'], 'collection') !== false) {
            $phpcsFile->addWarning(
                'Unnecessary loading of a Magento data collection. Use the getSize() method instead.',
                $stackPtr,
                'Found'
            );
        }
    }
}
