<?php
namespace EcgM2\Sniffs\Templates;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class ThisInTemplateSniff implements Sniff
{

    protected $message = 'Usage of $this in template files is deprecated.';

    protected $allowedMethods = [
        'helper',
    ];

    public function register()
    {
        return [
            T_VARIABLE
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['content'] == '$this') {
            $endOfStatementPtr = $phpcsFile->findEndOfStatement($stackPtr);
            $functionPtr = $phpcsFile->findNext(T_STRING, $stackPtr, $endOfStatementPtr);
            if ($functionPtr) {
                if (!in_array($tokens[$functionPtr]['content'], $this->allowedMethods)) {
                    $phpcsFile->addWarning($this->message, $stackPtr, 'ThisInTemplateWarning');
                }
            } else {
                $phpcsFile->addWarning($this->message, $stackPtr, 'ThisInTemplateWarning');
            }
        }
    }
}
