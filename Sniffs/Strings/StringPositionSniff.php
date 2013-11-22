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
        return array(T_IF);
    }

    protected $identicalOperators = array(
        T_IS_IDENTICAL,
        T_IS_NOT_IDENTICAL,
    );

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $open  = $tokens[$stackPtr]['parenthesis_opener'];
        $close = $tokens[$stackPtr]['parenthesis_closer'];

        $foundFunction = false;
        $foundIdentityOperator = false;

        for ($i = $open + 1; $i < $close; $i++) {
            if ($tokens[$i]['code'] === T_STRING && in_array($tokens[$i]['content'], $this->functions)) {
                $foundFunction = true;
            } else if ($tokens[$i]['code'] === T_IS_IDENTICAL || $tokens[$i]['code'] === T_IS_NOT_IDENTICAL) {
                $foundIdentityOperator = true;
            }
        }

        if ($foundFunction && !$foundIdentityOperator) {
            $phpcsFile->addWarning('Identical operator === is not used for testing the return value of %s function',
                $stackPtr, 'ImproperValueTesting', array($tokens[$stackPtr]['content']));
        }
    }
}
