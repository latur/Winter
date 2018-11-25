<?php
namespace Modules\Winter;

use Modules\Admin\Contrib\AdminMenuInterface;
use Modules\Winter\Models\MainSettings;
use Phact\Module\Module;
use Modules\Admin\Traits\AdminTrait;

class WinterModule extends Module implements AdminMenuInterface
{
    use AdminTrait;

    public function getVerboseName()
    {
        return 'Winter';
    }

    public function getSettingsModel()
    {
        return new MainSettings();
    }
}
