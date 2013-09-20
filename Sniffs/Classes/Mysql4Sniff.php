<?php

class Ecg_Sniffs_Classes_Mysql4Sniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(T_CLASS);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $next = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        if (strpos($phpcsFile->getTokens()[$next]['content'], 'Mysql4') !== false)
            $phpcsFile->addWarning('Mysql4 classes are obsolete.', $stackPtr, 'Found');
    }
}
