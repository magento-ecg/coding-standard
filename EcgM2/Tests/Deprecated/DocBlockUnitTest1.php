<?php
declare(strict_types=1);

use PHP_CodeSniffer\Files\File;

/**
 * @author
 * @category
 * @package
 * @subpackage
 */
class DocBlockUnitTest1
{
    /**
     * {@inheritDoc}
     */
    public function register()
    {
        return [
            T_DOC_COMMENT
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {

    }
}
