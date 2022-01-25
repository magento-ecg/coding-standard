<?php

declare(strict_types=1);

namespace EcgM2\Tests;

use Magento\Framework\DataObject;
use Php_Codesniffer\Files\File;

class MissingParentCallUnitTest1 extends DataObject
{
    public const CONSTRUCTOR_METHOD_NAMES = '__construct';

    private File $file;

    private array $data = [];

    /**
     * @param File $file
     * @param array $data
     */
    public function __construct(File $file, array $data = [])
    {
        $this->file = $file;
        $this->data = $data;
    }
}
