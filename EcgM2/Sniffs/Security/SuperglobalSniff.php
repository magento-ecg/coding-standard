<?php
namespace Ecg\Sniffs\Security;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class SuperglobalSniff implements PHP_CodeSniffer_Sniff
{
    public $superGlobalErrors = array(
        '$GLOBALS',
        '$_GET',
        '$_POST',
        '$_SESSION',
        '$_REQUEST',
        '$_ENV',
        '$_SERVER',
        '$_FILES',
    );

    public function register()
    {
        return array(T_VARIABLE);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $var = $tokens[$stackPtr]['content'];

        if (in_array($var, $this->superGlobalErrors)) {
            $phpcsFile->addError('Direct use of %s Superglobal detected.', $stackPtr, 'SuperglobalUsageError', array($var));
        } elseif ($var == '$_COOKIE') {
            $phpcsFile->addWarning('Direct use of %s Superglobal detected.', $stackPtr, 'SuperglobalUsageWarning', array($var));
        }
    }
}
