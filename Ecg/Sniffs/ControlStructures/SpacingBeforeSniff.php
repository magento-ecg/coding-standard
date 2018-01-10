<?php
/*
 * Checks that control structures have a blank line before them.
 * Based on Symfony2_Sniffs_Formatting_BlankLineBeforeReturnSniff sniffer
 *
 * @author    Jesús Plou <jplou@onestic.com>
 * @copyright 2017 Onestic
 */

namespace Ecg\Sniffs\ControlStructures;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

class SpacingBeforeSniff implements Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
                                   'PHP',
                                   'JS',
                                  );


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_IF,
                T_WHILE,
                T_FOREACH,
                T_FOR,
                T_SWITCH,
                T_DO,
                T_TRY,
               );

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                  $stackptr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens         = $phpcsFile->getTokens();
        $current        = $stackPtr;
        $previousLine   = $tokens[$stackPtr]['line'] - 1;
        $prevLineTokens = array();

        while ($tokens[$current]['line'] >= $previousLine) {
            if ($tokens[$current]['line'] == $previousLine &&
                $tokens[$current]['type'] != 'T_WHITESPACE' &&
                $tokens[$current]['type'] != 'T_COMMENT'
            ) {
                $prevLineTokens[] = $tokens[$current]['type'];
            }
            $current--;
        }

        if (isset($prevLineTokens[0])
            && $prevLineTokens[0] == 'T_OPEN_CURLY_BRACKET'
        ) {
            return;
        } else if(count($prevLineTokens) > 0) {
            $phpcsFile->addError(
                'Missing blank line before control structure',
                $stackPtr,
                'NoLineBeforeOpen'
            );
        }

        return;
    }
}
