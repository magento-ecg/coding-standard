<?php
declare(strict_types=1);

namespace EcgM2\Sniffs\Templates;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class EscapedOutputSniff implements Sniff
{
    private const TOKEN_NAME_T_OPEN_TAG = 'T_OPEN_TAG';
    private const TOKEN_NAME_T_CLOSE_TAG = 'T_CLOSE_TAG';
    private const TOKEN_NAME_T_COMMENT = 'T_COMMENT';
    private const TOKEN_NAME_T_VARIABLE = 'T_VARIABLE';
    private const TOKEN_NAME_T_OBJECT_OPERATOR = 'T_OBJECT_OPERATOR';
    private const TOKEN_NAME_T_STRING = 'T_STRING';

    private const COMMENT_NO_ESCAPE = '@noEscape';

    private const IGNORE_OPEN_TAG_TOKEN_TYPE = 'T_ECHO';

    private const ERROR_MESSAGE_BLOCK_ESCAPE_METHODS_DEPRECATED =
        'Use $escaper rather than $block as the use of $block->escape{method} has been deprecated. ' .
        'See https://devdocs.magento.com/guides/v2.4/release-notes/release-notes-2-4-0-open-source.html';

    private const ERROR_MESSAGE_INVALID_VARIABLE_NAME = 'Use $escaper variable only for escaping output. ' .
        'See https://devdocs.magento.com/guides/v2.4/release-notes/release-notes-2-4-0-open-source.html';

    private const VARIABLE_NAME_BLOCK = '$block';

    private const VARIABLE_NAME_ESCAPER = '$escaper';

    private array $tokens = [];

    private array $ignoreTokenType = [
        'T_WHITESPACE'
    ];

    /**
     * @var array|string[]
     */
    private array $escapingMethodName = [
        'escapeHtml',
        'escapeUrl',
        'escapeHtmlAttr',
        'encodeUrlParam',
        'escapeJs',
        'escapeCss',
        'escapeJsQuote',
        'escapeXssInUrl',
        'escapeQuote'
    ];

    private File $file;

    /**
     * @return int[]|mixed[]|void
     */
    public function register()
    {
        return [
            T_OPEN_TAG_WITH_ECHO,
            T_OPEN_TAG
        ];
    }

    /**
     * @param File $phpcsFile
     * @param $stackPtr
     * @return int|void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $this->tokens = $phpcsFile->getTokens();
        $this->file = $phpcsFile;
        $stackClosingPtr = $this->getClosingTagPtr($stackPtr);
        if (null === $stackClosingPtr) {
            return;
        }

        if (!$this->isExpectedTokenSequence($stackPtr, $stackClosingPtr)) {
            $error = 'Unescaped output is forbidden! %s';
            $invalidCodeSequence = $this->prepareInvalidCodeSequence($stackPtr, $stackClosingPtr);
            $phpcsFile->addError(
                $error,
                $stackPtr,
                'Unescaped output',
                [$invalidCodeSequence]
            );
        }
    }

    /**
     * Get token number from tokens stack, of the nearest further closing tag token.
     *
     * @param int $stackPtr
     * @return int|null
     */
    private function getClosingTagPtr(int $stackPtr): ?int
    {
        foreach ($this->tokens as $key => $token) {
            if ($key <= $stackPtr) {
                continue;
            }
            if ($token['type'] === self::TOKEN_NAME_T_CLOSE_TAG) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Check if tokens sequence expected (has escaping method, ot explicit @noEscape.
     *
     * @param int $stackPtr
     * @param int $stackClosingPtr
     * @return bool
     */
    private function isExpectedTokenSequence(int $stackPtr, int $stackClosingPtr): bool
    {
        for ($i = $stackPtr + 1; $i < $stackClosingPtr; $i++) {
            if (
                $this->tokens[$stackPtr]['type'] === self::TOKEN_NAME_T_OPEN_TAG
                    ? $this->canSkipTokenContent($i, $stackClosingPtr)
                    : $this->canSkipToken($i)
            ) {
                continue;
            }
            //shift 2 in case of echo construction
            $index = $this->tokens[$stackPtr]['type'] !== self::TOKEN_NAME_T_OPEN_TAG ? $i : $i + 2;

            return $this->isTokenEscapingSequenceProvided($index, $stackClosingPtr);
        }

        return true;
    }

    /**
     * Check token type, in order to skip inessential.
     *
     * @param int $i
     * @return bool
     */
    private function canSkipToken(int $i): bool
    {
        return in_array($this->tokens[$i]['type'], $this->ignoreTokenType, true);
    }

    /**
     * Check if token type and content can be skipped for this validation.
     *
     * @param int $index
     * @param int $stackClosingPtr
     * @return bool
     */
    private function canSkipTokenContent(int $index, int $stackClosingPtr): bool
    {
        for ($i = $index; $i < $stackClosingPtr; $i++) {
            if (
                $this->tokens[$i]['type'] === self::IGNORE_OPEN_TAG_TOKEN_TYPE
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check the output, to see if that's escaped, or marked explicitly by @noEscape comment.
     *
     * @param int $i
     * @param int $stackClosingPtr
     * @return bool
     */
    private function isTokenEscapingSequenceProvided(int $i, int $stackClosingPtr): bool
    {
        return $this->hasNoEscapeProvided($i)
            || (
                $i + 2 < $stackClosingPtr
                && $this->isEscapeMethodCall($i)
            );
    }

    /**
     * Check if the beginning of the output is the explicit @noEscape comment.
     *
     * @param int $i
     * @return bool
     */
    private function hasNoEscapeProvided(int $i): bool
    {
        return $this->tokens[$i]['type'] === self::TOKEN_NAME_T_COMMENT
            && false !== stripos($this->tokens[$i]['content'], self::COMMENT_NO_ESCAPE);
    }

    /**
     * @param int $index
     * @return bool
     */
    private function isEscapeMethodCall(int $index): bool
    {
        $result = $this->tokens[$index]['type'] === self::TOKEN_NAME_T_VARIABLE
            && $this->tokens[$index + 1]['type'] === self::TOKEN_NAME_T_OBJECT_OPERATOR
            && $this->tokens[$index + 2]['type'] === self::TOKEN_NAME_T_STRING
            && in_array($this->tokens[$index + 2]['content'], $this->escapingMethodName, true);

        if ($result) {
            switch ($this->tokens[$index]['content']) {
                case self::VARIABLE_NAME_BLOCK:
                    $this->file->addError(
                        self::ERROR_MESSAGE_BLOCK_ESCAPE_METHODS_DEPRECATED,
                        $index,
                        'DeprecatedEscapeUsage'
                    );
                    break;
                case self::VARIABLE_NAME_ESCAPER:
                    //exact this is expected, nothing to do
                    break;
                default:
                    $this->file->addError(
                        self::ERROR_MESSAGE_INVALID_VARIABLE_NAME,
                        $index,
                        'InvalidVariableEscapeUsage'
                    );
                    break;
            }
        }

        return $result;
    }

    /**
     * Return a piece of code containing the violence.
     *
     * @param int $stackPtr
     * @param int $stackClosingPtr
     * @return string
     */
    private function prepareInvalidCodeSequence(int $stackPtr, int $stackClosingPtr): string
    {
        $result = '';
        for ($i = $stackPtr; $i <= $stackClosingPtr; $i++) {
            $result .= $this->tokens[$i]['content'];
        }

        return $result;
    }
}
