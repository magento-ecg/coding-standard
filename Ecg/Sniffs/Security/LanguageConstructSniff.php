<?php

class Ecg_Sniffs_Security_LanguageConstructSniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
            T_EXIT,
            T_ECHO,
            T_PRINT,
            T_BACKTICK
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['code'] === T_BACKTICK) {
            if ($phpcsFile->findNext(T_BACKTICK, $stackPtr + 1)) return;
            $phpcsFile->addError('Incorrect usage of back quote string constant. Back quotes should be always inside strings.',
                $stackPtr, 'WrongBackQuotesUsage');
            return;
        }
        if ($tokens[$stackPtr]['code'] === T_EXIT) {
            $code = 'ExitUsage';
        } else {
            $code = 'DirectOutput';
        }
        $phpcsFile->addWarning('Use of %s language construct is discouraged.',
            $stackPtr, $code, array($tokens[$stackPtr]['content']));
    }
}
