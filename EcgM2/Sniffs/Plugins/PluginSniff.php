<?php
namespace EcgM2\Sniffs\Plugins;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class PluginSniff implements Sniff
{
    const PARAMS_QTY = 2;

    const P_BEFORE = 'before';
    const P_AROUND = 'around';
    const P_AFTER = 'after';

    const NS_WORD_PLUGIN = 'Plugin';

    protected $prefixes = [
        self::P_BEFORE,
        self::P_AROUND,
        self::P_AFTER
    ];

    protected $exclude = [];

    public function register()
    {
        return [
            T_FUNCTION
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        if (!$this->checkIsPluginClass($phpcsFile)) {
            return;
        }

        $functionName = $phpcsFile->getDeclarationName($stackPtr);
        $plugin = $this->startsWith($functionName, $this->prefixes, $this->exclude);
        if ($plugin) {
            $paramsQty = count($phpcsFile->getMethodParameters($stackPtr));
            if ($paramsQty < self::PARAMS_QTY) {
                $phpcsFile->addWarning(
                    'Plugin ' . $functionName . ' function should have at least two parameters.',
                    $stackPtr,
                    'PluginWarning'
                );
            }

            if ($plugin == self::P_BEFORE) {
                return;
            }

            $tokens = $phpcsFile->getTokens();

            $hasReturn = false;
            foreach ($tokens as $currToken) {
                if ($currToken['code'] == T_RETURN && isset($currToken['conditions'][$stackPtr])) {
                    $hasReturn = true;
                    break;
                }
            }

            if (!$hasReturn) {
                $phpcsFile->addError(
                    'Plugin ' . $functionName . ' function must return value.',
                    $stackPtr,
                    'PluginError'
                );
            }
        }
    }


    protected function startsWith($haystack, array $needle, array $excludeFunctions = array())
    {
        if (in_array($haystack, $excludeFunctions)) {
            return false;
        }
        $haystackLength = strlen($haystack);
        foreach ($needle as $currPref) {
            $length = strlen($currPref);
            if ($haystackLength != $length && substr($haystack, 0, $length) === $currPref) {
                return $currPref;
            }
        }
        return false;
    }

    private function checkIsPluginClass(File $file): bool
    {
        $startIndex = $file->findNext(T_NAMESPACE, 0);
        if (false === $startIndex) {
            return false;
        }
        $endIndex = $file->findEndOfStatement($startIndex, 0);

        $tokens = $file->getTokens();
        while ($startIndex = $this->findNextTString($file, $startIndex, $endIndex)) {
            if (self::isTStringEqualsPluginWord(
                $tokens[$startIndex]['content']
            )) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param File $file
     * @param int $startIndex
     * @param int $endIndex
     * @return bool|int
     */
    private function findNextTString(File $file, int $startIndex, int $endIndex)
    {
        return $file->findNext(T_STRING, $startIndex + 1, $endIndex);
    }

    /**
     * Check if a part of the namespace is the expected Plugin directory.
     *
     * @param string $contentValue
     * @return bool
     */
    private static function isTStringEqualsPluginWord(string $contentValue): bool
    {
        return self::NS_WORD_PLUGIN === $contentValue;
    }
}
