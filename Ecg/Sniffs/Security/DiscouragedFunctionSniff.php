<?php
namespace Ecg\Sniffs\Security;

use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff as GenericForbiddenFunctionsSniff;

class DiscouragedFunctionSniff extends GenericForbiddenFunctionsSniff
{
    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool
     */
    public $error = false;

    /**
     * If true, forbidden functions will be considered regular expressions.
     *
     * @var bool
     */
    protected $patternMatch = true;

    /**
     * A list of forbidden functions with their alternatives.
     *
     * The value is NULL if no alternative exists. IE, the
     * function should just not be used.
     *
     * @var [string => string|null]
     */
    public $forbiddenFunctions = [
        '^is_dir' => null,
        '^is_file$' => null,
        '^pathinfo$' => null,
    ];
}
