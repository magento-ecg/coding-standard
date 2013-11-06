<?php

class Ecg_Sniffs_Sql_RawQuerySniff implements PHP_CodeSniffer_Sniff
{
    public $statements = array(
        'SELECT',
        'UPDATE',
        'INSERT',
        'CREATE',
        'DELETE',
        'ALTER',
        'DROP'
    );

    public $queryFunctions = array(
        'query',
        'raw_query'
    );

    public function register()
    {
        return array(T_CONSTANT_ENCAPSED_STRING);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $prev   = $tokens[$phpcsFile->findPrevious(array(T_WHITESPACE, T_OPEN_PARENTHESIS), $stackPtr - 1, null, true)];

        if ($prev['code'] === T_EQUAL || ($prev['code'] == T_STRING && in_array($prev['content'], $this->queryFunctions))) {
            if (preg_match('/^' . implode('|', $this->statements) . '\s/i', $tokens[$stackPtr]['content'])) {
                $phpcsFile->addWarning('Possible raw SQL statement %s detected', $stackPtr, 'RawSql', array($tokens[$stackPtr]['content']));
            }
        }
    }
}
