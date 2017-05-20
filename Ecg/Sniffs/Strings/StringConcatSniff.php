<?php
namespace Ecg\Sniffs\Strings;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

class StringConcatSniff implements Sniff
{
    public function register()
    {
        return [
            T_PLUS,
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $prev = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
        $next = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, null, true);
        if ($prev === false || $next === false) {
            return;
        }
        $beforePrev = $phpcsFile->findPrevious(T_WHITESPACE, $prev - 1, null, true);

        $stringTokens = Tokens::$stringTokens;
        if (in_array($tokens[$prev]['code'], $stringTokens)
            || in_array($tokens[$next]['code'], $stringTokens)
            || $tokens[$beforePrev]['code'] === T_STRING_CONCAT
        ) {
            $phpcsFile->addError('Use of + operator to concatenate two strings detected', $stackPtr, 'Found');
        }
    }
}
