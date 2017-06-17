<?php
namespace Ecg\Sniffs\Performance;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class LoopSniff implements Sniff
{
    protected $countFunctions = [
        'sizeof',
        'count'
    ];

    protected $modelLsdMethods = [
        'load',
        'save',
        'delete'
    ];

    protected $dataLoadMethods = [
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
    ];

    /**
     * Cache of processed pointers to prevent duplicates in case of nested loops
     *
     * @var array
     */
    protected $processedStackPointers = [];

    public function register()
    {
        return [
            T_WHILE,
            T_FOR,
            T_FOREACH,
            T_DO
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
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
            } elseif (in_array($content, $this->modelLsdMethods)) {
                $error = 'Model LSD method %s detected in loop';
                $code  = 'ModelLSD';
            } elseif (in_array($content, $this->dataLoadMethods)) {
                $error = 'Data load %s method detected in loop';
                $code  = 'DataLoad';
            }

            if ($error) {
                $phpcsFile->addWarning($error, $ptr, $code, [$content . '()']);
                $this->processedStackPointers[] = $ptr;
            }
        }
    }
}
