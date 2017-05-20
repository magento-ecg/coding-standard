<?php
namespace Ecg\Sniffs\Strings;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

class RegExSniff implements Sniff
{
    public $functions = [
        'preg_replace',
    ];

    protected $ignoreTokens = [
        T_DOUBLE_COLON,
        T_OBJECT_OPERATOR,
        T_FUNCTION,
        T_CONST,
        T_CLASS,
    ];

    public function register()
    {
        return [
            T_STRING
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (!in_array($tokens[$stackPtr]['content'], $this->functions)) {
            return;
        }

        $prevToken = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
        if (in_array($tokens[$prevToken]['code'], $this->ignoreTokens)) {
            return;
        }

        $nextToken = $phpcsFile->findNext([T_WHITESPACE, T_OPEN_PARENTHESIS], $stackPtr + 1, null, true);
        if (in_array($tokens[$nextToken]['code'], Tokens::$stringTokens)
            && preg_match('/[#\/|~\}\)][imsxADSUXJu]*e[imsxADSUXJu]*.$/', $tokens[$nextToken]['content'])) {
            $phpcsFile->addWarning(
                'Possible executable regular expression in %s.
                 Make sure that the pattern doesn\'t contain "e" modifier',
                $stackPtr,
                'PossibleExecutableRegEx',
                [$tokens[$stackPtr]['content']]
            );
        }
    }
}
