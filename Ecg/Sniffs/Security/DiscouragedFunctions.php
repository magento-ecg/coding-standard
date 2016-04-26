<?php
namespace Ecg\Sniffs\Security;

use Generic_Sniffs_PHP_ForbiddenFunctionsSniff;

class DiscouragedFunctionSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff
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
     * @var array(string => string|null)
     */
    public $forbiddenFunctions = array(
        '^is_dir' => null,
        '^is_file$' => null,
        '^pathinfo$' => null,
    );
}
