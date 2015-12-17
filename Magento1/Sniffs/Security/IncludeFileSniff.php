<?php

class Ecg_Sniffs_Security_IncludeFileSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Pattern to match urls
     *
     * @var string
     */
    public $urlPattern = '#(https?|ftp)://.*#i';

    public function register()
    {
        return PHP_CodeSniffer_Tokens::$includeTokens;
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens     = $phpcsFile->getTokens();
        $firstToken = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $stackPtr + 1, null, true);

        $error = '"%s" statement detected. File manipulations are discouraged.';

        if ($tokens[$firstToken]['code'] === T_OPEN_PARENTHESIS) {
            $error .= ' Statement is not a function, no parentheses are required.';
            $firstToken = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $firstToken + 1, null, true);
        }

        $nextToken = $firstToken;
        $ignoredTokens = array_merge(PHP_CodeSniffer_Tokens::$emptyTokens, array(T_CLOSE_PARENTHESIS));

        $isConcatenated   = false;
        $isUrl            = false;
        $hasVariable      = false;
        $includePath      = '';

        while($tokens[$nextToken]['code'] !== T_SEMICOLON &&
            $tokens[$nextToken]['code'] !== T_CLOSE_TAG) {
            switch ($tokens[$nextToken]['code']) {
                case T_CONSTANT_ENCAPSED_STRING :
                    $includePath = trim($tokens[$nextToken]['content'], '"\'');
                    if (preg_match($this->urlPattern, $includePath)) {
                        $isUrl = true;
                    }
                    break;
                case T_STRING_CONCAT : {
                    $isConcatenated = true;
                    break;
                }
                case T_VARIABLE : {
                    $hasVariable = true;
                    break;
                }
            }

            $nextToken = $phpcsFile->findNext($ignoredTokens, $nextToken + 1, null, true);
        }

        if (stripos($includePath, 'controller') !== false && $tokens[$stackPtr]['level'] === 0) {
            $nextToken = $phpcsFile->findNext(T_CLASS, $nextToken + 1);
            if ($nextToken) {
                $nextToken = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $nextToken + 1, null, true);
                $className = $tokens[$nextToken]['content'];
                if (strripos($className, 'controller') !== false) {
                    return;
                }
            }
        }

        if ($isUrl) {
            $error .= ' Passing urls is forbidden.';
        }
        if ($isConcatenated) {
            $error .= ' Concatenating is forbidden.';
        }
        if ($hasVariable) {
            $error .= ' Variables inside are insecure.';
        }

        $phpcsFile->addWarning($error, $stackPtr, 'IncludeFileDetected', array($tokens[$stackPtr]['content']));
    }
}
