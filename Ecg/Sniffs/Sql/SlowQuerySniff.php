<?php

class Ecg_Sniffs_Sql_SlowQuerySniff implements PHP_CodeSniffer_Sniff
{
    public $adapterMethods = array(
        'group',
        'having',
        'distinct',
        'addLikeEscape',
        'escapeLikeValue',
        'union',
        'orHaving',
    );

    public $rawStatements = array(
        'GROUP BY',
        'HAVING',
        'DISTINCT',
        'LIKE',
        'UNION',
    );

    protected function getStrTokens()
    {
        return array_merge(PHP_CodeSniffer_Tokens::$stringTokens, [T_HEREDOC, T_NOWDOC]);
    }

    public function register()
    {
        return array_merge([T_STRING], $this->getStrTokens());
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $ignoredTokens = array_merge([T_WHITESPACE, T_OPEN_PARENTHESIS], PHP_CodeSniffer_Tokens::$stringTokens);
        $prev = $tokens[$phpcsFile->findPrevious($ignoredTokens, $stackPtr - 1, null, true)];

        if (in_array($tokens[$stackPtr]['code'], $this->getStrTokens()) && ($prev['code'] === T_EQUAL || $prev['code'] == T_STRING)) {
            $trim = function ($str) {
                return $str;
            };
            if (preg_match('/(' . implode('|', $this->rawStatements) . ')\s/i', $trim($tokens[$stackPtr]['content']))) {
                $phpcsFile->addWarning('Possible slow SQL statement %s detected', $stackPtr, 'SlowRawSql', [trim($tokens[$stackPtr]['content'])]);
            }
        } else if ($tokens[$stackPtr]['code'] === T_STRING && $prev['code'] === T_OBJECT_OPERATOR) {
            if (in_array($tokens[$stackPtr]['content'], $this->adapterMethods)) {
                $phpcsFile->addWarning('Possible slow SQL method %s detected', $stackPtr, 'SlowSql', [trim($tokens[$stackPtr]['content'])]);
            }
        }
    }
}
