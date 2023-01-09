<?php
declare(strict_types=1);

namespace EcgM2\Sniffs\Deprecated;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class InheritDocSniff implements Sniff
{
    private const ERROR_MESSAGE = 'This DocBlock has been deprecated and should not be used. For more info see ' .
    'https://devdocs.magento.com/guides/v2.4/coding-standards/docblock-standard-general.html#inheritdoc';

    private const INHERITDOC_COMMENT_TAG = '@inheritdoc';

    private const T_DOC_COMMENT_TYPES = [
        'T_DOC_COMMENT_TAG',
        'T_DOC_COMMENT_STRING'
    ];

    /**
     * @return array|int[]|mixed[]
     */
    public function register()
    {
        return [
            T_DOC_COMMENT_TAG
        ];
    }

    /**
     * @param File $phpcsFile
     * @param $stackPtr
     * @return int|void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        foreach ($tokens as $line => $token) {
            if (!$this->hasTokenMatch($token)) {
                continue;
            }

            $error = self::ERROR_MESSAGE . ' Found: %s';
            $phpcsFile->addError($error, $line, 'Found', [$token['content']]);
        }
    }

    /**
     * @param array $token
     * @return bool
     */
    private function hasTokenMatch(array $token): bool
    {
        return false !== stripos($token['content'], self::INHERITDOC_COMMENT_TAG)
            && in_array($token['type'], self::T_DOC_COMMENT_TYPES, true);
    }
}
