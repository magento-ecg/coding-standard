<?php

/**
 * Check if the === operator is used for testing the return value of the strpos PHP function
 *
 * Class Ecg_Sniffs_Strings_StringPositionSniff
 */
class Ecg_Sniffs_Strings_StringPositionSniff implements PHP_CodeSniffer_Sniff
{
    public $functions = array(
        'strpos',
        'stripos',
    );

    public function register()
    {
        return array(T_STRING);
    }

    protected $ignoreTokens = array(
        T_DOUBLE_COLON,
        T_OBJECT_OPERATOR,
        T_FUNCTION,
        T_CONST,
        T_CLASS,
    );

    protected $identicalOperators = array(
        T_IS_IDENTICAL,
        T_IS_NOT_IDENTICAL,
    );

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (!in_array($tokens[$stackPtr]['content'], $this->functions)) {
            return;
        }
        $prevToken = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
        if (in_array($tokens[$prevToken]['code'], $this->ignoreTokens)) {
            return;
        }
        $endOfFunction = $phpcsFile->findNext(T_CLOSE_PARENTHESIS, $stackPtr + 1);
        $nextToken = $phpcsFile->findNext(T_WHITESPACE, $endOfFunction + 1, null, true);
        if (!in_array($tokens[$prevToken]['code'], $this->identicalOperators) && !in_array($tokens[$nextToken]['code'], $this->identicalOperators)) {
            $phpcsFile->addWarning('Identical operator === is not used for testing the return value of %s function', $stackPtr, 'ImproperValueTesting', array($tokens[$stackPtr]['content']));
        }
    }
}
