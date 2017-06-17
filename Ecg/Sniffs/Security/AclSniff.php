<?php
namespace Ecg\Sniffs\Security;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

class AclSniff implements Sniff
{
    const PARENT_CLASS_NAME = 'Mage_Adminhtml_Controller_Action';
    const REQUIRED_ACL_METHOD_NAME = '_isAllowed';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_CLASS
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $classScopeStart = $tokens[$stackPtr]['scope_opener'];
        $classScopeEnd = $tokens[$stackPtr]['scope_closer'];
        $classPosition = $stackPtr;

        $stackPtr = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        $className = $tokens[$stackPtr]['content'];

        if (false === ($stackPtr = $phpcsFile->findNext(T_EXTENDS, $stackPtr + 1))) {
            // the currently tested class hasn't extended any class
            return;
        }

        $stackPtr = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        $parentClassName = $tokens[$stackPtr]['content'];

        if ($parentClassName == self::PARENT_CLASS_NAME) {
            while (false !== ($stackPtr =
                    $phpcsFile->findNext(
                        Tokens::$emptyTokens,
                        $classScopeStart + 1,
                        $classScopeEnd - 1,
                        true,
                        'function'
                    )
                )
            ) {
                $stackPtr = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
                $methodName = $tokens[$stackPtr]['content'];
                $classScopeStart = $stackPtr;

                if ($methodName == self::REQUIRED_ACL_METHOD_NAME) {
                    // the currently tested class has implemented the required ACL method
                    return;
                }
            }

            $phpcsFile->addError(
                'Missing the %s() ACL method in the %s class.',
                $classPosition,
                'MissingAclMethod',
                [self::REQUIRED_ACL_METHOD_NAME, $className]
            );
        }
    }
}
