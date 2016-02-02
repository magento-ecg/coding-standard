<?php
namespace EcgM2\Sniffs\Security;

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
        '$_FILES',
    );

    public $superGlobalWarning = array(
        '$_COOKIE', //sometimes need to  get list of all cookies array and there are no methods to do that in M2
        '$_SERVER'
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
        } elseif (in_array($var, $this->superGlobalWarning)) {
            $phpcsFile->addWarning('Direct use of %s Superglobal detected.', $stackPtr, 'SuperglobalUsageWarning', array($var));
        }
    }
}
