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

        $prevPrevToken = $phpcsFile->findPrevious(array(T_WHITESPACE, T_OPEN_PARENTHESIS, T_CLOSE_PARENTHESIS), $prevToken - 1, null, true);
        if (($tokens[$prevPrevToken]['code'] === T_VARIABLE || $tokens[$prevPrevToken]['code'] === T_STRING)
            && stripos($tokens[$prevPrevToken]['content'], 'collection') !== false) {
            $phpcsFile->addWarning('Unnecessary loading of a Magento data collection. Use the getSize() method instead.', $stackPtr, 'Found');
        }
    }
}
