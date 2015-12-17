<?php

/**
 * Class Ecg_Sniffs_Strings_RegExSniff
 */
class Ecg_Sniffs_Strings_RegExSniff implements PHP_CodeSniffer_Sniff
{
    public $functions = array(
        'preg_replace',
    );

    protected $ignoreTokens = array(
        T_DOUBLE_COLON,
        T_OBJECT_OPERATOR,
        T_FUNCTION,
        T_CONST,
        T_CLASS,
    );

    public function register()
    {
        return array(T_STRING);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (!in_array($tokens[$stackPtr]['content'], $this->functions))
            return;

        $prevToken = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
        if (in_array($tokens[$prevToken]['code'], $this->ignoreTokens))
            return;

        $nextToken = $phpcsFile->findNext(array(T_WHITESPACE, T_OPEN_PARENTHESIS), $stackPtr + 1, null, true);
        if (in_array($tokens[$nextToken]['code'], PHP_CodeSniffer_Tokens::$stringTokens)
            && preg_match('/[#\/|~\}\)][imsxADSUXJu]*e[imsxADSUXJu]*.$/', $tokens[$nextToken]['content'])) {
            $phpcsFile->addWarning('Possible executable regular expression in %s. Make sure that the pattern doesn\'t contain "e" modifier',
                $stackPtr, 'PossibleExecutableRegEx', array($tokens[$stackPtr]['content']));
        }
    }
}
