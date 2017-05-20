<?php
namespace Ecg\Sniffs\Sql;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

class SlowQuerySniff implements Sniff
{
    public $adapterMethods = [
        'group',
        'having',
        'distinct',
        'addLikeEscape',
        'escapeLikeValue',
        'union',
        'orHaving',
    ];

    public $rawStatements = [
        'GROUP BY',
        'HAVING',
        'DISTINCT',
        'LIKE',
        'UNION',
    ];

    protected function getStrTokens()
    {
        return array_merge(Tokens::$stringTokens, [T_HEREDOC, T_NOWDOC]);
    }

    public function register()
    {
        return array_merge([T_STRING], $this->getStrTokens());
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $ignoredTokens = array_merge([T_WHITESPACE, T_OPEN_PARENTHESIS], Tokens::$stringTokens);
        $prev = $tokens[$phpcsFile->findPrevious($ignoredTokens, $stackPtr - 1, null, true)];

        if (in_array($tokens[$stackPtr]['code'], $this->getStrTokens())
            && ($prev['code'] === T_EQUAL || $prev['code'] == T_STRING)
        ) {
            $trim = function ($str) {
                return $str;
            };
            if (preg_match('/(' . implode('|', $this->rawStatements) . ')\s/i', $trim($tokens[$stackPtr]['content']))) {
                $phpcsFile->addWarning(
                    'Possible slow SQL statement %s detected',
                    $stackPtr,
                    'SlowRawSql',
                    [trim($tokens[$stackPtr]['content'])]
                );
            }
        } elseif ($tokens[$stackPtr]['code'] === T_STRING && $prev['code'] === T_OBJECT_OPERATOR) {
            if (in_array($tokens[$stackPtr]['content'], $this->adapterMethods)) {
                $phpcsFile->addWarning(
                    'Possible slow SQL method %s detected',
                    $stackPtr,
                    'SlowSql',
                    [trim($tokens[$stackPtr]['content'])]
                );
            }
        }
    }
}
