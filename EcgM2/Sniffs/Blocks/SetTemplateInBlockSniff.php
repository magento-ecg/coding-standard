<?php

declare(strict_types=1);

namespace EcgM2\Sniffs\Blocks;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class SetTemplateInBlockSniff implements Sniff
{
    /**
     * @var string
     */
    protected $message = 'Define $_template instead of using $this->setTemplate() in Block classes.';

    /**
     * @var array
     */
    public $supportedTokenizers = ['PHP'];

    /**
     * @return array|int[]
     */
    public function register()
    {
        return [T_CLASS];
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return int|void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        foreach ($tokens as $line => $token) {
            if ($this->hasTokenMatch($token) === false) {
                continue;
            }

            $error = $this->message . ' Found: %s';
            $phpcsFile->addWarning($error, $line, 'Found', [$token]);
        }
    }

    private function hasTokenMatch(array $token): bool
    {
        if ($token['content'] !== 'setTemplate') {
            return false;
        }

        return true;
    }
}
