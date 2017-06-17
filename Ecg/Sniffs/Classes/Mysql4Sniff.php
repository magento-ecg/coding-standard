<?php
namespace Ecg\Sniffs\Classes;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class Mysql4Sniff implements Sniff
{
    public function register()
    {
        return [
            T_CLASS
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $check = function ($ptr) use ($phpcsFile) {
            if (strpos($phpcsFile->getTokens()[$ptr]['content'], 'Mysql4') !== false) {
                $phpcsFile->addWarning('Mysql4 classes are obsolete.', $ptr, 'Found');
                return true;
            }
            return false;
        };

        $next = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        $res = $check($next);
        if (!$res) {
            $extends = $phpcsFile->findNext(T_EXTENDS, $next + 1);
            if ($extends !== false) {
                $afterExtends = $phpcsFile->findNext(T_STRING, $extends + 1);
                $check($afterExtends);
            }
        }
    }
}
