<?php
declare(strict_types=1);

namespace EcgM2\Tests\Plugin;

class PluginUnitTest2
{
    /**
     * This will not pass validation - Plugin directory in namespace detected.
     */
    public function afterSave()
    {
        return random_int(0, 100);
    }
}
