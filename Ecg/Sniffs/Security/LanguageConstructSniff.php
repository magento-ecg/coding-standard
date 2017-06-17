<?php
namespace Ecg\Sniffs\Security;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class LanguageConstructSniff implements Sniff
{
    public function register()
    {
        return [
            T_EXIT,
            T_ECHO,
            T_PRINT,
            T_BACKTICK
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['code'] === T_BACKTICK) {
            if ($phpcsFile->findNext(T_BACKTICK, $stackPtr + 1)) {
                return;
            }
            $phpcsFile->addError(
                'Incorrect usage of back quote string constant. Back quotes should be always inside strings.',
                $stackPtr,
                'WrongBackQuotesUsage'
            );
            return;
        }
        if ($tokens[$stackPtr]['code'] === T_EXIT) {
            $code = 'ExitUsage';
        } else {
            $code = 'DirectOutput';
        }
        $phpcsFile->addWarning(
            'Use of %s language construct is discouraged.',
            $stackPtr,
            $code,
            [$tokens[$stackPtr]['content']]
        );
    }
}
