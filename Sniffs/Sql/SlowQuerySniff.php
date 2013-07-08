<?php

class Ecg_Sniffs_Sql_SlowQuerySniff implements PHP_CodeSniffer_Sniff
{
    public $adapterMethods = array(
        'GROUP',
        'HAVING',
        'DISTINCT',
        'LIKE',
        'UNION',
    );

    public $rawStatements = array(
        'GROUP BY',
        'HAVING',
        'DISTINCT',
        'LIKE',
        'UNION',
    );

    public function register()
    {
        return array(T_STRING, T_CONSTANT_ENCAPSED_STRING);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $prev = $tokens[$phpcsFile->findPrevious(array(T_WHITESPACE, T_OPEN_PARENTHESIS), $stackPtr - 1, null, true)];

        if ($tokens[$stackPtr]['code'] === T_CONSTANT_ENCAPSED_STRING && ($prev['code'] === T_EQUAL || $prev['code'] == T_STRING)) {
            if (preg_match('/' . implode('|', $this->rawStatements) . '\s/i', $tokens[$stackPtr]['content'])) {
                $phpcsFile->addWarning('Possible slow SQL statement %s detected', $stackPtr, 'SlowRawSql', array($tokens[$stackPtr]['content']));
            }
        } else if ($tokens[$stackPtr]['code'] === T_STRING && $prev['code'] === T_OBJECT_OPERATOR) {
            if (in_array($tokens[$stackPtr]['content'], $this->adapterMethods)) {
                $phpcsFile->addWarning('Possible slow SQL method %s detected', $stackPtr, 'SlowSql', array($tokens[$stackPtr]['content']));
            }
        }
    }
}
