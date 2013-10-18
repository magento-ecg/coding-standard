<?php

class Ecg_Sniffs_Performance_CollectionCountSniff implements PHP_CodeSniffer_Sniff
{
    public $methods = array(
        'count',
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

        $prevPrevToken = $phpcsFile->findPrevious(T_WHITESPACE, $prevToken - 1, null, true);
        if ($tokens[$prevPrevToken]['code'] !== T_VARIABLE || strpos($tokens[$prevPrevToken]['content'], 'collection') === false)
            return;

        $phpcsFile->addWarning('Unnecessary loading of a Magento data collection. Use the getSize() method instead.', $stackPtr, 'Found');
    }
}
