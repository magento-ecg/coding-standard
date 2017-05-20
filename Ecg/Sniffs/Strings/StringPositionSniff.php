<?php
/**
 * Check if the === operator is used for testing the return value of the strpos PHP function
 */
namespace Ecg\Sniffs\Strings;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class StringPositionSniff implements Sniff
{
    public $functions = [
        'strpos',
        'stripos',
    ];

    public function register()
    {
        return [
            T_IF
        ];
    }

    protected $identicalOperators = [
        T_IS_IDENTICAL,
        T_IS_NOT_IDENTICAL,
    ];

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $open  = $tokens[$stackPtr]['parenthesis_opener'];
        $close = $tokens[$stackPtr]['parenthesis_closer'];

        $foundFunction = false;
        $foundIdentityOperator = false;
        $foundFunctionName = '';

        for ($i = $open + 1; $i < $close; $i++) {
            if ($tokens[$i]['code'] === T_STRING && in_array($tokens[$i]['content'], $this->functions)) {
                $foundFunction = true;
                $foundFunctionName = $tokens[$i]['content'];
            } elseif ($tokens[$i]['code'] === T_IS_IDENTICAL || $tokens[$i]['code'] === T_IS_NOT_IDENTICAL) {
                $foundIdentityOperator = true;
            }
        }

        if ($foundFunction && !$foundIdentityOperator) {
            $phpcsFile->addWarning(
                'Identical operator === is not used for testing the return value of %s function',
                $stackPtr,
                'ImproperValueTesting',
                [$foundFunctionName]
            );
        }
    }
}
