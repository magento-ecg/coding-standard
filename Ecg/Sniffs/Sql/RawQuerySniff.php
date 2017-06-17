<?php
namespace Ecg\Sniffs\Sql;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

class RawQuerySniff implements Sniff
{
    public $statements = [
        'SELECT',
        'UPDATE',
        'INSERT',
        'CREATE',
        'DELETE',
        'ALTER',
        'DROP'
    ];

    public $queryFunctions = [
        'query',
        'raw_query'
    ];

    public function register()
    {
        return array_merge(Tokens::$stringTokens, [T_HEREDOC, T_NOWDOC]);
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $ignoredTokens = array_merge([T_WHITESPACE, T_OPEN_PARENTHESIS], Tokens::$stringTokens);
        $prev = $tokens[$phpcsFile->findPrevious($ignoredTokens, $stackPtr - 1, null, true)];

        if ($prev['code'] === T_EQUAL
            || ($prev['code'] == T_STRING && in_array($prev['content'], $this->queryFunctions))
            || in_array($tokens[$stackPtr]['code'], [T_HEREDOC, T_NOWDOC])
        ) {
            $trim = function ($str) {
                return trim(str_replace(['\'', '"'], '', $str));
            };
            if (preg_match('/^(' . implode('|', $this->statements) . ')\s/i', $trim($tokens[$stackPtr]['content']))) {
                $phpcsFile->addWarning(
                    'Possible raw SQL statement %s detected',
                    $stackPtr,
                    'RawSql',
                    [trim($tokens[$stackPtr]['content'])]
                );
            }
        }
    }
}
