<?php
declare(strict_types=1);

namespace EcgM2\Tests\Plugins;

use Magento\Framework\App\Config\Value;

class PluginUnitTest1 extends Value
{
    /**
     * This will pass validation.
     */
    public function afterSave()
    {
        return random_int(0, 100);
    }
}
