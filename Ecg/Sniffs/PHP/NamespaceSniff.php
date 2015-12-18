<?php
/**
 * When catching an exception inside a namespace it is important that you escape to the global space.
 *
 */
namespace Ecg\Sniffs\PHP;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class NamespaceSniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
            T_CATCH
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if ($phpcsFile->findNext(T_NAMESPACE, 0) === false) {
            return;
        }

        $tokens = $phpcsFile->getTokens();

        $endOfTryStatement = $phpcsFile->findEndOfStatement($stackPtr);

        $posOfCatchVariable = $phpcsFile->findNext(T_VARIABLE, $stackPtr, $endOfTryStatement);

        $posOfExceptionClassName = $phpcsFile->findNext(T_STRING, $stackPtr, $posOfCatchVariable);

        $posOfNsSeparator = $phpcsFile->findNext(T_NS_SEPARATOR, $stackPtr, $posOfExceptionClassName);

        if ($posOfNsSeparator === false) {
            $exceptionClassName = trim($tokens[$posOfExceptionClassName]['content']);
            $posOfClassInUse = $phpcsFile->findNext(T_STRING, 0, $stackPtr, false, $exceptionClassName);
            if ($posOfClassInUse === false || $tokens[$posOfClassInUse]['level'] != 0) {
                $phpcsFile->addError('Namespace for "'.$exceptionClassName.'" class is not specified.', $posOfExceptionClassName);
            }
        }
    }
}
