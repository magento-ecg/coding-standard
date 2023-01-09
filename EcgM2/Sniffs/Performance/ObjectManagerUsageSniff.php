<?php

declare(strict_types=1);

namespace EcgM2\Sniffs\Performance;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ObjectManagerUsageSniff implements Sniff
{
    /**
     * @var string
     */
    protected $message = 'Define dependencies in Class constructor or via DI instead of using ObjectManager manually.';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_OPEN_TAG];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        foreach ($tokens as $line => $token) {
            if (!$this->hasTokenMatch($token)) {
                continue;
            }

            $error = $this->message . ' Found: %s';
            $phpcsFile->addError($error, $line, 'Found', [$token['content']]);
        }
    }

    /**
     * Check if the content related to direct ObjectManager usage.
     *
     * @param $token
     * @return bool
     */
    public function hasTokenMatch($token)
    {
        return $token['content'] === 'ObjectManager';
    }
}
