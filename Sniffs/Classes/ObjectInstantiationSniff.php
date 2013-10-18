<?php

class Ecg_Sniffs_Classes_ObjectInstantiationSniff implements PHP_CodeSniffer_Sniff
{
    protected $allowedClassPrefixes = array(
        'Zend',
        'Varien',
        'Soap',
        'Apache',
        'Centinel',
        'Exception',
        'SimpleXML',
        'XMLWriter',
        'DOM',
        'tidy',
    );

    public function register()
    {
        return array(
            T_NEW
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $next = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        if (!preg_match('/^' . implode('|', $this->allowedClassPrefixes) . '/i', $phpcsFile->getTokens()[$next]['content'])) {
            $phpcsFile->addWarning('Direct object instantiation is discouraged in Magento.', $stackPtr, 'DirectInstantiation');
        }
    }
}
