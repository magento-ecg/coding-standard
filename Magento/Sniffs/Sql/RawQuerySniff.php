<?php

class Magento_Sniffs_Sql_RawQuerySniff implements PHP_CodeSniffer_Sniff
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
        return array_merge(PHP_CodeSniffer_Tokens::$stringTokens, [T_HEREDOC, T_NOWDOC]);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $ignoredTokens = array_merge(array(T_WHITESPACE, T_OPEN_PARENTHESIS), PHP_CodeSniffer_Tokens::$stringTokens);
        $prev = $tokens[$phpcsFile->findPrevious($ignoredTokens, $stackPtr - 1, null, true)];

        if ($prev['code'] === T_EQUAL
            || ($prev['code'] == T_STRING && in_array($prev['content'], $this->queryFunctions))
            || in_array($tokens[$stackPtr]['code'], [T_HEREDOC, T_NOWDOC])
        ) {
            $trim = function ($str) {
                return trim(str_replace(array('\'', '"'), '', $str));
            };
            if (preg_match('/^(' . implode('|', $this->statements) . ')\s/i', $trim($tokens[$stackPtr]['content']))) {
                $phpcsFile->addWarning('Possible raw SQL statement %s detected', $stackPtr, 'RawSql',
                    [trim($tokens[$stackPtr]['content'])]);
            }
        }
    }
}
