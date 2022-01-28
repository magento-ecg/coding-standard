<?php

declare(strict_types=1);

namespace EcgM2\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class MissingParentCallSniff implements Sniff
{
    private const CONSTRUCTOR_METHOD_NAME = '__construct';
    private const PARENT_KEYWORD = 'parent';

    private const TYPE_STRING_T_WHITESPACE = 'T_WHITESPACE';
    private const TYPE_STRING_T_STRING = 'T_STRING';
    private const TYPE_STRING_T_DOUBLE_COLON = 'T_DOUBLE_COLON';

    private array $tokens = [];

    private File $file;

    /**
     * @return array|int[]|mixed[]
     */
    public function register()
    {
        return [
            T_EXTENDS
        ];
    }

    /**
     * @param File $phpcsFile
     * @param $stackPtr
     * @return int|void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $this->file = $phpcsFile;
        $this->tokens = $phpcsFile->getTokens();
        if (!$this->isClass()) {
            return;
        }
        $constructorIndex = $this->getConstructorIndex();
        if (false === $constructorIndex) {
            return;
        }

        if (!$this->hasConstructorParentCall($constructorIndex)) {
            $phpcsFile->addWarning(
                'No parent method call! Possible violation',
                $constructorIndex,
                'NoParentMethodCall'
            );
        }
    }

    /**
     * @return bool
     */
    private function isClass(): bool
    {
        return false !== $this->file->findNext(T_CLASS, 0);
    }

    /**
     * @return bool|int
     */
    private function getConstructorIndex()
    {
        $publicIndex = 0;
        while ($publicIndex = $this->findNextPublic($publicIndex)) {
            $endOfStatement = $this->file->findEndOfStatement($publicIndex);
            $functionIndex = $this->file->findNext(T_FUNCTION, $publicIndex, $endOfStatement);
            if (false === $functionIndex) {
                $publicIndex = $endOfStatement;
                continue;
            }

            $methodNameIndex = $this->file->findNext(T_STRING, $functionIndex, $endOfStatement);
            if ($methodNameIndex
                && $this->tokens[$methodNameIndex]['content'] === self::CONSTRUCTOR_METHOD_NAME
            ) {
                return $methodNameIndex;
            }
            $publicIndex = $endOfStatement;
        }

        return false;
    }

    /**
     * @param int $startPos
     * @return bool|int
     */
    private function findNextPublic(int $startPos)
    {
        return $this->file->findNext(T_PUBLIC, $startPos);
    }

    /**
     * @param int $constructorIndex
     * @return bool
     */
    private function hasConstructorParentCall(int $constructorIndex): bool
    {
        return false !== $this->findParentCallInStatement($constructorIndex);
    }

    /**
     * @param int $constructorIndex
     * @return bool|int
     */
    private function findParentCallInStatement(int $constructorIndex)
    {
        $endOfConstructorMethodIndex = $this->file->findEndOfStatement($constructorIndex);
        $curlyOpeningIndex = $this->file->findNext(
            T_OPEN_CURLY_BRACKET,
            $constructorIndex,
            $endOfConstructorMethodIndex
        );
        $stringIndex = $curlyOpeningIndex + 1;
        while ($stringIndex = $this->getNextTString($stringIndex, $endOfConstructorMethodIndex)) {
            if ($this->tokens[$stringIndex]['content'] !== self::PARENT_KEYWORD) {
                $stringIndex++;
                continue;
            }

            if ($this->tokens[$stringIndex + 1]['type'] === self::TYPE_STRING_T_DOUBLE_COLON) {
                return $stringIndex;
            }
        }

        return false;
    }

    /**
     * @param $startIndex
     * @param int $endIndex
     * @return bool|int
     */
    private function getNextTString($startIndex, int $endIndex)
    {
        return $this->file->findNext(T_STRING, $startIndex, $endIndex);
    }
}
