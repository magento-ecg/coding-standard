<?php
namespace EcgM2\Sniffs\Templates;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class ThisInTemplateSniff implements PHP_CodeSniffer_Sniff
{

    protected $message = 'Usage of $this in template files is deprecated.';

    protected $allowedMethods = array(
        'helper',
    );

    public function register()
    {
        return array(
            T_VARIABLE
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['content'] == '$this') {
            $endOfStatementPtr = $phpcsFile->findEndOfStatement($stackPtr);
            $functionPtr = $phpcsFile->findNext(T_STRING, $stackPtr, $endOfStatementPtr);
            if ($functionPtr) {
                if (!in_array($tokens[$functionPtr]['content'], $this->allowedMethods)) {
                    $phpcsFile->addWarning($this->message, $stackPtr);
                }
            } else {
                $phpcsFile->addWarning($this->message, $stackPtr);
            }
        }
    }
}
