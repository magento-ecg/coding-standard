<?php

namespace EcgM2\Tests\Plugins;

class TestPlugin
{

    public function before()
    {
        return '';
    }


    public function beforeSetName($subject, $name)
    {
        return array('(' . $name . ')');
    }


    public function afterGetName($subject, $result)
    {
        if (true) {
            return 'hfwfwef';
        }
        return '|' . $result . '|';
    }


    public function aroundSave($subject, \Closure $proceed)
    {
        $this->doSmthBeforeProductIsSaved();
        $returnValue = $proceed();
        if ($returnValue) {
            $this->postProductToFacebook();
        }
        return $returnValue;
    }
}

$class = new TestPlugin();
echo $class->go();
