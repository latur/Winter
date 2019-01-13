<?php
namespace Modules\Winter\Models;

use Phact\Orm\Fields\CharField;
use Phact\Orm\Model;
use Phact\Translate\Translator;

class Settings extends Model
{
    use Translator;

    public static function getFields()
    {
        return [
            'site' => [
                'class' => CharField::class,
                'label' => self::t('Winter', 'Site name'),
                'null' => true,
            ],
            'slogan' => [
                'class' => CharField::class,
                'label' => self::t('Winter', 'Site slogan'),
                'null' => true,
            ],
        ];
    }

    public function __toString()
    {
        return self::t('Winter', 'Site settings');
    }
}