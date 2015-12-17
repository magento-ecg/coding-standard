<?php

class Ecg_Sniffs_Performance_GetFirstItemSniff implements PHP_CodeSniffer_Sniff
{
    public $methods = array(
        'getFirstItem',
    );

    public function register()
    {
        return array(T_STRING);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (!in_array($tokens[$stackPtr]['content'], $this->methods))
            return;

        $prevToken = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
        if ($tokens[$prevToken]['code'] !== T_OBJECT_OPERATOR)
            return;

        $phpcsFile->addWarning('getFirstItem() does not limit the result of collection load to one item.', $stackPtr, 'Found');
    }
}
