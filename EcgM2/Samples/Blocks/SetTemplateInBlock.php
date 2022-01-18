<?php
namespace EcgM2\Samples\Blocks;

class SetTemplateInBlock
{
    public function __construct()
    {
        $this->setTemplate('foobar.phtml');
    }
}
