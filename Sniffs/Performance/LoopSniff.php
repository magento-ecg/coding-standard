<?php

class Ecg_Sniffs_Performance_LoopSniff implements PHP_CodeSniffer_Sniff
{
    protected $countFunctions = array(
        'sizeof',
        'count'
    );

    protected $modelLsdMethods = array(
        'load',
        'save',
        'delete'
    );

    protected $dataLoadMethods = array(
        'getFirstItem',
        'getChildrenIds',
        'getParentIdsByChild',
        'getEditableAttributes',
        'getUsedProductAttributeIds',
        'getUsedProductAttributes',
        'getConfigurableAttributes',
        'getConfigurableAttributesAsArray',
        'getConfigurableAttributeCollection',
        'getUsedProductIds',
        'getUsedProducts',
        'getUsedProductCollection',
        'getProductByAttributes',
        'getSelectedAttributesInfo',
        'getOrderOptions',
        'getConfigurableOptions',
        'getAssociatedProducts',
        'getAssociatedProductIds',
        'getAssociatedProductCollection',
        'getProductsToPurchaseByReqGroups',
        'getIdBySku'
    );

    /**
     * Cache of processed pointers to prevent duplicates in case of nested loops
     *
     * @var array
     */
    protected $processedStackPointers = array();

    public function register()
    {
        return array(T_WHILE, T_FOR, T_FOREACH, T_DO);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (!array_key_exists('scope_opener', $tokens[$stackPtr])) {
            return;
        }

        for ($ptr = $tokens[$stackPtr]['scope_opener'] + 1; $ptr < $tokens[$stackPtr]['scope_closer']; $ptr++) {
            $content = $tokens[$ptr]['content'];
            if ($tokens[$ptr]['code'] !== T_STRING || in_array($ptr, $this->processedStackPointers)) {
                continue;
            }

            $error = '';
            $code  = '';
            if (in_array($content, $this->countFunctions)) {
                $error = 'Array size calculation function %s detected in loop';
                $code = 'ArraySize';
            } else if (in_array($content, $this->modelLsdMethods)) {
                $error = 'Model LSD method %s detected in loop';
                $code  = 'ModelLSD';
            } else if (in_array($content, $this->dataLoadMethods)) {
                $error = 'Data load %s method detected in loop';
                $code  = 'DataLoad';
            }

            if ($error) {
                $phpcsFile->addError($error, $ptr, $code, array($content . '()'));
                $this->processedStackPointers[] = $ptr;
            }
        }
    }
}
