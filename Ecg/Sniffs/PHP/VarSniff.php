<?php

class Ecg_Sniffs_PHP_VarSniff implements PHP_CodeSniffer_Sniff
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
