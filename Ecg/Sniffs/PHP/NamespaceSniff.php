<?php
/**
 * When catching an exception inside a namespace it is important that you escape to the global space.
 */
namespace Ecg\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class NamespaceSniff implements Sniff
{
    const NAME_T_NS_NAMESPACE = 'T_NS_SEPARATOR';

    private $tokens = [];

    /**
     * @return array|int[]|mixed[]
     */
    public function register()
    {
        return [
            T_CATCH
        ];
    }

    /**
     * @param File $phpcsFile
     * @param $stackPtr
     * @return int|void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($phpcsFile->findNext(T_NAMESPACE, 0) === false) {
            return;
        }

        $this->tokens = $phpcsFile->getTokens();

        $endOfTryStatement = $phpcsFile->findEndOfStatement($stackPtr);
        $posOfCatchVariable = $phpcsFile->findNext(T_VARIABLE, $stackPtr, $endOfTryStatement);
        $posOfExceptionClassName = $phpcsFile->findNext(T_STRING, $stackPtr, $posOfCatchVariable);
        $posOfNsSeparator = $phpcsFile->findNext(T_NS_SEPARATOR, $stackPtr, $posOfExceptionClassName);

        if ($posOfNsSeparator === false) {
            $exceptionClassName = trim($this->tokens[$posOfExceptionClassName]['content']);
            $posOfClassInUse = $this->findNextClassName($phpcsFile, 0, $stackPtr, $exceptionClassName);
            if ($posOfClassInUse === false || $this->tokens[$posOfClassInUse]['level'] !== 0) {
                $phpcsFile->addError(
                    'Namespace for "' . $exceptionClassName . '" class is not specified.',
                    $posOfExceptionClassName,
                    'NamespaceError'
                );
            }
        }
    }

    /**
     * @param File $phpcsFile
     * @param int $startPtr
     * @param int $endPtr
     * @param string $exceptionClassName
     * @return bool|int
     */
    private function findNextClassName(File $phpcsFile, $startPtr, $endPtr, $exceptionClassName)
    {
        $position = $phpcsFile->findNext(T_STRING, $startPtr, $endPtr, false, $exceptionClassName);
        if ($this->tokens[$position + 1]['type'] === self::NAME_T_NS_NAMESPACE) {
            $position = $this->findNextClassName($phpcsFile, $position + 1, $endPtr, $exceptionClassName);
        }

        return $position;
    }
}
