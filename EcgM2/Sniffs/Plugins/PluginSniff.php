<?php

class EcgM2_Sniffs_Plugins_PluginSniff implements PHP_CodeSniffer_Sniff
{

    const PARAMS_QTY = 2;

    const P_BEFORE = 'before';
    const P_AROUND = 'around';
    const P_AFTER = 'after';

    protected $prefixes = array(
        self::P_BEFORE,
        self::P_AROUND,
        self::P_AFTER
    );

    protected $exclude = array();


    public function register()
    {
        return array(
            T_FUNCTION
        );
    }


    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $functionName = $phpcsFile->getDeclarationName($stackPtr);

        $plugin = $this->startsWith($functionName, $this->prefixes, $this->exclude);
        if ($plugin) {
            $paramsQty = count($phpcsFile->getMethodParameters($stackPtr));
            if ($paramsQty < self::PARAMS_QTY) {
                $phpcsFile->addWarning('Plugin '.$functionName.' function should have at least two parameters.', $stackPtr);
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
                $phpcsFile->addError('Plugin '.$functionName.' function must return value.', $stackPtr);
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
}
