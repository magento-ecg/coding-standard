<?php

class Ecg_Sniffs_PHP_GotoSniff implements PHP_CodeSniffer_Sniff
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
