<?php
declare(strict_types=1);

namespace EcgM2\Sniffs\Deprecated;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class SpaceDocBlockSniff implements Sniff
{
    private const ERROR_MESSAGE = 'This DocBlock has been deprecated and should not be used. For more info see ' .
    'https://devdocs.magento.com/guides/v2.4/coding-standards/docblock-standard-general.html#documentation-space';

    private const INHERITDOC_COMMENT_TAG = [
        '@author',
        '@category',
        '@package',
        '@subpackage'
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

    private function hasTokenMatch($token): bool
    {
        foreach (self::INHERITDOC_COMMENT_TAG as $deprecatedDocBlock) {
            if (
                $token['type'] === 'T_DOC_COMMENT_TAG'
                && false !== stripos($token['content'], $deprecatedDocBlock)
            ) {
                return true;
            }
        }

        return false;
    }
}
