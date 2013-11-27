<?php

class Ecg_Sniffs_Classes_Mysql4Sniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(T_CLASS);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $check = function ($ptr) use ($phpcsFile) {
            $tokens = $phpcsFile->getTokens();
            if (strpos($tokens[$ptr]['content'], 'Mysql4') !== false) {
                $phpcsFile->addWarning('Mysql4 classes are obsolete.', $ptr, 'Found');
                return true;
            }
            return false;
        };

        $next = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        $res = $check($next);
        if (!$res) {
            $extends = $phpcsFile->findNext(T_EXTENDS, $next + 1);
            if ($extends !== false) {
                $afterExtends = $phpcsFile->findNext(T_STRING, $extends + 1);
                $check($afterExtends);
            }
        }
    }
}
